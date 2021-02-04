<?php 
include('../header.php');
$id = $_POST['id'];
$query="UPDATE
    tbl_emailsetup
SET
    status = CASE WHEN status = 1 THEN 0 ELSE 1
END
WHERE
    id  = $id";
    
$sql = mysqli_query($conn,$query );
if($sql){
    echo "successfully updated";
}else{
    echo "Failed to update";
}