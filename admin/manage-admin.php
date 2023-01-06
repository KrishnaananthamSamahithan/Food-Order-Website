<?php include('partials/menu.php');?>


        <!-- Main Contant Section Start -->
        <div class="main-content">
            <div class="wrapper">
                <h1> Manage Admin </h1>

            <br /> <br />

            <?php
                if(isset($_SESSION['add'])) {
                    echo $_SESSION['add']; // Displaying Session Message
                    unset($_SESSION['add']); //Removing Session Message
                
                }
               
            ?>
            <?php
                 if(isset($_SESSION['delete'])) {

                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
            ?>
            

            <?php
                 if(isset($_SESSION['update'])) {

                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            ?>

            <?php
                 if(isset($_SESSION['user-not-found'])) {

                    echo $_SESSION['user-not-found'];
                    unset($_SESSION['user-not-found']);

                if(isset($_SESSION['pwd-not-match'])) {

                    echo $_SESSION['pwd-not-match'];
                    unset($_SESSION['pwd-not-match']);
                }
                }
                if(isset($_SESSION['change-pwd'])) {

                    echo $_SESSION['change-pwd'];
                    unset($_SESSION['change-pwd']);
                }

                
            ?>

           
           
            <br /> <br />


           

            <!-- Button to Add Admin -->
            <a href="add-admin.php" class="btn-primary"> Add Admin </a>
               
            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>

                <?php
                    //Query to get all admin details
                    $sql = "SELECT * FROM tbl_admin";
                    //Executed the Query
                    $res = mysqli_query($conn, $sql);

                    //Check whether the query is Executed of not
                    if($res==True){

                        //Count rows to check whether we have data in database or not
                        $rows = mysqli_num_rows($res); // function to get all the rows in database
                        
                        $sn=1; //Creating a variable and assign the value
                        //check the num of rows
                        if($rows>0) {

                            //we have data in database
                            while ($rows = mysqli_fetch_assoc($res)) {

                                //using while loop to get all the data from database
                                //and while loop will run as long as wh have data in database

                                //get individual data
                                $id = $rows ['id'];
                                $full_name = $rows['full_name'];
                                $username = $rows['username']

                                // Display the values in the table
                                ?>

                                <tr>
                                    <td> <?php echo $sn++; ?></td>
                                    <td><?php echo $full_name; ?></td>
                                    <td> <?php echo $username; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class = "btn-primary"> Change Password</a>
                                        <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary"> Update Admin </a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger"> Delete Admin </a>
                                    </td>
                    
                                </tr>

                               <?php  
                            }
                        }
                        else {

                            //
                        }
                    }
                ?>

               
            </table>
                
            </div>   
        </div>    
        <!-- Main Contant Section Ends -->
        

<?php include('partials/footer.php');?>