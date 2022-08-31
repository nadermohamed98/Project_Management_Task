<?php 
include "../inc/inc.php";

if(isset($_GET['EditID']) && !empty($_GET['EditID'])){
    $EditedID = $_GET['EditID'];
    $SelectQuery = "SELECT T.*,P.name AS PrjName
        FROM tasks T 
            INNER JOIN projects P ON T.project_id=P.id 
        WHERE T.id=$EditedID AND T.deleted IS NULL AND P.deleted IS NULL";
    
    $result = mysqli_query($con,$SelectQuery);
    while($fetch = mysqli_fetch_array($result)){
        $row_name = $fetch['name'];
        $row_discreption = $fetch['discreption'];
        $row_project = $fetch['PrjName'];
        $row_project_id = $fetch['project_id'];
        $row_date = date("Y-m-d",strtotime($fetch['end_date']));
    }
}

$TaskDevelopers = mysqli_fetch_array(mysqli_query($con,"SELECT GROUP_CONCAT(developer_id SEPARATOR ',') AS IDs FROM project_developers WHERE project_id=$row_project_id AND task_id=$EditedID;"));
$DevIds = explode(",",$TaskDevelopers['IDs']);

if(isset($_POST['submitData'])){
    $name = stripslashes($_POST['taskName']);
    $discreption = stripslashes($_POST['taskDiscreption']);
    $project_id = stripslashes($_POST['project_id']);
    $date = date('Y-m-d',strtotime(stripslashes($_POST['taskDate'])));
    $UpdateQuery = "UPDATE tasks SET `name`='$name',`discreption`='$discreption',`project_id`=$project_id,`end_date`='$date' WHERE id=$EditedID;";
    if(mysqli_query($con,$UpdateQuery)){
        $insertedTaskID = mysqli_insert_id($con);
        if(!empty($_POST['Dev_id'])){
            $developer_ids = $_POST['Dev_id'];
            foreach($developer_ids as $developer_id){
                $CheckIfFound = "SELECT * FROM project_developers WHERE project_id=$row_project_id AND task_id=$EditedID AND developer_id=$developer_id";
                if(mysqli_num_rows(mysqli_query($con,$CheckIfFound)) > 0){
                    $UpdateQuery = "UPDATE project_developers SET developer_id=$developer_id,project_id=$project_id WHERE id=$EditedID";
                    mysqli_query($con,$UpdateQuery);
                }else{
                    $InsertQuery = "INSERT INTO project_developers (`developer_id`,`project_id`,`task_id`,`status`) VALUES ($developer_id,$project_id,$EditedID,1);";
                    mysqli_query($con,$InsertQuery);
                }
            }
        }
        echo '<div class="alert alert-success text-center">Task Added Successfully</div>';
        header("refresh:1;url=../tasks/tasks.php");
    }else{
        echo '<div class="alert alert-danger text-center">Error !!</div>';
    }
}

$selectDev = "SELECT * FROM users WHERE is_admin=0 AND deleted_at IS NULL";
$DevResult = mysqli_query($con,$selectDev);

$selectPrj = "SELECT * FROM projects WHERE deleted IS NULL";
$result = mysqli_query($con,$selectPrj);

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task info</title>
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
                                        if($row_project_id == $fetch['id']){$selected="selected";}
                                        else{$selected="";}
                                        echo '<option value="'.$fetch['id'].'" '.$selected.'>'.$fetch['name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label class="control-label col-lg-4" for="Dev_id"> Developers </label>
                            <div class="col-lg-4 float-inp">
                                <select name="Dev_id[]" id="Dev_id" class="form-control" multiple="multiple" style="height: 100px !important;">
                                    <option value=""></option>
                                    <?php 
                                    while($fetch = mysqli_fetch_array($DevResult)){
                                        if(in_array($fetch['id'],$DevIds)){$selected="selected";}
                                        else{$selected="";}
                                        echo '<option value="'.$fetch['id'].'" '.$selected.'>'.$fetch["name"].'</option>';    
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="taskName">Task Name </label>
                            <div class="col-lg-4 float-inp">
                                <input type="text" class="form-control"  name="taskName" id="taskName" value="<?php echo $row_name ?>" required>
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
                                <textarea name="taskDiscreption" class="form-control" id="taskDiscreption"><?php echo $row_discreption ?></textarea>
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
        <script>
            document.getElementById("taskDate").defaultValue = "<?php echo $row_date ?>"
        </script>
    </body>
</html>