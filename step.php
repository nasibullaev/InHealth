<?php

require 'dbcon.php';

if(isset($_POST['action']) && $_POST['action'] == 'set_step'){


    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $steps   = mysqli_real_escape_string($conn, $_POST['steps']);
    
    $date = date('Y-m-d');
    $day = date('d');
    $month = date('m');
    $year = date('Y');
    // check date
    $date_checker = mysqli_query($conn, "SELECT date FROM steps WHERE user_id = '$user_id' && date = '$date'");
    $number_of_dates = mysqli_num_rows($date_checker);

    // if there is step on this date
    if($number_of_dates > 0){
        $query = mysqli_query($conn, "UPDATE steps SET steps = '$steps' WHERE user_id = $user_id && date = '$date'");
        if($query){
            $result = ['result' => true, 'weekly_steps' => get_weekly_steps($user_id), 'monthly_steps' => get_monthly_steps($user_id)];
            echo json_encode($result);
            exit();
        }
        else {
            $result = ['result' => false, 'error_info' => 'Failed to update user\'s steps'];
            echo json_encode($result);
            exit();
        }

    } // end of checking date


    $sql = "INSERT into steps(user_id, day, month, year, steps, date) VALUES ('$user_id', '$day', '$month', '$year', '$steps', '$date')";
    $query = mysqli_query($conn, $sql);
    if($query){
        $result = ['result' => true, 'weekly_steps' => get_weekly_steps($user_id), 'monthly_steps' => get_monthly_steps($user_id)];
        echo json_encode($result);
    }
    else {
        $result = ['result' => false, 'error_info' => 'Failed to set steps'];
        echo json_encode($result);
        exit(0);
    }
}

?>