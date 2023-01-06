<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1> Manage Food </h1>

        <br /> <br />
        

            <!-- Button to Add Admin -->
            <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary"> Add Food </a>
            
            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset ($_SESSION['add']);
                }  

                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset ($_SESSION['delete']);
                }  

                if(isset($_SESSION['update2']))
                {
                    echo $_SESSION['update2'];
                    unset ($_SESSION['update2']);
                }  

                if(isset($_SESSION['no-category-found']))
                {
                    echo $_SESSION['no-category-found'];
                    unset ($_SESSION['no-category-found']);
                }  

                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset ($_SESSION['upload']);
                }  

                if(isset($_SESSION['failed-remove']))
                {
                    echo $_SESSION['failed-remove'];
                    unset ($_SESSION['failed-remove']);
                } 

                
            ?>

            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Feature</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>

                <?php

                    //Query to Get all categories from database
                    $sql = "SELECT * FROM food";

                    //Execute the query
                    $res = mysqli_query($conn, $sql);

                    //Count Rows
                    $count = mysqli_num_rows($res);

                    //Check serial number variable and asign value as 1
                    $sn=1;

                    // Check whether we have data indatabase or not
                    if($count>0)
                    {
                        //We have data in database
                        //get the data and display
                        while($row= mysqli_fetch_assoc($res))
                        {
                            $id = $row['id'];
                            $title = $row['title'];
                            $description = $row['description'];
                            $price = $row['price'];
                            $image_name = $row['image_name'];
                            $category = $row['category_id'];
                            $featured = $row['feature'];
                            $active = $row['active'];

                            ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $description; ?></td>
                                    <td><?php echo $price; ?></td>
                                    <td>
                                        <?php 
                                            //Check whether the image name is available or not
                                            if($image_name!="")
                                            {
                                                //Display the image
                                                ?>
                                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">
                                                <?php
                                            }
                                            else
                                            {
                                                //Display the message
                                                echo "<div class='error'> Image not added </div>";
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $category; ?></td>
                                    <td><?php echo $featured; ?></td>
                                    <td><?php echo $active; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary"> Update Food </a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger"> Delete Food </a>
                                    </td>
                    
                                </tr>
                            <?php


                        }
                    }
                    else{
                        //We have data in database
                        //we'll diaplay message inside table
                        ?>
                        <tr>
                            <td colspan="6"><div class="error"> No Food Added </div></td>
                        </tr>
                        <?php
                    }
                ?>

                

                
            </table>
    </div>
</div>



<?php include('partials/footer.php');?>