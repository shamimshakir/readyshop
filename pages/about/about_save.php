<?php
include('../header.php');
$mode = $_POST['mode'];
$about_id = $_POST['about_id'];

$description = $_POST['description'];
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
$path = $folfer_loc.'about_us/';

$img = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];
$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
$final_image = rand(1000,1000000).$img;

$imageName = strtolower($final_image);
$path = $path.$imageName;
if ($mode == 2){
    if(in_array($ext, $valid_extensions)) {

        if(move_uploaded_file($tmp,$path)){
            $rmvSql = mysqli_query($conn, "SELECT au_image FROM tbl_about_us WHERE id = '$about_id'");
            $image=mysqli_fetch_array($rmvSql);
            unlink('../../uploads/about_us/'.$image['au_image']);
            $query="UPDATE tbl_about_us 
                        SET     
                            au_description = '$description',                          
                            au_image = '$imageName'              
                        WHERE id  = $about_id ";
            $sql = mysqli_query($conn,$query );
            if($sql){
                echo "Data successfully updated";
            }else{
                echo "Failed to update data";
            }
        }
        else{
            $query="UPDATE tbl_about_us 
                SET     
                    au_description = '$description'
                WHERE id  = $about_id ";
            $sql = mysqli_query($conn,$query );
            if($sql){
                echo "Data successfully updated";
            }else{
                echo "Failed to update data";
            }
        }
    }
    else{
        $query="UPDATE tbl_about_us 
                SET     
                    au_description = '$description'
                WHERE id  = $about_id ";
        $sql = mysqli_query($conn,$query );
        if($sql){
            echo "Data successfully updated";
        }else{
            echo "Failed to update data";
        }
    }
}
?>