<?php 
include('../library/dbconnect.php');
if(isset($_REQUEST['id'])){
	if($_REQUEST['id']>0){
    $table=$_REQUEST['table'];
    $id=$_REQUEST['id'];
    $where=$_REQUEST['where'];
    $mode = 2;
     $SeNTlist = "SELECT * FROM $table WHERE $where = '$id' ";
    $ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error($conn));
    $rowNewsTls=mysqli_num_rows($ExSeNTlist);
    while($rowNewsTl=mysqli_fetch_assoc($ExSeNTlist)){
		//print_r($rowNewsTl);
        //extract($rowNewsTl);
		array_push($rowNewsTl,'success=>ok');
		echo json_encode($rowNewsTl);
    }
	}else{
		$rowNewsTl=array();
		array_push($rowNewsTl,'success=>fail');
		echo json_encode($rowNewsTl);
	}
	
}
?>
