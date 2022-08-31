<?php 
include "../inc/inc.php";

if(isset($_POST['submitData'])){
    $name = stripslashes($_POST['DevName']);
    $userName = stripslashes($_POST['userName']);
    $password = md5(stripslashes($_POST['password']));

    $InsertQuery = "INSERT INTO users (`name`,`user_name`,`password`,`is_admin`) VALUES('$name','$userName','$password',1);";
    if(mysqli_query($con,$InsertQuery)){
        echo '<div class="alert alert-success text-center">Admin Added Successfully</div>';
        header("refresh:1;url=admins.php");
    }else{
        echo '<div class="alert alert-danger text-center">Error !!</div>';
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Admin</title>
</head>
    <body>
        <?php 
            include "../inc/menu.php";
        ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <br>
                    <a href="admins.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                    <hr>
                    <form method="POST" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="DevName">Name </label>
                            <div class="col-lg-4 float-inp">
                                <input type="text" class="form-control"  name="DevName" id="DevName" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="userName">User Name </label>
                            <div class="col-lg-4 float-inp">
                                <input type="text" class="form-control" name="userName" id="userName" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="password">Password </label>
                            <div class="col-lg-4 float-inp">                                
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for=""> </label>
                            <div class="col-lg-4 float-inp">
                                <input type="submit" class="btn btn-success" value="Save" name="submitData" id="submitData" class="btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>