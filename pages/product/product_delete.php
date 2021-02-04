<?php
$id = $_REQUEST[ 'id' ];
$loc = '../../'.$_REQUEST[ 'loc' ];
$p_name = $_REQUEST[ 'p_name' ];
include "../../library/dbconnect.php";
include "../../library/library.php";

$dsql = "DELETE FROM tbl_product_images WHERE pro_img_id = '$id'";
mysqli_query( $conn, $dsql )or die( mysqli_error( $conn ) );
//echo $loc . "/comm/".$p_name;
unlink( $loc."/comm/".$p_name);
unlink( $loc . "/mobile".$p_name);
unlink( $loc . "/tab".$$p_name);

?>
