<?php
include "../inc/inc.php";
if(isset($_GET['type']) && !empty($_GET['type']))
    $type = $_GET['type'];
else
    $type = 2;

$SelectQuery = "SELECT * FROM projects WHERE deleted IS NULL AND status = $type;";
$result = mysqli_query($con,$SelectQuery);

?>
<html>
    <head>
        <title>Done Projects</title>
    </head>
    <body>
        <?php 
            include "../inc/menu.php";
        ?>
        <div class="container">
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
                                                                <a href="DetailsProject.php?prjID='.$fetch['id'].'" class="btn btn-warning">Details</a>
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