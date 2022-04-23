<?php
    $pages = '';
    isset($_GET['pages']) ? $pages =$_GET['pages'] : $pages='order_info'; //get route user nedeed

    if(isset($_SESSION['user_id']))
    {
        if($pages == 'order_info')
        {
            //include statistic file 
            include 'template/statistic.php';
            // get all data in user to comment
            $stmt = $con->prepare(" SELECT products.*,carts.c_statues ,cart_product.* FROM cart_product 
                                    INNER JOIN products on products.p_id =cart_product.prod_id
                                    INNER JOIN carts on carts.c_id = cart_product.cart_id
                                    WHERE carts.c_statues=2 AND products.user_id =?");
            $stmt->execute(array($_SESSION['user_id']));
            $rows = $stmt->fetchALL();
            
            ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Latest Orders</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                                <td>ID</td>
                                <td>Product Name</td>
                                <td>Image</td>
                                <td>Quantity</td>
                                <td>Ready Time</td>
                        </tr>
                        <?php
                        $i=1;
                        foreach($rows as $row)
                        {
                        echo "<tr>";
                                echo "<td>".   $i   ."</td>";
                                echo "<td>".   $row['p_name']       ."</td>";
                                echo "<td>";
                                        $image = explode(',', $row['p_image']);
                                        echo '<img style="width: 115px;height: 100px;" src="../admin/layout/image/'.$image[0].'">';
                                echo "</td>";
                                echo "<td>".   $row['Quantity']      ."</td>";
                                echo "<td>".   $row['p_time_ready'] * $row['Quantity'] ." Days </td>";
                        echo "</tr>";
                        $i++;
                        }?>
                    </table>
                </div>
            </div>




<?php
        }
        elseif($pages == 'comm_edit')
        {
            $stmt = $con->prepare(" SELECT * FROM comments where com_id=?");
            $stmt->execute(array($comid));
            $row = $stmt->fetch(); 
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Comments</h3>
                </div>
                <div class="panel-body">
                    <form action="?go=comments&pages=comm_update" method="POST">
                        <div class="form-group">
                            <label for=""> Comments :</label>
                            <input  type="text"
                                    name="comment"
                                    class="form-control" 
                                    placeholder="Enter Name Comments :"
                                    required="required"
                                    value="<?php echo $row['com_comment']?>"
                            >
                        </div>
                        
                        <input type="hidden" name="comm_id" value="<?php echo $row['com_id'];?>">
                        <button type="submit" class="btn btn-primary" style="float:right;">Save comment</button>
                    </form>
                </div>
            </div>
        <?php
        }elseif($pages == 'comm_update')
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $com_id =$_POST['comm_id'];
                $comment = $_POST['comment'];

                if(!empty($comment))
                {
                $stmt = $con->prepare(" UPDATE comments 
                                                SET com_comment     = ?,
                                                    com_create   = now()
                                                WHERE 
                                                    com_id = ?");
                    $stmt->execute(array($comment,$com_id));
                    $thsMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Recored Updated ! </div>" ;
                    redirect_Home($thsMsg,'index.php?go=comments',1);
                }
            }
        }
        elseif($pages == 'comm_delete')
        {
            $stmt = $con->prepare("DELETE FROM comments WHERE com_id = ?");
            $stmt->execute(array($comid));

            $thsMsg  = "<div class='alert alert-success'>" . $stmt->rowCount() . " Recored Delete ! </div>" ;
            redirect_Home($thsMsg,'index.php?go=comments',1);
        }
    }
    else
    {
        $theMsg = "";
        redirect_Home($theMsg,'log_rig/login.php',1);
    }
        
?>