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
    $SelectQuery = "SELECT * FROM `tasks` WHERE project_id=$EditedID AND deleted IS NULL";
    // $SelectQuery = "SELECT * FROM `tasks` AS T INNER JOIN `project_developers` AS P ON P.project_id=T.project_id WHERE P.project_id=$EditedID AND P.deleted IS NULL";
    $TaskResult = mysqli_query($con,$SelectQuery);
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
        include "../inc/menu.php";
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
            <a href="../projects/projects.php?type=1" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a> 
            <a href="../tasks/AddNewTask.php?prjID=<?php echo $EditedID; ?>" class="btn btn-success">Add New Task</a> 
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
                                            <th class="text-center">Task ID</th>
                                            <th class="text-center">Task</th>
                                            <th class="text-center">Discreption</th>
                                            <th class="text-center">End date</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $i=1;
                                            while($TaskFtch = mysqli_fetch_array($TaskResult)){
                                                echo '<tr class="even gradeC">
                                                    <td class="text-center">'.$i.'</td>
                                                    <td class="text-center">'.$TaskFtch['id'].'</td>
                                                    <td class="text-center">'.$TaskFtch['name'].'</td>
                                                    <td class="text-center">'.$TaskFtch['discreption'].'</td>
                                                    <td class="text-center">'.$TaskFtch['end_date'].'</td>
                                                    <td class="text-center">
                                                        <a href="?delID='.$TaskFtch['id'].'" onclick="return confirm(\'Are U Sure ?\')" class="btn btn-danger">Delete</a>
                                                        <a href="../tasks/EditTask.php?EditID='.$TaskFtch['id'].'" class="btn btn-primary">Edit</a>
                                                        <a href="../tasks/DetailsTask.php?taskID='.$TaskFtch['id'].'" class="btn btn-warning">More</a>
                                                    </td>
                                                </tr>';
                                                $i++;
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