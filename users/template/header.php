<?php
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
    <link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/css/font-awesome.min.css">
    <link rel="stylesheet" href="layout/css/main.css">
</head>
<body>
    <!-- Start Header -->
    <header class="myheader">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <h1><i class="fa fa-cogs" aria-hidden="true"></i> Dashborde <?php echo $user_name;?></h1>
                </div>
            </div>    
        </div>
    </header>
    <!-- End Header -->

    <!-- start sidebar -->
    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group">
                        <a href="?go=personal_info" class="list-group-item active">
                            <i class="fa fa-user-circle" aria-hidden="true"></i> <?php echo $user_name;?>
                        </a>
                        <a href="../homes/index.php" class="list-group-item" target="_blank">
                            <i class="fa fa-home" aria-hidden="true"></i> Home Page
                        </a>
                        <a href="?go=products" class="list-group-item">
                            <i class="fa fa-product-hunt" aria-hidden="true"></i> Products
                        </a>
                        <a href="?go=orders" class="list-group-item">
                            <i class="fa fa-align-justify" aria-hidden="true"></i> Orders
                        </a>
                        <a href="?go=carts" class="list-group-item">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> Carts
                        </a>
                        <a href="?go=comments" class="list-group-item">
                            <i class="fa fa-comments" aria-hidden="true"></i> Comments
                        </a>
                        <a href="logout.php" class="list-group-item">
                            <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                        </a>
                        
                    </div>
                </div>
                <div class="col-md-9">
