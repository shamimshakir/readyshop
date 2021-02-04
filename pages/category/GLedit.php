<?php

include_once( "../../library/dbconnect.php" );
include_once( "../../library/library.php" );
include_once( "../../library/GLLibrary.php" );
$nodename = $_REQUEST[ 'nodename' ];
$cat_id = $_REQUEST[ 'cat_id' ];
$sid = $_REQUEST[ 'sid' ];



$cate_code = $_REQUEST[ 'cate_code' ];
$node_query = "select cat_name as nname
               from tbl_category
               where cat_id='$cat_id'
			   
               ";

$rset = mysqli_query($conn,$node_query )or die( "Error: " . mysqli_error($conn) );

$row = mysqli_fetch_array( $rset );

extract( $row );

 $update_query = "update tbl_category set 
				 cat_name='" . $nodename . "',			
				 catagory_code='$cate_code'			
                 where cat_id='$sid'
                ";
//echo $update_query;
if ( mysqli_query($conn, $update_query ) )
  print_r( "4" );
else
  print_r( "5" );


?>
