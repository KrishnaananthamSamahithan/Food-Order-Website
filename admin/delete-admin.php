<?php

    // Include constants.php file
    include('../config/constants.php');

    // Get the id of admin to delete
    $id = $_GET['id'];

    // Create sql query for delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //Execute the query
    $res = mysqli_query($conn, $sql);

    // Check whether the query executed successfully or not
    if($res==TRUE) {
        // Query Executed Successfully and Admin Deleted
       // echo "Admin Deleted Successfully";
       //Create Session Variable to delete message
       $_SESSION['delete'] = "<div class='success'> Admin Deleted Successfully </div>";

       // Redirect to manage admin page
       header('location:'.SITEURL.'admin/manage-admin.php');

    }
    else {
        //Delete action Failed
        //echo "Failed to Delete Admin";

        //Create Session Variable to delete message
       $_SESSION['delete'] = " <div class='error'>Failed to Delete Admin Details </div>";

       // Redirect to manage admin page
       header('location:'.SITEURL.'admin/manage-admin.php');
    }
?>