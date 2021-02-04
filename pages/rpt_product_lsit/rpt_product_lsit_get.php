<?php include('../header.php');
//echo '<pre>';
//print_r($_REQUEST);
//exit();
$s_cat_id = $_REQUEST['s_cat_id'];
$s_product_id = $_REQUEST['s_product_id'];
//print_r($_REQUEST);
$cond = "";
if(isset($_REQUEST['s_cat_id']) AND $_REQUEST['s_cat_id'] != 0){
    $cond .= " WHERE tbl_product.cat_id = $s_cat_id";
}
if(isset($_REQUEST['s_product_id']) AND $_REQUEST['s_product_id'] != 0){
    $cond .= " AND tbl_product.pd_id = $s_product_id";
}
//echo $cond;
$sql = "SELECT 
		tbl_category.cat_name,
		tbl_product.pd_id,
       tbl_product.pd_name,
       tbl_brand.brand_display,
       tbl_unit.unit_display,
       tbl_product.pd_description,
       tbl_product.pd_price,
       tbl_product.pd_code,
       tbl_product.pd_prev_price,
       tbl_product.pd_price_comments,
       tbl_product.pd_qty,
       tbl_product.pd_image,
       tbl_product.pd_thumbnail,
       tbl_product.product_detail,
       tbl_product.product_specification,
       tbl_product.product_warranty,
       tbl_product.pd_date,
       tbl_product.pd_last_update,
       tbl_product.reward_point,
       tbl_product.entry_by,
       tbl_product.entry_date,
       tbl_product.update_by,
       tbl_product.update_date
FROM tbl_product
LEFT JOIN tbl_category ON tbl_category.cat_id = tbl_product.cat_id
LEFT JOIN tbl_brand ON tbl_brand.brand_id = tbl_product.brand_id
LEFT JOIN tbl_unit ON tbl_unit.unit_id = tbl_product.unit_type
    $cond";
$res = mysqli_query($conn, $sql);
$numrows = mysqli_num_rows($res);

if($numrows>0) {
    $i=0;
    echo "<table class='table table-bordered'>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Unit</th>
                <th>Price</th>
                <th>qty</th>
            </tr>
        </thead>";
    while($rows=mysqli_fetch_array($res)){
        extract($rows);
        echo"<tr>
            <td> $pd_name </td>
            <td> $cat_name </td>
            <td> $brand_display </td>
            <td> $unit_display </td>
            <td> $pd_price </td>
            <td> $pd_qty  </td>
        </tr> ";
        $i++;
    }
}else{
    echo "<center><b> Data Not Found.....</b>";
}