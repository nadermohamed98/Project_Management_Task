<?php 
include "../inc/inc.php";

if(isset($_GET['taskID']) && !empty($_GET['taskID'])){
    $EditedID = $_GET['taskID'];
    $SelectQuery = "SELECT T.*,P.name AS PrjName FROM tasks T INNER JOIN projects P ON T.project_id=P.id WHERE T.id=$EditedID AND T.deleted IS NULL";
    $result = mysqli_query($con,$SelectQuery);
    while($fetch = mysqli_fetch_array($result)){
        $row_name = $fetch['name'];
        $row_discreption = $fetch['discreption'];
        $row_PrjName = $fetch['PrjName'];
        $row_end_date = date("Y-m-d",strtotime($fetch['end_date']));
    }
}

if(isset($_GET['taskID']) && !empty($_GET['taskID'])){
    $EditedID = $_GET['taskID'];
    $SelectQuery = "SELECT PD.status AS status
                        ,T.name AS TName
                        ,U.name AS UName
                        ,T.id AS Tid
                        ,T.discreption AS TDisc
                        ,T.end_date AS TEnd
                        ,PD.dead_line AS TDead
                        ,PD.id AS rowID
                    FROM `project_developers` PD 
                        INNER JOIN tasks T ON PD.task_id=T.id 
                        LEFT JOIN users U ON PD.developer_id=U.id 
                    WHERE PD.task_id=$EditedID 
                        AND T.deleted IS NULL";

    $TaskResult = mysqli_query($con,$SelectQuery);
}

if(isset($_GET['delID']) && !empty($_GET['delID'])){
    ECHO $deleteQuery = "DELETE FROM project_developers WHERE id=".$_GET['delID']." AND status!=2;";
    mysqli_query($con,$deleteQuery);
    if(mysqli_affected_rows($con) > 0){
        echo '<div class="alert alert-success text-center">SUCCESS</div>';
        header("refresh:1;url=DetailsTask.php?taskID=".$_GET['taskID']);
    }else{
        echo '<div class="alert alert-danger text-center">CANNOT DELETE DONE TASK</div>';
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
</head>
<body>
    <?php 
        include "../inc/menu.php";
    ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="form-group well" >
                    <label style="margin: 0; width: 50%;">number : </label>
                    <span style="width: 50%;"><?php echo $EditedID; ?></span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="form-group well" >
                    <label style="margin: 0; width: 50%;">Name : </label>
                    <span><?php echo $row_name; ?></span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="form-group well" >
                    <label style="margin: 0; width: 60%;">End Date : </label>
                    <span style="width: 60%;"><?php echo $row_end_date; ?></span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="form-group well" >
                    <label style="margin: 0; width: 60%;">Project : </label>
                    <span style="width: 60%;"><?php echo $row_PrjName; ?></span>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group well">
                    <label style="margin: 0;">Description : </label>
                    <span style="width: 60%;"><?php echo $row_discreption; ?></span>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <a href="../tasks/tasks.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a> 
            <!-- <a href="../tasks/AssignTask.php?taskID=<?php echo $EditedID; ?>&" class="btn btn-success"> Assign Task To Developer</a>  -->
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
                                            <th class="text-center">Developer</th>
                                            <th class="text-center">Deadline</th>
                                            <th class="text-center">Task End date</th>
                                            <th class="text-center">status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            while($TaskFtch = mysqli_fetch_array($TaskResult)){
                                                $status = ($TaskFtch['status']==1)?'On Proccess':'Done';
                                                echo '<tr class="even gradeC">
                                                    <td class="text-center">'.$TaskFtch['Tid'].'</td>
                                                    <td class="text-center">'.$TaskFtch['UName'].'</td>
                                                    <td class="text-center">'.$TaskFtch['TDead'].'</td>
                                                    <td class="text-center">'.$TaskFtch['TEnd'].'</td>
                                                    <td class="text-center">'.$status.'</td>
                                                    <td class="text-center">
                                                        <a href="?delID='.$TaskFtch['rowID'].'&taskID='.$EditedID.'" onclick="return confirm(\'Are U Sure ?\')" class="btn btn-danger">Delete</a>
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
</body>
</html>