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
                                    ORDER BY com_id DESC");
            $stmt->execute();
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