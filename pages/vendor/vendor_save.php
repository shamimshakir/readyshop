<?php

include('../header.php');

extract($_REQUEST);

if ($mode == 1) {
     $sql="INSERT INTO
             tbl_vendor(
                vendor_name,
                company_name,
                phone,
                email,
                user_regdate,
                address,
                status) 
            VALUES(
                '$vendor_name',
                '$company_name',
                '$phone',
                '$email',
                '$user_regdate',
                '$address',
                '$status')";
    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully Added";
    }else{
        echo "Failed to add data";
    }
} else if ($mode == 2){
    $sql = mysqli_query($conn, "UPDATE  tbl_vendor 
            SET 
                vendor_name = '$vendor_name',
                company_name = '$company_name',
                phone = '$phone',
                email = '$email',
                user_regdate = '$user_regdate',
                address  = '$address',
                status='$status'
            WHERE vendor_id  = '$vendor_id' ");

    if($sql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>