<?php
include "../inc/inc.php";
echo $query = "SELECT id,name FROM users where id=".$_GET['userId']." AND deleted_at IS NULL";
$result = @mysqli_query($con, $query);
$data = '<option value=""></option>';
while ($row = @mysqli_fetch_array($result)) {
    if(isset($_GET['userId']) && !empty($_GET['userId']) && $_GET['userId']==$row['id']){$sel="selected";}
    else{$sel="";}
    $data .= '<option value="'.$row['id'].'" '.$sel.'>'.$row['name'].'</option>';
}

echo $data;