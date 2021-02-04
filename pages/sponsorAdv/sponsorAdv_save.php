<?php
include('../header.php');
$mode = $_POST['mode'];
$sponsor_id = $_POST['sponsor_id'];
$name = $_POST['name'];
$link=$_POST['link'];
$act_status = $_POST['act_status'];

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
$path = $folfer_loc.'sponsors_ad/';

$img = $_FILES['logo']['name'];
$tmp = $_FILES['logo']['tmp_name'];
$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
$final_image = rand(1000,1000000).$img;

$imageName = strtolower($final_image);
$path = $path.$imageName;
if ($mode == 1) {
    if(in_array($ext, $valid_extensions)) {
        if(move_uploaded_file($tmp,$path)){
            $sql = "INSERT 
                INTO tbl_sponsors_ad (
                    name,
                    link,
                    act_status,
                    logo
                ) 
                VALUES (
                    '$name',
                    '$link',
                    '$act_status',
                    '$imageName'
                )";

            $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
            if($runSql){
                echo "Data successfully added";
            }else{
                echo "Failed to add data";
            }
        }
        else
        {
            echo "ERROR";
        }
    }else {
        $sql = "INSERT 
                INTO tbl_sponsors_ad (
                    name,
                    link,
                    act_status
                ) 
                VALUES (
                    '$name',
                    '$link',
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
            $rmvSql = mysqli_query($conn, "SELECT logo FROM tbl_sponsors_ad WHERE id = '$sponsor_id'");
            $image=mysqli_fetch_array($rmvSql);
            unlink($folfer_loc.'sponsors_ad/'.$image['logo']);
            $query="UPDATE tbl_sponsors_ad 
                        SET     
                            name = '$name',                           
                            link= '$link',         
                            logo = '$imageName',
                            act_status='$act_status'                  
                        WHERE id  = '$sponsor_id' ";
            $sql = mysqli_query($conn,$query );
            if($sql){
                echo "Data successfully updated";
            }else{
                echo "Failed to update data";
            }
        }
        else{
            $query="UPDATE tbl_sponsors_ad 
                SET     
                    name = '$name',                           
                    link= '$link',
                    act_status='$act_status'                  
                WHERE id  = '$sponsor_id' ";
            $sql = mysqli_query($conn,$query );
            if($sql){
                echo "Data successfully updated";
            }else{
                echo "Failed to update data";
            }
        }
    }
    else{
        $query="UPDATE tbl_sponsors_ad 
                SET     
                    name = '$name',                           
                    link= '$link',
                    act_status='$act_status'                  
                WHERE id  = '$sponsor_id' ";
        $sql = mysqli_query($conn,$query );
        if($sql){
            echo "Data successfully updated";
        }else{
            echo "Failed to update data";
        }
    }
}
?>