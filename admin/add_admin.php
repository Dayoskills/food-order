<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br> <br>

        <?php 
                if (isset($_SESSION['add'])) { //Checking whether the session is set or not
                    
                    echo $_SESSION['add'];  //Displaying Session Message if set
                    unset($_SESSION['add']); //Removing Session Message
                }

            ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Enter Your Username"></td>
                </tr>

                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Enter Your Password"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php 
    // process the value from form and save it in the Database
    
    // check whether the submit button is clicked or not

    if (isset($_POST['submit'])) {
        // Button clicked
        // echo "Button clicked";

         //1. Get the data from form
         $full_name = $_POST['full_name'];
         $username = $_POST['username'];
         $password = md5($_POST['password']); //Password encryption with MD5

         //2. SQL Query to save data into database
         $sql = "INSERT INTO tbl_admin SET 
            full_name = '$full_name',
            username = '$username',
            password = '$password'
         ";
        
         // 3. Executing Query and saving Data into Database
         $result = mysqli_query($conn, $sql) or die();
         
       
         //4. Check whether the (Query is excuted) data is inserted or not, and display appropriate message 
         if ($result == TRUE){
            // Data Inserted 
            // echo "Data Inserted";
            // create a session variable to display message
            $_SESSION['add'] = "<div class = 'success'>Admin Deleted Succefully.</div>";
            // Redirect page to Manage Admin
            header("location:" .SITEURL. 'admin/manage_admin.php');

         }
         else {
            // Failed to insert Data
            // echo "Failed to insert Data"; 
            // create a session variable to display message
            $_SESSION['add'] = "<div class = 'error'>Failed to Delete Admin. Try Again Later</div>";
            // Redirect page to Add Admin
            header("location:" .SITEURL. 'admin/add_admin.php');
         }

        } 
            
?>