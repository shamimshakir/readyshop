<?php
include( '../header.php' );

$mode = $_POST['mode'];
$adv_id = $_POST['adv_id'];
$comp_name = $_POST['comp_name'];
$business_type = $_POST['business_type'];
$comp_url = $_POST['comp_url'];
$comp_status = $_POST['comp_status'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$adv_position = $_POST['adv_position'];

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
$path = $folfer_loc.'adv/';

$img = $_FILES['comp_image']['name'];
$tmp = $_FILES['comp_image']['tmp_name'];
$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
$final_image = rand(1000,1000000).$img;
$imageName = strtolower($final_image);
$path = $path.$imageName;

if ($mode == 1) {
    if(in_array($ext, $valid_extensions)) {
        if(move_uploaded_file($tmp,$path)){
            $sql = "INSERT 
                INTO tbl_adv (
                    comp_name,
                    business_type,
                    comp_url,
                    comp_status,
                    comp_image,
                    start_date,
                    end_date,
                    adv_position
                ) 
                VALUES (
                    '$comp_name',
                    '$business_type',
                    '$comp_url',
                    '$comp_status',
                    '$imageName',
                    '$start_date',
                    '$end_date',
                    '$adv_position'
                )";
            $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
            if($runSql){
                echo "Data successfully added";
            }else{
                echo "Failed to add data";
            }
        }else{
            echo 'upload e somossan';
        }
    }else {
        $sql = "INSERT 
            INTO tbl_adv (
                comp_name,
                business_type,
                comp_url,
                comp_status,
                start_date,
                end_date,
                adv_position
            ) 
            VALUES (
                '$comp_name',
                '$business_type',
                '$comp_url',
                '$comp_status',
                '$start_date',
                '$end_date',
                '$adv_position'
            )";
        $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        if($runSql){
            echo "Data successfully added";
        }else{
            echo "Failed to add data";
        }
    }
}
else if ($mode == 2){
    $sql = mysqli_query($conn, "UPDATE tbl_adv 
                SET 	
                    comp_name = '$comp_name',							
                    business_type = '$business_type',							
                    comp_url = '$comp_url',		
                    comp_status = '$comp_status',			
                    start_date = '$start_date',				
                    end_date = '$end_date',				
                    adv_position = '$adv_position'				
                WHERE adv_id  = '$adv_id' ");

    if(in_array($ext, $valid_extensions)) {
        $rmvSql = mysqli_query($conn, "SELECT comp_image FROM tbl_adv WHERE adv_id = '$adv_id'");
        $image=mysqli_fetch_array($rmvSql);
        unlink('../../uploads/adv/'.$image['comp_image']);
        if(move_uploaded_file($tmp,$path)){
            $sql = mysqli_query($conn, "UPDATE tbl_adv 
                SET				
                    comp_image = '$imageName'						
                WHERE adv_id  = '$adv_id' ");
        }
    }

    if($sql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>