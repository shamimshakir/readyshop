<?php
include('../header.php');

extract($_REQUEST);
echo "UPDATE tbl_order SET od_payment_amount  = '$od_payment_amount', od_payment_date = 'now()'  WHERE od_id  = '$od_id'";
$sql = mysqli_query($conn, "UPDATE tbl_order SET od_payment_amount  = '$od_payment_amount', od_payment_date = 'now()'  WHERE od_id  = '$od_id' ");

if($sql){
    echo "Data successfully updated";
}else{
    echo "Failed to update data";
}