<?php 
include "../inc/inc.php";

if(isset($_GET['EditID']) && !empty($_GET['EditID'])){
    $EditedID = $_GET['EditID'];
    $SelectQuery = "SELECT * FROM projects WHERE id=$EditedID AND deleted IS NULL";
    $result = mysqli_query($con,$SelectQuery);
    while($fetch = mysqli_fetch_array($result)){
        $row_name = $fetch['name'];
        $row_date = date("Y-m-d",strtotime($fetch['finish_date']));
        $row_discreption = $fetch['discreption'];
    }
}

if(isset($_POST['submitData'])){
    $name = stripslashes($_POST['prjName']);
    $discreption = stripslashes($_POST['prjDiscreption']);
    $date = date('Y-m-d',strtotime(stripslashes($_POST['prjDate'])));
    $EditQuery = "UPDATE projects SET `name`='$name',`finish_date`='$date',`discreption`='$discreption' WHERE id=$EditedID ;";
    if(mysqli_query($con,$EditQuery)){
        echo '<div class="alert alert-success text-center">Project Edited Successfully</div>';
        header("refresh:1;url=projects.php");
    }else{
        echo '<div class="alert alert-danger text-center">Error !!</div>';
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
</head>
    <body>
        <?php 
            include "../inc/menu.php";
        ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <br>
                    <a href="projects.php?type=1" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                    <hr>
                    <form method="POST" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="prjName">Project Name </label>
                            <div class="col-lg-4 float-inp">
                                <input type="text" class="form-control"  name="prjName" id="prjName" value="<?php echo $row_name; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="prjDate">Project Finish Date </label>
                            <div class="col-lg-4 float-inp">
                                <input type="date" class="form-control" name="prjDate" id="prjDate" value="<?php echo $row_date; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="prjDiscreption">Project Discreption </label>
                            <div class="col-lg-4 float-inp">
                                <textarea name="prjDiscreption" class="form-control" id="prjDiscreption"> <?php echo $row_discreption; ?> </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="prjDiscreption"> </label>
                            <div class="col-lg-4 float-inp">
                                <input type="submit" class="btn btn-success" name="submitData" value="Edit" id="submitData" class="btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>


    <script>
        document.getElementById("prjDate").defaultValue = "<?php echo $row_date ?>";
    </script>
</html>