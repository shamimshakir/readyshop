<?php
include "../../library/dbconnect.php";

$mode =              $_REQUEST['mode'];
$id =          $_REQUEST['id'];
$page_title =          $_REQUEST['page_title'];
$page_name =          $_REQUEST['page_name'];
$page_content =     $_REQUEST['page_content'];
$act_status = $_REQUEST['act_status'];

if ($mode == 1) {
    $sql = "INSERT INTO tbl_pages_content ( page_title,page_name, page_content,active_status) VALUES ( '$page_title','$page_name', '".mysqli_real_escape_string($conn,$page_content)."'	,'$act_status')";

    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}else if ($mode == 2){
    $sql = "UPDATE tbl_pages_content 
            SET 
            page_title= '$page_title',
            page_name = '$page_name',							
            page_content = '".mysqli_real_escape_string($conn,$page_content)."'	,
            active_status='$act_status'
            WHERE id  = '$id' ";
    $res = mysqli_query($conn, $sql);
    if($res){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>