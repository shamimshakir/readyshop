<?php
include "../../library/dbconnect.php";

$mode =              $_REQUEST['mode'];
$id =       $_REQUEST['id'];
$social_name =       $_REQUEST['social_name'];
$url =               $_REQUEST['url'];
$icon =              $_REQUEST['icon'];
$act_status = $_REQUEST['act_status'];

if ($mode == 1) {
    $sql = "INSERT 
                INTO  tbl_social_links (
                    social_name,
                    url,
                    icon,
                    active_status
                ) 
                VALUES (
                    '$social_name',
                    '$url',
                    '$icon',
                    '$act_status'
                )";

    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}else if ($mode == 2){
    $sql = mysqli_query($conn, "UPDATE tbl_social_links
            SET
                social_name = '$social_name',
                url = '$url',
                icon = '$icon',
                active_status='$act_status'
            WHERE id  = '$id' ");
    if($sql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>