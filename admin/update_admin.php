<?php include('partials/menu.php'); ?>

<div class="main_content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php
            //1. Get the ID of selected Admin
            $id = $_GET['id'];

            //2. Create SQL Query to get the details
            $sql = "SELECT * FROM tbl_admin WHERE id = $id";

            //3. Execute the Query
            $result = mysqli_query($conn, $sql);

            // Check whether the Query is executed or not
            if ($result == TRUE) {
                //check whether the data is available or not
                $resultchecker = mysqli_num_rows($result);

                //check whether we have Admin data or not
                if ($resultchecker == 1) {
                    //Get the details
                    //echo "Admin Availble";
                    $row = mysqli_fetch_assoc($result);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                } else {
                    //Redirect to Manage Admin Page
                    header('location:' .SITEURL. 'admin/manage_admin.php');
                }
            }
        
        ?>

        <form action="" method="POST">
            <table class="tbl-30">

                    <tr>
                        <td>Full Name:</td>
                        <td><input type="text" name="full_name" value="<?php echo $full_name; ?>"></td>
                    </tr>

                    <tr>
                        <td>Username:</td>
                        <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id;?>">
                            <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                        </td>
                    </tr>
            </table>

        </form>
    </div>
</div>

<?php 
    //Check whether the Submit Button is clicked
    if (isset($_POST['submit'])) {
        //echo "Button Clicked";
        //Get all values from form to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        //Create a SQL Query to Update Admin
        $sql = "UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$username'
        WHERE id = '$id'
        ";

        //Execute the Query 
        $result = mysqli_query($conn, $sql);

        //Check whether the query executed successfully or not
        if ($result == TRUE) {
            //Query executed and Admin updated
            $_SESSION['update'] = "<div class= 'success'>Admin Updated Successfuly</div>";
            //Redirect to Manage Admin Page
            header('location:' .SITEURL. 'admin/manage_admin.php');
            
        } else {
            //Failed to Update Admin 
            $_SESSION['update'] = "<div class= 'error'>Failed to Update Admin</div>";
            //Redirect to Manage Admin Page
            header('location:' .SITEURL. 'admin/manage_admin.php');
            
        }
    }

?>


<?php include('partials/footer.php'); ?>