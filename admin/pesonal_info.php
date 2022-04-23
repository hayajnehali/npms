<?php
        
        $pages = '';
        isset($_GET['pages']) ? $pages =$_GET['pages'] : $pages='pers_info';
        if(isset($_SESSION['user_id']))
        {
            if($pages == "pers_info")
            {
                // SELECT row in databes
                $stmt = $con->prepare("SELECT * FROM `users` WHERE `u_id`=?");
                $stmt->execute(array($_SESSION['user_id']));
                $res = $stmt->fetch();  ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Personal Information</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-3">
                            <img src="layout/image/<?php echo $res['avatar']?>" class="img-thumbnail" style="height: 224px; width: 100%;">
                        </div>
                        <div class="col-md-6" style="width: 75%;">
                            <h2><?php echo $res['u_fullname']; ?> </h2>
                            <p ><?php echo $res['u_describe'];  ?></p>
                            <span class="spandisp"><i class="fa fa-envelope" aria-hidden="true"></i> Email : <?php echo $res['u_email']; ?></span>
                            <span class="spandisp"><i class="fa fa-phone" aria-hidden="true"></i> Phone : <?php echo $res['u_phone']; ?></span>
                            <span class="spandisp"><i class="fa fa-calendar" aria-hidden="true"></i>  Birth-Date : <?php echo  $res['u_bdate'] ?> </span>
                            <span class="spandisp"><i class="fa fa-location-arrow" aria-hidden="true"></i>  Address : <?php echo $res['u_address']?></span>
                            <a href="?go=personal_info&pages=pers_edit" class="btn btn-primary" style="float:right">Edit Information</a>
                        </div>
                    </div>
                </div>
    <?php   } 
            elseif($pages == 'pers_edit')
            {
                // SELECT row in databes in ID And Fetch data 
                $stmt = $con->prepare("SELECT * FROM `users` WHERE `u_id`=?");
                $stmt->execute(array($_SESSION['user_id']));
                $res = $stmt->fetch();
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit Information</h3>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="?go=personal_info&pages=pers_update" enctype="multipart/form-data">
                            <input type="hidden" name='user_id' value="<?php echo $_SESSION['user_id'];  ?>">
                            <div class="form-group">
                                <label for="">Name :</label>
                                <input  type="text"
                                        name="user_name" 
                                        class="form-control" 
                                        placeholder="Enter Name :" 
                                        value="<?php echo $res['u_name']; ?>"
                                        required="required">
                            </div>
                            <div class="form-group">
                                <label for="">password :</label>
                                <input type="hidden" name="old_password" class="form-control"  placeholder="Enter Name :" value="<?php echo $res['u_password']; ?>">
                                <input  type="password"
                                        name="new_password"     
                                        class="form-control"  
                                        placeholder="Leave Password if no change:" 
                                        value="">
                            </div>
                            <div class="form-group">
                                <label for="">E-mail :</label>
                                <input  type="email" 
                                        name="email" 
                                        class="form-control" 
                                        placeholder="Enter E-mail :" 
                                        value="<?php echo $res['u_email']; ?>"
                                        required="required">
                            </div>
                            <div class="form-group">
                                <label for="">Full Name :</label>
                                <input  type="text"
                                        name="full_name" 
                                        class="form-control" 
                                        placeholder="Enter Full Name :" 
                                        value="<?php echo $res['u_fullname']; ?>"
                                        required="required">
                            </div>
                            <div class="form-group">
                                <label for="">phone:</label>
                                <input  type="number" 
                                        name="user_phone"   
                                        class="form-control" 
                                        placeholder="Enter phone :" 
                                        value="<?php echo $res['u_phone']; ?>"
                                        required="required">
                            </div>
                            <div class="form-group">
                                <label for="">Address:</label>
                                <input  type="text" 
                                        name="address"   
                                        class="form-control" 
                                        placeholder="Enter Address :" 
                                        value="<?php echo $res['u_address']; ?>"
                                        required="required">
                            </div>
                            <div class="form-group">
                                <label for="">Enter The Avatar:</label>
                                <input  type="file" 
                                        name="new_my_avatar"   
                                        class="form-control">

                                <input  type="hidden" 
                                        name="old_my_avatar"
                                        value="<?php echo $res['avatar']  ?>"   
                                        >
                            </div>
                            
                            <textarea name="user_describe" cols="30" rows="7" class="form-control"> <?php  echo $res['u_describe'] ?>   </textarea>
                            <button type="submit" class="btn btn-primary" style="float:right;">Save Info</button>
                        </form>
                    </div>
                </div>
    <?php   }
            elseif($pages == 'pers_update')
                {
                    if($_SERVER['REQUEST_METHOD'] =="POST")
                    {
                        // Get The Data In Form Edit
                        $id             = $_POST['user_id'];
                        $user_name      = $_POST['user_name'];
                        $email          = $_POST['email'];
                        $fullname       = $_POST['full_name'];
                        $phone          = $_POST['user_phone'];
                        $address        = $_POST['address'];
                        // $bdate          = date('y-m-d' ,strtotime($_POST['bdate']));
                        $user_describe  = $_POST['user_describe'];

                        //  change password
                        $old_pass       = $_POST['old_password'];
                        $new_pass       = $_POST['new_password'];
                        $pass='';
                        empty($new_pass)?$pass = $old_pass : $pass = sha1($new_pass);

                        // get image  and validate
                        $file_error =$_FILES['new_my_avatar']['error'];
                        if($file_error == 4)
                        {
                            $file_name = $_POST['old_my_avatar'];
                        }
                        else
                        {
                            // define all variable 
                            $file_tmp =$_FILES['new_my_avatar']['tmp_name'];
                            $file_name =$_FILES['new_my_avatar']['name'];
                            $file_size =$_FILES['new_my_avatar']['size'];
                            $file_type =$_FILES['new_my_avatar']['type'];
                            
                            $allowd_extension = array('jpg','png','jpeg','gif'); // extension allowd to uploded
                            $image_ex = explode('.',$file_name);
                            $image_extension = strtolower(end($image_ex)); // get current extesion
                        }
                        
                        
                        // validate form error
                        $formErrors = array();
                        if(empty($user_name))
                        {
                            $formErrors[] = ' [ User Name ] Cant be Empty';
                        }
                        if(strlen($user_name) < 4)
                        {
                            $formErrors[] = ' [ User Name ] Cant be less 4 Char';
                        }
                        if(empty($email))
                        {
                            $formErrors[] = '[ E-mail ] Cant be Empty';
                        }
                        if(empty($fullname))
                        {
                            $formErrors[] = '[ Full Name ] Cant be Empty';
                        }
                        if(strlen($fullname) < 5)
                        {
                            $formErrors[] = '[ Full Name ] Cant be less 5 Char';
                        }
                        // validate file
                        if(!($file_error == 4)) // if not image uploded
                        {
                            if($file_size > 200000)
                            {
                                $formErrors[] = '[ Avatar ] The Size is more 200000 size';
                            }
                            if(! in_array($image_extension , $allowd_extension))
                            {
                                $formErrors[] = '[ Avatar ] The Extension Is Not Allowed';
                            }
                        }
                        
                        //update The database in new information
                        if(empty($formErrors))
                        {
                            if(isset($file_tmp))
                            {
                                move_uploaded_file($file_tmp, $_SERVER['DOCUMENT_ROOT'].'\projectV3\admin\layout\image\\'.$file_name);
                            }
                            $stmt = $con->prepare(" UPDATE users 
                                                    SET u_name = ?,
                                                        u_password=?,
                                                        u_email = ?,
                                                        u_fullname = ?,
                                                        u_phone = ?,
                                                        u_address =?,
                                                        avatar=?,
                                                        u_describe = ?
                                                    WHERE 
                                                        u_id = ?");
                            $stmt->execute(array(   $user_name,
                                                    $pass,
                                                    $email,
                                                    $fullname,
                                                    $phone,
                                                    $address,
                                                    $file_name,
                                                    $user_describe
                                                    ,$id));

                            //  echo success Message Update and ridirct
                            $thsMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Recored Updated ! </div>';
                            redirect_Home($thsMsg,'back');
                        }
                        else
                        {
                            // print the error in 
                            foreach($formErrors as $error)
                            {
                                echo "<div class='alert alert-danger mt-3'>" . $error ."</div>";
                            }
                        }
                    }
                    else
                    {
                        $thsMsg = '<div class="alert alert-danger">Sorry You Cant Browser This Page Directly</div>';
                        redirect_Home($thsMsg);
                    }
                }
        }
        else
        {
            $thsMsg = "";
            redirect_Home($thsMsg,"log_rig/login.php");
        }
        
        ?> 