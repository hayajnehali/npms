<?php
    $pages = '';
    isset($_GET['pages']) ? $pages =$_GET['pages'] : $pages='user_info'; //get route user nedeed
    $uid=0;
    // Get product d in [GET] Methode and check if number and parse [int]
    (isset($_GET['u_id']) && is_numeric($_GET['u_id'])) ? $uid= intval($_GET['u_id']):$uid=0;

    if(isset($_SESSION['user_id']))
    {
        if($pages == 'user_info')
        {
            //include statistic file 
            include 'template/statistic.php';
            // Select products in databes this user 
            $stmt = $con->prepare("SELECT * FROM users WHERE u_groupID = 2 ORDER BY u_id DESC LIMIT 10");
            $stmt->execute();
            $rows = $stmt->fetchALL();
            ?>
            <!-- Start latest products -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Latest Users</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                                <td>Name</td>
                                <td>E-mail</td>
                                <td>Full Name</td>
                                <td>Address</td>
                                <td>Phone</td>
                                <td>Controller</td>
                        </tr>
                        <?php foreach($rows as $row)
                        {
                        echo "<tr>";
                                echo "<td>".   $row['u_name']       ."</td>";
                                echo "<td>".   $row['u_email']      ."</td>";
                                echo "<td>".   $row['u_fullname']   ."</td>";
                                echo "<td>".   $row['u_address']    ."</td>";
                                echo "<td>".   $row['u_phone']      ."</td>";
                                echo "<td>";
                                    // contoller in show page
                                    echo "  <a  href='?go=users&pages=user_show&u_id=".$row['u_id']."' 
                                                class='btn btn-info btn-control'>
                                                <i class='fa fa-eye' aria-hidden='true'></i>
                                            </a>";
                                    
                                    // contoller in delete page
                                    echo "  <a  href='?go=users&pages=user_delete&u_id=".$row['u_id']."' 
                                                class='btn btn-danger btn-control'>
                                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                            </a>";
                                    
                                    // contoller in available page
                                    $clred = ($row['u_req_status'])? 'btn btn-success' : 'btn btn-danger';
                                    echo "  <a  href='?go=users&pages=user_approve&u_id=".$row['u_id']."' 
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
        elseif($pages == 'user_show')
        {
            $stmt = $con->prepare("SELECT * FROM users WHERE u_id=?");
            $stmt->execute(array($uid));
            $row = $stmt->fetch();    
        ?>
            <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">personal information</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-3">
                            <img src="layout/image/<?php echo $row['avatar']?>" class="img-thumbnail" style="height: 224px; width: 100%;">
                        </div>
                        <div class="col-md-6" style="width: 75%;">
                            <h2><?php echo $row['u_fullname']; ?> </h2>
                            <p ><?php echo $row['u_describe'];  ?></p>
                            <span class="spandisp"><i class="fa fa-envelope" aria-hidden="true"></i> Email : <?php echo $row['u_email']; ?></span>
                            <span class="spandisp"><i class="fa fa-phone" aria-hidden="true"></i> phone : <?php echo $row['u_phone']; ?></span>
                            <span class="spandisp"><i class="fa fa-calendar" aria-hidden="true"></i>  Bdate : <?php echo  $row['u_bdate'] ?> </span>
                            <span class="spandisp"><i class="fa fa-location-arrow" aria-hidden="true"></i>  Address : <?php echo $row['u_address']?></span>
                        </div>
                    </div>
                </div>
<?php   }
        elseif($pages == 'user_approve')
        {
            $stmt = $con->prepare("UPDATE users SET `u_req_status` = NOT`u_req_status` WHERE u_id = ?");
            $stmt->execute(array($uid));
            $thsMsg  = "<div class='alert alert-success'>" . $stmt->rowCount() . " Recored Appeoved ! </div>" ;
            if($stmt->rowCount() > 0)
            {
                redirect_Home($thsMsg,'index.php?go=users',1);
            }
            
            
        }

        elseif($pages == 'user_delete')
        {
            $stmt = $con->prepare("DELETE FROM users WHERE u_id = ?");
            $stmt->execute(array($uid));

            $thsMsg  = "<div class='alert alert-success'>" . $stmt->rowCount() . " Recored Delete ! </div>" ;
            redirect_Home($thsMsg,'index.php?go=users',1);
        }
    }
    else
    {
        header("location:login.php");
    }

?>