<?php 
include "../inc/inc.php";
if(isset($_GET['rowID']) && !empty($_GET['rowID'])){
    $EditedID = $_GET['rowID'];
    $SelectQuery = "SELECT T.name AS TaskName
                        ,T.id AS TaskID
                        ,PD.dead_line AS TaskEndDate
                        ,T.discreption AS TaskDisc
                        ,P.name AS PrjName
                        ,U.name AS UserName
                        ,PD.status AS status
                        ,PD.developer_id AS DevId
                        ,PD.project_id AS PrjId
                        ,PD.task_id AS TaskId
                    FROM project_developers AS PD 
                        INNER JOIN tasks AS T ON PD.task_id=T.id 
                        INNER JOIN projects AS P ON PD.project_id=P.id 
                        LEFT JOIN users AS U ON PD.developer_id=U.id 
                    WHERE P.deleted IS NULL 
                        AND T.deleted IS NULL
                        AND PD.id=$EditedID;";

    $SelectResult = mysqli_query($con,$SelectQuery);
    $RowFetch = mysqli_fetch_array($SelectResult);
    $dev_id = $RowFetch['DevId'];
    $dev_name = $RowFetch['UserName'];
    $prj_id = $RowFetch['PrjId'];
    $prj_name = $RowFetch['PrjName'];
    $task_id = $RowFetch['TaskId'];
    $DeadLine_db = date("Y-m-d",strtotime($RowFetch['TaskEndDate']));
}

if(isset($_POST['submitData'])){
    $developer_name = $_POST['developer_name'];
    $prjName = $_POST['prjName'];
    $taskName = $_POST['taskName'];
    $deadline = date('Y-m-d',strtotime($_POST['deadline']));
    $checkIfFound = mysqli_query($con,"SELECT * FROM project_developers WHERE developer_id=$developer_name AND project_id=$prjName AND task_id=$taskName AND status=1");
    if(mysqli_num_rows($checkIfFound) == 0){
        $UpdateQuery = "UPDATE project_developers SET developer_id=$developer_name, project_id=$prjName, task_id=$taskName, dead_line='$deadline' WHERE id=$EditedID";
        if(mysqli_query($con,$UpdateQuery)){
            echo '<div class="alert alert-success text-center">Task Assigned Successfully</div>';
            header("refresh:1;url=EditAssignedTask.php?rowID=$EditedID");
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
    <title>Re-Assign Task</title>
</head>
    <body>
        <?php 
            include "../inc/menu.php";
        ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <br>
                    <a href="../users/DetailsDeveloper.php?id=<?php echo $dev_id ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                    <hr>
                    <form method="POST" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="developer_name">Developer </label>
                            <div class="col-lg-4 float-inp">
                                <select name="developer_name" id="developer_name" class="form-control" required>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="prjName">Project </label>
                            <div class="col-lg-4 float-inp">
                                <select name="prjName" id="prjName" class="form-control" onchange="GetTasks(this.value);" required>                            
                                    <option value="<?php echo $prj_id ?>" selected><?php echo $prj_name ?></option>
                                </select>
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
                                <input type="submit" class="btn btn-success" value="Re-Assign" name="submitData" id="submitData" class="btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>

            document.getElementById("deadline").defaultValue = "<?php echo $DeadLine_db ?>"

            $.ajax({          
                type: "GET",
                url: "../Apis/users.php",
                data: "userId="+<?php echo $dev_id ?>,
                success: function(data){
                    $("#developer_name").html(data);
                }
            });

            $.ajax({          
                type: "GET",
                url: "../Apis/projects.php",
                data: "PrjId="+<?php echo $prj_id ?>,
                success: function(data){
                    $("#prjName").html(data);
                }
            });

            $.ajax({          
                type: "GET",
                url: "../Apis/tasks.php",
                data:'prj_id='+<?php echo $prj_id ?>+'&taskId='+<?php echo $task_id ?>,
                success: function(data){
                    $("#taskName").html(data);
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