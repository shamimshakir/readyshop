<?php
include "../../library/dbconnect.php";

$mode =              $_REQUEST['mode'];
$brand_id =          $_REQUEST['brand_id'];
$brand_display =     $_REQUEST['brand_display'];
$brand_detail =      $_REQUEST['brand_detail'];
$brand_remarks =     $_REQUEST['brand_remarks'];

if ($mode == 1) {
    $sql = "INSERT 
                INTO tbl_brand (
                    brand_display,
                    brand_detail,
                    brand_remarks
                ) 
                VALUES (
                    '$brand_display',
                    '$brand_detail',
                    '$brand_remarks'
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
                brand_detail = '$brand_detail',
                brand_remarks = '$brand_remarks'
            WHERE brand_id  = '$brand_id' ");
    if($sql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>