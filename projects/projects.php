<?php
include "../inc/inc.php";
if(isset($_GET['type']) && !empty($_GET['type']))
    $type = $_GET['type'];
else
    $type = 1;

$SelectQuery = "SELECT * FROM projects WHERE deleted IS NULL AND status = $type;";
$result = mysqli_query($con,$SelectQuery);

if(isset($_GET['delID']) && !empty($_GET['delID'])){
    $DeleteDate = date('Y-m-d H:i:s');
    $DeletedID = $_GET['delID'];
    $DeleteQuery = "UPDATE projects SET deleted='$DeleteDate' WHERE id=$DeletedID";
    if(mysqli_query($con,$DeleteQuery)){
        echo '<div class="alert alert-success text-center"> Project Deleted Successfully </div>';
        header("refresh:1;url=projects.php?type=1");
    }else{
        echo '<div class="alert alert-danger text-center"> Error !! </div>';
    }
}

if(isset($_GET['ComID']) && !empty($_GET['ComID'])){
    $CondID = $_GET['ComID'];
    $ConQuery = "SELECT * FROM project_developers WHERE project_id=$CondID AND status=1";
    if(mysqli_num_rows(mysqli_query($con,$ConQuery)) == 0){
        $DoneQuery = "UPDATE projects SET status=2 WHERE id=".$CondID.";";
        if(mysqli_query($con,$DoneQuery)){
            echo '<div class="alert alert-success text-center"> Project Finished Successfully </div>';
            header("refresh:1;url=projects.php?type=1");
        }else{
            echo '<div class="alert alert-danger text-center"> ERROR </div>';
        }
    }else{
        echo '<div class="alert alert-danger text-center"> There is tasks not finished yet </div>';
    }
}

?>
<html>
    <head>
        <title>On Process Projects</title>
    </head>
    <body>
        <?php 
            include "../inc/menu.php";
        ?>
        <div class="container">
            <br>
            <a href="AddNewProject.php" class="btn btn-success">Add New Project</a> <br>
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
                                                    <th class="text-center">serial</th>
                                                    <th class="text-center">name</th>
                                                    <th class="text-center">description</th>
                                                    <th class="text-center">finish date</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    while($fetch = mysqli_fetch_array($result)){
                                                        echo '<tr class="even gradeC">
                                                            <td class="text-center">'.$fetch['id'].'</td>
                                                            <td class="text-center">'.$fetch['name'].'</td>
                                                            <td class="text-center">'.$fetch['discreption'].'</td>
                                                            <td class="text-center">'.$fetch['finish_date'].'</td>
                                                            <td class="text-center">
                                                                <a href="?delID='.$fetch['id'].'" onclick="return confirm(\'Are U Sure ?\')" class="btn btn-danger">Delete</a>
                                                                <a href="EditProject.php?EditID='.$fetch['id'].'" class="btn btn-primary">Edit</a>
                                                                <a href="DetailsProject.php?prjID='.$fetch['id'].'" class="btn btn-warning">Details</a>
                                                                <a href="?ComID='.$fetch['id'].'" class="btn btn-info">Done</a>
                                                                <!-- Button trigger modal -->
                                                                <button style="display:none" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditModal-'.$fetch['id'].'">
                                                                Edit
                                                                </button>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="EditModal-'.$fetch['id'].'" tabindex="-1" aria-labelledby="EditModal" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="EditModal">Modal title</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            ...
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
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