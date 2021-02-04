<?php
include('../header.php');
$mode = $_POST['mode'];
$image_id = $_POST['image_id'];
$act_status = $_POST['act_status'];

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
$path = $folfer_loc.'slider_background/';

$img = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];
$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
$final_image = rand(1000,1000000).$img;

$imageName = strtolower($final_image);
$path = $path.$imageName;

if ($mode == 1) {
    if(in_array($ext, $valid_extensions)) {
        if(move_uploaded_file($tmp,$path)){
            $sql = "INSERT 
                INTO tbl_slider_background (
                    image,
                    active_status
                ) 
                VALUES (
                    '$imageName',
                    '$act_status'
                    
                )";

            $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
            if($runSql){
                echo "Data successfully added";
            }else{
                echo "Failed to add data";
            }
        }
    }else {
        $sql = "INSERT 
            INTO tbl_slider_background (
                act_status
            ) 
            VALUES (
                '$act_status'
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

    if(in_array($ext, $valid_extensions)) {

        if(move_uploaded_file($tmp,$path)){
            $rmvSql = mysqli_query($conn, "SELECT image FROM tbl_slider_background WHERE id = '$image_id'");
            $image=mysqli_fetch_array($rmvSql);
            unlink('../../uploads/slider_background/'.$image['image']);
            $query="UPDATE tbl_slider_background
                SET                 
                    active_status = '$act_status',                     
                    image = '$imageName'                
                WHERE id  = '$image_id' ";
            $sql = mysqli_query($conn,$query );
            if($sql){
                echo "Data successfully updated";
            }else{
                echo "Failed to update data";
            }
        }
        else{
            $query="UPDATE tbl_slider_background 
                SET               
                    active_status = '$act_status'                
                WHERE id  = '$image_id' ";
            $sql = mysqli_query($conn,$query );
            if($sql){
                echo "Data successfully updated";
            }else{
                echo "Failed to update data";
            }
        }
    }
    else{
        $query="UPDATE tbl_slider_background 
                SET                 
                    active_status = '$act_status'                
                WHERE id  = '$image_id' ";
        $sql = mysqli_query($conn,$query );
        if($sql){
            echo "Data successfully updated";
        }else{
            echo "Failed to update data";
        }
    }
}
?>