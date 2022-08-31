<?php
include "../inc/inc.php";
$search = $_GET['prj_id'];
$query = "SELECT id,name FROM tasks where project_id=$search";
$result = @mysqli_query($con, $query);
$data = '<option value=""></option>';
while ($row = @mysqli_fetch_array($result)) {
    $data .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
}

echo $data;