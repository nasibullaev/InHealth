<?php

require 'dbcon.php';

if(isset($_POST['delete_user']))
{
    $user_id = mysqli_real_escape_string($conn, $_POST['delete_user']);

    $query = "DELETE FROM users WHERE id='$user_id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        header("Location: admin.php");
        exit(0);
    }
    else
    {
        header("Location: admin.php");
        exit(0);
    }
}

?>