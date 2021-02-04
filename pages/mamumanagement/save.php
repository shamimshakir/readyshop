<?php 

include "../../library/dbconnect.php";
include "../../library/library.php";


$data = json_decode($_POST['data']);

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
	mysqli_query( $conn,"update _tree_entries set pid = '".$row['parentID']."', sl = '".$i."' where id = '".$row['id']."' ");
}


?>
