<?php 
    //Include constants file
    include('../config/constants.php');
    //Check whether the ID and image_name is set or not
    if (isset($_GET['id']) && isset($_GET['image_name'])) {

        //Proceed to Delete
        
        //1. Get the ID and Image_name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2. Remove image available
        //check whether the image is  available or not, and delete only if available
        if ($image_name != "") {

            //It have image and need to remove from folder
            //set the image path
            $path = "../images/food_image/".$image_name;

            //Remove image file from folder
            $remove = unlink($path);

            //check whether the image is removed or not
            if ($remove == FALSE) {

                //failed to remove image
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image</div>";
                //Redirect to manage food page
                header('location: manage_food.php');
                //stop the process of deleting food
                die(); 
            }
        }

        //3. Delete food from database
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        //Execute the query
        $result = mysqli_query($conn, $sql);

        //Check whether the query is executed or not, and set the session message respectively
        //4. Redirect to manage food page with session message
        if ($result = TRUE) {
            
            //Food deleted
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
            header('location: manage_food.php');
        }else {
            
            //Failed to Delete food
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Food</div>";
            header('location: manage_food.php');
        }
        

    }else {
        
        //Redirect to Manage Food Page
        $_SESSION['unauthorised'] = "<div class='error'>Unauthorised Access</div>";
        header('location: manage_food.php');
    }

?>