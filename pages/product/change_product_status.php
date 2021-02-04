<?php
include('../header.php');

$product_id = $_POST['product_id'];
$statusName = $_POST['statusName'];

$query="UPDATE
    tbl_product
SET
    $statusName = CASE WHEN $statusName = 1 THEN 0 ELSE 1
END
WHERE
    pd_id  = $product_id";
$sql = mysqli_query($conn,$query );
if($sql){
    echo "successfully updated";
}else{
    echo "Failed to update";
}