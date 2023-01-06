<?php include('partials/menu.php');?>

    <div class="main-content">
                <div class="wrapper">
                    <h1> Change Password </h1>
                    <br /> <br />

                    <?php
                        if(isset($_GET['id'])) {
                            $id=$_GET['id'];
                        }
                    ?>

                    <form action="" method="POST">

                    <table>
                        <tr>
                            <td>Current Password:</td>
                            <td>
                                <input type="password" name="current_password" placeholder="Old Password">
                            </td>
                        </tr>

                        <tr>
                            <td>New Password:</td>
                            <td>
                                <input type="password" name="new_password" placeholder="New Password">
                            </td>
                        </tr>
                        <tr>
                            <td>Confirm Password:</td>
                            <td>
                                <input type="password" name="confirm_password" placeholder="Confirm Password">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                <input type="submit" name="submit" value="change password" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
    </div>

    <?php

        //check whether the submit Button is clicked or not
        if(isset($_POST['submit'])) {

            //get the data from admin table
            $id=$_POST['id'];
            $current_password=md5($_POST['current_password']);
            $new_password=md5($_POST['new_password']);
            $confirm_password=md5($_POST['confirm_password']);

            // sql query to check data from database
            $sql ="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

            //execute the query
            $res = mysqli_query($conn, $sql);

            if($res==TRUE) {
                
                //check whether data is available or not
                $count=mysqli_num_rows($res);

                if($count==1) {
                    //user exists and pasword can be changed
                    //echo "User Found";

                    //check whether the new password and confirm match or not
                    if($new_password=$confirm_password) {
                        //Update the password
                        //echo "Password Change Successfully";
                        $sql2 = "UPDATE tbl_admin SET
                            password='$new_password'
                            WHERE id=$id ";

                        //Execute the query
                        $res2 = mysqli_query($conn, $sql2);

                        //check the query executed or not
                        if($res==true) {
                            //Display Success Message
                            //Redirect to manage admin page with sucess message
                            $_SESSION['change-pwd'] = "<div class='success'> Password Changed Successfully </div>";
                            //redirect message
                            header('location:' .SITEURL. 'admin/manage-admin.php');
                        }
                        else {
                            //Display error message
                            //Redirect to manage admin page with error message
                            $_SESSION['change-pwd'] = "<div class='error'> Password Changed Failed </div>";
                            //redirect message
                            header('location:' .SITEURL. 'admin/manage-admin.php');
                        }

                    }
                    else {
                        //user does not exits set message and redirect
                        $_SESSION['pwd-not-match'] = "<div class='error'> Password did not match </div>";
                        //redirect message
                        header('location:' .SITEURL. 'admin/manage-admin.php');

                    }
                }
                else {
                    //user does not exits set message and redirect
                    $_SESSION['user-not-found'] = "<div class='error'>User Not Found </div>";
                    //redirect message
                    header('location:' .SITEURL. 'admin/manage-admin.php');

                }
            }
        }
    
    ?>

<?php include('partials/footer.php');?>