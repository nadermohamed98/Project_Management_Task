<?php 
include "../inc/inc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta content="charset=utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="../css/regist.css">
</head>
<body>
    <form id="Register" method="post">
        <h1>Register</h1>
        <fieldset id="inputs">
            <input id="username" name="name" autocomplete="off" type="text" placeholder="name" autofocus required>
            <input id="username" name="username" autocomplete="off" type="text" placeholder="Username" required>
            <input id="password" name="pass" autocomplete="off" type="password" placeholder="Password" required>
            <br><a href="login.php">Login with your account</a>
        </fieldset>
        <fieldset id="actions">
            <input type="submit" name="submitRigist" id="submit" value="Register">
        </fieldset>
    </form>
</body>
</html>