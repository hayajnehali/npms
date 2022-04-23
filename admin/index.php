<?php 
    session_start();
    isset($_GET['go'])? $go = $_GET['go'] : $go = 'personal_info';
    
    
    if(isset($_SESSION['user_name']))
    {
        include 'template/header.php';
        include 'inti.php';
        if($go == 'users')
        {
            include 'users.php';
        }
        elseif($go == 'personal_info')
        {
            include 'pesonal_info.php';

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
        elseif($go == 'category')
        {
            include 'category.php';
        }
        elseif($go == 'feedback')
        {
            include 'feedback.php';
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