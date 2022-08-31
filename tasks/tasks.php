<?php
include "../inc/inc.php";
if(isset($_GET['type']) && !empty($_GET['type']))
    $type = $_GET['type'];
else
    $type = 1;

$SelectQuery = "SELECT T.*,P.name AS PrjName FROM tasks T 
                    INNER JOIN projects P ON T.project_id=P.id 
                WHERE T.deleted IS NULL";
$result = mysqli_query($con,$SelectQuery);

if(isset($_GET['delID']) && !empty($_GET['delID'])){
    $DeleteDate = date('Y-m-d H:i:s');
    $DeletedID = $_GET['delID'];
    $DeleteQuery = "UPDATE tasks SET deleted='$DeleteDate' WHERE id=$DeletedID";
    if(mysqli_query($con,$DeleteQuery)){
        echo '<div class="alert alert-success text-center"> Task Deleted Successfully </div>';
        header("refresh:1;url=tasks.php");
    }else{
        echo '<div class="alert alert-danger text-center"> Error !! </div>';
    }
}

?>
<html>
    <head>
        <title>All Tasks</title>
    </head>
    <body>
        <?php 
            include "../inc/menu.php";
        ?>
        <div class="container">
            <br>
            <a href="AddNewTask.php" class="btn btn-success">Add New Task</a> <br>
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
                                                    <th class="text-center">task</th>
                                                    <th class="text-center">project</th>
                                                    <th class="text-center">description</th>
                                                    <th class="text-center">end date</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    while($fetch = mysqli_fetch_array($result)){
                                                        echo '<tr class="even gradeC">
                                                            <td class="text-center">'.$fetch['id'].'</td>
                                                            <td class="text-center">'.$fetch['name'].'</td>
                                                            <td class="text-center">'.$fetch['PrjName'].'</td>
                                                            <td class="text-center">'.$fetch['discreption'].'</td>
                                                            <td class="text-center">'.$fetch['end_date'].'</td>
                                                            <td class="text-center">
                                                                <a href="?delID='.$fetch['id'].'" onclick="return confirm(\'Are U Sure ?\')" class="btn btn-danger">Delete</a>
                                                                <a href="EditTask.php?EditID='.$fetch['id'].'" class="btn btn-primary">Edit</a>
                                                                <a href="DetailsTask.php?taskID='.$fetch['id'].'" class="btn btn-warning">Details</a>
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