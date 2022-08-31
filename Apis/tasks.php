<?php
include "../inc/inc.php";
$query = "SELECT id,name FROM tasks where project_id=".$_GET['prj_id']." AND deleted IS NULL";
$result = @mysqli_query($con, $query);
$data = '<option value=""></option>';
while ($row = @mysqli_fetch_array($result)) {
    if(isset($_GET['taskId']) && !empty($_GET['taskId']) && $_GET['taskId']==$row['id']){$sel="selected";}
    else{$sel="";}
    $data .= '<option value="'.$row['id'].'" '.$sel.'>'.$row['name'].'</option>';
}

echo $data;