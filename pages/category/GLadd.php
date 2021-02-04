<?php

session_start();
include_once( "../../Library/dbconnect.php" );
include_once( "../../Library/Library.php" );
?>
<?php
$rset = mysqli_query( $conn, "select max(cat_id) as id from tbl_category" )or die( mysql_error() );

$row = mysqli_fetch_array( $rset );

extract( $row );

$iid = intval( $id ) + 1;
$lid = intval( $_REQUEST[ 'lid' ] ) + 1;

$nodename = $_REQUEST[ 'nodename' ];
$cat_id = $_REQUEST[ 'cat_id' ];
$cat_type_id = $_REQUEST[ 'cat_type_id' ];
$cate_code = $_REQUEST[ 'cate_code' ];

 $insert_query = "  insert into tbl_category
                        (
                              cat_id,
							  cat_parent_id,
                              cat_name,
							  cat_description,
							  catagory_code,							 
							  level_id,
							  act_status                           
                        )
                        values
                        (
                               $iid,
							  '$cat_id',
                              '$nodename',
							  '$nodename',							  
							  '$cate_code',							
							  '$lid',
							  '1'
                        )
                       ";
// echo $insert_query;
if ( mysqli_query($conn, $insert_query ) )
  print_r( "1" );
else
  print_r( "2" );
?>
