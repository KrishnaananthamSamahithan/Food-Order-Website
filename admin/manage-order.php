<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1> Manage Order </h1>
        <br><br>

        <?php
             if(isset($_SESSION['update']))
             {
                 echo $_SESSION['update'];
                 unset ($_SESSION['update']);
             }  
        ?>

       

           
            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Customer Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>

                <?php
                    //Get all the details from database
                    $sql = "SELECT * FROM order_food ORDER BY id DESC";
                    //Execute the query
                    $res =mysqli_query($conn, $sql);
                    //Count the rows
                    $count = mysqli_num_rows($res);

                    $sn= 1; 

                    if($count>0)
                    {
                        //Order available
                        while($row=mysqli_fetch_assoc($res))
                        {
                            //Get all the order details
                            $id = $row['id'];
                            $food = $row['food'];
                            $price = $row['price'];
                            $qty = $row['quantity'];
                            $total = $row['total'];
                            $order_date = $row['order_date'];
                            $status = $row['status'];
                            $customer_name = $row['customer_name'];
                            $contact = $row['customer_contact'];
                            $email = $row['customer_email'];
                            $address = $row['customer_address'];

                            ?> 

                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $food ;?></td>
                                    <td><?php echo $price;?></td>
                                    <td><?php echo $qty;?></td>
                                    <td> <?php echo $total ?></td>
                                    <td><?php echo $order_date;?></td>
                                    <td>
                                    <?php
                                            // Ordered, On Delivery, Delivered, Cancelled

                                            if($status=="Ordered")
                                            {
                                                echo "<label>$status</lable>";
                                            }
                                            elseif($status=="On Delivery")
                                            {
                                                echo "<label style='color: orange;'>$status</label>";
                                            }
                                            elseif($status=="Deliverted")
                                            {
                                                echo "<label style='color: green;'>$status</label>";
                                            }
                                            elseif($status=="Cancelled")
                                            {
                                                echo "<label style='color: red;'>$status</label>";
                                            }
                                         ?>
                                    </td>
                                    <td><?php echo $customer_name;?></td>
                                    <td><?php echo $contact;?></td>
                                    <td><?php echo $email;?></td>
                                    <td><?php echo $address;?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary"> Update Order </a>
                                        
                                    </td>
                    
                            </tr>


                        <?php
                            
                        }
                    }
                    else
                    {
                        //Order not available
                        echo "<div class='error'> Order Not Available </div>";
                    }
                ?>

                
              
            </table>
   