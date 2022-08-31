<?php 
include "../inc/inc.php";

$EditedID = $_GET['prjID'];
$SelectQuery = "SELECT T.*,P.id AS rowID FROM `tasks` AS T INNER JOIN `project_developers` AS P ON P.task_id=T.id
    WHERE T.deleted IS NULL AND P.developer_id=".$Logged_id." AND P.status=2";
$TaskResult = mysqli_query($con,$SelectQuery);

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
</head>
<body>
    <?php 
        include "../inc/dev_menu.php";
    ?>
    <hr>
    <div id="content">
        <div class="container">
            <!-- <a href="../Dev_projects/projects.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>  -->
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if(mysqli_num_rows($TaskResult) > 0){
                                            while($TaskFtch = mysqli_fetch_array($TaskResult)){
                                                echo '<tr class="even gradeC">
                                                    <td class="text-center">'.$TaskFtch['id'].'</td>
                                                    <td class="text-center">'.$TaskFtch['name'].'</td>
                                                    <td class="text-center">'.$TaskFtch['discreption'].'</td>
                                                    <td class="text-center">'.$TaskFtch['end_date'].'</td>
                                                </tr>';
                                            }
                                        }else{
                                            echo '<td colspan="5" class="text-center">No tasks Yet !</td>';
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