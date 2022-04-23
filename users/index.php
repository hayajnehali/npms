<?php 
    session_start();
    isset($_GET['go'])? $go = $_GET['go'] : $go = 'personal_info';
    $getTitle = $go; // title name 
    
    if(isset($_SESSION['user_name']))
    {
        include 'template/header.php';
        include 'inti.php';
        
        if($go == 'personal_info')
        {
            include 'pesonal_info.php';
        }
        elseif($go == 'orders')
        {
            include 'orders.php';
        }
        elseif($go == 'products')
        {
            include 'products.php';
        }
        elseif($go == 'carts')
        {
            include 'carts.php';
        }
        elseif($go == 'comments')
        {
            include 'comments.php';
        }



        include 'template/footer.php';    
    }
    else
    {
        echo "You Are Not athorized .";
        header("location:../log_rig/login.php");
        exit();
    }
?>