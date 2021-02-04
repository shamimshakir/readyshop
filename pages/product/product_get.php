
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
$where .= " WHERE 1 = 1";

if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] > 0){
       $where .=" AND tbl_product.cat_id='".$_REQUEST['cat_id']."'";
}
if(isset($_REQUEST['product_name']) && $_REQUEST['product_name'] !=''){
       $where .=" AND tbl_product.pd_name like '%".$_REQUEST['product_name']."%'";
}
if(isset($_REQUEST['status']) && $_REQUEST['status'] !=''){
    if($_REQUEST['status'] == "upsstat"){
      $where .=" AND tbl_product.upsstat = 1";
    }
    if($_REQUEST['status'] == "popular_stat"){
      $where .=" AND tbl_product.popular_stat = 1";
    }
    if($_REQUEST['status'] == "feature_stat"){
      $where .=" AND tbl_product.feature_stat = 1";
    }
    if($_REQUEST['status'] == "new_stat"){
      $where .=" AND tbl_product.new_stat = 1";
    }
    if($_REQUEST['status'] == "onsale_stat"){
      $where .=" AND tbl_product.onsale_stat = 1";
    }    
    if($_REQUEST['status'] == "pd_status"){
       $where .=" AND tbl_product.pd_status = 0";
    }
}

$columns = array(
  0 => 'pd_id',
  1 => 'pd_name',
  2 => 'cat_name',
  3 => 'brand_display',
  4 => 'pd_code',
  5 => 'pd_price',
  6 => 'pd_qty',
  7 => 'pd_thumbnail',
  8 => 'upsstat',
  9 => 'popular_stat',
  10 => 'feature_stat',
  11 => 'new_stat',
  12 => 'onsale_stat',
  13 => 'pd_status'
);
// getting total number records without any search

$sql = "SELECT
    		tbl_product.pd_id, 
    		tbl_product.pd_name, 
    		tbl_category.cat_name, 
    		tbl_brand.brand_display,
    		tbl_product.pd_code, 
    		tbl_product.pd_price, 
    		tbl_product.pd_qty,
    		tbl_product.pd_thumbnail,
    		tbl_product.upsstat,
    		tbl_product.popular_stat,
    		tbl_product.feature_stat,
    		tbl_product.new_stat,
    		tbl_product.onsale_stat,
    		tbl_product.pd_status
    	FROM
    		tbl_product
    		left join tbl_category ON tbl_category.cat_id=tbl_product.cat_id
    		left join tbl_product_stat ON tbl_product_stat.prod_stat_type = tbl_product.prod_stat_type
    		left JOIN tbl_brand ON tbl_brand.brand_id=tbl_product.brand_id";
  
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

    $row_array=array(++$i, substr($row[1], 0, 20), $row[2], $row[3], $row[4], $row[5], $row[6]);

    if($row[7]!=' '){
		$images='.<img style="height: 50px;width: auto;" src="'.$folder_admin.'products/thumbnails/'.$row[7].'" alt=""  style="height::100px"/>.';}
		else{
		$images=' ';	
	} 
	array_push($row_array,$images);	
	
	$statuses = array();
	if($row[8] == 1){ 
        $upsstat = '<button class="btn btn-success btn-sm stsbtn" id="upsstat" onclick="update_status(this.id, '.$row[0].')" >Upcoming</button><br>';
    }else{
        $upsstat = '<button class="btn btn-danger btn-sm stsbtn" id="upsstat" onclick="update_status(this.id, '.$row[0].')" >Upcoming</button><br>';
    } 
    array_push($statuses, $upsstat);
    
	if($row[9] == 1){ 
        $popular_stat = '<button class="btn btn-success btn-sm stsbtn" id="popular_stat" onclick="update_status(this.id, '.$row[0].')" >Popular</button><br>';
    }else{
        $popular_stat = '<button class="btn btn-danger btn-sm stsbtn" id="popular_stat" onclick="update_status(this.id, '.$row[0].')" >Popular</button><br>';
    } 
    array_push($statuses, $popular_stat);

	if($row[10] == 1){ 
        $feature_stat = '<button class="btn btn-success btn-sm stsbtn" id="feature_stat" onclick="update_status(this.id, '.$row[0].')" >Feature</button><br>';
    }else{
        $feature_stat = '<button class="btn btn-danger btn-sm stsbtn" id="feature_stat" onclick="update_status(this.id, '.$row[0].')" >Feature</button><br>';
    } 
    array_push($statuses, $feature_stat);
    
	if($row[11] == 1){ 
        $new_stat = '<button class="btn btn-success btn-sm stsbtn" id="new_stat" onclick="update_status(this.id, '.$row[0].')" >New Arrival </button><br>';
    }else{
        $new_stat = '<button class="btn btn-danger btn-sm stsbtn" id="new_stat" onclick="update_status(this.id, '.$row[0].')" >New Arrival</button><br>';
    } 
    array_push($statuses, $new_stat);
    
	if($row[12] == 1){ 
        $onsale_stat = '<button class="btn btn-success btn-sm stsbtn" id="onsale_stat" onclick="update_status(this.id, '.$row[0].')" >OnSale</button><br>';
    }else{
        $onsale_stat = '<button class="btn btn-danger btn-sm stsbtn" id="onsale_stat" onclick="update_status(this.id, '.$row[0].')" >OnSale</button><br>';
    } 
    array_push($statuses, $onsale_stat);
    
	if($row[13] == 1){ 
        $pd_status = '<button class="btn btn-success btn-sm stsbtn" id="pd_status" onclick="update_status(this.id, '.$row[0].')" >Inactive</button><br>';
    }else{
        $pd_status = '<button class="btn btn-danger btn-sm stsbtn" id="pd_status" onclick="update_status(this.id, '.$row[0].')" >Inactive</button><br>';
    } 
    array_push($statuses, $pd_status);
	
	array_push($row_array,join('', $statuses));
	
	
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

