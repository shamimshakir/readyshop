<?php 

include "../../library/dbconnect.php";
include "../../library/library.php";


$data = json_decode($_POST['data']);
print_r($_POST['data']);
function parseJsonArray($jsonArray, $parentID = 0) {

  $return = array();
  foreach ($jsonArray as $subArray) {
    $returnSubSubArray = array();
    if (isset($subArray->children)) {
 		$returnSubSubArray = parseJsonArray($subArray->children, $subArray->id);
    }

    $return[] = array('id' => $subArray->id, 'parentID' => $parentID);
    $return = array_merge($return, $returnSubSubArray);
  }
  return $return;
}

$readbleArray = parseJsonArray($data);

$i=0;
foreach($readbleArray as $row){
  $i++;
	mysqli_query( $conn,"update tbl_category set cat_parent_id = '".$row['parentID']."', sl = '".$i."' where cat_id = '".$row['id']."' ");
}


?>
