<?php
include "../../library/dbconnect.php";
$mode =                       $_REQUEST['mode'];
$parameter_id =                   $_REQUEST['parameter_id'];
$parameter_name =              $_REQUEST['parameter_name'];
$parameter_value =               $_REQUEST['parameter_value'];
$parameter_status =              $_REQUEST['parameter_status'];

if ($mode == 1) {
    $sql = "INSERT 
                INTO tbl_parameter (
                    parameter_name,
                    parameter_value,
                    parameter_status) 
                VALUES (
                    '$parameter_name',
                    '$parameter_value',
                    '$parameter_status')";
    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}else if ($mode == 2){
    $sql = mysqli_query($conn, "UPDATE tbl_parameter 
            SET 	
            parameter_name = '$parameter_name',							
            parameter_value = '$parameter_value',							
            parameter_status = '$parameter_status'					
            WHERE parameter_id  = '$parameter_id' ");
    if($sql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>