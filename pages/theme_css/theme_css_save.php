<?php
include "../../library/dbconnect.php";

$mode =      $_REQUEST['mode'];
$id =        $_REQUEST['id'];
$label =     $_REQUEST['label'];
$item =      $_REQUEST['item'];
$item_value =      $_REQUEST['item_value'];
$status =      $_REQUEST['status'];

if ($mode == 1) {
    $sql = "INSERT 
                INTO tbl_css (
                    label,
                    item,
                    item_value,
                    status
                ) 
                VALUES (
                    '$label',
                    '$item',
                    '$item_value',
                    '$status'
                )";

    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}else if ($mode == 2){
    $sql = mysqli_query($conn, "UPDATE tbl_css
            SET
                label = '$label',
                item = '$item',
                item_value = '$item_value',
                status = '$status'
            WHERE id  = '$id' ");
    if($sql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>
