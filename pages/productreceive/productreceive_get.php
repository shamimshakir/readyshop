<?php
include('../header.php');
 session_start();
$pageid = $_REQUEST[ 'page' ];
$user_role = $_SESSION[ "user_profile_id" ];
$editper = 0;
$deleteper = 0;
$editper = PermissionVerification( $user_role, $pageid, 'edit' );
$deleteper = PermissionVerification( $user_role, $pageid, 'delete' );

$params = $columns = $totalRecords = $data = array();
$params = $_REQUEST;
$where = $sqlTot = $sqlRec = "";
$where .= " WHERE 1 = 1";


if(isset($_REQUEST['txtcat_id']) && $_REQUEST['txtcat_id'] >0){
        $where.=" AND trn_mat_receive_detail.cat_id='".$_REQUEST['txtcat_id']."'";
}

if(isset($_REQUEST['s_product_id']) && $_REQUEST['s_product_id'] >0){
        $where.=" AND trn_mat_receive_detail.prod_id='".$_REQUEST['s_product_id']."'";
}
if(isset($_REQUEST['client_id']) && $_REQUEST['client_id']>0){

        $where.=" AND `mas_mat_receive`.`client_id` ='".$_REQUEST['client_id']."'";
}
if(isset($_REQUEST['bill_no']) && $_REQUEST['bill_no']!=''){

        $where.=" AND mas_mat_receive.invoice_number='".$_REQUEST['bill_no']."'";
}
if(isset($_REQUEST['txtfromentry_date']) && $_REQUEST['txttoentry_date'] !=''){
    $pieces = explode("/",$_REQUEST['txtfromentry_date']);
    $txtfromentry_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
    $pieces = explode("/",$_REQUEST['txttoentry_date']);
    $txttoentry_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
        $where.=" AND (trn_mat_receive_detail.entry_date>='".$txtfromentry_date."' AND trn_mat_receive_detail.entry_date<='".$txttoentry_date."')";
}

$columns = array(
  0 => 'invoiceobjet_id',
  1 => 'invoice_number',
  2 => 'invoice_date',
  3 => 'client_id', 
  4 => 'total_bill',  
  5 => 'entry_date',
  6 => 'update_date'
);
// getting total number records without any search

$sql = "SELECT
        mas_mat_receive.invoiceobjet_id,
        mas_mat_receive.invoice_number,
        DATE_FORMAT(mas_mat_receive.invoice_date,'%d/%m/%Y') as invoice_date,
        tbl_vendor.vendor_name as client_id,  
        mas_mat_receive.total_bill,    
        mas_mat_receive.entry_date,
        mas_mat_receive.update_date
    FROM 
        mas_mat_receive		
		
        LEFT JOIN tbl_vendor ON  tbl_vendor.vendor_id  = mas_mat_receive.client_id";
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
	$row_array=array($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
	
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


    