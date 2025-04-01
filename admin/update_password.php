<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br> <br>

        <?php 
            //Get the ID of selected Admin to change the password
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            }
        
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password:</td>
                    <td><input type="password" name="current_password" placeholder="Current Password"></td>
                </tr>

                <tr>
                    <td>New Password:</td>
                    <td><input type="password" name="new_password" placeholder="New Password"></td>
                </tr>

                <tr>
                    <td>Confirm Password:</td>
                    <td><input type="password" name="confirm_password" placeholder="Confirm Password"></td>
                </tr>

                <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id;?>">
                            <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                        </td>
                    </tr>

            </table>
        </form>

    </div>
</div>

<?php 
    //Check whether the Submit Button is clicked or not
    if (isset($_POST['submit'])) {
        // echo "Clicked";

        //1. Get the data from form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        //2. Check whether the user with current ID and current password exist or not 
        $sql = "SELECT * FROM tbl_admin WHERE id= $id AND password= '$current_password'";
        
        //Execute the Query
        $result = mysqli_query($conn, $sql);

        if ($result == TRUE) {
            //Check whether data is available or not 
            $resultcheck = mysqli_num_rows($result);

            if ($resultcheck == 1) {
                //User Exists and Password can be changed
                //echo "User Found";

                //check whether the new password and confirm password match or not
                if ($new_password == $confirm_password) {
                    //Update the password
                    $sql2 = "UPDATE tbl_admin SET password= '$new_password' WHERE id= $id";

                    //Execute the Query
                    $result2 = mysqli_query($conn, $sql2);

                    //check whether the query executed or not
                    if ($result2 == TRUE) {
                        //Display Success Message
                        $_SESSION['pwd-change'] = "<div class='success'> Password Changed Successfully</div>";
                        //Redirect the User to Manage Admin Page with Success Message
                        header('location:' .SITEURL.'admin/manage_admin.php');

                    }
                    else {
                        //Display Error Message
                        $_SESSION['pwd-change'] = "<div class='error'> Failed to Change Password</div>";
                        //Redirect the User to Manage Admin Page with Error Message
                        header('location:' .SITEURL.'admin/manage_admin.php');
                    }

                } else {
                    //Redirect to Manage Admin Page with Error Message
                    $_SESSION['pwd-not-match'] = "<div class='error'> Password does not match</div>";
                    //Redirect the User to Manage Admin Page with Error Message
                    header('location:' .SITEURL.'admin/manage_admin.php');
                }

            }
            else {
                //User Does Not Exist, Set Message and Redirect
                $_SESSION['user-not-found'] = "<div class='error'> User Not Found </div>";
                //Redirect the User to Manage Admin Page with Error Message
                header('location:' .SITEURL.'admin/manage_admin.php');
            }
        }

        //3. Check whether the New Password and Confirm Password Match or not 

        //4. Change Password if all above is TRUE 
    }

?>




<?php include('partials/footer.php'); ?>