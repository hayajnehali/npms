<?php
    $pages = '';
    isset($_GET['pages']) ? $pages =$_GET['pages'] : $pages='feed_info'; //get route user nedeed
    if(isset($_SESSION['user_id']))
    {
        if($pages == 'feed_info')
        {
            //include statistic file 
            include 'template/statistic.php';
            // get all data in user to comment
            $stmt = $con->prepare(" SELECT feedback.*,users.u_fullname,users.u_email
                                    FROM feedback
                                    INNER JOIN users on users.u_id =feedback.user_id
                                    ORDER BY id DESC");
            $stmt->execute();
            $rows = $stmt->fetchALL();
            ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Latest Feedback</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                                <td>Feedback</td>
                                <td>Full Name</td>
                                <td>E-mail</td>
                        </tr>
                        <?php foreach($rows as $row)
                        {
                        echo "<tr>";
                                echo "<td>".   $row['feedback']       ."</td>";
                                echo "<td>".   $row['u_fullname']      ."</td>";
                                echo "<td>".   $row['u_email']   ."</td>";
                        echo "</tr>";
                        }?>
                    </table>
                </div>
            </div>

<?php
        }

    }
    else
    {
        $theMsg = "";
        redirect_Home($theMsg,'log_rig/login.php',1);
    }
        
?>