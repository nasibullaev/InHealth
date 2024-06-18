<?php

require '../dbcon.php';



// Set favorite
if(isset($_POST['action']) && $_POST['action'] == 'set_favorite'){

    $user_id    = mysqli_real_escape_string($conn, $_POST['user_id']);
    $food_name  = mysqli_real_escape_string($conn, $_POST['food_name']);
    $favorite    = mysqli_real_escape_string($conn, $_POST['favorite']);
    if($favorite == "true") {
        $favorite = true;
    }
    elseif($favorite == "false") {
        $favorite = false;
    }


    // check id and food name
    $id_checker    = mysqli_query($conn, "SELECT user_id FROM favorites WHERE user_id = '$user_id' && food_name = '$food_name'");
    $number_of_ids = mysqli_num_rows($id_checker);

    // if there is id and food in db
    if($number_of_ids > 0){
        
        $query = mysqli_query($conn, "UPDATE favorites SET favorite = '$favorite' WHERE user_id = '$user_id' && food_name = '$food_name'");
        if($query){
            $result = ['result' => true, 'info' => "Successfully updated", 'like_status' => $favorite, 'details' => [
                $user_id, $food_name, $favorite
            ]];
            echo json_encode($result);
            exit();
        }
        else {
            $result = ['result' => false, 'error_info' => 'Failed to update user\'s favorite\'s', 'details' => [
                $user_id, $food_name, $favorite
            ]];
            echo json_encode($result);
            exit();
        }

    } // end of checking id and food

    
    $sql = "INSERT into favorites(user_id, food_name, favorite) VALUES ('$user_id', '$food_name', '$favorite')";
    $query = mysqli_query($conn, $sql);
    if($query){
        $result = ['result' => true, 'info' => 'User successfully liked ' . "$food_name"];
        echo json_encode($result);
    }
    else {
        $result = ['result' => false, 'error_info' => 'Failed to like a food'];
        echo json_encode($result);
        exit(0);
    }
}


// Get food
if(isset($_POST['action']) && $_POST['action'] == 'get_foods') {

    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    
    // check and clarify user's illness
    $illness             = mysqli_query($conn, "SELECT illness FROM medical WHERE user_id = '$user_id'");
    $number_of_illnesses = mysqli_num_rows($illness);
    
    // if user set illness
    if($number_of_illnesses > 0) {
        $illness = mysqli_fetch_array($illness);
        $illness = $illness["illness"];
        
        // Get foods from database for this illness
        $foods            = mysqli_query($conn, "SELECT * FROM foods where illness = '$illness'");
        $number_of_foods  = mysqli_num_rows($foods);
    
        // if there are foods for user's illness
        if($number_of_foods > 0) {
            $recommended_foods = [];
            foreach($foods as $food){
                $food_name   = $food['food_name'];
                $recipe      = $food['recipe'];
                $img_url     = $food['img_url'];
                $ingredients = $food['ingredients'];

                // check favorite
                $favorite        = mysqli_query($conn, "SELECT favorite FROM favorites where user_id = '$user_id' && food_name = '$food_name'");
                $favorite_number = mysqli_num_rows($favorite);

                if($favorite_number > 0) {
                    $favorite = mysqli_fetch_array($favorite);
                    $favorite = $favorite['favorite'];

                    $favorite = empty($favorite) ? false : true;
                }
                else {
                    $favorite = false;
                }

                $recommended_foods = array_merge($recommended_foods, [['food_name' => $food_name, 'recipe' => $recipe, 'img_url' => $img_url, 'ingredients' => $ingredients, 'is_favorite' => $favorite]]);
            }
            echo json_encode($recommended_foods);
            
        }
        else {
            $result = ['reuslt' => false, 'error_info' => 'Foods not found for this illness'];
            echo json_encode($result);
        }
    }   
    else {
        $result = ['result' => false, 'error_info' => 'User did not set illness'];
        echo json_encode($result);
        exit(0);
    }
}