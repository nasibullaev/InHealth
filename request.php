<?php
require 'dbcon.php';


// SignUp
if(isset($_POST['action']) && $_POST['action'] == 'signup'){
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $surname  = mysqli_real_escape_string($conn, $_POST['surname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $user_pic = mysqli_real_escape_string($conn, $_POST['user_pic']);
    
    $date = date('Y-m-d');


    // check email
    $email_checker = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    $number_of_emails = mysqli_num_rows($email_checker);

    if($number_of_emails > 0){
        $result = ['result' => false, 'error_info' => 'Email already in use'];
        echo json_encode($result);
        exit();
    } // end of checking email


    $sql = "INSERT into `users`(`name`, `surname`, `password`, `email`, `date_joined`, `user_pic`) VALUES ('$name', '$surname', '$password', '$email', '$date', '$user_pic')";
    $query = mysqli_query($conn, $sql);
    if($query){
        $user_id = mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM users WHERE email = '$email' "));
        $result = ['result' => true, 'id' => $user_id['id']];
        echo json_encode($result);
    }
    else {
        $result = ['result' => false];
        echo json_encode($result);
        exit(0);
    }
}

// Login
if(isset($_POST['action']) && $_POST['action'] == 'login'){

    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $info_checker = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' and password = '$password'");
    $number_of_rows = mysqli_num_rows($info_checker);

    if($number_of_rows > 0){
        $user = mysqli_fetch_array($info_checker);
        $user_id = $user['id'];

            // get medicals
            $medical_checker = mysqli_query($conn, "SELECT * FROM medical WHERE user_id = $user_id");
            $number_of_medical = mysqli_num_rows($medical_checker);
            if($number_of_medical > 0) {
                $medical = mysqli_fetch_array($medical_checker);
                $medicals = [
                    'weight' => $medical['weight'],
                    'height' => $medical['height'],
                    'b_d' => $medical['b_d'],
                    'illness' => $medical['illness']
                ];
            }
            else {
                $medicals = [
                    'no_medical' => true
                ];
            }

        $result = [
            'result' => true, 
            'user_details' => [
                'id'       => $user['id'],
                'name'     => $user['name'],
                'surname'  => $user['surname'],
                'email'    => $user['email'],
                'user_pic' => $user['user_pic']
            ],
            'user_steps' => [
                'current_steps' => get_current_steps($user['id']),
                'weekly_steps' => get_weekly_steps($user['id']),
                'monthly_steps' => get_monthly_steps($user['id'])
            ],
            'user_medicals' => $medicals
        ];
        echo json_encode($result);
        exit();
    }
    else {
        $result = ['result' => false, 'error_info' => 'Invalid email address or password'];
        echo json_encode($result);
        exit(0);
    }

}

// Edit (without password)
if(isset($_POST['action']) && $_POST['action'] == 'edit'){
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    
    // checking for user_pic
    $user_pic_sql = '';
    if(isset($_POST['user_pic'])) {
        $user_pic = $_POST['user_pic'];
        $user_pic_sql = ', user_pic = ' . "'" . $user_pic . "'";
    }
    $query = mysqli_query($conn, "UPDATE users SET name = '$name', surname = '$surname' $user_pic_sql WHERE id = $id");
    if($query){
        $result = ['result' => true];
        echo json_encode($result);
    }
    else {
        $result = ['result' => false, 'error_info' => 'Failed to edit user info'];
        echo json_encode($result);
    }

}


// Edit Password
if(isset($_POST['action']) && $_POST['action'] == 'edit_password'){
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    
    $check_pass = mysqli_query($conn, "SELECT password FROM users WHERE id = $id");
    $pass = mysqli_fetch_array($check_pass);
    if($old_password == $pass['password']) {

        $query = mysqli_query($conn, "UPDATE users SET password = '$new_password' WHERE id = $id");
        if($query){
            $result = ['result' => true];
            echo json_encode($result);
        }
        else {
            $result = ['result' => false, 'error_info' => 'Failed to edit user password'];
            echo json_encode($result);
        }
    }
    else {
        $result = ['result' => false, 'error_info' => 'Wrong password'];
        echo json_encode($result);
    }

}



?>