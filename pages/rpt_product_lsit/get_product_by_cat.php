<?php
include('../header.php');

$cat_id = $_REQUEST['cat_id'];

$sql = "SELECT tbl_product.pd_name, tbl_product.pd_id FROM tbl_product WHERE tbl_product.cat_id = $cat_id";

$res = mysqli_query($conn, $sql);

$count = mysqli_num_rows($res);

if($count >= 1){
    echo "<option value='0'>Select a product</option>";
    while ($products = mysqli_fetch_assoc($res)){
        echo "<option value='$products[pd_id]'>$products[pd_name]</option>";
    }
}else{
    echo "<option value='-1'>No product found</option>";
}



