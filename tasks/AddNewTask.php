<?php 
include "../inc/inc.php";

if(isset($_POST['submitData'])){
    $name = stripslashes($_POST['taskName']);
    $discreption = stripslashes($_POST['taskDiscreption']);
    $project_id = stripslashes($_POST['project_id']);
    $date = date('Y-m-d',strtotime(stripslashes($_POST['taskDate'])));
    $InsertQuery = "INSERT INTO tasks (`name`,`discreption`,`project_id`,`end_date`) VALUES('$name','$discreption','$project_id','$date');";
    if(mysqli_query($con,$InsertQuery)){
        $insertedTaskID = mysqli_insert_id($con);
        if(!empty($_POST['Dev_id'])){
            $project_id = stripslashes($_POST['project_id']);
            $developer_ids = $_POST['Dev_id'];
            foreach($developer_ids as $developer_id){
                $InsertQuery = "INSERT INTO project_developers (`developer_id`,`project_id`,`task_id`,`status`) VALUES ($developer_id,$project_id,$insertedTaskID,1);";
                mysqli_query($con,$InsertQuery);
            }
        }
        echo '<div class="alert alert-success text-center">Task Added Successfully</div>';
        header("refresh:1;url=../projects/DetailsProject.php?prjID=".$_GET['prjID']."");
    }else{
        echo '<div class="alert alert-danger text-center">Error !!</div>';
    }
}

$selectDev = "SELECT * FROM users WHERE is_admin=0 AND deleted_at IS NULL";
$DevResult = mysqli_query($con,$selectDev);

$selectPrj = "SELECT * FROM projects WHERE deleted IS NULL";
$result = mysqli_query($con,$selectPrj);

if(isset($_GET['prjID']) && !empty($_GET['prjID'])){
    $selected = "selected";
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Project</title>
</head>
    <body>
        <?php 
            include "../inc/menu.php";
        ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <br>
                    <a href="../tasks/tasks.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                    <hr>
                    <form method="POST" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="project_id">Project </label>
                            <div class="col-lg-4 float-inp">
                                <select name="project_id" id="project_id" class="form-control">
                                    <option value=""></option>
                                    <?php 
                                    while($fetch = mysqli_fetch_array($result)){
                                        echo '<option value="'.$fetch['id'].'" '.$selected.'>'.$fetch["name"].'</option>';    
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label class="control-label col-lg-4" for="Dev_id">Developer </label>
                            <div class="col-lg-4 float-inp">
                                <select name="Dev_id[]" id="Dev_id" class="form-control" multiple="multiple" style="height: 100px !important;">
                                    <option value=""></option>
                                    <?php 
                                    while($fetch = mysqli_fetch_array($DevResult)){
                                        echo '<option value="'.$fetch['id'].'">'.$fetch["name"].'</option>';    
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="taskName">Task Name </label>
                            <div class="col-lg-4 float-inp">
                                <input type="text" class="form-control"  name="taskName" id="taskName" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="taskDate">Task End Date </label>
                            <div class="col-lg-4 float-inp">
                                <input type="date" class="form-control" name="taskDate" id="taskDate" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="taskDiscreption">Task Discreption </label>
                            <div class="col-lg-4 float-inp">
                                <textarea name="taskDiscreption" class="form-control" id="taskDiscreption"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="taskDiscreption"> </label>
                            <div class="col-lg-4 float-inp">
                                <input type="submit" class="btn btn-success" name="submitData" id="submitData" class="btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>