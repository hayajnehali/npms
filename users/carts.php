<?php
date_default_timezone_set('Asia/Amman');

    $pages = '';
    isset($_GET['pages']) ? $pages =$_GET['pages'] : $pages='cart_info'; //get route user nedeed

    if(isset($_SESSION['user_name']))
    {
        if($pages == 'cart_info')
        {
            include 'template/statistic.php';
            $stmt = $con->prepare(" SELECT carts.* , users.u_fullname 
                                    FROM carts 
                                    INNER JOIN users 
                                    ON users.u_id = carts.user_id AND  carts.user_id=?
                                    ");
            $stmt->execute(array($_SESSION['user_id']));
            $rows = $stmt->fetchALL(); 
            
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Latest Carts</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                                <td>Carts ID</td>
                                <td>Address</td>
                                <td>Name Users</td>
                                <td>Total Product</td>
                                <td>Date</td>
                                <td>Controller</td>
                        </tr>
                        <?php
                        foreach($rows as $row)
                        {
                            echo "<tr>";
                                echo "<td>".   $row['c_id']       ."</td>";
                                echo "<td>".   $row['c_address']      ."</td>";
                                echo "<td>".   $row['u_fullname']   ."</td>";
                                echo "<td>".   $row['c_total_product']  ."</td>";
                                echo "<td>"; 
                                    $date = new DateTime( $row['c_create']);
                                    
                                    echo $row['c_create'] ;
                                echo "</td>";
                                echo "<td><a href='?go=carts&pages=cart_info&c_id=".$row['c_id']."&date_cart=".$date->format("y-m-d h:i:s")."' class='btn btn-info btn-control'><i class='fa fa-eye' aria-hidden='true'></i></a></td>";
                            echo "</tr>";
                        }        
                        ?>
                    </table>
                    <a href="../homes/index.php" class="btn btn-primary" style="float:right;">Add Cart</a>
                </div>
            </div>
    <?php
            if(isset($_GET['c_id']) && is_numeric($_GET['c_id']))
            {
                $stmt = $con->prepare(" SELECT 
                                            * 
                                        FROM 
                                            users,products
                                        INNER JOIN cart_product ON cart_product.prod_id = products.p_id
                                        WHERE cart_product.cart_id = ? AND users.u_id =products.user_id
            ");
                $stmt->execute(array($_GET['c_id']));
                $rows = $stmt->fetchALL(); ?>
                <!-- Start show carts -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Show Carts ID : <?php echo $_GET['c_id']  ?></h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <td>number product</td>
                                <td>Name</td>
                                <td>price</td>
                                <td>Quantity</td>
                                <td>cartete</td>
                                <td>Name user</td>
                            </tr>
                            <tr>
                                <?php
                                    $total_price=0;
                                    $maxtime =0;
                                    $i = 1;
                                    foreach($rows as $row)
                                    {
                                        echo '<tr>';
                                            echo "<td>".$i."</td>";
                                            echo "<td>".$row['p_name']."</td>";
                                            echo "<td>".$row['p_price']."</td>";
                                            echo "<td>".$row['Quantity']."</td>";
                                            echo "<td>".$row['p_create']."</td>";
                                            echo "<td>".$row['u_name']."</td>";
                                            $total_price+= $row['p_price'] * $row['Quantity'];
                                        echo '</tr>';
                                        $i++;
                                        $timeready = $row['p_time_ready'] * $row['Quantity'];
                                                        if($timeready >= $maxtime )
                                                        {
                                                            $maxtime = $timeready;
                                                        }
                                    }
                                    if(strtotime($_GET['date_cart'],time()+$maxtime*60*60) > strtotime(date('Y-m-d h:i:s')))
                                    {
                                        $stmt =$con->prepare('UPDATE `carts` SET `c_statues`= 1 WHERE c_id=?');
                                        $stmt->execute(array($_GET['c_id']));
                                        echo '<div class="alert alert-success">The Cart Complate</div> ';
                                    }
                                    else
                                    {
                                        $stmt =$con->prepare('UPDATE `carts` SET `c_statues`= 2 WHERE c_id=?');
                                        $stmt->execute(array($_GET['c_id']));
                                        echo '<div class="alert alert-warning">The Cart Waiting To Produce Products</div>';
                                    }
                                ?>
                            </tr>
                        </table>
                        
                        <h4 class="text-center" style="color: red;"><?php echo 'Total price   =' . $total_price . ' JD '; ?></h4>
                        <h4 class="text-center" style="color: red;"><?php echo 'Time To ready = ' . $maxtime . ' Days '; ?></h4>
                    </div>
                </div>
    <?php
            }
        }
    }
    else
    {
        $thsMsg ="";
        redirect_Home($thsMsg,"log_rig/login.php");
    }
    

?>