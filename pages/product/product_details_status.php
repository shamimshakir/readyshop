<?php 
include('../header.php');
$id = $_POST['id'];
$field = $_POST['field'];
$query="UPDATE
    tbl_product
SET
    ".$field." = CASE WHEN ".$field." = 1 THEN 0 ELSE 1
END
WHERE
    pd_id  = $id";
    
$sql = mysqli_query($conn,$query );
if($sql){
    echo "successfully updated";
}else{
    echo "Failed to update";
}