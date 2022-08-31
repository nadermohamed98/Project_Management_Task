<?php
include "../inc/inc.php";
?>

<!-- <!DOCTYPE html>
<html>
<head>
    <meta content="charset=utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <form id="login" method="post">
        <h1>Log In</h1>
        <fieldset id="inputs">
            <input id="username" name="username" autocomplete="off" type="text" placeholder="Username" autofocus required>
            <input id="password" name="pass" autocomplete="off" type="password" placeholder="Password" required>
            <br><a href="regist.php">don't have an account !</a>
        </fieldset>
        <fieldset id="actions">
            <input type="submit" name="login" id="submit" value="Log in">
        </fieldset>
    </form>
</body>

</html>
 -->

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include "../inc/head.php"; ?>

</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('../assets/assets/BackLogin.jpg');">	
		<div class="wrap-login100 p-b-30">
				<form class="login100-form validate-form" method="POST">  
			
					<?php 
					if(isset($_GET['msg']) && $_GET['msg'] == -1){
						echo '<div class="login100-form alert alert-danger">Username Or Password is wrong !!</div>';
					}
					?>
					<span class="login100-form-title p-t-15 p-b-45">
						Login
					</span>
					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="user" placeholder="Username" autocomplete="off">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password" autocomplete="new-password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
                        <input type="submit" name="login" class="login100-form-btn" value="Log In">
					</div>
					
				</form>
				
			</div>
		</div>
	</div>
	
	
<?php include "../inc/scripts.php"; ?>
	
</body>
</html>