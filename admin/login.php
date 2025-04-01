<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

    <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>

        <?php 
            if (isset($_SESSION['login'])) {
                echo $_SESSION['login']; //Display session message
                unset($_SESSION['login']); //Remove session message
            }

            if (isset($_SESSION['no-login-message'])) {
                echo $_SESSION['no-login-message']; //Display session message
                unset($_SESSION['no-login-message']); //Remove session message
            }
        ?>

        <br><br>
        <!-- Login form starts here -->
        <form action="" method="POST" class="text-center">
        Username: <br>
        <input type="text" name="username" placeholder="Enter Your Username"> <br><br>

        Password: <br>
        <input type="password" name="password" placeholder="Enter Your Password"> <br><br>
        <input type="submit" name="submit" value="Login" class="btn-primary">
        </form>
        <!-- Login form ends here -->

        <br><br>
        <p class="text-center"> Created By - <a href="#">Temidayo</a></p>
    </div>
    
</body>
</html>

<?php 

    //check whether the submit button is clicked or not
    if (isset($_POST['submit'])) {
        
        //Process for Login
        //1. Get the Data from Login Form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //2. SQL Check whether the user with username and password exist or not 
        $sql = "SELECT * FROM tbl_admin WHERE username= '$username' AND password= '$password'";

        //3. Execute the Query
        $result = mysqli_query($conn, $sql);

        //4. Count rows to check whether the user exist or not
        $resultcheck = mysqli_num_rows($result);

        if ($resultcheck == 1) {
            
            //User Exist and Login Success
            //Display Success Message
            $_SESSION['login'] = "<div class='success'> Login Successfully</div>";
            $_SESSION['user'] = $username; //To check whether the user is logged in or not and logout will unset it 

            //Redirect the User to HomePage/Dashboard with Success Message
            header('location:' .SITEURL.'admin/index.php');
        }
        else {

            //User does not exist and Login Failed
            //Display Error Message
            $_SESSION['login'] = "<div class='error text-center'> Wrong Username/Password Combination</div>";
            //Redirect the User to HomePage/Dashboard with Error Message
            header('location:' .SITEURL.'admin/login.php');
        }
    } 

?>