<?php 
include "../inc/inc.php";
if(isset($_GET['id']) && !empty($_GET['id'])){
    $Dev_ID = $_GET['id'];
    $SelectQuery = "SELECT * FROM users WHERE id=$Dev_ID AND is_admin=0 AND deleted_at IS NULL";
    $SelectResult = mysqli_query($con,$SelectQuery);
    $DevFetch = mysqli_fetch_array($SelectResult);
    $dev_id = $DevFetch['id'];
    $dev_name = $DevFetch['name'];
    $dev_user_name = $DevFetch['user_name'];
}

if(isset($_POST['submitData'])){
    $developer_name = $_POST['developer_name'];
    $prjName = $_POST['prjName'];
    $taskName = $_POST['taskName'];
    $deadline = date('Y-m-d',strtotime($_POST['deadline']));
    $checkIfFound = mysqli_query($con,"SELECT * FROM project_developers WHERE developer_id=$developer_name AND project_id=$prjName AND task_id=$taskName AND status=1");
    if(mysqli_num_rows($checkIfFound) == 0){
        $InsertQuery = "INSERT INTO project_developers (`developer_id`,`project_id`,`task_id`,`dead_line`,`status`) VALUES($developer_name,$prjName,$taskName,'$deadline',1);";
        if(mysqli_query($con,$InsertQuery)){
            echo '<div class="alert alert-success text-center">Task Assigned Successfully</div>';
            header("refresh:1;url=../users/DetailsDeveloper.php?id=$Dev_ID");
        }else{
            echo '<div class="alert alert-danger text-center">Error !!</div>';
        }
    }else{
        echo '<div class="alert alert-warning text-center">This Task Is allready Assigned to this developer ..</div>';
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Task</title>
</head>
    <body>
        <?php 
            include "../inc/menu.php";
        ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <br>
                    <a href="../users/DetailsDeveloper.php?id=<?php echo $Dev_ID ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                    <hr>
                    <form method="POST" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="developer_name">Developer </label>
                            <div class="col-lg-4 float-inp">
                                <select name="developer_name" id="developer_name" class="form-control" required>
                                    <option value="<?php echo $Dev_ID ?>" selected><?php echo $dev_name ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="prjName">Project </label>
                            <div class="col-lg-4 float-inp">
                                <select name="prjName" id="prjName" class="form-control" onchange="GetTasks(this.value);" required></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="taskName">Task </label>
                            <div class="col-lg-4 float-inp">
                                <select name="taskName" id="taskName" class="form-control" required></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="deadline">Dead line </label>
                            <div class="col-lg-4 float-inp">
                                <input type="date" class="form-control" name="deadline" id="deadline" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4"> </label>
                            <div class="col-lg-4 float-inp">
                                <input type="submit" class="btn btn-success" value="Assign" name="submitData" id="submitData" class="btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $.ajax({          
                    type: "GET",
                    url: "../Apis/projects.php",
                    success: function(data){
                        $("#prjName").html(data);
                    }
            });

            function GetTasks(id){
                $.ajax({          
                        type: "GET",
                        url: "../Apis/projectTasks.php",
                        data:'prj_id='+id,
                        success: function(data){
                            $("#taskName").html(data);
                        }
                });
            }
        </script>
    </body>
</html>