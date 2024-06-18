<?php
session_start();
require '../dbcon.php';


if(isset($_POST['add_food']))
{
    $illness     = mysqli_real_escape_string($conn, $_POST['illness']);
    $food_name   = mysqli_real_escape_string($conn, $_POST['food_name']);
    $recipe      = mysqli_real_escape_string($conn, $_POST['recipe']);
    $img_url     = mysqli_real_escape_string($conn, $_POST['img_url']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

    $query = "INSERT INTO foods (illness,food_name,recipe,img_url, ingredients) VALUES ('$illness','$food_name','$recipe','$img_url', '$ingredients')";

    $query_run = mysqli_query($conn, $query);
    if($query_run)
    {
        $_SESSION['message'] = "Food successfully added";
        header("Location: index.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Failed to add food";
        header("Location: index.php");
        exit(0);
    }
}