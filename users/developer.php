<?php
include "../inc/inc.php";

$SelectQuery = "SELECT * FROM users WHERE deleted_at IS NULL AND is_admin=0;";
$result = mysqli_query($con,$SelectQuery);

if(isset($_GET['delID']) && !empty($_GET['delID'])){
    $DeleteDate = date('Y-m-d H:i:s');
    $DeletedID = $_GET['delID'];
    $DeleteQuery = "UPDATE users SET deleted_at='$DeleteDate' WHERE id=$DeletedID AND is_admin=0";
    if(mysqli_query($con,$DeleteQuery)){
        echo '<div class="alert alert-success text-center"> User Deleted Successfully </div>';
        header("refresh:1;url=users.php");
    }else{
        echo '<div class="alert alert-danger text-center"> Error !! </div>';
    }
}

?>
<html>
    <head>
        <title> Developers</title>
    </head>
    <body>
        <?php 
            include "../inc/menu.php";
        ?>
        <div class="container">
            <br>
            <a href="AddNewDeveloper.php" class="btn btn-success">Add New Developer</a> <br>
            <hr>
            <div id="content">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">serial</th>
                                                    <th class="text-center">name</th>
                                                    <th class="text-center">user name</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    while($fetch = mysqli_fetch_array($result)){
                                                        echo '<tr class="even gradeC">
                                                            <td class="text-center">'.$fetch['id'].'</td>
                                                            <td class="text-center">'.$fetch['name'].'</td>
                                                            <td class="text-center">'.$fetch['user_name'].'</td>
                                                            <td class="text-center">
                                                                <a href="?delID='.$fetch['id'].'" onclick="return confirm(\'Are U Sure ?\')" class="btn btn-danger">Delete</a>
                                                                <a href="EditDeveloper.php?EditID='.$fetch['id'].'" class="btn btn-primary">Edit</a>
                                                                <a href="DetailsDeveloper.php?id='.$fetch['id'].'" class="btn btn-warning">Projects And Tasks</a>
                                                            </td>
                                                        </tr>';
                                                    }        
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>