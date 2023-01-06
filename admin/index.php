<?php include('partials/menu.php');?>

        <!-- Main Contant Section Start -->
        <div class="main-content">
            <div class="wrapper">
                <h1> Dashboard </h1>

                <br><br>

                <?php
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                        unset ($_SESSION['login']);
                    }
                ?>
               
            
                  
                <br><br>

                <div class="col-4 text-center">
                    <?php
                        //sql query
                        $sql = "SELECT * FROM category";
                        //Ececute query
                        $res = mysqli_query($conn, $sql);
                        //Count row
                        $count = mysqli_num_rows($res);
                    ?>
                    <h1> <?php echo $count; ?></h1>
                    <br/>
                    Categories
                </div>

                <div class="col-4 text-center">
                <?php
                        //sql query
                        $sql2 = "SELECT * FROM food";
                        //Ececute query
                        $res2 = mysqli_query($conn, $sql2);
                        //Count row
                        $count2 = mysqli_num_rows($res2);
                    ?>
                    <h1> <?php echo $count2; ?></h1>
                    <br/>
                    Foods
                </div>

                <div class="col-4 text-center">
                <?php
                        //sql query
                        $sql3 = "SELECT * FROM order_food";
                        //Ececute query
                        $res3 = mysqli_query($conn, $sql3);
                        //Count row
                        $count3 = mysqli_num_rows($res3);
                    ?>
                    <h1> <?php echo $count3; ?></h1>
                    <br/>
                    Total Orders
                </div>

                <div class="col-4 text-center">

                <?php
                    //Create sql query to get the total revenue
                    //Aggregate function in sql
                    $sql4 = "SELECT SUM(total) AS Total FROM order_food WHERE status = 'Deliverted'";
                    //Ececute query
                    $res4 = mysqli_query($conn, $sql4); 

                    // Get the value
                    $row4 = mysqli_fetch_assoc($res4);

                    //Get the total revenuw
                    $total_revenue = $row4['Total'];
                ?>
                    <h1> Rs <?php echo $total_revenue; ?></h1>
                    <br/>
                    Revenue Generated
                </div>

                <div class="clearfix"></div>

               
            </div>   
        </div>    
        <!-- Main Contant Section Ends -->


<?php include('partials/footer.php');?>