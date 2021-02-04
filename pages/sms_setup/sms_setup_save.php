<?php
	include "../../library/dbconnect.php";

	$id=$_REQUEST['id'];   
 	$name=$_REQUEST['name'];
	$sms_url=$_REQUEST['sms_url'];
	$submit_param=$_REQUEST['submit_param'];
	$type=$_REQUEST['SMTPAuth'];
 	$mode=$_POST['mode'];

 	if ($mode == 1) 
 	{
 		if(isset($name))
		{
			$Asql = mysqli_query($conn, "INSERT INTO tbl_sms_setup (name,sms_url,submit_param,type,status) VALUES ('".$name."','".$sms_url."','".$submit_param."','".$type."','1')");
			if($Asql)
			{
				echo "Data successfully added";
			}
			else
			{
				echo "Failed to add data";
			}
		} 
		else
		{
			echo "Error in adding data";
		}
 	}

 	else if ($mode == 2)
 	{
 		if(isset($name))
		{
			
						
			$Usql = mysqli_query($conn, "UPDATE tbl_sms_setup 
								SET name = '".$name."',
									sms_url ='".$sms_url."',
									submit_param ='".$submit_param."',
									type='".$type."'
								WHERE id  = '$id' ");
								
					
			if($Usql)
			{
				echo "Data successfully updated";
			} 
			else
			{
				echo "Failed to update data";
			}
		}
		else
		{
			echo "Error in updating data";
		}
 	}
?>