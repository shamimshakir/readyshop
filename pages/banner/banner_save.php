<?php
include( '../header.php' );
$mode = $_POST['mode'];
$banner_image_id = $_POST['banner_image_id'];
$title = $_POST['title'];
$comp_url = $_POST['comp_url'];
$comp_name = $_POST['comp_name'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$act_status = $_POST['act_status'];

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
$path = $folfer_loc.'banner/';

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
                INTO tbl_banner (
                    title,
                    comp_url,
                    comp_name,
                    start_date,
                    end_date,
                    image,
                    active_status
                ) 
                VALUES (
                    '$title',
                    '$comp_url',
                    '$comp_name',
                    '$start_date',
                    '$end_date',
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
            INTO tbl_banner (
                title,
                comp_url,
                comp_name,
                start_date,
                end_date,
                act_status
            ) 
            VALUES (
                '$title',
                '$comp_url',
                '$comp_name',
                '$start_date',
                '$end_date',
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
            $rmvSql = mysqli_query($conn, "SELECT image FROM tbl_banner WHERE id = '$banner_image_id'");
            $image=mysqli_fetch_array($rmvSql);
            unlink('../../uploads/banner/'.$image['image']);
            $query="UPDATE tbl_banner
                SET     
                    title = '$title',  
                    comp_url = '$comp_url',
                    comp_name = '$comp_name',
                    start_date = '$start_date',
                    end_date = '$end_date',
                    active_status = '$act_status',                     
                    image = '$imageName'                
                WHERE id  = '$banner_image_id' ";
            $sql = mysqli_query($conn,$query );
            if($sql){
                echo "Data successfully updated";
            }else{
                echo "Failed to update data";
            }
        }
        else{
            $query="UPDATE tbl_banner 
                SET     
                    title = '$title',  
                    comp_url = '$comp_url',  
                    comp_name = '$comp_name',  
                    start_date = '$start_date',  
                    end_date = '$end_date',  
                    comp_url = '',
                    active_status = '$act_status'                
                WHERE id  = '$banner_image_id' ";
            $sql = mysqli_query($conn,$query );
            if($sql){
                echo "Data successfully updated";
            }else{
                echo "Failed to update data";
            }
        }
    }
    else{
        $query="UPDATE tbl_banner 
                SET     
                    title = '$title',  
                    comp_url = '$comp_url',  
                    comp_name = '$comp_name',  
                    start_date = '$start_date',  
                    end_date = '$end_date',  
                    active_status = '$act_status'                
                WHERE id  = '$banner_image_id' ";
        $sql = mysqli_query($conn,$query );
        if($sql){
            echo "Data successfully updated";
        }else{
            echo "Failed to update data";
        }
    }
}
?>