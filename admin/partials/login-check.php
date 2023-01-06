<?php 

    //Authorization - Access control
    //Check whether the user is loggged in or not
    if(!isset($_SESSION['user'])) // if user session is not set
    {
        //user is not loggedin
        //Redirect to login with message
        $_SESSION['no-login-message'] = "<div class= 'error text-center'> Please login to access Admin Panel</div>";
        //Redirect to login page
        header('location:'.SITEURL.'admin/login.php');
    }

?>