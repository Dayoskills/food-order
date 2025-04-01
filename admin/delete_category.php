<?php
// Include Constants File
include('../config/constants.php');

// Check whether the id and image_name value is set or not
if (isset($_GET['id']) && isset($_GET['image_name'])) {
    // Get the values
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // Remove the physical image if available
    if ($image_name != "") {
        // Remove leading/trailing whitespace from the image name
        $image_name = trim($image_name);

        // Construct the file path
        //$path = "C:/xampp/htdocs/projects/food_order/images/category_image/" . $image_name;
        $path = "../images/category_image/" .$image_name;

        // Remove the image
        $remove_image = unlink($path);

        // If failed to remove image, then send an error message and stop the process
        if ($remove_image == FALSE) {
            // Set the session message
            $_SESSION['remove_image'] = "<div class='error'>Failed to remove Category Image</div>";

            // Redirect to Manage Category Page
            header('location:' . SITEURL . 'admin/manage_category.php');
            die();
        }
    }

    // Delete data from the database
    // SQL Query to delete data
    $sql = "DELETE FROM tbl_category WHERE id=$id";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check whether the data is deleted or not
    if ($result == TRUE) {
        // Set Success Message and redirect
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
        // Redirect to Manage Category Page
        header('location:' . SITEURL . 'admin/manage_category.php');
    } else {
        // Set Fail Message and Redirect
        $_SESSION['delete'] = "<div class='Error'>Failed to Delete Category</div>";
        // Redirect to Manage Category Page
        header('location:' . SITEURL . 'admin/manage_category.php');
    }
} else {
    // Redirect to manage category page
    header('location: manage_category.php');
}
?>