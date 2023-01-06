<?php include('partials/menu.php');?>

<?php

    //Check whether the id is set or not
    if(isset($_GET['id']))
    {
        //get the id and all other details
        $id = $_GET['id'];
        //Create sql query to get all the details
        $sql ="SELECT * FROM food WHERE id=$id";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        //Get the  value based on query executed
        $row = mysqli_fetch_assoc($res);

        //Get all the data
        $title = $row['title'];
        $description = $row['description'];
        $price = $row['price'];
        $current_image = $row['image_name'];
        $current_category = $row['category_id'];
        $featured = $row['feature'];
        $active = $row['active']; 

      
    }
    else
    {
        //redirect to manage category
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>

<div class = "main-content">
    <div class = "weapper">
        <h1> Update Food </h1>

        <br><br>

              
        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Description:</td>
                <td>
                    <textarea name="description" cols="30" rows="5" ><?php echo $description ?></textarea>
                </td>
            </tr>

            <tr>
                <td>Price:</td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>"  > 
                </td>
            </tr>

            <tr>
                <td>Current Image: </td>
                <td>
                    <?php

                        if($current_image =="")
                        {
                            //Display Message
                            echo "<div class= 'error'> Image not Added </div>";
                        }
                        else
                        {
                            
                            //Display the Image
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                            <?php
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
                <td>Category:</td>
                <td>
                    <select name="category" value="<?php echo $category; ?>">

                    <?php
                        //Create Php code to display categories from database
                        //create Sql to get all active categories from database
                        $sql2= "SELECT * FROM category WHERE active='Yes'";

                        //Execute the query
                        $res2= mysqli_query($conn, $sql2);

                        //count rows to check whether we have categoried or not
                        $count2 = mysqli_num_rows($res2);

                        //if count is greater than zero. we have categories else we dont have categories
                        if($count2>0)
                        {
                            //We have Categories
                            while($row2=mysqli_fetch_assoc($res2))
                            {
                                //get the details of categories
                                $category_id=$row2['id'];
                                $category_title=$row2['title'];

                                ?>
                                 <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                <?php
                            }
                        }
                        else
                        {
                            //We do not have categories
                            ?>
                                <option value="0">No Category Found</option>
                            <?php
                        }
                    ?>
                    </select>
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
                    <input type="hidden" name="id" value="<?php echo $id; ?> ">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="submit" name="submit" value="Update food" class="btn-secondary">

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
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
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
                        $image_name = "Food_".rand(0000,9999).'.'.$ext; // Food_Category_834.jpg

                        $scr_path = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/".$image_name;

                        //Finaly Upload the image
                        $upload = move_uploaded_file($scr_path, $dest_path);

                        //Check whether the image is uploaded or not
                        //and if the image is not uploaded the we will stop the process and redirect with error message
                        if($upload==FALSE)
                        {
                            //set message
                            $_SESSION['upload'] = "<div class='error'> Failed to upload image</div>";
                            //redirect to add category page
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //Stop this process
                            die();
                        }

                        // Remove the current image if available
                        if($current_image!="")
                        {
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);

                            //Check whether the image is remove or not
                            // if failed to remove then diaplay message and stop the process
                            if($remove==FALSE)
                            {
                                //Failed to remove image
                                $_SESSION['failed-remove'] = "<div class='error'> Failed to remove current Image </div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
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
                $sql3 = " UPDATE food SET
                title = '$title',
                description = '$description',
                price = '$price',
                image_name = '$image_name',
                category_id = '$category',
                feature = '$featured',
                active = '$active'
                WHERE id = '$id'";

                //Execute the query
                $res3 = mysqli_query($conn, $sql3);

                // check whether the query executed successfully or not
                if($res3 ==TRUE) {

                    //Query Executed and admin Updated
                    $_SESSION['update2'] = "<div class ='success'> Food Updated Successfully </div>";
                    //Redirect to manage admin page
                    header('location:' .SITEURL.'admin/manage-food.php');

                }
                else {
                    //failed to update admin
                    $_SESSION['update2'] = "<div class ='error'> Food Updated Failed </div>";
                    //Redirect to manage admin page
                    header('location:' .SITEURL.'admin/manage-food.php');

                }
            }
        ?>



<?php include('partials/footer.php');?>