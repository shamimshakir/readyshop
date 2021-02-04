<?php
include('../header.php');
 session_start();
$pageid = $_REQUEST[ 'page' ];
$user_role = $_SESSION[ "user_profile_id" ];



$editper = 0;
$deleteper = 0;
$editper = PermissionVerification( $user_role, $pageid, 'edit' );
$deleteper = PermissionVerification( $user_role, $pageid, 'delete' );

/**** initilize all variable ******/
$params = $columns = $totalRecords = $data = array();
$params = $_REQUEST;
$where = $sqlTot = $sqlRec = "";
$where .= " WHERE 1 = 1 AND (tbl_order.od_status = 5 OR tbl_order.od_status = 6)";


if(isset($_REQUEST['txtc_id']) && $_REQUEST['txtc_id'] !=""){
        $where .=" AND tbl_order.cl_id='".$_REQUEST['txtc_id']."'";
}
if(isset($_REQUEST['txtod_no']) && $_REQUEST['txtod_no'] !=""){
        $where.=" AND tbl_order.od_no='".$_REQUEST['txtod_no']."'";
   
}
if(isset($_REQUEST['txtod_status']) && $_REQUEST['txtod_status'] !=""){
        $where.=" AND tbl_order.od_status='".$_REQUEST['txtod_status']."'";
}


if(isset($_REQUEST['txtfromrec_date']) && $_REQUEST['txtfromrec_date'] !=NULL){
    $pieces = explode("/",$_REQUEST['txtfromrec_date']);
    $txtfromrec_date=trim($pieces[2]."-".$pieces[0]."-".$pieces[1], '-');
    $pieces = explode("/",$_REQUEST['txttorec_date']);
    $txttorec_date=trim($pieces[2]."-".$pieces[0]."-".$pieces[1], '-');
        $where.=" AND (tbl_order.od_date>='$txtfromrec_date' AND tbl_order.od_date<='$txttorec_date')";

}


$columns = array(
  0 => 'od_id',
  1 => 'od_no',
  2 => 'cl_id',
  3 => 'payment_status',
  4 => 'payment_date',
  5 => 'od_date',
  6 => 'ship_date',
  7 => 'ord_status',
  8 => 'total_cost'
);
// getting total number records without any search

 $sql = "SELECT
        tbl_order.od_id,
        tbl_order.od_no,
        tbl_customer.cl_pin as cl_id,
        CASE WHEN tbl_order.payment_status = 1 THEN 'Paid' ELSE 'Due' END AS paymentStatus,
        DATE_FORMAT(tbl_order.od_payment_date,'%m/%d/%Y') as payment_date,
        DATE_FORMAT(tbl_order.od_date,'%m/%d/%Y') as od_date,
        DATE_FORMAT(tbl_order.ship_date,'%m/%d/%Y') as ship_date,
        tbl_order_status.ord_status,
        tbl_order.total_cost
    FROM 
        tbl_order           
    LEFT JOIN tbl_customer ON  tbl_customer.cl_id = tbl_order.cl_id
    LEFT JOIN tbl_order_status ON  tbl_order_status.id = tbl_order.od_status ";
  
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

    $row_array=array($i++, $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8] );

// 	if($editper>0){
		$edit = "<div class='dropdown'>
          <button class='btn btn-primary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            Actions
          </button>
          <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
            <button class='dropdown-item' onclick='order_status_form({$row[0]})'  href='#'>Change Status</button>
            
            <button class='dropdown-item' onclick='order_details({$row[0]})'' href='#'>Order Details</button>
          </div>
        </div>";
// 	}
	
	array_push($row_array,$edit);
	$data[] = $row_array;
}

$json_data = array(
  "draw" => intval( $params[ 'draw' ] ),
  "recordsTotal" => intval( $totalRecords ),
  "recordsFiltered" => intval( $totalRecords ),
  "data" => $data // total data array
);
echo json_encode( $json_data ); // send data as json format
?>

