<?php include('partials/menu.php');?>

<div class = "main-content">
    <div class = "weapper">
        <h1> Update Admin</h1>

        <br><br>

        <?php
            // Get the id of selected admin
            $id = $_GET['id'];

            //Create SQL query
            $sql = "SELECT * FROM tbl_admin WHERE id=$id";

            // Execute query
            $res= mysqli_query($conn, $sql);

            //check whether the query executed or not
            if($res==TRUE) {
                // check the data available
                $count = mysqli_num_rows($res);
                // check whether we have admin data or not
                if($count==1) {
                    // Get the details
                    $row=mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                    
                }
                else {
                    //redirect to manage admin page
                    header('location:'.SITEURL. 'admin/manage-admin.php');
                }
            }

        ?>

        <form action="" method="POST">

        <table class = "tbl-30">
            <tr>
                <td>Full Name:</td>
                <td>
                    <input type="text" name = "full_name" value= " <?php echo $full_name; ?>">
                </td>
            </tr>

            <tr>
                <td>Username:</td>
                <td>
                    <input type="text" name = "username" value = " <?php echo $username; ?>">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value= "<?php echo $id; ?>">
                    <input type="submit" name = "submit" value = " Update Admin " class= "btn-secondary">
                </td>
            </tr>
        </table>
        </form>
    </div>
</div>

<?php

    // check whether the submit button is click or not
    if(isset($_POST['submit'])) {
        //echo "Button Clicked";
        //get all the value from form to update
        $id =$_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        //Create sql query to  update admin details
        $sql = " UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$username'
        WHERE id = '$id'";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        // check whether the query executed successfully or not
        if($res ==TRUE) {

            //Query Executed and admin Updated
            $_SESSION['update'] = "<div class ='success'> Admin Updated Successfully </div>";
            //Redirect to manage admin page
            header('location:' .SITEURL.'admin/manage-admin.php');

        }
        else {
            //failed to update admin
            $_SESSION['update'] = "<div class ='error'> Admin Updated Failed </div>";
            //Redirect to manage admin page
            header('location:' .SITEURL.'admin/manage-admin.php');

        }
    }
?>


<?php include('partials/footer.php');?>