<?php 
include "../inc/inc.php";

if(isset($_GET['prjID']) && !empty($_GET['prjID'])){
    $EditedID = $_GET['prjID'];
    $SelectQuery = "SELECT * FROM projects WHERE id=$EditedID AND deleted IS NULL";
    $result = mysqli_query($con,$SelectQuery);
    while($fetch = mysqli_fetch_array($result)){
        $row_name = $fetch['name'];
        $row_date = date("Y-m-d",strtotime($fetch['finish_date']));
        $row_discreption = $fetch['discreption'];
    }
}

if(isset($_GET['prjID']) && !empty($_GET['prjID'])){
    $EditedID = $_GET['prjID'];
    $SelectQuery = "SELECT T.*,P.dead_line AS deadline,P.id AS rowID,P.status AS TStatus FROM `tasks` AS T 
                        INNER JOIN `project_developers` AS P ON P.task_id=T.id 
                    WHERE P.project_id=$EditedID 
                        AND P.developer_id=".$Logged_id."
                        AND T.deleted IS NULL";
    $TaskResult = mysqli_query($con,$SelectQuery);
}

if(isset($_GET['taskID']) && !empty($_GET['taskID'])){
    $taskID = $_GET['taskID'];
    $finishQuery = "UPDATE project_developers SET status=2 WHERE id=".$taskID;
    if(mysqli_query($con,$finishQuery)){
        echo '<div class="alert alert-success text-center">Task Finished</div>';
        header("refresh:1;url=?prjID=$EditedID");
    }else{
        echo '<div class="alert alert-Danger text-center">Error !!</div>';
    }
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
</head>
<body>
    <?php 
        include "../inc/dev_menu.php";
    ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="form-group well" >
                    <label style="margin: 0; width: 50%;">number : </label>
                    <span style="width: 50%;"><?php echo $EditedID; ?></span>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="form-group well" >
                    <label style="margin: 0; width: 50%;">Name : </label>
                    <span><?php echo $row_name; ?></span>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="form-group well" >
                    <label style="margin: 0; width: 60%;">Finish Date : </label>
                    <span style="width: 60%;"><?php echo $row_date; ?></span>
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
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            while($TaskFtch = mysqli_fetch_array($TaskResult)){
                                                // $status = ($TaskFtch['TStatus']==1)?'on process':'done';
                                                if($TaskFtch['TStatus'] == 1){
                                                    $status = "on proccess";
                                                    $btn = '<a href="?prjID='.$EditedID.'&taskID='.$TaskFtch['rowID'].'" class="btn btn-success" onclick="return confirm(\'Are U Sure ?\')"> End Task</a>';
                                                }else{
                                                    $status = "Done";
                                                    $btn = 'Allready submitted';
                                                }
                                                echo '<tr class="even gradeC">
                                                    <td class="text-center">'.$TaskFtch['id'].'</td>
                                                    <td class="text-center">'.$TaskFtch['name'].'</td>
                                                    <td class="text-center">'.$TaskFtch['discreption'].'</td>
                                                    <td class="text-center">'.$TaskFtch['deadline'].'</td>
                                                    <td class="text-center">'.$status.'</td>
                                                    <td class="text-center">'.$btn.'</td>
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