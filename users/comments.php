<?php
    $pages = '';
    isset($_GET['pages']) ? $pages =$_GET['pages'] : $pages='comm_info'; //get route user nedeed
    $comid=0;
    // Get product d in [GET] Methode and check if number and parse [int]
    (isset($_GET['com_id']) && is_numeric($_GET['com_id'])) ? $comid= intval($_GET['com_id']):$comid=0;

    if(isset($_SESSION['user_id']))
    {
        if($pages == 'comm_info')
        {
            //include statistic file 
            include 'template/statistic.php';
            // get all data in user to comment
            $stmt = $con->prepare(" SELECT comments.*,products.p_name,users.u_name
                                    FROM comments
                                    INNER JOIN products on products.p_id =comments.product_id
                                    INNER JOIN users on users.u_id =comments.user_id
                                    WHERE comments.user_id =?");
            $stmt->execute(array($_SESSION['user_id']));
            $rows = $stmt->fetchALL();
            ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Latest Comments</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                                <td>Comment</td>
                                <td>Create_At</td>
                                <td>User Name</td>
                                <td>Product Name</td>
                                <td>Controller</td>
                        </tr>
                        <?php foreach($rows as $row)
                        {
                        echo "<tr>";
                                echo "<td>".   $row['com_comment']       ."</td>";
                                echo "<td>".   $row['com_create']      ."</td>";
                                echo "<td>".   $row['u_name']   ."</td>";
                                echo "<td>";
                                        echo $row['p_name'];
                                echo "</td>";
                                echo "<td>";
                                    // contoller in edit page 
                                    echo "  <a href='?go=comments&pages=comm_edit&com_id=".$row['com_id'] . "' 
                                                class='btn btn-primary btn-control'>
                                                    <i class='fa fa-pencil-square-o' aria-hidden='true'></i>
                                            </a>";
                                    // contoller in delete page
                                    echo "  <a  href='?go=comments&pages=comm_delete&com_id=".$row['com_id']."' 
                                                class='btn btn-danger btn-control'>
                                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                            </a>";
                                echo "</td>";
                                
                        echo "</tr>";
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
                        <button type="submit" class="btn btn-primary" style="float:right;">Save Comment</button>
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