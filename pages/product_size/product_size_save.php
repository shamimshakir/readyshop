<?php
include('../header.php');

$mode =              $_REQUEST['mode'];
$size_id =          $_REQUEST['size_id'];
$size_display = $_REQUEST['size_display'];
// $size_type = $_REQUEST['size_type'];
$size_remarks = $_REQUEST['size_remarks'];
$status=$_REQUEST['status'];
// print_r($_REQUEST);
// exit();
if ($mode == 1) {
$sql = "INSERT 
                INTO tbl_size (
                    size_display,
                    -- size_type,
                    size_remarks,
                    status
                ) 
                VALUES (
                    '$size_display',
                    -- '$size_type',
                    '$size_remarks',
                    '$status'
                )";

$runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
if($runSql){
    echo "Data successfully added";
}else{
    echo "Failed to add data";
}
}else if ($mode == 2){
    $sql = "UPDATE tbl_size 
            SET     
            size_display='$size_display',
            -- size_type='$size_type',
            size_remarks ='$size_remarks',
            status='$status'               
            WHERE size_id  = '$size_id' ";
    $res = mysqli_query($conn, $sql);
    if($res){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>