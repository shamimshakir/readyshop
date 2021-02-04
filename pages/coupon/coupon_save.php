<?php
include('../header.php');

$id =                       $_REQUEST['id'];
$mode =                       $_REQUEST['mode'];
$code =                   $_REQUEST['code'];
$value =              $_REQUEST['value'];
$multiple =              $_REQUEST['multiple'];
$start_date = date('Y-m-d', strtotime($_REQUEST['start_date']));
$end_date = date('Y-m-d', strtotime($_REQUEST['end_date']));
$active =              $_REQUEST['active'];
$description =              $_REQUEST['description'];

if ($mode == 1) {
    $sql = "INSERT 
                INTO coupons (
                    code,
                    description,
                    active,
                    value,
                    multiple,
                    start_date,
                    end_date
                    ) 
                VALUES (
                    '$code',
                    '$description',
                    '$active',
                    '$value',
                    '$multiple',
                    '$start_date',
                    '$end_date'
                    )";
    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}else if ($mode == 2){
    $sql = mysqli_query($conn, "UPDATE coupons 
            SET 	
            code = '$code',
            description = '$description',
            active = '$active',
            value = '$value',
            multiple = '$multiple',
            start_date = '$start_date',
            end_date = '$end_date'					
            WHERE id  = '$id' ");
    if($sql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>