<?php
include "../inc/inc.php";
$_SESSION['user'] = "";
$_SESSION['pass'] = "";
session_destroy();
$url="login.php";
header("location: ".$url."");
exit();
?>