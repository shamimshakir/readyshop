<?php 
include('../header.php');
$cat_id=$_REQUEST['cat_id'];
$brand_id=$_REQUEST['brand_id'];
 $pd_name=$_REQUEST['pd_name'];
$cat_code=pick("tbl_category","catagory_code","cat_id=".$cat_id." ");
$brand_code=pick("tbl_brand","brand_display","brand_id=".$brand_id." ");

$first_part =substr($pd_name, 0, 3);;
$pcode='';
if($cat_code==''){
	$pcode='000';
}else{
	$pcode=$cat_code;
}
if($brand_code==''){
	$pcode .='-000';
}else{
	$pcode .='-'.$brand_code;
}
if($first_part==''){
	$pcode .='-000';
}else{
	$pcode .='-'.$first_part;
}
echo $pcode;
?>
