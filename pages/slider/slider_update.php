<?php
include('../header.php');

$slider_title = $_REQUEST['slider_title'];
$act_status = $_REQUEST['act_status'];
$p_slider_id = $_REQUEST['p_slider_id'];
$main_text = $_REQUEST['main_text'];
$alt_text = $_REQUEST['alt_text'];
$slide_id = $_REQUEST['slide_id'];
$url = $_REQUEST['url'];


$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
$path = $folfer_loc.'slider/';

$img = $_FILES['bg_img']['name'];
$tmp = $_FILES['bg_img']['tmp_name'];
$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
$final_image = rand(1000,1000000).$img;

$imageName = strtolower($final_image);
$path = $path.$imageName;

if(in_array($ext, $valid_extensions)) {
    if(move_uploaded_file($tmp,$path)){

        $sql = "UPDATE tbl_slider_images SET 
            title_text = '$slider_title',
            main_text = '$main_text',
            alt_text = '$alt_text',
            slider_id = '$p_slider_id',
            act_status = '$act_status',
            url='$url',
            bg_img = '$imageName' 
			WHERE  id  = '$slide_id'";

        $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        if($runSql){
            echo "Data successfully update";
        }
		else{
            echo "Failed to update data";
        }
    }
}else {
    $sql = "UPDATE tbl_slider_images SET 
            title_text = '$slider_title',
            main_text = '$main_text',
            alt_text = '$alt_text',
            slider_id = '$p_slider_id',
            url='$url',
            act_status = '$act_status' WHERE  id  = '$slide_id'";

    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}
