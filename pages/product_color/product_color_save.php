<?php
include('../header.php');

extract($_REQUEST);

if ($mode == 1) {
    $sql="INSERT INTO
             tbl_color(
                color_name,
                color_status
            ) 
            VALUES(
                '$color_name',
                '$color_status'
            )";
    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully Added";
    }else{
        echo "Failed to add data";
    }
} else if ($mode == 2){
    $sql = mysqli_query($conn, "UPDATE  tbl_color 
            SET 
                color_name = '$color_name',
                color_status = '$color_status'						
            WHERE color_id  = '$color_id' ");

    if($sql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>