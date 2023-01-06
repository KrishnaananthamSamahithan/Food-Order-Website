<?php include('partials/menu.php');?>

<div class = "main-content">
    <div class = "weapper">
        <h1> Update Category </h1>

        <br><br>

        <?php

            //Check whether the id is set or not
            if(isset($_GET['id']))
            {
                //get the id and all other details
                $id = $_GET['id'];
                //Create sql query to get all the details
                $sql ="SELECT * FROM category WHERE id=$id";

                //Execute the query
                $res = mysqli_query($conn, $sql);

                //Count the Rows to check whether the id is valid or not
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //Get all the data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['feature'];
                    $active = $row['active']; 

                }
                else
                {
                    //redirect to manage category with session message
                    $_SESSION['no-category-found'] = "<div class ='error'> Category not found </div>";
                    //Redirect to manage admin page
                    header('location:' .SITEURL.'admin/manage-category.php');

                }
            }
            else
            {
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image: </td>
                <td>
                    <?php

                        if($current_image !="")
                        {
                            //Display the Image
                            ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                        else
                        {
                            //Display Message
                            echo "<div class= 'error'> Image not Added </div>";
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td> New Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Featured:</td>
                <td>
                    <input <?php if($featured=="Yes") {echo "checked";}?> type="radio" name="feature" value="Yes"> Yes 

                    <input <?php if($featured=="No") {echo "checked";}?> type="radio" name="feature" value="No"> No
                </td>
            </tr>

            <tr>
                <td>Active:</td>
                <td>
                    <input <?php if($active=="Yes") {echo "checked";}?> type="radio" name="active" value="Yes"> Yes 

                    <input <?php if($active=="No") {echo "checked";}?> type="radio" name="active" value="No"> No
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?> ">
                    <input type="submit" name="submit" value="Update Category" class="btn-secondary">

                </td>
            </tr>

        </table>
        </form>

        <?php

            // check whether the submit button is click or not
            if(isset($_POST['submit'])) {
                //echo "Button Clicked";
                //get all the value from form to update
                $id =$_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['feature'];
                $active = $_POST['active'];

                // Updating new image if selected
                // Check whether the image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //Get the image Details
                    $image_name = $_FILES['image']['name'];

                    //check whether the image is available or not
                    if($image_name !="")
                    {
                        //Image Available
                        //Upload the new image
                        //Auto Rename the image
                        //Get the extention of the image(jpg,png.gif,etc) eg:- "specialfood1.jpg"
                        $ext = end(explode('.', $image_name));

                        //Rename the image
                        $image_name = "Food_Category_".rand(000,999).'.'.$ext; // Food_Category_834.jpg

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;

                        //Finaly Upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Check whether the image is uploaded or not
                        //and if the image is not uploaded the we will stop the process and redirect with error message
                        if($upload==FALSE)
                        {
                            //set message
                            $_SESSION['upload'] = "<div class='error'> Failed to upload image</div>";
                            //redirect to add category page
                            header('location:'.SITEURL.'admin/manage-category.php');
                            //Stop this process
                            die();
                        }

                        // Remove the current image if available
                        if($current_image!="")
                        {
                            $remove_path = "../images/category/".$current_image;

                             $remove = unlink($remove_path);

                            //Check whether the image is remove or not
                            // if failed to remove then diaplay message and stop the process
                            if($remove==FALSE)
                            {
                                //Failed to remove image
                                $_SESSION['failed-remove'] = "<div class='error'> Failed to remove current Image </div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                 die(); // stop the process
                            }
                        }
                        

                    }
                    else
                    {
                        $image_name = $current_image; 
                    }
                }
                else
                {
                    $image_name = $current_image;
                }


                //Create sql query to  update admin details
                $sql2 = " UPDATE category SET
                title = '$title',
                image_name = '$image_name',
                feature = '$featured',
                active = '$active'
                WHERE id = '$id'";

                //Execute the query
                $res = mysqli_query($conn, $sql2);

                // check whether the query executed successfully or not
                if($res ==TRUE) {

                    //Query Executed and admin Updated
                    $_SESSION['update'] = "<div class ='success'> Category Updated Successfully </div>";
                    //Redirect to manage admin page
                    header('location:' .SITEURL.'admin/manage-category.php');

                }
                else {
                    //failed to update admin
                    $_SESSION['update'] = "<div class ='error'> Category Updated Failed </div>";
                    //Redirect to manage admin page
                    header('location:' .SITEURL.'admin/manage-category.php');

                }
            }
        ?>



<?php include('partials/footer.php');?>