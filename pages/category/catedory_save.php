<?php
include('../header.php');
$mode = $_POST['mode'];
$cat_id = $_POST['cat_id'];

$cat_name = $_POST['cat_name'];
$catagory_code = $_POST['catagory_code'];
$level_id = $_POST['level_id'];
$cat_parent_id = $_POST['cat_parent_id'];
$act_status = $_POST['act_status'];
$cat_name = $_POST['cat_name'];


if ($mode == 2){
    
         $query="UPDATE 
					`tbl_category` 
				SET 
					`cat_parent_id` = '$cat_parent_id', 
					`cat_name` = '$cat_name', 
					`cat_description` = '$cat_name', 
					`level_id` = '$level_id', 
					`act_status` = '$act_status', 
					`catagory_code` = '$catagory_code'
				WHERE 
					`cat_id` = '$cat_id'";  
	$sql = mysqli_query($conn,$query );
            if($sql){
                echo "Data successfully Update";
            }else{
                echo "Failed to Update data";
            }
       
    }
    else{
        $query="INSERT INTO `tbl_category`(
						`cat_parent_id`, 
						`cat_name`, 
						`cat_description`, 						
						`level_id`, 
						`act_status`,
						`catagory_code`
					) 
					VALUES 
						(
							'$cat_parent_id', 
							'$cat_name', 
							'$cat_name',
							'$level_id', 
							'$act_status',
							'$catagory_code'
						)";
            $sql = mysqli_query($conn,$query );
            if($sql){
                echo "Data successfully Add";
            }else{
                echo "Failed to Add data";
            }
    }

?>