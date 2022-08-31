<?php
include "../inc/inc.php";
$query = "SELECT id,name FROM projects where deleted IS NULL AND status=1";
$result = @mysqli_query($con, $query);
$data = '<option value=""></option>';
while ($row = @mysqli_fetch_array($result)) {
    if(isset($_GET['PrjId']) && !empty($_GET['PrjId']) && $_GET['PrjId']==$row['id']){$sel="selected";}
    else{$sel="";}
    $data .= '<option value="'.$row['id'].'" '.$sel.'>'.$row['name'].'</option>';
}

echo $data;