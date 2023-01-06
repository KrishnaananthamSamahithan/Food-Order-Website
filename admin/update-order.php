<?php include('partials/menu.php');?>

<div class = "main-content">
    <div class = "weapper">
        <h1> Update Order </h1>

        <br><br>


        <?php
            //Check whether the is set ornot
            if(isset($_GET['id']))
            {
                //Get the order details
                $id=$_GET['id'];

                //Get all the details from the order table
                $sql= "SELECT * FROM order_food WHERE id=$id";

                $res= mysqli_query($conn, $sql);

                $count= mysqli_num_rows($res);

                if($count>0)
                {
                    //Details available
                    $row=mysqli_fetch_assoc($res);

                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['quantity'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];

                }
                else
                {
                    //Details not available
                    //redirect to manage order
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }
            else
            {
                //Redirect to the manage order page
                header('location:'.SITEURL.'admin/manage-order.php');
            }
        ?>

        <form action="" method="POST">
            
        <table class="tbl-30">
            <tr>
                <td> Food Name</td>
                <td><b><?php echo $food; ?></b></td>
            </tr>

            <tr>
                <td> Food Price</td>
                <td><b> Rs <?php echo $price; ?></b></td>
            </tr>

            <tr>
                <td> Quantity</td>
                <td>
                    <input type="number" name="quantity" value="<?php echo $qty; ?>">
                </td>
            </tr>

          

            <tr>
                <td>Status</td>
                <td>
                    <select name="status" >
                        <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                        <option <?php if($status=="On Delivery"){echo "selected";} ?> value="On Delivery"> On Delivery</option>
                        <option <?php if($status=="Deliverted"){echo "selected";} ?> value="Deliverted"> Deliverted</option>
                        <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Cancelled"> Cancelled</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td> Customer Name</td>
                <td>
                    <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                </td>
            </tr>

            <tr>
                <td> Customer Contact</td>
                <td>
                    <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                </td>
            </tr>

            <tr>
                <td> Customer Email</td>
                <td>
                    <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                </td>
            </tr>

            <tr>
                <td> Customer Address</td>
                <td>
                    <textarea name="customer_address" cols="30" rows="5"> <?php echo $customer_address; ?> </textarea>
                </td>
            </tr>

            <tr>
                <td colspan="2" >
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="price" value="<?php echo $price ; ?>">
                    <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                </td>
            </tr>
        </table>
        </form>

        <?php
            if(isset($_POST['submit']))
            {
                //Get all the value from form
                $id = $_POST['id'];
                $price = $_POST['price'];
                $qty = $_POST['quantity'];

                $total = $price * $qty;

                $status =$_POST['status'];

                $customer_name = $_POST['customer_name'];
                $customer_contact = $_POST['customer_contact'];
                $customer_email = $_POST['customer_email'];
                $customer_address = $_POST['customer_address'];

                //Update the value
                $sql2 = "UPDATE order_food SET
                    quantity = $qty,
                    total = $total,
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                    WHERE id = $id";

                $res2 = mysqli_query($conn, $sql2);

                // check whether the query executed successfully or not
                if($res2 ==TRUE) {

                    //Query Executed and admin Updated
                    $_SESSION['update'] = "<div class ='success'> Food order Updated Successfully </div>";
                    //Redirect to manage admin page
                    header('location:' .SITEURL.'admin/manage-order.php');

                }
                else {
                    //failed to update admin
                    $_SESSION['update'] = "<div class ='error'> Food order Updated Failed </div>";
                    //Redirect to manage admin page
                    header('location:' .SITEURL.'admin/manage-order.php');

                }
            }
        ?>



        </div>
</div>



<?php include('partials/footer.php');?>