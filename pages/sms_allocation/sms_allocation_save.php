<?php
include( '../header.php' );


$id = $_POST[ 'id' ];
$amount = $_POST[ 'amount' ];

$mode = $_POST[ 'mode' ];

if ( $mode == 1 ) {
  if ( isset( $amount ) ) {
    $Asql = mysqli_query( $conn, "INSERT
									INTO
									  `tbl_sms_allocation_details`(											   
										`name`,
										`allocate_ammount`,
										`allocation_date`
									  )
									VALUES(
									  '1',
									  '" . $amount . "',
									 NOW())" );
$hasdata=pick('tbl_sms_allocation','count(current_ammount)','id=1');
	  if($hasdata>0){
mysqli_query( $conn, "UPDATE 
						 `tbl_sms_allocation`
						SET
						  `current_ammount` = current_ammount+$amount,
						  `allocate_ammount` = allocate_ammount+$amount,
						  `allocation_date` = NOW(),
						  `total` = total+$amount
						WHERE id=1" );
	  }else{
		  mysqli_query($conn,"INSERT INTO `tbl_sms_allocation`( 
						`name`, 
						`current_ammount`, 
						`allocate_ammount`, 
						`allocation_date`,
						`total`
					) 
					VALUES 
						(		
							'".$subdomain."',
							'".$amount."',
							'".$amount."',
							NOW(),
							'".$amount."'
						)");
	  }

    if ( $Asql ) {
      echo "Data successfully added";
    } else {
      echo "Failed to add data";
    }
  } else {
    echo "Error in adding data";
  }
}