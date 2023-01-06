<?php include('partials/menu.php');?>

<div class="main-content">
    <div class = "wrapper">
        <h1>Add Admin</h1>
        <br><br>

        <?php
                if(isset($_SESSION['add'])) {
                    echo $_SESSION['add']; // Displaying Session Message
                    unset($_SESSION['add']); //Removing Session Message
                }
            ?>
            <br /> <br />

        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Enter Your Username"></td>
                </tr>

                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" placeholder="Enter Your Password"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">

                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php');?>

<?php
    //Process the value from form and save it in database
    //check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        //Get the data from the form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password =md5( $_POST['password']); // password Encryption with MD5

        //Sql query to save the admin data in to database
        $sql = "INSERT INTO tbl_admin SET
                full_name = '$full_name',
                username = '$username',
                password = '$password' ";
        
        
        $res = mysqli_query($conn,$sql) or die(mysqli_error());

        //Check whether the query is executed data is inserted or not and display correct message
        if($res==TRUE){
            //Data Inserted
            //echo "Data Inserted";
            $_SESSION['add'] = "<div class = 'success'> Admin Added Successfuly </div>";
            //Redirect Page manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else {

            //Inserted Failed
            //echo "Faile to Insert Data";
            $_SESSION['add'] = "<div class = 'error'> Admin Added Failed </div>";
            //Redirect Page manage Admin
            header("location:".SITEURL,'admin/add-admin.php');
        }

    }
?>