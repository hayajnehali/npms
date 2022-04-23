<?php
    session_start();
    include '../admin/include/config.php';

    include '../admin/include/function.php';


    if(isset($_SESSION['user_name']))
    {
        // if loggined redirect_Home index in dashbord users in page pesonalinformation
        $thsMsg  = '';
        redirect_Home($thsMsg,"../index.php?go=personal_info&pages=pers_info",3);

        exit();     
    }
    else
    {
?>
            <!DOCTYPE html>
            <html>
            <head>
                <title><?php $getTitle="registration" ?></title>
                <link rel="stylesheet" href="css/bootstrap.css">
                <link rel="stylesheet"  href="css/regsttation.css">
                <link rel="stylesheet"  href="regsttation.css">
            </head>
            <body>
            <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $username   = $_POST['user_name'];
                $pass       = $_POST['password'];
                $hashpass   = sha1($pass);
                $full_name  = $_POST['full_name'];
                $email      = $_POST['email'];
                $phone      = $_POST['phone'];
                $address    = $_POST['address'];
                $describe   = $_POST['describe'];
                $bdate      = date('y-m-d' ,strtotime($_POST['bdate']));
    
                // insert if users exist in databes
                $stmt = $con->prepare(" INSERT INTO `users`(`u_name`, `u_password`, `u_email`, `u_fullname`,`u_bdate`, `u_phone`, `u_address`, `u_describe`, `u_groupID`) 
                                        VALUES (:zname ,:zpass,:zemail,:zfull,:bdate,:zphone,:zaddr,:zdesc,2)");
                $stmt->execute(array(
                            'zname' =>$username,
                            'zpass' =>$hashpass,
                            'zemail' =>$email,
                            'zfull' =>$full_name,
                            'bdate' =>$bdate,
                            'zphone' =>$phone,
                            'zaddr' =>$address,
                            'zdesc' =>$describe
                ));
                //  echo success Message Update
                $thsMsg  = "<div class='alert alert-success container'>" . $stmt->rowCount() . " Recored Inserted ! </div>" ;
    
                //if counts > 0 The Databeas Contain Record About users
                if($stmt->rowCount() > 0)
                {
                    redirect_Home($thsMsg,"login.php",3);
                }
    
            }
    }
            ?>
            <section class="form my-4 ">
                <div class="container">
                        <div class="row no-gutters mt-5">
                            <div class="col-lg-5">
                            <div class="logo_box">
                                <img src="img/logo.png">
                            </div>
                            <div class="wilcome_logo">
                                Welcome 
                            </div>
                            </div>
                            <div class="col-lg-7 border px-5 pt-5">
                                <h1 class="font-weight-bold py-3">Register</h1>
                                <h4>Enter Your Information</h4>
                                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                                    <div class="form-row">
                                        <div class="col-lg-7">
                                            <input type="text" placeholder="Enter User Name" required="" class="form-control my-2 " name="user_name">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-lg-7">
                                            <input type="password" placeholder="Enter Password" required="" class="form-control my-2 " name="password">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-lg-7">
                                            <input type="text" placeholder="Enter full_name" required="" class="form-control my-2 " name="full_name">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-lg-7">
                                            <input type="email" placeholder="Enter email" required="" class="form-control my-2 " name="email">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-lg-7">
                                            <input type="number" placeholder="Enter phone" required="" class="form-control my-2 " name="phone">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-lg-7">
                                            <input type="date"  class="form-control my-2 " name="bdate">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-lg-7">
                                            <input type="text" placeholder="Enter address" required="" class="form-control my-2 " name="address">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-lg-7">
                                            <input type="text" placeholder="Enter describe" required="" class="form-control my-2 " name="describe">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-lg-7">
                                            <button type="submit" class="btn1 mt-3 mb-5">Regster</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
            </section>

</body>
</html>
