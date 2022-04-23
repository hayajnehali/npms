<?php
    
    $pages = '';
    isset($_GET['pages']) ? $pages =$_GET['pages'] : $pages='prod_info'; //get route user nedeed
    $pid=0;
    // Get product d in [GET] Methode and check if number and parse [int]
    (isset($_GET['p_id']) && is_numeric($_GET['p_id'])) ? $pid= intval($_GET['p_id']):$pid=0;

    if(isset($_SESSION['user_id']))
    {
        if($pages == 'prod_info')
        {
            //include statistic file 
            include 'template/statistic.php';
            // Select products in databes this user 
            $stmt = $con->prepare(" SELECT products.*,category.cate_name FROM products 
                                    INNER JOIN category on category.cate_id =products.p_category
                                    ORDER BY p_id DESC LIMIT 10");
            $stmt->execute();
            $rows = $stmt->fetchALL();
            ?>
            <!-- Start latest products -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Latest products</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                                <td>Name</td>
                                <td>Price</td>
                                <td>Detailes</td>
                                <td>Available</td>
                                <td>Category</td>
                                <!-- <td>rate</td> -->
                                <td>Controller</td>
                        </tr>
                        <?php foreach($rows as $row)
                        {
                        echo "<tr>";
                                echo "<td>".   $row['p_name']       ."</td>";
                                echo "<td>".   $row['p_price']      ."</td>";
                                echo "<td>".   $row['p_describe']   ."</td>";
                                echo "<td>";
                                        echo ($row['p_available'])?'In Stock': 'No Stock'  ;
                                echo "</td>";
                                echo "<td>".   $row['cate_name']  ."</td>";
                                // echo "<td>";
                                //     for($i=1;$i<=$row['p_rate'];$i++)
                                //     {
                                //         echo "<i class='fa fa-star' aria-hidden='true'></i>"; 
                                //     } 
                                echo "</td>";
                                echo "<td>";
                                    // contoller in show page
                                    echo "  <a  href='?go=products&pages=prod_show&p_id=".$row['p_id']."' 
                                                class='btn btn-info btn-control'>
                                                <i class='fa fa-eye' aria-hidden='true'></i>
                                            </a>";
                                    // contoller in delete page
                                    echo "  <a  href='?go=products&pages=prod_delete&p_id=".$row['p_id']."' 
                                                class='btn btn-danger btn-control'>
                                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                            </a>";
                                    // contoller in available page
                                    $clred = ($row['p_requ'])? 'btn btn-success' : 'btn btn-danger';
                                    echo "  <a  href='?go=products&pages=prod_approve&p_id=".$row['p_id']."' 
                                                class='$clred btn-control'>
                                                    <i class='fa fa-check' aria-hidden='true'></i>
                                            </a>";

                                echo "</td>";
                                
                        echo "</tr>";
                        }?>
                    </table>
                </div>
            </div>
            <!-- End latest users -->
<?php   }
        elseif($pages == 'prod_show')
        {
            // Get product d in [GET] Methode and check if number and parse [int]
            (isset($_GET['p_id']) && is_numeric($_GET['p_id'])) ? $pid= intval($_GET['p_id']):$pid=0;
            // Select all data in databes where user_
            $stmt = $con->prepare(" SELECT products.* ,users.u_name ,category.cate_name 
                                    FROM products
                                    INNER JOIN users ON users.u_id = products.user_id 
                                    INNER JOIN category ON category.cate_id = products.p_category
                                    WHERE `p_id`=?");
            $stmt->execute(array($pid));
            $row = $stmt->fetch();                      ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">show Product</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-3">
                        <?php

                        $img_Prod = explode(',' , $row['p_image']);
                        for($i=0;   $i<count($img_Prod);    $i++)
                        {
                            echo "<img src='layout/image/".$img_Prod[$i]."' class='img-thumbnail' style='height: 100px; width: 100%;'>";
                        }
                        ?>
                    </div>
                    <div class="col-md-6" style="width: 75%;">
                        <h2><?php echo $row['p_name'] ?> </h2>
                        <p>  <?php echo $row['p_describe'] ?>   </p>
                        <span style="display: block;color: #00ADB5;"> 
                            <?php
                                for($i=1 ;$i<=$row['p_rate'];$i++)
                                {
                                    echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                }
                            ?>
                            <span style="margin-left: 15px;">review <?php echo floatval($row['p_rate'])?></span>
                        </span>
                        <h3 style="color: darkgreen;">JD <?php echo $row['p_price'];  ?></h3>
                        <span class="spandisp"><i class="fa fa-check-square-o" aria-hidden="true"></i> avalability : <?php echo ($row['p_available'])? 'In stock':'No stock'; ?></span>
                        <span class="spandisp"><i class="fa fa-list-alt" aria-hidden="true"></i> Category : <?php echo $row['cate_name']?></span>
                        <span class="spandisp"><i class="fa fa-user" aria-hidden="true"></i>  name users : <?php echo  $row['u_name']?></span>
                    </div>
                </div>
            </div>
<?php   }
        elseif($pages == 'prod_aval')
        {
            $stmt = $con->prepare("UPDATE products SET `p_available` = NOT`p_available` WHERE p_id = ?");
            $stmt->execute(array($pid));
            $thsMsg  = "<div class='alert alert-success'>" . $stmt->rowCount() . " Recored Availiable ! </div>" ;
            if($stmt->rowCount() > 0)
            {
                redirect_Home($thsMsg,'index.php?go=products',1);
            }
            
            
        }
        elseif($pages == 'prod_approve')
        {
            $stmt = $con->prepare("UPDATE products SET `p_requ` = NOT`p_requ` WHERE p_id = ?");
            $stmt->execute(array($pid));
            $thsMsg  = "<div class='alert alert-success'>" . $stmt->rowCount() . " Recored Appeoved ! </div>" ;
            if($stmt->rowCount() > 0)
            {
                redirect_Home($thsMsg,'index.php?go=products',1);
            }
            
            
        }
        elseif($pages == 'prod_delete')
        {
            $stmt = $con->prepare("DELETE FROM products WHERE p_id = ?");
            $stmt->execute(array($pid));

            $thsMsg  = "<div class='alert alert-success'>" . $stmt->rowCount() . " Recored Delete ! </div>" ;
            redirect_Home($thsMsg,'index.php?go=products',1);
        }
    }
    else
    {
        header("location:login.php");
    }

?>