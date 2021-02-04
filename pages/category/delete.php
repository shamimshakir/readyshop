<?php
include "../../library/dbconnect.php";
function recursiveDelete( $id, $db ) {
  $db_conn = $db;
  $query =  mysqli_query( $db_conn, "select * from tbl_category where cat_parent_id = '" . $id . "' " );
  if ( mysqli_num_rows($query) > 0 ) {
    while ( $current = mysqli_fetch_assoc( $query )  ) {
      recursiveDelete( $current[ 'cat_id' ], $db_conn );
    }
  }
  mysqli_query( $db_conn, " UPDATE `tbl_category` SET act_status = CASE WHEN act_status = 1 THEN 0 ELSE 1 END WHERE cat_id = '" . $id . "' " );
	
}

 recursiveDelete( $_POST[ 'id' ], $conn );


?>
