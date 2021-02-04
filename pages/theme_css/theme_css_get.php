
<?php
include_once '../../library/dbconnect.php';
include_once "../../library/library.php";
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
$where .= " WHERE 1 = 1";

// if(isset($_REQUEST['theme_id']) && $_REQUEST['theme_id'] > 0){
//     $where .=" AND tbl_theme.id='".$_REQUEST['theme_id']."'";
// }
// if( !empty($params['search']['value']) ) {
//  $where .= " WHERE ";
//  $where .= " (  brand_display LIKE '%".$params['search']['value']."%' )";    
// }
$columns = array(
  0 => 'id',
  1 => 'label',
  2 => 'item',
  3 => 'status',
  4 => 'item_value'
);
// getting total number records without any search

$sql = "SELECT
        tbl_css.id,
        tbl_css.label,
        tbl_css.item,
        tbl_css.status,
        tbl_css.item_value
    FROM 
        tbl_css";
  
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
$i = 1;
while ( $row = mysqli_fetch_row( $queryRecords ) ) {
  $row_array=array($row[0], $row[1], substr($row[2], 0, 40));

    if($row[3] == 1){
      array_push($row_array, "<span class='badge badge-pill badge-success' id='pd_status'>Active</span>");
    }else{
      array_push($row_array, "<span class='badge badge-pill badge-danger' id='pd_status'>Inactive</span>");
    }

    array_push($row_array, "<p style='width:50px; height:16px;background:{$row[4]};'></p>");

    if($editper>0){
        $edit = "<button class='btn btn-primary btn-xs' onclick='edit({$row[0]})' >
            <i class='mdi mdi-grease-pencil'></i> Edit
        </button>";
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

