<?php
include('../header.php');

$mode =                       $_REQUEST['mode'];
$unit_id =                   $_REQUEST['unit_id'];
$unit_name =              $_REQUEST['unit_name'];
$status =              $_REQUEST['status'];

// echo '<pre>';
// print_r($_REQUEST);
// echo '</pre>';

if ($mode == 1) {
    $sql = "INSERT INTO tbl_unit ( unit_display, status ) VALUES ( '$unit_name', '$status' )";
    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}else if ($mode == 2){
    $sql = mysqli_query($conn, "UPDATE tbl_unit SET unit_display = '$unit_name', status = '$status' WHERE unit_id  = '$unit_id' ");
    if($sql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
        echo mysqli_error($conn); 
    }
}
?>