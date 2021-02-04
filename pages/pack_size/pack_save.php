<?php
include('../header.php');

$mode =              $_REQUEST['mode'];
$ct_id =          $_REQUEST['ct_id'];
$weight =     $_REQUEST['weight'];
$height =      $_REQUEST['height'];
$width =     $_REQUEST['width'];
$length =     $_REQUEST['length'];
$cubic =     $_REQUEST['cubic'];

if ($mode == 1) {
$sql = "INSERT 
                INTO tbl_pack_size (
                    packweight,
                    packheight,
                    packwidth,
                    packlength,
                    cubicsize
                ) 
                VALUES (
                    '$weight',
                    '$height',
                    '$width',
                    '$length',
                    '$cubic'
                )";

$runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
if($runSql){
    echo "Data successfully added";
}else{
    echo "Failed to add data";
}
}else if ($mode == 2){
    $sql = "UPDATE tbl_pack_size 
            SET 	
            packweight = '$weight',							
            packheight = '$height',							
            packwidth = '$width',					
            packlength = '$length',					
            cubicsize = '$cubic'					
            WHERE ct_id  = '$ct_id' ";
    $res = mysqli_query($conn, $sql);
    if($res){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>