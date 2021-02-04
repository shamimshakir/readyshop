<?php
include "../../library/dbconnect.php";

$mode =              $_REQUEST['mode'];
$id =          $_REQUEST['id'];
$location =     $_REQUEST['location'];
$price =      $_REQUEST['price'];
if ($mode == 1) {
    $sql = "INSERT 
                `tbl_shipping_costs`(
                     `location`, 
                     `price`) 
                VALUES (
                    '$location',
                    '$price'
                )";

    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}else if ($mode == 2){
    $sql = mysqli_query($conn, "UPDATE tbl_shipping_costs
            SET
                location = '$location',
                price = '$price'
            WHERE id  = '$id' ");
    if($sql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>