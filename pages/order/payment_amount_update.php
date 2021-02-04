<?php
include('../header.php');

extract($_REQUEST);
// $date = date('Y-m-d H:i:s');
// print_r($_REQUEST);
// exit();

$sql = mysqli_query($conn, "UPDATE tbl_order SET payment_status  = '$payment_status', od_payment_date = '$od_payment_date', od_payment_update_by='$od_payment_update_by'  WHERE od_id  = '$od_id' ");

if($sql){
    echo "Data successfully updated";
}else{
    echo "Failed to update data";
}