<?php 

    //Authorisation or Access Control
    //Check whether the user is logged in or not 
    if (!isset($_SESSION['user'])) //If user not logged in 
    {
        //User not logged in
        //Redirect to Login Page with Error Message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login to Access Admin Panel</div>";
        //Redirect to login page 
        header('location:' .SITEURL. 'admin/login.php');
    }

?>