<?php
    include '../admin/inti.php';
    include 'template/header.php';
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart']))
    {
        ?>
        <!-- Start SideProduct -->
                <div class="col-md-9 col-sm-10 second">
                    <div class="row">
                        <div class="col-12 col-lg-8" style="margin-top: 63px;">
                            <h3>Shopping Cart</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>image</th>
                                        <th>Name</th>
                                        <th>price</th>
                                        <th>quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                            $maxtime = 0;
                                            $totalp =0;
                                            foreach($_SESSION['cart'] as $row)
                                            {
                                                $totalp +=$row['prod_price'] * $row['prod_quanti'] ;
                                            ?>
                                            <tr>
                                                <td><img style="width: 120px;height:80px" src="../admin/layout/image/<?php $img1 =explode(',',$row['prod_image']); echo $img1[0];   ?>"></td>
                                                <td><h5><?php echo $row['prod_name']?></h5></td>
                                                <td><?php echo number_format( $row['prod_price'],2)?>JD</td>
                                                <td><?php echo $row['prod_quanti'] ?></td>
                                                <?php $timeready = $row['prod_ready'] * $row['prod_quanti'];
                                                        if($timeready >= $maxtime )
                                                        {
                                                            $maxtime = $timeready;
                                                        }
                                                ?>
                                            </tr>
                                            <?php }  ?>
                                    
                                    
                                </tbody>
                            </table>

                        </div>
                        <div class="col-12 col-lg-4" >
                            <div class="cart-summary">
                                        <h5>Cart Total</h5>
                                        <ul class="summary-table">
                                            <li><span>subtotal:</span> <span><?php echo $totalp ?>JD</span></li>
                                            <li><span>delivery:</span> <span>100</span></li>
                                            <li><span>Time To delivery:</span> <span><?php echo $maxtime . ' Days' ?></span></li>
                                            <li><span>total:</span> <span><?php echo $totalp+100 ?>JD</span></li>
                                        </ul>
                                        <div class="cart-btn mt-100">
                                            <a href="?go=addcart" onclick="alert('inserted row')" class="btn amado-btn w-100">Checkout</a>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>
        </div>
        <?php
                // insert data cart in databess
                $userid = $_SESSION['user_id'];
                $cart = isset($_SESSION['cart']) ?$_SESSION['cart'] : 0;
                $go = isset($_GET['go'])? $_GET['go']:'home_page';
                $couCarts = count($_SESSION['cart']);
                if($go == 'addcart')
                {
                    $stmt = $con->prepare(" INSERT INTO `carts`(`c_address`, `c_statues`, `c_total_price`, `c_total_product`, `c_create`, `user_id`) 
                                            VALUES ('Jordan,irbd','2',$totalp,$couCarts,now(),$userid) ");
                    $stmt->execute();
                    
                    if($stmt->rowCount() > 0)
                    {
                        $stmt = $con->prepare(" SELECT c_id FROM carts ORDER BY c_id DESC LIMIT 1 ");
                        $stmt->execute();
                        $ca=$stmt->fetch();
                        $cartid =$ca['c_id'];
                        for($i=0;$i<$couCarts;$i++)
                        {
                            $prodid = $cart[$i]["prod_id"];
                            $quat = $cart[$i]["prod_quanti"];
                            $stmt = $con->prepare(" INSERT INTO `cart_product`(`cart_id`, `prod_id`, `Quantity`) VALUES ($cartid,$prodid,$quat) ");
                            $stmt->execute();
                        }
                        $_SESSION['cart'] = null;
                    }
                    else
                    {
                        echo 'no';
                    }
                    
                    
                }
                
        

    }
    else
    {
        redirect_Home('','index.php');
    }
    
    
    
    include 'template/footer.php';
    ?>