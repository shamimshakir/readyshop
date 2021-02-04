<?php
include('../header.php');
$mode = $_POST['mode'];
$id = $_POST['id'];
$sc_name = $_POST['sc_name'];
$sc_email = $_POST['sc_email'];
$sc_address = $_POST['sc_address'];
$sc_phone = $_POST['sc_phone'];
$url=$_POST['url'];
$act_status = $_POST['act_status'];

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
$path = '../../uploads/shop_setup/';

$logo = $_FILES['sc_logo']['name'];
$tmplogo = $_FILES['sc_logo']['tmp_name'];
$ext = strtolower(pathinfo($logo, PATHINFO_EXTENSION));
$final_logo = rand(1000,1000000).$logo;

$imageName = strtolower($final_logo);
$path = $path.$imageName;

$favicon = $_FILES['favicon']['name'];
$tmp = $_FILES['favicon']['tmp_name'];
$ext = strtolower(pathinfo($favicon, PATHINFO_EXTENSION));
$final_favicon = rand(1000,1000000).$favicon;

$faviconName = strtolower($final_favicon);
$path2 = $path.$faviconName;

if ($mode == 1) {
    if(in_array($ext, $valid_extensions)) {
        if(move_uploaded_file($tmplogo,$path) || move_uploaded_file($tmp,$path2)){
            $sql = "INSERT 
                INTO tbl_shop_config (
                    sc_name,
                    sc_address,
                    sc_phone,
                    sc_email,
                    sc_logo,
                    url,
                    favicon,
                    active_status
                    
                ) 
                VALUES (
                    '$sc_name',
                    '$sc_address',
                    '$sc_phone',
                    '$sc_email',
                    '$imageName',
                    '$faviconName',
                    '$act_status'
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
                INTO tbl_shop_config (
                    sc_name,
                    sc_address,
                    sc_phone,
                    sc_email,
                    url,
                    active_status
                    
                ) 
                VALUES (
                    '$sc_name',
                    '$sc_address',
                    '$sc_phone',
                    '$sc_email',
                    '$act_status'
                )
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

        if(move_uploaded_file($tmp,$path) || move_uploaded_file($tmp,$path2)){
            $rmvSql = mysqli_query($conn, "SELECT sc_logo,favicon FROM tbl_shop_config WHERE id = '$id'");
            $image=mysqli_fetch_array($rmvSql);
            // if(!empty($logo))
            // {
            //     unlink('../../uploads/shop_setup/'.$image['sc_logo']);
            // }
            // if(!empty($favicon))
            // {
            //     unlink('../../uploads/shop_setup/'.$image['favicon']);
            // }
            $query="UPDATE tbl_shop_config 
                        SET     
                            sc_name = '$sc_name',                           
                            sc_address= '$sc_address',         
                            sc_phone = '$sc_phone',
                            sc_email='$sc_email',
                            sc_logo='$imageName',
                            url='$url',
                            favicon='$faviconName',
                            active_status='$act_status'
                        WHERE id  = '$id' ";
            $sql = mysqli_query($conn,$query );
            if($sql){
                echo "Data successfully updated";
            }else{
                echo "Failed to update data";
            }
        }
        else{
            $query="UPDATE tbl_shop_config 
                        SET     
                            sc_name = '$sc_name',                           
                            sc_address= '$sc_address',         
                            sc_phone = '$sc_phone',
                            sc_email='$sc_email',
                            url='$url',
                            active_status='$act_status'
                        WHERE id  = '$id'  ";
            $sql = mysqli_query($conn,$query );
            if($sql){
                echo "Data successfully updated";
            }else{
                echo "Failed to update data";
            }
        }
    }
    else{
        $query="UPDATE tbl_shop_config 
                        SET     
                            sc_name = '$sc_name',                           
                            sc_address= '$sc_address',         
                            sc_phone = '$sc_phone',
                            sc_email='$sc_email',
                            url='$url',
                            active_status='$act_status'
                        WHERE id  = '$id'  ";
        $sql = mysqli_query($conn,$query );
        if($sql){
            echo "Data successfully updated";
        }else{
            echo "Failed to update data";
        }
    }
}
?>