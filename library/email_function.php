<?php
function SendMails($clientemailaddress, $clientname, $subject, $body, $email_id=NULL )
{
	if (NULL === $email_id) {
        $email_id = 1;
    }
	if($email_id!=''){
		$condition=" and id='$email_id'";
	}
	
	global $conn;
	session_start();
	$SUser_ID=$_SESSION['SUserID'];	
	
	$SeNTlist = "SELECT name,`port`, `Username`, `Password`, `setFrom`, `SMTPAuth`, `Host`, `SMTPSecure`, `addReplyTo`, `addCC`, `addBCC`, `isHTML`, `Mailer` FROM `tbl_emailsetup` WHERE  status=1 ";
	$ExSeNTlist = mysqli_query($conn,$SeNTlist) or die(mysqli_error($conn));
	while ($rowNewsTl = mysqli_fetch_array($ExSeNTlist)) {
			extract($rowNewsTl);
	}
    $mail = new PHPMailer;
    $mail->SMTPDebug = false;                               // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = '' . $Host . ''; // Specify main and backup SMTP servers
	if($SMTPAuth!=''){
    if ($SMTPAuth == 'true') {
        $mail->SMTPAuth   = '' . $SMTPAuth . ''; // Enable SMTP authentication
        $mail->Username   = '' . $Username . ''; // SMTP username
        $mail->Password   = '' . $Password . ''; // SMTP password
        $mail->SMTPSecure = '' . $SMTPSecure . ''; // Enable TLS encryption, `ssl` also accepted
    }
	}
    $mail->Port = '' . $port . ''; // TCP port to connect to
    $mail->setFrom('' . $setFrom . '','' . $name . '');
    $mail->addAddress('' . $clientemailaddress . '', '' . $clientname . ''); // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('' . $addReplyTo . '');
	if($addCC!=''){
    $mail->addCC('' . $addCC . '');
	}
	/*if($addBCC!=''){
    $mail->addBCC('' . $addBCC . '');
	}*/
    //$mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
    $mail->isHTML($isHTML); // Set email format to HTML
    $mail->Subject = "" . $subject . "";
    $mail->MsgHTML("" . $body . "");
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if (!$mail->send()) {
		$Asql = mysqli_query($conn, "INSERT INTO `tbl_email_log`(`email`, `email_body`, `return_message`, `from_email`, `snder_id`, `email_status`, `date_time`)VALUES ('" . $clientemailaddress ." ". $clientname . "','".$body."','".$mail->ErrorInfo."','".$email_id."','".$SUser_ID."','false',NOW())");
        return false;
	   //echo $mail->ErrorInfo;
    } 
	else {
		$Asql = mysqli_query($conn, "INSERT INTO `tbl_email_log`(`email`, `email_body`, `return_message`, `from_email`, `snder_id`, `email_status`, `date_time`)VALUES ('" . $clientemailaddress ." ". $clientname . "','".$body."','".$mail->ErrorInfo."','".$email_id."','".$SUser_ID."','true',NOW())");
       return true;
		//return date('j-m-Y H:i:s').' Email- '.$clientemailaddress.'->'.$clientname.'->'.$body.'|';
    }
}
 


?>