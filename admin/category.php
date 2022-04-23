<?php
    
    $pages = '';
    isset($_GET['pages']) ? $pages =$_GET['pages'] : $pages='cate_info'; //get route user nedeed
    $cateid=0;
    // Get product d in [GET] Methode and check if number and parse [int]
    (isset($_GET['cate_id']) && is_numeric($_GET['cate_id'])) ? $cateid= intval($_GET['cate_id']):$cateid=0;

    if(isset($_SESSION['user_id']))
    {
        if($pages == 'cate_info')
        {
            //include statistic file 
            include 'template/statistic.php';
            // Select products in databes this user 
            $stmt = $con->prepare("SELECT * FROM category ORDER BY cate_id DESC LIMIT 10");
            $stmt->execute();
            $rows = $stmt->fetchALL();?>
            <!-- Start latest products -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Latest Category</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                                <td>Name</td>
                                <td>Controller</td>
                        </tr>
                        <?php foreach($rows as $row)
                        {
                        echo "<tr>";
                                echo "<td>".   $row['cate_name']       ."</td>";
                                echo "<td>";
                                    // contoller in edit page 
                                    echo "  <a href='?go=category&pages=cate_edit&cate_id=".$row['cate_id'] . "' 
                                                class='btn btn-primary btn-control'>
                                                    <i class='fa fa-pencil-square-o' aria-hidden='true'></i>
                                            </a>";
                                    
                                    // contoller in delete page
                                    echo "  <a  href='?go=category&pages=cate_delete&cate_id=".$row['cate_id']."' 
                                                class='btn btn-danger btn-control'>
                                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                            </a>";

                                echo "</td>";
                                
                        echo "</tr>";
                        }?>
                    </table>
                </div>
            </div>
            <a href="?go=category&pages=cate_add" class="btn btn-primary" style="float:right;">Add Category</a>
            <!-- End latest users -->
<?php   }
        elseif($pages == 'cate_add')
        {?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Category</h3>
                </div>
                <div class="panel-body">
                    <form action="?go=category&pages=cate_insert" method="POST">
                        
                        <div class="form-group">
                            <label for="">Name Category :</label>
                            <input  type="text"
                                    name="ca_name"
                                    class="form-control" 
                                    placeholder="Enter Name Category :"
                                    required="required"
                            >
                        <button type="submit" class="btn btn-primary" style="float:right;">Add Category</button>
                    </form>
                </div>
            </div>
<?php   }
        elseif($pages == "cate_insert")
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $cate_name          = $_POST['ca_name'];

                $formErrors = array();
                if(empty($cate_name))
                {
                    $formErrors[] = ' [ product Name ] Cant be Empty';
                }
                if(strlen($cate_name) < 4)
                {
                    $formErrors[] = ' [ product Name ] Cant be less 4 Char';
                }
                
                if(empty($formErrors))
                {
                    //insert query bind paragram
                    $stmt =$con->prepare("  INSERT INTO category(`cate_name`,`user_id`)
                                            VALUES( :cName,:uids)");
                    $stmt->execute(array(
                        'cName'     => $cate_name,
                        'uids'       => $_SESSION['user_id'],
                    ));
                    //  echo success Message Update
                    $thsMsg ="<div class='alert alert-success'>" . $stmt->rowCount() . " Recored Inserted ! </div>" ;
                    redirect_Home($thsMsg,'index.php?go=category');
                }
                else
                {
                    // print the error in 
                    foreach($formErrors as $error)
                    {
                        echo "<div class='alert alert-danger mt-3'>" . $error ."</div>";
                    }
                    redirect_Home('','back');
                }
            }
            else
            {

                $thsMsg = "<div class='alert alert-danger'> No Dirctory pages </div>";
                
                redirect_Home($thsMsg,'index.php?go=products');
            }
        }
        elseif($pages == "cate_edit")
        {
            // SELECT row in databes in ID And Fetch data 
            $stmt = $con->prepare("SELECT * FROM `category` WHERE `cate_id`=?");
            $stmt->execute(array($cateid));
            $row = $stmt->fetch();
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Category</h3>
                </div>
                <div class="panel-body">
                    <form action="?go=category&pages=cate_update" method="POST">
                        <input type="hidden" name="ca_id" value="<?php echo $cateid ?>">
                        <div class="form-group">
                            <label for="">Name Product :</label>
                            <input  type="text"
                                    name="ca_name"
                                    class="form-control" 
                                    placeholder="Enter Name category :"
                                    required="required"
                                    value="<?php echo $row['cate_name']; ?>"
                            >
                        </div>
                        <button type="submit" class="btn btn-primary" style="float:right;">Save prodcut</button>
                    </form>
                </div>
            </div>
<?php   }
        elseif($pages == 'cate_update')
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                
                // Fet The Product info in From Edit
                $caid = $_POST['ca_id'];
                $caname = $_POST['ca_name'];
            
                
                // validate form error
                $formErrors = array();
                if(empty($caname))
                {
                    $formErrors[] = ' [ Category Name ] Cant be Empty';
                }
                if(strlen($caname) < 4)
                {
                    $formErrors[] = ' [ Category Name ] Cant be less 4 Char';
                }

                if(empty($formErrors))
                {
                    $stmt = $con->prepare(" UPDATE category 
                                                SET cate_name = ?
                                                WHERE 
                                                    cate_id = ?");
                    $stmt->execute(array($caname,$caid));

                    $thsMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Recored Updated ! </div>" ;
                    redirect_Home($thsMsg,'index.php?go=category');
                }
            }
            else
            {
                $thsMsg  = "<div class='alert alert-danger'> NO Directy pages </div>" ;
                redirect_Home($thsMsg,'index.php?go=category');
            }
        }
        elseif($pages == 'cate_delete')
        {
            $stmt = $con->prepare("DELETE FROM category WHERE cate_id = ?");
            $stmt->execute(array($cateid));

            $thsMsg  = "<div class='alert alert-success'>" . $stmt->rowCount() . " Recored Delete ! </div>" ;
            redirect_Home($thsMsg,'index.php?go=category',1);
        }
    }
    else
    {
        header("location:login.php");
    }

?>