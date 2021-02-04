<?php
include( '../header.php' );

$mode = $_REQUEST[ 'mode' ];
$id = $_REQUEST[ 'id' ];
$name = $_REQUEST[ 'name' ];
$Username = $_REQUEST[ 'Username' ];
$Password = $_REQUEST[ 'Password' ];
$SMTPAuth = $_REQUEST[ 'SMTPAuth' ];
$Host = $_REQUEST[ 'Host' ];
$SMTPSecure = $_REQUEST[ 'SMTPSecure' ];
$setFrom = $_REQUEST[ 'setFrom' ];
$addReplyTo = $_REQUEST[ 'addReplyTo' ];
$addCC = $_REQUEST[ 'addCC' ];
$addBCC = $_REQUEST[ 'addBCC' ];
$isHTML = $_REQUEST[ 'isHTML' ];
$Mailer = $_REQUEST[ 'Mailer' ];
$port = $_REQUEST[ 'port' ];

if ( $mode == 1 ) {
  $sql = "INSERT INTO `tbl_crm_emailsetup`(
												`name`, 
												`port`, 
												`Username`,
												`Password`, 
												`setFrom`,
												`SMTPAuth`,
												`Host`,
												`SMTPSecure`, 
												`addReplyTo`, 
												`addCC`, 
												`addBCC`, 
												`isHTML`, 
												`Mailer`)
										VALUES(				 													'$name',
												'$port',
												'$Username',
												'$Password',
												'$setFrom',
												'$SMTPAuth',
												'$Host',
												'$SMTPSecure',
												'$addReplyTo',
												'$addCC',
												'$addBCC',
												'$isHTML',
												'$Mailer')";

  $runSql = mysqli_query( $conn, $sql )or die( mysqli_error( $conn ) );
  if ( $runSql ) {
    echo "Data successfully added";
  } else {
    echo "Failed to add data";
  }
} else if ( $mode == 2 ) {
  $sql = "UPDATE tbl_emailsetup SET 
            name='$name', 
			port='$port', 
			Username='$Username',
            Password='$Password',
			setFrom='$setFrom',
            SMTPAuth='$SMTPAuth',
			Host='$Host', 
			SMTPSecure='$SMTPSecure',
            addReplyTo='$addReplyTo',
			addCC='$addCC',
            addBCC='$addBCC', 
			isHTML='$isHTML', 
			Mailer='$Mailer' 
            WHERE id=$id ";
  $res = mysqli_query( $conn, $sql );
  if ( $res ) {
    echo "Data successfully updated";
  } else {
    echo "Failed to update";
  }
}
?>