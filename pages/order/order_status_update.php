<?php
session_start();
include "../../library/dbconnect.php";
include "../../library/library.php";
include "../../library/common_function.php";
include "../../library/sms_function.php";
extract( $_REQUEST );


$clid = pick( 'tbl_order', 'cl_id', "od_id = '$od_id'" );
$order_id = pick( 'tbl_order', 'od_no', "od_id = '$od_id'" );
$clients_name = pick( 'tbl_customer', 'firstname', "cl_id = '$clid'" );
$mobile = pick( 'tbl_customer', 'phone', "cl_id = '$clid'" );
$row = array( 'clients_name' => $clients_name, 'order_id' => $order_id, );
if ( $od_status == '2' ) {
  $smsstatus = pick( 'tbl_sms_template', 'status', " command='ready'" );
  if ( $smsstatus > 0 ) {
    $smsbody = pick( 'tbl_sms_template', 'description', " command='ready'" );
    $api_id = 1;
    $smsbody = bind_to_template( $row, $smsbody );
    if ( $mobile != "" ) {
      SmsSendSystem( $mobile, $smsbody, $api_id );
    }
  }
}
if ( $od_status == '3' ) {
  $sql = "UPDATE tbl_order SET 
						od_status  = '$od_status', 
						status_change_comment = '$status_change_comment', 
						od_last_update = NOW(), 
						ship_date = NOW() 
						WHERE od_id  = '$od_id' ";
  $smsstatus = pick( 'tbl_sms_template', 'status', " command='shipped'" );
  if ( $smsstatus > 0 ) {
    $smsbody = pick( 'tbl_sms_template', 'description', " command='shipped'" );
    $api_id = 1;
    $smsbody = bind_to_template( $row, $smsbody );
    if ( $mobile != "" ) {
      SmsSendSystem( $mobile, $smsbody, $api_id );
    }
  }
} elseif ( $od_status == '4' ) {
  $sql = "UPDATE tbl_order SET od_status  = '$od_status', status_change_comment = '$status_change_comment', od_last_update = NOW(), od_delivary_date = NOW() WHERE od_id  = '$od_id' ";
	 $smsstatus = pick( 'tbl_sms_template', 'status', " command='delivered'" );
  if ( $smsstatus > 0 ) {
    $smsbody = pick( 'tbl_sms_template', 'description', " command='delivered'" );
    $api_id = 1;
    $smsbody = bind_to_template( $row, $smsbody );
    if ( $mobile != "" ) {
      SmsSendSystem( $mobile, $smsbody, $api_id );
    }
  }
} else {
  $sql = "UPDATE tbl_order SET od_status  = '$od_status', status_change_comment = '$status_change_comment', od_last_update = NOW() WHERE od_id  = '$od_id' ";
}
$sql = mysqli_query( $conn, $sql );


mysqli_query( $conn, "INSERT INTO `tbl_order_history`(
				`od_id`, 
				`status`, 
				`comments`, 
				`update_by`, 
				`update_date`
			) 
			VALUES 
				(
					'$od_id', 
					'$od_status',
					'$status_change_comment' ,
					" . $_SESSION[ 'SUserID' ] . ", 
					NOW()
				)" );
if ( $sql ) {
  echo "Data successfully updated";
} else {
  echo "Failed to update data";
}