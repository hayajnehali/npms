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
            $stmt = $con->prepare(" SELECT products.*,category.cate_name 
                                    FROM products,category 
                                    WHERE category.cate_id = products.p_category AND products.user_id=?");
            $stmt->execute(array($_SESSION['user_id']));
            $rows = $stmt->fetchALL();?>
            <!-- Start latest products -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Latest Products</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                                <td>Name</td>
                                <td>Price</td>
                                <td>Detailes</td>
                                <td>Avaliable</td>
                                <td>Cateygory</td>
                                <td>Rate</td>
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
                                echo "<td>";
                                    for($i=1;$i<=$row['p_rate'];$i++)
                                    {
                                        echo "<i class='fa fa-star' aria-hidden='true'></i>"; 
                                    } 
                                echo "</td>";
                                echo "<td>";
                                    // contoller in edit page 
                                    echo "  <a href='?go=products&pages=prod_edit&p_id=".$row['p_id'] . "' 
                                                class='btn btn-primary btn-control'>
                                                    <i class='fa fa-pencil-square-o' aria-hidden='true'></i>
                                            </a>";
                                    // contoller in show page
                                    echo "  <a  href='?go=products&pages=prod_show&p_id=".$row['p_id']."' 
                                                class='btn btn-info btn-control'>
                                                <i class='fa fa-eye' aria-hidden='true'></i>
                                            </a>";
                                    // contoller in available page
                                    $clred = ($row['p_available'])? 'btn btn-success' : 'btn btn-danger';
                                    echo "  <a  href='?go=products&pages=prod_aval&p_id=".$row['p_id']."' 
                                                class='$clred btn-control'>
                                                    <i class='fa fa-check' aria-hidden='true'></i>
                                            </a>";
                                    // contoller in delete page
                                    echo "  <a  href='?go=products&pages=prod_delete&p_id=".$row['p_id']."' 
                                                class='btn btn-danger btn-control'>
                                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                            </a>";

                                echo "</td>";
                                
                        echo "</tr>";
                        }?>
                    </table>
                </div>
            </div>
            <a href="?go=products&pages=prod_add" class="btn btn-primary" style="float:right;">Add Product</a>
            <!-- End latest users -->
