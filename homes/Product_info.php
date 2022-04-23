    <?php
        include '../admin/inti.php';
        include 'template/header.php';
        $pid=0;
        $pid =(isset($_GET['p_id']) && is_numeric($_GET['p_id']))?$_GET['p_id']:0;

        $stmt =$con->prepare("  SELECT products.*,users.u_name,category.cate_name  FROM `products` 
                                INNER JOIN users ON users.u_id =products.user_id
                                INNER JOIN category ON category.cate_id=products.p_category
                                WHERE products.p_id = ?");
        $stmt->execute(array($pid));
        $row = $stmt->fetch();
        
    ?>
        <!-- Start SideProduct -->
        <div class="col-md-9 col-sm-10 second">
            <div class = "card-wrapper">
                <div class = "card">
                <!-- card left -->
                <div class = "product-imgs">
                    <div class = "img-display">
                    <div class = "img-showcase">
                        <?php  
                            $img_all = explode(',',$row['p_image']);

                            foreach($img_all as $imgf)
                            {
                                
                                echo '<img style="width: 114px; height: 411px;" src = "../admin/layout/image/'.$imgf.'" style="" alt = "shoe image">';
                            }
                        ?>
                        
                    </div>
                    </div>
                    <div class = "img-select">
                        <?php
                            $i=1;
                            foreach($img_all as $imgf)
                            { 

                                echo '<div class = "img-item">';
                                    echo '<a href = "#" data-id = "'.$i.'">';
                                    echo '<img style="width: 124px;height: 101px;" src = "../admin/layout/image/'.  $imgf.'" alt = "shoe image">';
                                    echo '</a>';
                                echo '</div>';
                                $i++;
                                if($i >5)
                                {
                                    $i=1;
                                }
                            }
                        ?> 
                    </div>
                    
                </div>
                <!-- card right -->
                <div class = "product-content">
                    <h2 class = "product-title"><?php echo $row['p_name'];?></h2>
                    <div class = "product-rating">
                        <input type="radio" name="star" id="star1"><label for="star1"></label>
                        <input type="radio" name="star" id="star2"><label for="star2"></label>
                        <input type="radio" name="star" id="star3"><label for="star3"></label>
                        <input type="radio" name="star" id="star4"><label for="star4"></label>
                        <input type="radio" name="star" id="star5"><label for="star5"></label>
                        <span><?php echo $row['p_rate']?></span>
                    </div>

                    <div class = "product-price">
                    <p class = "last-price">Old Price: <span><?php echo number_format( $row['p_price'],2)?>JD</span></p>
                    <p class = "new-price">New Price: <span><?php echo number_format( $row['p_price']-($row['p_price']/(100/5)), 2)?>JD(5%)</span></p>
                    </div>
        
                    <div class = "product-detail">
                    <h1>about this item: </h1>
                    <p><?php echo $row['p_describe']?></p>
                    <ul>
                        <li>Producer: <span>
                            <?php echo $row['u_name']?>
                            </span>
                        </li>
                        <li>Available: <span>
                            <?php echo ($row['p_available']>0)? 'In Stock':"Not Stock" ?>
                            </span></li>
                        <li>Shipping Fee: <span>Free</span></li>
                        <li>Time To Prepare The Product: <span>
                            <?php echo $row['p_time_ready'] . 'Days'?>
                        </span></li>
                    </ul>
                    </div>
        
                    <div class = "purchase-info">
                    <form action="<?php echo 'index.php?go=home_page&action=add_cart&prod_id='.$row['p_id']; ?>" method="POST">
                        <input type="hidden" name="prod_id" value="<?php echo $row['p_id']?>">
                        <input type="hidden" name="prod_name" value="<?php echo $row['p_name']?>">
                        <input type="hidden" name="prod_price" value="<?php echo $row['p_price']?>">
                        <input type="hidden" name="prod_image" value="<?php echo $row['p_image']?>">
                        <input type="hidden" name="prod_ready" value="<?php echo $row['p_time_ready']?>">
                        <input type="number" class="qrt1" name="quanti" min="1" value="1">
                        <button type ="submit" name='add_to_cart' class="btn">
                            Add to Cart <i class = "fa fa-shopping-cart"></i>
                        </button>
                    </form> 
                    </div>
                    
                </div>
                </div>
            </div>
            <!-- Cart Comment -->
            <?php 
                $stmt =$con->prepare("  SELECT comments.*,users.u_name FROM comments
                                        INNER JOIN products on products.p_id = comments.product_id
                                        INNER JOIN users on users.u_id = comments.user_id
                                        WHERE products.p_id =?");
                $stmt->execute(array($pid));
                $rows = $stmt->fetchALL();?>
            <form action="?p_id=<?php echo $row['p_id']?>" method="POST" class="comment-form">
                <?php
                    foreach($rows as $row)
                    {
                        echo '<span class="User-name">'.$row['u_name'].'</span>';
                        echo '<p class="comment-content">'.$row['com_comment'].'</p>';
                        echo '<hr>';
                    }
                ?>
                <input type="text" name="comment" placeholder="Comment...">
                <input type="hidden" name="user_id"value="<?php echo $_SESSION['user_id']?>" placeholder="Comment...">
                <input type="hidden" name="prod_id"value="<?php echo $pid?>" placeholder="Comment...">
                <button type = "submit" name="add_comm" class = "btn">
                    Comment <i class="fa fa-comment fa-1x"></i>
                </button>
            </form>
        </div>
        <!-- ADD Comments -->
        <?php
                if(isset($_POST['add_comm']))
                {
                    $comm =$_POST['comment'];
                    $userid =$_SESSION['user_id'];
                    if(!empty($comm))
                    {
                        $stmt =$con->prepare("  INSERT INTO `comments`(`com_comment`, `com_create`, `user_id`, `product_id`) VALUES('$comm' ,now(),'$userid','$pid')");
                        $stmt->execute();
                    }
                
                }
        ?>
        <!-- End SideProduct -->
        </div> 

    <?php
    include 'template/footer.php';

    ?>