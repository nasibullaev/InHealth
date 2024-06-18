<?php

require 'dbcon.php';

if(isset($_POST['action']) && $_POST['action'] == 'set_medical'){


    $user_id  = mysqli_real_escape_string($conn, $_POST['user_id']);
    $weight   = mysqli_real_escape_string($conn, $_POST['weight']);
    $height   = mysqli_real_escape_string($conn, $_POST['height']);
    $b_d      = mysqli_real_escape_string($conn, $_POST['b_d']);
    $illness  = mysqli_real_escape_string($conn, $_POST['illness']);
    
    // check id
    $id_checker = mysqli_query($conn, "SELECT user_id FROM medical WHERE user_id = '$user_id'");
    $number_of_ids = mysqli_num_rows($id_checker);

    // if there is id in db
    if($number_of_ids > 0){
        $query = mysqli_query($conn, "UPDATE medical SET weight = '$weight', height = '$height', b_d = '$b_d', illness = '$illness' WHERE user_id = $user_id");
        if($query){
            $result = ['result' => true, 'info' => 'User medicals successfully updated'];
            echo json_encode($result);
            exit();
        }
        else {
            $result = ['result' => false, 'error_info' => 'Failed to update user\'s medicals'];
            echo json_encode($result);
            exit();
        }

    } // end of checking id


    $sql = "INSERT into medical(user_id, weight, height, b_d, illness) VALUES ('$user_id', '$weight', '$height', '$b_d', '$illness')";
    $query = mysqli_query($conn, $sql);
    if($query){
        $result = ['result' => true, 'info' => 'User medicals successfully created'];
        echo json_encode($result);
    }
    else {
        $result = ['result' => false, 'error_info' => 'Failed to set user medicals'];
        echo json_encode($result);
        exit(0);
    }
}

if(isset($_POST['action']) && $_POST['action'] == 'get_medical'){


    $user_id  = mysqli_real_escape_string($conn, $_POST['user_id']);

    // check id
    $id_checker = mysqli_query($conn, "SELECT * FROM medical WHERE user_id = '$user_id'");
    $number_of_ids = mysqli_num_rows($id_checker);

    // if there is id in db
    if($number_of_ids > 0){

        $medical = mysqli_fetch_array($id_checker);
        $result = [
            'weight' => $medical['weight'],
            'height' => $medical['height'],
            'b_d' => $medical['b_d'],
            'illness' => $medical['illness']
        ];

        echo json_encode($result);

    } // end of checking id
    else {
        $result = ['result' => false, 'error_info' => 'User did not set medicals'];
        echo json_encode($result);
    }
    
}

?>