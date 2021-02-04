<?php
include('../header.php');
extract($_REQUEST);

$sql = "UPDATE users 
 		SET 
 			user_name = '$user_name',	
 			real_name = '$real_name',	
 			user_pass = '$user_pass',	
 			mobile = '$mobile',	
 			address = '$address',		
 			user_email = '$user_email'
		WHERE user_id = $user_id ";
// echo $sql;
$Usql = mysqli_query($conn, $sql);

if($Usql){
    echo "Data successfully updated";
}else{
    echo "Failed to update data";
}
