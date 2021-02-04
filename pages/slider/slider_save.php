<?php

include('../header.php');

$slider_title = $_POST['slider_title'];
$slider_id = $_POST['p_slider_id'];
$main_text = $_POST['main_text'];
$alt_text = $_POST['alt_text'];
$act_status=$_POST['act_status'];
$url=$_POST['url'];

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
$path =$folfer_loc.'/slider/';

$img = $_FILES['bg_img']['name'];
$tmp = $_FILES['bg_img']['tmp_name'];
$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
$final_image = rand(1000,1000000).$img;

$imageName = strtolower($final_image);
$path = $path.$imageName;

if(in_array($ext, $valid_extensions)) {
    if(move_uploaded_file($tmp,$path)){
        $sql = "INSERT 
            INTO tbl_slider_images (
                title_text,
                main_text,
                alt_text,
                slider_id,
                act_status,
                bg_img,
                url
            ) 
            VALUES (
                '$slider_title',
                '$main_text',
                '$alt_text',
                '$slider_id',
                '$act_status',
                '$imageName',
                '$url'
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
        INTO tbl_slider_images (
            title_text,
            main_text,
            alt_text,
            slider_id,
            act_status,
            url
        ) 
        VALUES (
            '$slider_title',
            '$main_text',
            '$alt_text',
            '$slider_id',
            '$act_status',
            '$url'
        )";
    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}

?>