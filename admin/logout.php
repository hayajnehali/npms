<?php
    session_start();

    session_unset();
    session_destroy();

    header('location:../log_rig/login.php');
    exit();

?>