<?php
    include '../admin/inti.php';
    include 'template/header.php';
    $cid = 1;
    $cid = isset($_GET['cate_id']) && !empty($_GET['cate_id']) ? $_GET['cate_id'] : 1; 
    $pid = 1;
    $pid = isset($_POST['prod_id']) && !empty($_POST['prod_id'])? $_POST['prod_id'] : 1;



    if(isset($_SESSION['user_name']) && !empty($_SESSION['user_name']))
    {
        if(isset($_POST['add_to_cart']))
        {
            if(isset($_SESSION['cart']))
            {
                $prod_ids = array_column($_SESSION['cart'] ,'prod_id');
                if(!in_array($pid ,$prod_ids))
                {
                    $count_carts = count($_SESSION['cart']);
                    $prod_cart = array(
                        'prod_id' => $_POST['prod_id'],
                        'prod_name' => $_POST['prod_name'],
                        'prod_price' => $_POST['prod_price'],
                        'prod_quanti' => $_POST['quanti'],
                        'prod_image' => $_POST['prod_image']
                    );
                    $_SESSION['cart'][$count_carts] =$prod_cart;
                }
                else
                {
                    echo '<script>alert("Product Exiests")</script>';
                }
            }
            else
            {
                $prod_cart = array(
                    'prod_id' => $_POST['prod_id'],
                    'prod_name' => $_POST['prod_name'],
                    'prod_price' => $_POST['prod_price'],
                    'prod_image' => $_POST['prod_image'],
                    'prod_quanti' => $_POST['quanti']
                );
                $_SESSION['cart'][0] =$prod_cart;
            }
        }
    }
    else
    {
        $_SESSION['cart'] = array();
    }

    // SELECT Product info in database
    $stmt = $con->prepare("SELECT * FROM `products` WHERE `products`.p_available = 1 AND `products`.`p_category` = ? ");
    $stmt->execute(array($cid));
    $rows = $stmt->fetchALL();
    if($stmt->rowCount() < 1)
    {
        $thsMsg = '<div class="alert alert-danger">No Products In This Category</div>';
        redirect_Home($thsMsg,'index.php');
    }

?>
        <!-- Start SideProduct -->
    <div class="col-md-9 col-sm-10 second">
                <?php
                    $i=3;
                    foreach($rows as $row)
                    {
                        $i--;
                        $image_all = explode(',',$row['p_image']);

                        if( $i < 0 )
                        {
                            echo '<div class="row">';
                        }
                        else
                        {
                            $i=3;
                        }
                        ?>
                            
                                <div class="col-md-4 col-sm-6 bg-black cart_product">
                                    <form action="<?php echo $_SERVER['PHP_SELF'].'?go=home_page&action=add_cart&prod_id='.$row['p_id']; ?>" method="POST">
                                        <input type="hidden" name="prod_id" value="<?php echo $row['p_id']?>">
                                        <input type="hidden" name="prod_name" value="<?php echo $row['p_name']?>">
                                        <input type="hidden" name="prod_price" value="<?php echo $row['p_price']?>">
                                        <input type="hidden" name="prod_image" value="<?php echo $row['p_image']?>">
                                        <input type="number" class="qrt" name="quanti" min="1" value="1">
                                        <button type ="submit" name='add_to_cart' class="btn">
                                            Add to Cart <i class = "fa fa-shopping-cart"></i>
                                        </button>
                                    </form>  
                                    <a href="Product_info.php?p_id=<?php echo $row['p_id'] ?>">
                                        <img src="../users/layout/image/<?php echo $image_all[0]?>" class="" alt="">
                                    </a>
                                    <div class="text-img">
                                        <span class="span1"></span>
                                        <span class="price"><?php echo number_format($row['p_price'],2)?>JD</span>
                                        <span class="name"><?php echo $row['p_name']?></span>
                                    </div> 
                                    <!-- <div class="shadow"></div> -->
                                </div>
                            
                        
            <?php       if($i<0)
                        {
                            echo '</div>';
                        }
            }  //End Foreach $rows  ?>
            
    </div>
    <!-- End SideProduct -->
    
    </div>

<?php
    include 'template/footer.php';
?>