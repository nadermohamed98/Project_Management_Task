<?php 
include "../inc/inc.php";

$SelectQuery = "SELECT T.*,P.id AS rowID FROM `tasks` AS T 
                    INNER JOIN `project_developers` AS P ON P.task_id=T.id
                WHERE T.deleted IS NULL 
                    AND P.developer_id=".$Logged_id."
                    AND P.status=1";
$TaskResult = mysqli_query($con,$SelectQuery);


if(isset($_GET['DoneID']) && !empty($_GET['DoneID'])){
    $doneQuery = "UPDATE project_developers SET status=2 WHERE id=".$_GET['DoneID']."";
    if(mysqli_query($con,$doneQuery)){
        echo '<div class="alert alert-success text-center"> Task Finished </div>';
        header("refresh:1;url=onProccess.php");
    }else{
        echo '<div class="alert alert-danger text-center"> Error !! </div>';
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>On-proccess Tasks</title>
</head>
<body>
    <?php 
        include "../inc/dev_menu.php";
    ?>
    <hr>
    <div id="content">
        <div class="container">
            <a href="../Dev_projects/onProccess.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a> 
            <br>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">serial</th>
                                            <th class="text-center">Task</th>
                                            <th class="text-center">Discreption</th>
                                            <th class="text-center">End date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(mysqli_num_rows($TaskResult) > 0){
                                            while($TaskFtch = mysqli_fetch_array($TaskResult)){
                                                $status = ($TaskFtch['status']==1)?'on process':'done';
                                                echo '<tr class="even gradeC">
                                                    <td class="text-center">'.$TaskFtch['id'].'</td>
                                                    <td class="text-center">'.$TaskFtch['name'].'</td>
                                                    <td class="text-center">'.$TaskFtch['discreption'].'</td>
                                                    <td class="text-center">'.$TaskFtch['end_date'].'</td>
                                                    <td class="text-center">'.$status.'</td>
                                                    <td class="text-center">
                                                        <a href="?DoneID='.$TaskFtch['rowID'].'" class="btn btn-success">Done</a>
                                                    </td>
                                                </tr>';
                                            }
                                        }else{
                                            echo '<td colspan="6" class="text-center">No tasks Yet !</td>';
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
</body>
</html>