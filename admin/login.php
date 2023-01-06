<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br> <br>      
            
            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset ($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset ($_SESSION['no-login-message']);
                }
            ?>

            <br><br>

            <!-- Login form start here -->
            <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter Username"><br><br>

            Password: <br>
            <input type="password" name="password" placeholder="Enter Password"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
            </form>
            <!-- Login form end here -->

            <p class="text-center">Created By- <a href="#">K.Samahithan</a></p>
        </div>
    </body>
</html>

<?php

    //Check whether the submit button is clicked or not
    if(isset($_POST['submit'])) {
        //process for login
        //get the data from login page
        $username = $_POST['username'];
        $password = md5($_POST['password']);
    //Sql query to check whether the user with user name and password exists or not
    $sql = "SELECT * FROM tbl_admin WHERE username= '$username' AND password='$password'";

    //Execute the sql query
    $res= mysqli_query($conn, $sql);

    //Count the rows to check whether the user exits or not
    $count = mysqli_num_rows($res);

    if($count==1) {
        //User available login success
        $_SESSION['login'] = "<div class = 'success'> Login Successful </div>";
        $_SESSION['user'] = $username; // to check whether the user is logged in or logout will unset it

        //Redirect to home page/dashboard
        header('location:' .SITEURL. 'admin/');

    }
    else {
        //user not available login failed
        $_SESSION['login'] = "<div class = 'error text-center'> User name or password did not match </div>";
        //Redirect to home page/dashboard
        header('location:' .SITEURL. 'admin/manage-admin.php');
    }

}

?>