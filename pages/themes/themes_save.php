<?php
include "../../library/dbconnect.php";

$mode =      $_REQUEST['mode'];
$id =        $_REQUEST['id'];
$name =     $_REQUEST['name'];
$act_status =      $_REQUEST['act_status'];
$edit_status =      $_REQUEST['edit_status'];

if ($mode == 1) {
    $sql = "INSERT 
                INTO tbl_theme (
                    theme_name,
                    status,
                    edit_status
                ) 
                VALUES (
                    '$name',
                    '$act_status',
                    '$edit_status'
                )";

    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        $last_id = mysqli_insert_id($conn);
        if ($act_status==1) {
            $inactive=mysqli_query($conn,"UPDATE `tbl_theme` SET `status`=0 WHERE id != '$last_id'");
        }
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}else if ($mode == 2){
    $sql = mysqli_query($conn, "UPDATE tbl_theme
            SET
                theme_name = '$name',
                status = '$act_status',
                edit_status= '$edit_status'
            WHERE id  = '$id' ");
    if($sql){
        $inactive=mysqli_query($conn,"UPDATE `tbl_theme` SET `status`=0 WHERE id != '$id'");
        if ($inactive) {
            echo "Data successfully updated";
        }
        
    }else{
        echo "Failed to update data";
    }
}
?>
