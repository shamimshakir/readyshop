<?php
include('../header.php');

$mode =                       $_REQUEST['mode'];
$sp_id =                   $_REQUEST['sp_id'];
$sp_name =              $_REQUEST['sp_name'];
$sp_email =               $_REQUEST['sp_email'];
$sp_sddress =              $_REQUEST['sp_sddress'];
$sp_mobile =              $_REQUEST['sp_mobile'];
$sp_contact_person =              $_REQUEST['sp_contact_person'];
$status =              $_REQUEST['status'];

// echo '<pre>';
// print_r($_REQUEST);
// echo '</pre>';
// exit();


if ($mode == 1) {
    $sql = "INSERT 
                INTO tbl_shippers (
                    sp_name,
                    sp_email,
                    sp_sddress,
                    sp_mobile,
                    status,
                    sp_contact_person
                ) 
                VALUES (
                    '$sp_name',
                    '$sp_email',
                    '$sp_sddress',
                    '$sp_mobile',
                    '$status',
                    '$sp_contact_person'
                )";
    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}else if ($mode == 2){
    $sql = mysqli_query($conn, "UPDATE tbl_shippers 
            SET 	
                sp_name = '$sp_name',							
                sp_email = '$sp_email',							
                sp_sddress = '$sp_sddress',					
                sp_mobile = '$sp_mobile',					
                status = '$status',                   
                sp_contact_person = '$sp_contact_person'						
            WHERE sp_id  = '$sp_id' ");
    if($sql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>