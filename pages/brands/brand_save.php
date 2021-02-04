<?php
include "../../library/dbconnect.php";

$mode =              $_REQUEST['mode'];
$brand_id =          $_REQUEST['brand_id'];
$brand_display =     $_REQUEST['brand_display'];
$status =      $_REQUEST['status'];
if ($mode == 1) {
    $sql = "INSERT 
                INTO tbl_brand (
                    brand_display,
                    status
                ) 
                VALUES (
                    '$brand_display',
                    '$status'
                )";

    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}else if ($mode == 2){
    $sql = mysqli_query($conn, "UPDATE tbl_brand
            SET
                brand_display = '$brand_display',
                status = '$status'
            WHERE brand_id  = '$brand_id' ");
    if($sql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>