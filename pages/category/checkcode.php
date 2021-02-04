<?php
//session_start();
include '../../Library/dbconnect.php';
if(isset($_POST['cate_code']))
{
	$cate_code=$_REQUEST['cate_code'];
	$sql="SELECT count(`cat_id`) as num FROM `tbl_category` WHERE cate_code = '".$cate_code."'";
	$res = mysqli_query($conn,$sql);	
	while($rowquery=mysqli_fetch_array($res))
 		{
 			extract($rowquery);
 		}
	if($num <= 0)
	{
		echo " <span style=\"color:green\">Available For Use</span>";
		echo '<input type="hidden" value="1" name="code_status">';
	}
	else
	{
	echo " <span style=\"color:rgba(255,0,4,1.00)\">Code Already Used</span>";
	echo '<input type="hidden" value="2" name="code_status">';
	}
	exit();
}
?>

