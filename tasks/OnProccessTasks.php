<?php
include "../inc/inc.php";
$SelectQuery = "SELECT PD.id AS id,T.name AS TaskName
                    ,T.id AS TaskID
                    ,PD.dead_line AS DeadLine
                    ,T.end_date AS TaskEndDate
                    ,T.discreption AS TaskDisc
                    ,P.name AS PrjName
                    ,U.name AS UserName 
                FROM project_developers AS PD 
                    INNER JOIN tasks AS T ON PD.task_id=T.id 
                    INNER JOIN projects AS P ON PD.project_id=P.id 
                    LEFT JOIN users AS U ON PD.developer_id=U.id 
                WHERE P.deleted IS NULL 
                    AND T.deleted IS NULL
                    AND PD.status=1;";

$result = mysqli_query($con,$SelectQuery);

if(isset($_GET['delID']) && !empty($_GET['delID'])){
    $DeleteDate = date('Y-m-d H:i:s');
    $DeletedID = $_GET['delID'];
    $DeleteQuery = "DELETE FROM project_developers WHERE id=$DeletedID";
    if(mysqli_query($con,$DeleteQuery)){
        echo '<div class="alert alert-success text-center"> Task Deleted Successfully </div>';
        header("refresh:1;url=OnProccessTasks.php");
    }else{
        echo '<div class="alert alert-danger text-center"> Error !! </div>';
    }
}

?>
<html>
    <head>
        <title>On Process Tasks</title>
    </head>
    <body>
        <?php 
            include "../inc/menu.php";
        ?>
        <div class="container">
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
                                                    <th class="text-center">Task ID</th>
                                                    <th class="text-center">task</th>
                                                    <th class="text-center">project</th>
                                                    <th class="text-center">developer</th>
                                                    <th class="text-center">Deadline</th>
                                                    <th class="text-center">description</th>
                                                    <th class="text-center">end date</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    while($fetch = mysqli_fetch_array($result)){
                                                        echo '<tr class="even gradeC">
                                                            <td class="text-center">'.$fetch['TaskID'].'</td>
                                                            <td class="text-center">'.$fetch['TaskName'].'</td>
                                                            <td class="text-center">'.$fetch['PrjName'].'</td>
                                                            <td class="text-center">'.$fetch['UserName'].'</td>
                                                            <td class="text-center">'.$fetch['DeadLine'].'</td>
                                                            <td class="text-center">'.$fetch['TaskDisc'].'</td>
                                                            <td class="text-center">'.$fetch['TaskEndDate'].'</td>
                                                            <td class="text-center">
                                                                <a href="?delID='.$fetch['id'].'" onclick="return confirm(\'Are U Sure ?\')" class="btn btn-danger">Delete</a>
                                                                <a href="EditTask.php?EditID='.$fetch['TaskID'].'" class="btn btn-primary">Edit</a>
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