<?php include('partials/menu.php');?>
    <div class="main-content">
        <div class="wrapper">
            <h1> Add Category </h1>
            <br><br>

            <?php
                

                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset ($_SESSION['upload']);
                }
            ?>
            <br><br>

            <!-- Add category form start -->
            <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Enter Category title"></td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" > 
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image" > 
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category" >

                            <?php
                                //Create Php code to display categories from database
                                //create Sql to get all active categories from database
                                $sql= "SELECT * FROM category WHERE active='Yes'";

                                //Execute the query
                                $res= mysqli_query($conn, $sql);

                                //count rows to check whether we have categoried or not
                                $count = mysqli_num_rows($res);

                                //if count is greater than zero. we have categories else we dont have categories
                                if($count>0)
                                {
                                    //We have Categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the details of categories
                                        $id=$row['id'];
                                        $title=$row['title'];

                                        ?>
                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //We do not have categories
                                    ?>
                                        <option value="1">No Category Found</option>
                                    <?php
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="feature" value="Yes"> Yes 
                        <input type="radio" name="feature" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes 
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">

                    </td>
                </tr>
            </table>
        </form>
        <!-- Add category form end -->

        <?php

            //Check whether the Submit Button is Clicked or not
            if(isset($_POST['submit']))
            {
                //echo "clicked";
                //get the value from category form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];


                //for radio input, we need to check whether the button is selected or not
                if(isset($_POST['feature']))
                {
                    //get the value from forn
                    $featured = $_POST['feature'];
                }
                else 
                {
                    //set the default value
                    $featured = "NO";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else{
                    $active = "NO";
                }

                //Check whether the image is selected or not and set the value for image name accordingly
                //print_r($_FILES['image']);

                //die(); //Break the code here

                if(isset($_FILES['image']['name']))
                {
                    //upload the image
                    //To upload the image we need image name, source path and destination
                    $image_name = $_FILES['image']['name'];

                    //Upload the image only if image is selected
                    if($image_name !="")
                    {

                        //Auto Rename the image
                        //Get the extention of the image(jpg,png.gif,etc) eg:- "specialfood1.jpg"
                        $ext = end(explode('.', $image_name));

                        //Rename the image
                        $image_name = "Food_".rand(0000,9990).'.'.$ext; // Food_834.jpg

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/food/".$image_name;

                        //Finaly Upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Check whether the image is uploaded or not
                        //and if the image is not uploaded the we will stop the process and redirect with error message
                        if($upload==FALSE)
                        {
                            //set message
                            $_SESSION['upload'] = "<div class='error'> Failed to upload image</div>";
                            //redirect to add category page
                            header('location:'.SITEURL.'admin/add-food.php');
                            //Stop this process
                            die();
                        }
                    }

                }
                else{
                    //Don't upload the image and set the image_name value as blank
                    $image_name="";
                }

                // Create query to insert data in to caregory table
                $sql2 = "INSERT INTO food SET
                    title ='$title',
                    description ='$description',
                    price = '$price',
                    image_name = '$image_name',
                    category_id = '$category',
                    feature = '$featured',
                    active = '$active' ";

                // Execute the query and save in database
                $res2 = mysqli_query($conn, $sql2);

                // Check whether the query executed or not data add or not
                if($res2==TRUE)
                {
                    //Query executed and category added
                    $_SESSION['add'] = "<div class='success'> Food added successfully</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else{
                    //failed to add category
                    $_SESSION['add'] = "<div class='error'> Food added Failed</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-food.php');

                }

            }
        ?>  
        </div>
    </div>


<?php include('partials/footer.php');?>