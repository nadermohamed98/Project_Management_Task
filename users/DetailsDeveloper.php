<?php 
include "../inc/inc.php";

if(isset($_GET['id']) && !empty($_GET['id'])){
    $EditedID = $_GET['id'];
    $SelectQuery = "SELECT * FROM users WHERE id=$EditedID AND deleted_at IS NULL";
    $result = mysqli_query($con,$SelectQuery);
    while($fetch = mysqli_fetch_array($result)){
        $row_name = $fetch['name'];
        $row_user_name = $fetch['user_name'];
    }
}

if(isset($_GET['ReAssignID']) && !empty($_GET['ReAssignID'])){
    $ReAssignID = $_GET['ReAssignID'];
    $SelectQuery = "UPDATE project_developers SET status=1 WHERE id=$ReAssignID";
    if(mysqli_query($con,$SelectQuery)){
        echo '<div class="alert alert-success text-center">Task Re-Assigned Successfully</div>';
        header("refresh:1;url=DetailsDeveloper.php?id=$EditedID");
    }
    
}

if(isset($_GET['id']) && !empty($_GET['id'])){
    $EditedID = $_GET['id'];
    // $SelectQuery = "SELECT * FROM `tasks` WHERE project_id=$EditedID AND deleted_at IS NULL";
    $SelectQuery = "SELECT T.name AS TaskName,T.id AS TaskID,PD.dead_line AS TaskEndDate
                        ,T.discreption AS TaskDisc,P.name AS PrjName,U.name AS UserName
                        ,PD.status AS status
                        ,PD.id AS RowId
                        ,PD.status AS TStatus
                    FROM project_developers AS PD 
                        INNER JOIN tasks AS T ON PD.task_id=T.id 
                        INNER JOIN projects AS P ON PD.project_id=P.id 
                        LEFT JOIN users AS U ON PD.developer_id=U.id 
                    WHERE P.deleted IS NULL 
                        AND T.deleted IS NULL
                        AND PD.developer_id=$EditedID;";
    $TaskResult = mysqli_query($con,$SelectQuery);
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Profile</title>
</head>
<body>
    <?php 
        include "../inc/menu.php";
    ?>
    <div class="container">
        <br>
        <a href="../users/developer.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a> 
        <a href="../tasks/AssignTask.php?id=<?php echo $EditedID; ?>" class="btn btn-success">Assign new task</a> 
        <br>
        <hr>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="form-group well" >
                    <label style="margin: 0; width: 50%;">ID : </label>
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
                    <label style="margin: 0; width: 60%;">User Name : </label>
                    <span style="width: 60%;"><?php echo $row_user_name; ?></span>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Project</th>
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
                                                $status = ($TaskFtch['status']==1)?'on process':'done';
                                                echo '<tr class="even gradeC">
                                                    <td class="text-center">'.$TaskFtch['TaskID'].'</td>
                                                    <td class="text-center">'.$TaskFtch['PrjName'].'</td>
                                                    <td class="text-center">'.$TaskFtch['TaskName'].'</td>
                                                    <td class="text-center">'.$TaskFtch['TaskDisc'].'</td>
                                                    <td class="text-center">'.$TaskFtch['TaskEndDate'].'</td>
                                                    <td class="text-center">'.$status.'</td>
                                                    <td class="text-center">
                                                        <a href="?delID='.$TaskFtch['id'].'" onclick="return confirm(\'Are U Sure ?\')" class="btn btn-danger">Delete</a>';
                                                        if($TaskFtch['TStatus'] == 1){
                                                            echo ' <a href="../tasks/EditAssignedTask.php?rowID='.$TaskFtch['RowId'].'" class="btn btn-primary">Edit</a> ';
                                                        }else{
                                                            echo ' <a href="?ReAssignID='.$TaskFtch['RowId'].'&id='.$EditedID.'"  onclick="return confirm(\'Are U Sure ?\')" class="btn btn-warning">Re-assign</a> ';
                                                        }
                                                    echo '</td>
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