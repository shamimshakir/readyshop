<?php 
include('../header.php');
$slider_id = $_POST['slider_id'];
$query1="UPDATE
    tbl_slider
SET
    status = 0";
mysqli_query($conn,$query1 );

$query="UPDATE
    tbl_slider
SET
    status = 1
WHERE
    id  = $slider_id";
    
$sql = mysqli_query($conn,$query );
if($sql){
    echo "successfully updated";
}else{
    echo "Failed to update";
}