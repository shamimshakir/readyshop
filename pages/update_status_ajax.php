<?php 
include "../library/dbconnect.php";

$id = $_POST['id'];
$table = $_POST['table'];
$idField = $_POST['idField'];
$status = $_POST['status'];

$query="UPDATE
     {$table}
SET
    {$status} = CASE WHEN {$status} = 1 THEN 0 ELSE 1
END
WHERE
    {$idField}  = $id";

$sql = mysqli_query($conn,$query );
if($sql){
    echo "successfully updated";
}else{
    echo "Failed to update";
}