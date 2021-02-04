<?php
include('../header.php');
session_start();
$pageid = $_REQUEST[ 'page' ];
$user_role = $_SESSION[ "user_profile_id" ];

$editper = 0;
$deleteper = 0;
$editper = PermissionVerification( $user_role, $pageid, 'edit' );
$deleteper = PermissionVerification( $user_role, $pageid, 'delete' );

// initilize all variable
$params = $columns = $totalRecords = $data = array();
$params = $_REQUEST;
$where = $sqlTot = $sqlRec = "";
if( !empty($params['search']['value']) ) {
		$where .= " WHERE ";
		$where .= " (  location LIKE '%".$params['search']['value']."%' ";    
		$where .= " OR price LIKE '%".$params['search']['value']."%' )";
	}
$columns = array(
  0 => 'id',
  1 => 'location',
  2 => 'price'
);
// getting total number records without any search

$sql = "SELECT
  `id`,
  `location`,
  `price`
FROM
  `tbl_shipping_costs`";
$sqlTot .= $sql;
$sqlRec .= $sql;
//concatenate search sql if value exist
if ( isset( $where ) && $where != '' ) {
  $sqlTot .= $where;
  $sqlRec .= $where;
}
 $sqlRec .= " ORDER BY " . $columns[ $params[ 'order' ][ 0 ][ 'column' ] ] . "   " . $params[ 'order' ][ 0 ][ 'dir' ] . "  LIMIT " . $params[ 'start' ] . " ," . $params[ 'length' ] . "";
$queryTot = mysqli_query( $conn, $sqlTot )or die( "database error:" . mysqli_error( $conn ) );
$totalRecords = mysqli_num_rows( $queryTot );

$queryRecords = mysqli_query( $conn, $sqlRec )or die( "error to fetch Thana" );
//iterate on results row and create new index array of data

while ( $row = mysqli_fetch_row( $queryRecords ) ) {	
	$row_array=array($row[0], $row[1],$row[2]);
	
		
	if($editper>0){
		$edit='<button class="btn btn-primary btn-xs" onclick="edit('.$row[0].')" >Edit</button>';
	}
	
	array_push($row_array,$edit);
	$data[] = $row_array;	
}
//print_r($data);
$json_data = array(
  "draw" => intval( $params[ 'draw' ] ),
  "recordsTotal" => intval( $totalRecords ),
  "recordsFiltered" => intval( $totalRecords ),
  "data" => $data // total data array
);
echo json_encode( $json_data ); // send data as json format
?>
