<?php

ini_set( 'display_errors', 'OFF' );
error_reporting( E_ALL );


//$domain = preg_replace( '/^www\./', '', $_SERVER[ 'HTTP_HOST' ] );
//$domain = str_replace( ".", "_", $domain );

$servername = "localhost";
$usernames = "root";
$passwords = "Next@store@123";
$subdomain = "readyshop_cloud";

  $dbname = $subdomain;
  $folfer_loc = "../../uploads/" . $subdomain . "/";
  $folder_fontend = "admin/uploads/" . $subdomain . "/";
  $folder_admin = "uploads/" . $subdomain . "/";


$conn = mysqli_connect( $servername, $usernames, $passwords, $dbname )or die( "Connection failed: " . mysqli_connect_error() );

if ( mysqli_connect_errno() ) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


?>
