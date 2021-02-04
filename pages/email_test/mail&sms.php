<?php
include_once "../../library/dbconnect.php";
include_once "../../library/library.php";
include_once "../../library/email_function.php";
include_once "../../library/common_function.php";
include_once "../../../phpmailer/PHPMailerAutoload.php";
//print_r($_REQUEST);
$email       =  $_REQUEST['email'];
$clientname  =  '';
$subject     =  $_REQUEST['subject'];
$emailbody   =  $_REQUEST['emailbody'];
$email_id    =  $_REQUEST['email_id'];


echo SendMails($email, $clientname, $subject, $emailbody, $email_id);

?>