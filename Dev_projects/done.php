<?php
include "../inc/inc.php";

$SelectQuery = "SELECT DISTINCT P.* FROM projects P INNER JOIN project_developers DP ON P.id=DP.project_id
 WHERE P.deleted IS NULL AND DP.developer_id=$Logged_id AND P.status = 2;";
$result = mysqli_query($con, $SelectQuery);

?>
<html>

<head>
    <title>On Process Projects</title>
</head>

<body>
    <?php
    include "../inc/dev_menu.php";
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
                                            if(mysqli_num_rows($result) > 0){
                                                while ($fetch = mysqli_fetch_array($result)) {
                                                    echo '<tr class="even gradeC">
                                                                <td class="text-center">' . $fetch['id'] . '</td>
                                                                <td class="text-center">' . $fetch['name'] . '</td>
                                                                <td class="text-center">' . $fetch['discreption'] . '</td>
                                                                <td class="text-center">' . $fetch['finish_date'] . '</td>
                                                                <td class="text-center">
                                                                    <a href="../Dev_tasks/onProccess.php?prjID=' . $fetch['id'] . '" class="btn btn-warning">Details</a>
                                                                </td>
                                                            </tr>';
                                                }
                                            }else{
                                                echo '<td colspan="5" class="text-center">No projects Yet !</td>';
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