<?php   }
        elseif($pages == 'prod_add')
        {
            $stmt =$con->prepare("SELECT * FROM category");
            $stmt->execute();
            $rows = $stmt->fetchALL();
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Product</h3>
                </div>
                <div class="panel-body">
                    <form action="?go=products&pages=prod_insert" method="POST" enctype="multipart/form-data">
                        
                        <div class="form-group">
                            <label for="">Name Product :</label>
                            <input  type="text"
                                    name="pr_name"
                                    class="form-control" 
                                    placeholder="Enter Name Product :"
                                    required="required"
                            >
                        </div>
                        <div class="form-group">
                            <label for="price">price</label>
                            <input  type="number" 
                                    class="form-control" 
                                    name="pr_price" 
                                    placeholder="Enter The Price :"
                                    required="required"
                            >
                        </div>
                        <div class="form-group">
                            <label>Time Of Ready</label>
                            <input  type="number" 
                                    class="form-control" 
                                    name="pr_ready" 
                                    placeholder="Enter The time to Ready Product :"
                                    required="required"
                            >
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select Category</label>
                            <select class="form-control" name="cate" id="exampleFormControlSelect1">
                                <?php
                                    foreach($rows as $row)
                                    {
                                        echo '<option value="'.$row['cate_id'].'">'.$row['cate_name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                                <label for="">Enter The image:</label>
                                <input  type="file" 
                                        name="my_avatar[]"   
                                        class="form-control"
                                        multiple="multiple"
                                >
                        </div>
                        <textarea name="pr_describe" cols="30" rows="7" class="form-control"></textarea>

                        <button type="submit" class="btn btn-primary" style="float:right;">Add prodcut</button>
                    </form>
                </div>
            </div>
<?php   }
        elseif($pages == "prod_insert")
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $prod_name          = $_POST['pr_name'];
                $prod_price         = $_POST['pr_price'];
                $prod_describe      = $_POST['pr_describe'];
                $pprod_cate         = $_POST['cate'];
                $prod_ready         = $_POST['pr_ready'];
                $my_avatar          = $_FILES['my_avatar'];

                $all_imageval=array();

                // multiple images define all variable
                $file_tmp   =$my_avatar['tmp_name'];
                $file_name  =$my_avatar['name'];
                $file_size  =$my_avatar['size'];
                $file_type  =$my_avatar['type'];
                $allowd_extension = array('jpg','png','jpeg','gif','jfif'); // extension allowd to uploded

                // 
                $file_count = count($my_avatar['name']);
                if(!($my_avatar['error'][0] == 4))
                {
                    for($i=0;   $i<$file_count ; $i++)
                    {
                        $image_ex = explode('.',$file_name[$i]);
                        $image_extension = strtolower(end($image_ex)); // get current extesion 
                        $error_file = array();

                        if($file_size[$i] > 1000000)
                        {
                            $error_file[] = '[ Avatar ] The Size is more 200000 size';
                        }
                        if(! in_array($image_extension , $allowd_extension))
                        {
                            $error_file[] = '[ Avatar ] The Extension Is Not Allowed';
                        }


                        // uploded file
                        if(empty($error_file))
                        {
                            move_uploaded_file($file_tmp[$i], $_SERVER['DOCUMENT_ROOT'].'\projectV3\admin\layout\image\\'.$file_name[$i]);
                            $all_imageval[]=$file_name[$i];
                        }
                        else
                        {
                            foreach($error_file as $err)
                            {
                                echo '<div class="alert alert-danger"> '.($i+1) ." ".  $file_name[$i]." ".$err.' </div>';
                            }
                            
                        }
                    }

                }
                $all_img= implode(',',$all_imageval);

                $formErrors = array();
                if(empty($prod_name))
                {
                    $formErrors[] = ' [ product Name ] Cant be Empty';
                }
                if(strlen($prod_name) < 4)
                {
                    $formErrors[] = ' [ product Name ] Cant be less 4 Char';
                }
                if(empty($prod_price))
                {
                    $formErrors[] = '[ product price ] Cant be Empty';
                }
                if($prod_price < 0)
                {
                    $formErrors[] = '[ product price ] Cant be less 0';
                }
                if(empty($formErrors))
                {
                    //insert query bind paragram
                    $stmt =$con->prepare("  INSERT INTO products(`p_name`,`p_time_ready`,`p_category`,`p_image`,`p_price`,`p_describe`,`user_id`,`p_create`)
                                            VALUES( :pName,:pready,:pcate,:pimage, :pPrice, :pdescribe , :uids,now())");
                    $stmt->execute(array(
                        'pName'     => $prod_name,
                        'pready'    => $prod_ready,
                        'pcate'     => $pprod_cate,
                        'pPrice'    => $prod_price,
                        'pdescribe' => $prod_describe,
                        'pimage'    => $all_img,
                        'uids'      => $_SESSION['user_id'],
                    ));
                    //  echo success Message Update
                    $thsMsg ="<div class='alert alert-success'>" . $stmt->rowCount() . " Recored Inserted ! </div>" ;
                    redirect_Home($thsMsg,'index.php?go=products',2);
                }
                else
                {
                    // print the error in 
                    foreach($formErrors as $error)
                    {
                        echo "<div class='alert alert-danger mt-3'>" . $error ."</div>";
                    }
                    redirect_Home("","back",2);
                }
            }
            else
            {

                $thsMsg = "<div class='alert alert-danger'> No Dirctory pages </div>";
                
                redirect_Home($thsMsg,'index.php?go=products');
            }
        }
        elseif($pages == "prod_edit")
        {
            // Get product d in [GET] Methode and check if number and parse [int]
            (isset($_GET['p_id']) && is_numeric($_GET['p_id'])) ? $pid= intval($_GET['p_id']):$pid=0;
            // SELECT row in databes in ID And Fetch data 
            $stmt = $con->prepare("SELECT * FROM `products` WHERE `user_id`=? AND `p_id` = ?");
            $stmt->execute(array($_SESSION['user_id'],$pid));
            $row = $stmt->fetch();
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Product</h3>
                </div>
                <div class="panel-body">
                    <form action="?go=products&pages=prod_update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="pr_id" value="<?php echo $pid ?>">
                        <div class="form-group">
                            <label for="">Name Product :</label>
                            <input  type="text"
                                    name="pr_name"
                                    class="form-control" 
                                    placeholder="Enter Name Product :"
                                    required="required"
                                    value="<?php echo $row['p_name']; ?>"
                            >
                        </div>
                        <div class="form-group">
                            <label for="price">price</label>
                            <input  type="number" 
                                    class="form-control" 
                                    name="pr_price" 
                                    placeholder="Enter The Price :"
                                    required="required"
                                    value="<?php echo $row['p_price']; ?>"
                            >
                        </div>
                        <div class="form-group">
                            <label>Time Of Ready</label>
                            <input  type="number" 
                                    class="form-control" 
                                    name="pr_ready" 
                                    placeholder="Enter The time to Ready Product :"
                                    required="required"
                                    value="<?php echo $row['p_time_ready']?>"
                            >
                        </div>
                        <div class="form-group">
                                <label for="">Enter The Avatar:</label>
                                <input  type="file" 
                                        name="my_avatar[]"   
                                        class="form-control"
                                        multiple="multiple"
                                >
                        </div>
                        <textarea name="pr_describe" cols="30" rows="7" class="form-control"><?php echo $row['p_describe']; ?></textarea>

                        <button type="submit" class="btn btn-primary" style="float:right;">Save prodcut</button>
                    </form>
                </div>
            </div>
<?php   }
        elseif($pages == 'prod_update')
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                
                // Fet The Product info in From Edit
                $pid = $_POST['pr_id'];
                $pname = $_POST['pr_name'];
                $pprice = $_POST['pr_price'];
                $prod_ready =$_POST['pr_ready'];
                $pdescribe = $_POST['pr_describe'];
                $my_avatar = $_FILES['my_avatar'];

                $all_imageval=array();

                // multiple images define all variable
                $file_tmp   =$my_avatar['tmp_name'];
                $file_name  =$my_avatar['name'];
                $file_size  =$my_avatar['size'];
                $file_type  =$my_avatar['type'];
                $allowd_extension = array('jpg','png','jpeg','gif','jfif'); // extension allowd to uploded
            
                // 
                $file_count = count($my_avatar['name']);
                if(!($my_avatar['error'][0] == 4))
                {
                    for($i=0;   $i<$file_count ; $i++)
                    {
                        $image_ex = explode('.',$file_name[$i]);
                        $image_extension = strtolower(end($image_ex)); // get current extesion 
                        $error_file = array();

                        if($file_size[$i] > 3000000000000000000)
                        {
                            $error_file[] = '[ Avatar ] The Size is more 200000 size';
                        }
                        if(! in_array($image_extension , $allowd_extension))
                        {
                            $error_file[] = '[ Avatar ] The Extension Is Not Allowed';
                        }


                        // uploded file
                        if(empty($error_file))
                        {
                            move_uploaded_file($file_tmp[$i], $_SERVER['DOCUMENT_ROOT'].'\projectV3\admin\layout\image\\'.$file_name[$i]);
                            $all_imageval[]=$file_name[$i];
                        }
                        else
                        {
                            foreach($error_file as $err)
                            {
                                echo '<div class="alert alert-danger"> '.($i+1) ." ".  $file_name[$i]." ".$err.' </div>';
                            }
                            
                        }
                    }

                }
                $all_img= implode(',',$all_imageval);

                // validate form error
                $formErrors = array();
                if(empty($pname))
                {
                    $formErrors[] = ' [ product Name ] Cant be Empty';
                }
                if(strlen($pname) < 4)
                {
                    $formErrors[] = ' [ product Name ] Cant be less 4 Char';
                }
                if(empty($pprice))
                {
                    $formErrors[] = ' [ product price ] Cant be Empty';
                }

                if(empty($formErrors))
                {
                    $stmt = $con->prepare(" UPDATE products 
                                                SET p_name       = ?,
                                                    p_time_ready = ?,
                                                    p_price      = ?,
                                                    p_describe   = ?
                                                WHERE 
                                                    p_id = ?");
                    $stmt->execute(array($pname,$prod_ready,$pprice,$pdescribe,$pid));
                    //save images in databes
                    if(!($my_avatar['error'][0] == 4))
                    {
                        $stmt = $con->prepare(" UPDATE products SET p_image=? WHERE p_id = ?");
                        $stmt->execute(array($all_img,$pid));
                    }
                    $thsMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Recored Updated ! </div>" ;
                    redirect_Home($thsMsg,'index.php?go=products',100);
                }
            }
            else
            {
                $thsMsg  = "<div class='alert alert-danger'> NO Directy pages </div>" ;
                redirect_Home($thsMsg,'index.php?go=products');
            }
        }
        elseif($pages == 'prod_show')
        {
            // Get product d in [GET] Methode and check if number and parse [int]
            (isset($_GET['p_id']) && is_numeric($_GET['p_id'])) ? $pid= intval($_GET['p_id']):$pid=0;
            // Select all data in databes where user_
            $stmt = $con->prepare(" SELECT products.* ,users.u_name 
                                    FROM products
                                    INNER JOIN users ON users.u_id = products.user_id 
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
                                echo "<img src='../admin/layout/image/".$img_Prod[$i]."' class='img-thumbnail' style='height: 100px; width: 100%;'>";
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
                        <span class="spandisp"><i class="fa fa-list-alt" aria-hidden="true"></i> Category : <?php echo $row['p_category']?></span>
                        <span class="spandisp"><i class="fa fa-user" aria-hidden="true"></i>  name users : <?php echo  $row['u_name']?></span>
                        <a href="?go=products&pages=prod_edit&p_id=<?php echo $row['p_id']?>"  class="btn btn-primary" style="float:right">Edit Product</a>
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