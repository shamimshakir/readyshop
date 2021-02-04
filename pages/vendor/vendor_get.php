<?php
session_start();
$pageid = $_REQUEST[ 'page' ];
$user_role = $_SESSION[ "user_profile_id" ];
include('../header.php');
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
		$where .= " (  vendor_name LIKE '%".$params['search']['value']."%' ";    
		$where .= " OR vendor_name LIKE '%".$params['search']['value']."%' ";
		$where .= " OR company_name LIKE '%".$params['search']['value']."%' ";
		$where .= " OR phone LIKE '%".$params['search']['value']."%' ";
		$where .= " OR email LIKE '%".$params['search']['value']."%' )";
	}


$columns = array(
  0 => 'vendor_id',
  1 => 'vendor_name',
  2 => 'company_name',
  3 => 'phone',
  4 => 'email',
  5 => 'userRegDate',
  6 => 'status'
);
// getting total number records without any search

$sql = "SELECT
  vendor_id,
  vendor_name,
  company_name,
  phone,
  email,
  Date(tbl_vendor.user_regdate) AS userRegDate,
  status
FROM
  tbl_vendor";
  
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

$queryRecords = mysqli_query( $conn, $sqlRec )or die( "error to fetch" );
//iterate on results row and create new index array of data
$i = 0;
while ( $row = mysqli_fetch_row( $queryRecords ) ) {	
		$row_array=array(++$i, $row[1], $row[2], $row[3], $row[4], $row[5]);

    $vendor_status = array();
    if($row[6] == 1){
      array_push($vendor_status, "<span class='badge badge-pill badge-success'>Active</span>");
    }else{
      array_push($vendor_status, "<span class='badge badge-pill badge-danger'>Inactive</span>");
    }
    array_push($row_array, join($vendor_status));

    $vendor_action = array();

    $checked = "";
    if ( $row[6] == 0 ) { $checked = "checked";}
    array_push($vendor_action, "<div>
      <input type='checkbox' id='switch{$i}' switch='none'  value='1' onclick='update_status({$row[0]})' {$checked} />
      <label for='switch{$i}' data-on-label='On' data-off-label='Off' ></label>
    </div>");
    array_push($row_array, join($vendor_action));


	if($editper>0){
		$edit='<button class="btn btn-primary btn-xs" onclick="edit('.$row[0].')" >Edit</button>';
	}
	
	array_push($row_array,$edit);
	$data[] = $row_array;	
}
// print_r($data);
$json_data = array(
  "draw" => intval( $params[ 'draw' ] ),
  "recordsTotal" => intval( $totalRecords ),
  "recordsFiltered" => intval( $totalRecords ),
  "data" => $data // total data array
);
echo json_encode( $json_data ); // send data as json format
?>

