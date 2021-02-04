<?php
function SmsSendSystem($mobile, $smsbody, $sms_id=NULL) {
	
	$usein=pick("tbl_parameter","parameter_status","parameter_name='nextech_sms'");
	$has=pick("tbl_sms_allocation","current_ammount","id=1");
	$lengths=strlen($smsbody)/60;
	if($usein==1){
	if($has<$lengths){
		die;
		}
	 }
	if (NULL === $sms_id) {
        $sms_id = 1;
    }
	session_start();
	$SUser_ID=$_SESSION['SUserID'];	
	global $conn;
	 $SeNTlist = "SELECT
					  `id`,
					  `name`,
					  `sms_url`,
					  `submit_param`,
					  `return_param`,
					  `return_value_type`,
					  type
					FROM
					  `tbl_sms_setup`
					WHERE id=".$sms_id."";
$ExSeNTlist = mysqli_query($conn,$SeNTlist) or die(mysqli_error($conn));
$data=array();
while ($rowNewsTl = mysqli_fetch_array($ExSeNTlist)) {
    extract($rowNewsTl);
	$url=$sms_url;	
	$values=explode(',',$submit_param);
	foreach($values as $value){
	$nval=explode('=',$value);
	 $nval[0].'=>'.$nval[1];
	 array_push($data[$nval[0]]=$nval[1]);
		}
}
  if ($mobile != "") {
		$url=$url;
		$fields =$data;
		if($type=='get'){
		foreach($fields as $key=>$value) {
		 $fields_string .= $key.'='.$value.'&'; 
		 }
		 $fields_string=rtrim($fields_string, '&');
		 $furl=$url.'?'.$fields_string;
		 $smsbody = preg_replace( "/\r|\n/", "",convert_text($smsbody));
		$furl=bind_to_template(array('mobile'=>$mobile,'smsbody'=>$smsbody), $furl);
		
		$ch =curl_init($furl);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result=curl_exec($ch);
		if($result === false)
		{
		   //return 'Curl error: ' . curl_error($ch);
		   $return_val=serialize($result);
		   $Asql = mysqli_query($conn, "INSERT INTO tbl_sms_log (`number`, `sms_body`, `return_message`, `from_api`, `snder_id`, sms_status, date_time) VALUES ('".$mobile."','".$smsbody."','".$return_val."','".$sms_id."','".$SUser_ID."','false',NOW())");
		  return false;
		}
		else
		{
		  // return 'Operation completed without any errors';
		  $return_val=serialize($result);
		   $Asql = mysqli_query($conn, "INSERT INTO tbl_sms_log (`number`, `sms_body`, `return_message`, `from_api`, `snder_id`, sms_status, date_time) VALUES ('".$mobile."','".$smsbody.$furl."','".$return_val."','".$sms_id."','".$SUser_ID."','true',NOW())");
		   
		   
		   ///If use internal Api 
		   if($usein==1){
		   $xml = simplexml_load_string($result, "SimpleXMLElement", LIBXML_NOCDATA);
			$json = json_encode($xml);
			$array = json_decode($json,TRUE);
			foreach ($array as $value) {
			$MessageId =$value['MessageId'];
			$Status =$value['Status'];
			$StatusText =$value['StatusText'];
			$ErrorCode =$value['ErrorCode'];
			$ErrorText =$value['ErrorText'];
			$SMSCount =$value['SMSCount'];
			$CurrentCredit =$value['CurrentCredit'];
			}
			if($StatusText=='success'){
				$Usql = "UPDATE
						  `tbl_sms_allocation`
						SET
						  `current_ammount` =current_ammount-$SMSCount
						WHERE
						  `id` = '1'";
				mysqli_query($conn,$Usql) or die(mysqli_error($conn));
			}
		   }
		   
		   
		  return true;
		}
		//close connection
		curl_close($ch);
		}
		elseif($type=='post'){
		$fields=bind_to_template(array('mobile'=>$mobile,'smsbody'=>$smsbody), $fields);
		$payload = json_encode($fields);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		
		
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($payload))
		);
        //Execute CURL
		$result = curl_exec($ch);
		
		if ($result === false) {
		   $return_val=serialize($result);
		   $Asql = mysqli_query($conn, "INSERT INTO tbl_sms_log (`number`, `sms_body`, `return_message`, `from_api`, `snder_id`, sms_status, date_time) VALUES ('".$mobile."','".$smsbody."','".$return_val."','".$sms_id."','".$SUser_ID."','false',NOW())");
		   return false;
			return 'Curl error: ' . curl_error($ch);
		} 
		else {
		   $return_val=serialize($result);
		   $Asql = mysqli_query($conn, "INSERT INTO tbl_sms_log (`number`, `sms_body`, `return_message`, `from_api`, `snder_id`, sms_status, date_time) VALUES ('".$mobile."','".$smsbody."','".$return_val."','".$sms_id."','".$SUser_ID."','true',NOW())");
		   
		   
		    ///If use internal Api 
		   if($usein==1){
		    $xml = simplexml_load_string($result, "SimpleXMLElement", LIBXML_NOCDATA);
			$json = json_encode($xml);
			$array = json_decode($json,TRUE);
			foreach ($array as $value) {
			$MessageId =$value['MessageId'];
			$Status =$value['Status'];
			$StatusText =$value['StatusText'];
			$ErrorCode =$value['ErrorCode'];
			$ErrorText =$value['ErrorText'];
			$SMSCount =$value['SMSCount'];
			$CurrentCredit =$value['CurrentCredit'];
			}
			if($StatusText=='success'){
				$Usql = "UPDATE
						  `tbl_sms_allocation`
						SET
						  `current_ammount` =current_ammount-$SMSCount
						WHERE
						  `id` = '1'";
				mysqli_query($conn,$Usql) or die(mysqli_error($conn));
			}
		   }
		   
		   
		   
		   return true;
		   //return 'Operation completed without any errors';							
		}
		curl_close($ch);	
	}
        }
}
?>

