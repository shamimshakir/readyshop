<?php
include( '../header.php' );
$mode = $_POST['mode'];
$id = $_POST['id'];
$meta_page = $_POST['meta_page'];
$meta_name = $_POST['meta_name'];
$meta_content = $_POST['meta_content'];
$meta_type = $_POST['meta_type'];
$status = $_POST['status'];

if ($mode == 1) {
        $sql = "INSERT 
            INTO meta_tags (
                meta_page,
                meta_name,
                meta_content,
                meta_type,
                status
            ) 
            VALUES (
                '$meta_page',
                '$meta_name',
                '$meta_content',
                '$meta_type',
                '$status'
            )";
        $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        if($runSql){
            echo "Data successfully added";
        }else{
            echo "Failed to add data";
        }
}
else if ($mode == 2){
        $query="UPDATE meta_tags 
                SET     
                    meta_page = '$meta_page',  
                    meta_name = '$meta_name',  
                    meta_content = '$meta_content',   
                    meta_type = '$meta_type',  
                    status = '$status'                
                WHERE id  = '$id' ";
        $sql = mysqli_query($conn,$query );
        if($sql){
            echo "Data successfully updated";
        }else{
            echo "Failed to update data";
        }
}
?>
