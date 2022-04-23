<?php
    session_start();
    $count_carts = empty($_SESSION['cart'])?0: count($_SESSION['cart']);
    if(isset($_SESSION['user_name']))
    {
        $user_name = $_SESSION['user_name'];
        
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NPMS</title>
    <!-- the file css inculded -->
    <link rel="stylesheet" href="../users/layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="../users/layout/css/font-awesome.min.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <span class="up"><i class="fa fa-angle-double-up "></i></span>
    <div class="content_all">
    <div class="row">
    <!-- Start Sidebar -->
    <div class="col-md-3 col-sm-2 bg-primery ">
            <div class="row">
                <div class="col-md-12">
                    <div class="logo_box">
                        <img src="../admin/layout/image/logo.png" class="head-img" alt="">
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <ul style="list-style: none;" class="list_first">
                        <li>
                            <a href="index.php">Home Page</a></li>
                        <li><a href="#" class="dropdown">
                            <button onclick="myFunction()" class="dropbtn">CATEGORES</button>
                            <div id="myDropdown" class="dropdown-content">
                                <?php
                                    $stmt =$con->prepare("SELECT * FROM category");
                                    $stmt->execute();
                                    $rows = $stmt->fetchALL();
                                    foreach($rows as $row)
                                    {
                                        echo '<a href="category.php?cate_id='.$row['cate_id'].'">'.$row['cate_name'].'</a>';
                                    }
                                ?>
                                
                                
                            </div>
                        </a>
                        </li>
                        <li>
                            <?php
                                if(!empty($user_name))
                                {
                                    echo '<a href="../users/index.php">' .$user_name .'</a>';
                                }
                                else
                                {
                                    echo '<a href="../log_rig/login.php">Account</a>';
                                }
                            ?>
                            
                        </li>                    
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul style="list-style: none;" class="list_two">
                        <li class=" btn btn1"><a href="cart.php">
                            <i class="fa fa-shopping-cart"></i> CART (<?php echo  $count_carts; ?>)
                        </a></li>
                        <li class="btn btn2"><a href="#">
                            <i class="fa fa-search"></i> SEARCH
                        </a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="list_three">
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>   
                    </ul>
                </div>
            </div>
    </div>
    <!-- End Sidebar -->