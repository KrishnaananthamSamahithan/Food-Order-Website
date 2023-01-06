<?php

    // Include constants.php file
    include('../config/constants.php');

    //check whether the is and image value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        // Get the id of admin to delete
        $id = $_GET['id'];

        // Create sql query for delete admin
        $sql = "DELETE FROM category WHERE id=$id";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        // Check whether the query executed successfully or not
        if($res==TRUE)
        {
        // Query Executed Successfully and Admin Deleted
       // echo "Admin Deleted Successfully";
       //Create Session Variable to delete message
            $_SESSION['delete'] = "<div class='success'> Category Deleted Successfully </div>";

            // Redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-category.php');

        }
        else 
        {
            //Delete action Failed
            //echo "Failed to Delete Admin";

            //Create Session Variable to delete message
            $_SESSION['delete'] = " <div class='error'>Failed to Delete Category Details </div>";

            // Redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-category.php');
        }
    }
    else
    {
        //redirect tomanage category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }

    
?>