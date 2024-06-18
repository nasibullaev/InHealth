<?php

$conn = mysqli_connect('localhost', '', '', '') or die("Connection Failed:" . mysqli_connect_error());

if(!$conn){
    die('Connection Failed'. mysqli_connect_error());
}
// functions
function get_current_steps($user_id) {
    global $conn;

    $date = date('Y-m-d');
    $query = mysqli_query($conn, "SELECT steps FROM steps WHERE user_id = $user_id && date = $date");
    
    // checks if there is steps on today's date
    if(mysqli_num_rows($query) > 0){
        $current_steps = mysqli_fetch_array($query);
        return $current_steps['steps'];
    }
        // if no return 0 steps
        return 0;
}

function get_weekly_steps($user_id) {
    global $conn;

    $now = new DateTime( "7 days ago", new DateTimeZone('ASIA/Tashkent'));
    $interval = new DateInterval( 'P1D'); // 1 Day interval
    $period = new DatePeriod( $now, $interval, 7); // 7 Days
    
    $last_seven_days = [];
    foreach( $period as $day) {
        $key = $day->format( 'Y-m-d');
        $last_seven_days[ $key ] = 0;
    }

    $query = mysqli_query($conn, "SELECT * FROM steps WHERE user_id = $user_id");

    $weekly_steps = 0;
    foreach($query as $date){
        if(array_key_exists($date['date'], $last_seven_days))
        $weekly_steps += $date['steps'];
    }
    return $weekly_steps;
}

function get_monthly_steps($user_id) {
    global $conn;

    $now = new DateTime( "30 days ago", new DateTimeZone('ASIA/Tashkent'));
    $interval = new DateInterval( 'P1D'); // 1 Day interval
    $period = new DatePeriod( $now, $interval, 31); // 30 Days
    
    $last_months_days = [];
    foreach( $period as $day) {
        $key = $day->format( 'Y-m-d');
        $last_months_days[ $key ] = 0;
    }

    $query = mysqli_query($conn, "SELECT * FROM steps WHERE user_id = $user_id");

    $monthly_steps = 0;
    foreach($query as $date){
        if(array_key_exists($date['date'], $last_months_days))
        $monthly_steps += $date['steps'];
    }
    return $monthly_steps;
} // enf of functions
?>