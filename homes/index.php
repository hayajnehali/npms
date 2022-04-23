<?php
    include '../admin/inti.php';
    include 'template/header.php';
    $go = isset($_GET['go']) && !empty($_GET['go']) ? $_GET['go'] : 'home_page'; 
    if($go = 'home_page')
    {
        include 'Home_page.php';
    }





    include "template/footer.php";

?>