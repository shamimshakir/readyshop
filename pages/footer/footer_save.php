<?php
include('../header.php');
$mode = $_POST['mode'];
$footer_id = $_POST['footer_id'];
$address= $_POST['address'];
$phone= $_POST['phone'];
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
$path = '../../uploads/footer/';

$img = $_FILES['logo']['name'];
$tmp = $_FILES['logo']['tmp_name'];
$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
$final_image = rand(1000,1000000).$img;

$imageName = strtolower($final_image);
$path = $path.$imageName;

if ($mode == 2){
    if(in_array($ext, $valid_extensions)) {

        if(move_uploaded_file($tmp,$path)){
            $rmvSql = mysqli_query($conn, "SELECT au_image FROM tbl_about_us WHERE id = '$about_id'");
            $image=mysqli_fetch_array($rmvSql);
            unlink('../../uploads/footer/'.$image['footer_logo']);
            $query="UPDATE tbl_footer 
                        SET     
                            footer_phone = '$phone',
                            footer_contact='$address',                          
                            footer_logo = '$imageName'              
                        WHERE id  = $footer_id ";
            $sql = mysqli_query($conn,$query );
            if($sql){
                echo "Data successfully updated";
            }else{
                echo "Failed to update data";
            }
        }
        else{
            $query="UPDATE tbl_footer 
                        SET     
                            footer_phone = '$phone',
                            footer_contact='$address'            
                        WHERE id  = $footer_id";
            $sql = mysqli_query($conn,$query );
            if($sql){
                echo "Data successfully updated";
            }else{
                echo "Failed to update data";
            }
        }
    }
    else{
        $query="UPDATE tbl_footer 
                        SET     
                            footer_phone = '$phone',
                            footer_contact='$address'              
                        WHERE id  = $footer_id ";
        $sql = mysqli_query($conn,$query );
        if($sql){
            echo "Data successfully updated";
        }else{
            echo "Failed to update data";
        }
    }
}
?>