<?php 
include_once "connection.php";
session_start();
error_reporting(0);

if(isset($_POST['login'])){
    $_SESSION['user'] = $_POST['user'];
    $_SESSION['pass'] = md5($_POST['pass']);

    $userDateQuery = "SELECT * FROM users WHERE `user_name`='$_SESSION[user]' AND `password`='$_SESSION[pass]' AND deleted_at IS NULL";
    $userDate = mysqli_query($con,$userDateQuery);
    if(mysqli_num_rows($userDate) > 0){
        $userDateFetch = mysqli_fetch_array($userDate);
        if($userDateFetch['is_admin'] == 1){
            $url = "../projects/projects.php";
        }else{
            $url = "../Dev_projects/onProccess.php";
        }
        header("location:$url");
    }else{
        $url1 = "login.php?msg=-1";
        header("refresh:1;url=$url1");
    }
}

if(isset($_POST['submitRigist'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $pass = md5($_POST['pass']);

    $_SESSION['user'] = $username;
    $_SESSION['pass'] = $pass;
    
    $insertNewUser = "INSERT INTO users (`name`,`user_name`,`password`,`is_admin`) VALUES('$name','$username','$pass',1)";
    if(mysqli_query($con,$insertNewUser)){
        $url = "../administration/";
        header("refresh:1;url=$url");
    }else{
        $url = "../auth/regist.php";
        header("refresh:1;url=$url");
    }
}


if(!empty($_SESSION['user']) && !empty($_SESSION['pass'])){
    $userDateQuery = "SELECT * FROM users WHERE `user_name`='$_SESSION[user]' AND `password`='$_SESSION[pass]' AND deleted_at IS NULL";
    $userDate = mysqli_query($con,$userDateQuery);
    $userDateFetch = mysqli_fetch_array($userDate);
    $Logged_id = $userDateFetch['id'];
    $Logged_name = $userDateFetch['name'];
    $Logged_username = $userDateFetch['user_name'];
    $Logged_pass = $userDateFetch['password'];
    $Logged_role = $userDateFetch['is_admin'];
}else{
    if(basename($_SERVER['PHP_SELF']) != "login.php" && basename($_SERVER['PHP_SELF']) != "regist.php")
        header("location:../auth/login.php");
}
?>