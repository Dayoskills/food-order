<?php

    // Include constants.php file here
    include('../config/constants.php');

    //1. get the ID of Admin to be deleted
    $id = $_GET['id'];

    //2. create SQL Query to delete Admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //3. Execute the Query
    $result = mysqli_query($conn, $sql);

    //4. Check whether the Query executed successfully or not
    if ($result == TRUE) {
        // Query executed successfully and Admin Deleted
        // echo "Admin Deleted"; 
        // Create Session variable to display message 
        $_SESSION['delete'] = "<div class = 'success'>Admin Deleted Succefully.</div>";
        //Redirect to Manage Admin page
        header('location:' .SITEURL. 'admin/manage_admin.php');
    } 
    else {
        //Failed to Delete Admin
        //echo "Failed to Delete Admin";

        $_SESSION['delete'] = "<div class = 'error'>Failed to Delete Admin. Try Again Later</div>";
        header('location:' .SITEURL. 'admin/manage_admin.php');
    }

    //5. Redirect to Manage Admin page with message (success/error)

?>