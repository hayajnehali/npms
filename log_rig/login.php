<?php 
    session_start();
    include '../admin/include/config.php'; 
    include '../admin/include/function.php'; 
    $getTitle = 'login';

    if(isset($_SESSION['user_name']))
    {
        // if loggined redirect_Home index in dashbord users in page pesonalinformation
        $thsMsg  = '';
        redirect_Home($thsMsg,"../users/index.php?go=personal_info&pages=pers_info",1);      // if loggined Redirect index in dashbord users in page pesonalinformation
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet"  href="css/newlogin.css">
	
</head>
<body>
		<?php
        // check if user Coming From HTTP POST REQUEST
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $username = $_POST['user_name'];
            $pass = $_POST['password'];
            $hashpass = sha1($pass);

            // check if users exist in databes
            $stmt = $con->prepare("	SELECT u_name,u_password,u_id,u_groupID,u_req_status 
									FROM users 
									WHERE u_name = ? AND u_password = ?");
            $stmt->execute(array($username,$hashpass));
            $count = $stmt->rowCount();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            //if counts > 0 The Databeas Contain Record About users
            if($count > 0)
            {
				if($result['u_req_status'] == 1)
				{
					$_SESSION['user_name'] = $username;     //Reqister Session Name
					$_SESSION['user_id'] = $result['u_id'];     //  Reqister Session Name
				}
				else
				{
					$thsMsg  = '<div class="alert alert-info">You Must Approve Login First Plz Agin In 5M </div>';
					redirect_Home($thsMsg,"../homes/index.php",3);
					exit();
				}
                // if loggined redirect_Home index in dashbord users in page pesonalinformation
				if($result['u_groupID'] == 1 )
				{
					$thsMsg  = '';
					redirect_Home($thsMsg,"../admin/index.php?go=personal_info&pages=pers_info",0);
					exit();
				}
				elseif($result['u_groupID'] == 2)
				{
					$thsMsg  = '';
					redirect_Home($thsMsg,"../users/index.php?go=personal_info&pages=pers_info",0);
					exit();
				}
				
            }

        }
    
?>
	<section class="form my-4 mx-5">
		<div class="container">
				<div class="row no-gutters mt-5">
					<div class="col-lg-5 box_logo">
						<div class="logo_box">
							<img src="img/logo.png">
						</div>
						<div class="wilcome_logo">
							Welcome 
						</div>
					</div>

					<div class="col-lg-7 px-5 pt-5">
						<h1 class="font-weight-bold py-3">Login</h1>
						<h4>Sign into your account</h4>
						<form action="?"  method="POST">
							<div class="form-row">
								<div class="col-lg-7">
									<input type="username" placeholder="username" class="form-control my-3 " name="user_name" required>
								</div>
							</div>

							<div class="form-row">
								<div class="col-lg-7">
									<input type="password" placeholder="password" class="form-control my-3" name="password" required>
								</div>
							</div>
							<div class="form-row">
								<div class="col-lg-7">
									<button type="submit" class="btn1 mt-3 mb-5">Login</button>
								</div>
							</div>

							<p class="mb-5"> Don't have any accont?  <a href="registration.php">Register here</a></p>

						</form>
						
					</div>
				</div>
			
		</div>
	</section>
	<script src="js/popper.min.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>    
    <script src="bootstrap.js"></script>
</body>
</html>