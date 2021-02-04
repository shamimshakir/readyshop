<?php
include_once "../../library/dbconnect.php";
include_once "../../library/library.php";
include "../../library/common_function.php";
include "../../library/sms_function.php";
$mobile = $_REQUEST['mobile'];
$smsbody    = $_REQUEST['smsbody'];
$api_id =$_REQUEST['api_id'];


if($api_id=='-1'){
	$api_id=1;
	}			
echo  SmsSendSystem($mobile, $smsbody,$api_id);
?>