<?php

include "../../library/dbconnect.php";
include "../../library/library.php";

function recursiveDelete( $id, $db ) {
  $db_conn = $db;
  $query =  mysqli_query( $db_conn, "select * from tbl_category where cat_parent_id = '" . $id . "' " );
  if ( mysqli_num_rows($query) > 0 ) {
    while ( $current = mysqli_fetch_assoc( $query )  ) {
      recursiveDelete( $current[ 'id' ], $db_conn );
    }
  }
  mysqli_query( $db_conn, " UPDATE `tbl_category` SET `act_status` = '0' WHERE cat_id = '" . $id . "' " );
}
//echo $_POST['id'];
recursiveDelete( $_POST[ 'id' ], $conn );

?>
