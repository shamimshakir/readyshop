<?php
include('../header.php');

$mode =              $_REQUEST['mode'];
$tag_id =          $_REQUEST['tag_id'];
$tag_name = $_REQUEST['tag_name'];
$tag_label = $_REQUEST['tag_label'];
// print_r($_REQUEST);
// exit();
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
    $sql = "UPDATE product_tags 
            SET     
            tag_name='$tag_name',
            tag_label='$tag_label'                  
            WHERE tag_id  = '$tag_id' ";
    $res = mysqli_query($conn, $sql);
    if($res){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>