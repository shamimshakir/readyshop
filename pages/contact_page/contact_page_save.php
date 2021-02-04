<?php
include "../../library/dbconnect.php";



$id =          $_REQUEST['id'];
$contact_address =     $_REQUEST['contact_address'];
$contact_phone =      $_REQUEST['contact_phone'];
$contact_email =     $_REQUEST['contact_email'];
$contact_map_location =     $_REQUEST['contact_map_location'];

$sql = "UPDATE tbl_contact_page_info 
        SET 	
        contact_address = '$contact_address',							
        contact_phone = '$contact_phone',							
        contact_email = '$contact_email',					
        contact_map_location = '$contact_map_location'					
        WHERE id  = '$id' ";
$res = mysqli_query($conn, $sql);
if($res){
    echo "Data successfully updated";
}else{
    echo "Failed to update data";
}

?>