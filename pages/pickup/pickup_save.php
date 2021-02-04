<?php
include('../header.php');

$mode =                       $_REQUEST['mode'];
$loc_id =                   $_REQUEST['loc_id'];
$location =              $_REQUEST['location'];
$city =               $_REQUEST['city'];
$loc_status =              $_REQUEST['loc_status'];
$address =              $_REQUEST['address'];

// echo '<pre>';
// print_r($_REQUEST);
// echo '</pre>';

if ($mode == 1) {
    $sql = "INSERT 
            INTO tbl_pickup_location (
                location,
                city,
                loc_status,
                address
            ) 
            VALUES (
                '$location',
                '$city',
                '$loc_status',
                '$address'
            )";
    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}else if ($mode == 2){
    $sql = mysqli_query($conn, "UPDATE tbl_pickup_location 
            SET 	
                location = '$location',							
                city = '$city',							
                loc_status = '$loc_status',					
                address = '$address'						
            WHERE loc_id  = '$loc_id' ");
    if($sql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>