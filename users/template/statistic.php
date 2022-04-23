<?php

    $ues_id = $_SESSION['user_id'];
    
?>

<!-- start statstic  -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Statisctcs </h3>
    </div>
    <div class="panel-body">
        <div class="col-md-3 col-xs-6">
            <div class="well mystat">
                <h4><i class="fa fa-product-hunt" aria-hidden="true"></i> Products</h4>
                <h4 class="text-center"><?php echo countRows('user_id','products',$ues_id); ?></h4>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="well mystat" >
                <h4><i class="fa fa-shopping-cart" aria-hidden="true"></i> Carts</h4>
                <h4 class="text-center"><?php echo countRows('user_id','carts',$ues_id); ?></h4>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="well mystat" >
                <h4><i class="fa fa-comments"></i> Comment</h4>
                <h4 class="text-center"><?php echo countRows('user_id','comments',$ues_id);?></h4>
            </div>
        </div>
        <?php
            $stmt =$con->prepare("SELECT COUNT(products.p_rate) as pcount,SUM(products.p_rate) as psum FROM `products` WHERE user_id=?");
            $stmt->execute(array($ues_id));
            $row =$stmt->fetch();
            
        ?>
        <div class="col-md-3 col-xs-6">
            <div class="well mystat">
                <h4><i class="fa fa-star" aria-hidden="true"></i> Rates</h4> 
                <h4 class="text-center"><?php
                    if($row['psum'] > 0 && $row['pcount'])
                    {
                        echo number_format($row['psum']/$row['pcount'] ,1)  ; 
                    }
                    else
                    {
                        echo '0';
                    }?>
                </h4>
            </div>
        </div>
    </div>
</div>
<!-- End statstic  -->