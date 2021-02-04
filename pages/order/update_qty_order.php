<?php 
include('../header.php');

$order_id = $_POST['order_id'];
$product_ids = $_POST['product_ids'];
$change_item_quantity_input = $_POST['change_item_quantity_input'];
$products_prices = $_POST['products_prices'];

$sub_total=0;

$item_dlt_sql = "DELETE FROM tbl_order_item WHERE od_id = $order_id";
$res = mysqli_query($conn, $item_dlt_sql);
if($res){
    foreach($product_ids as $index=>$product_id){
        if($change_item_quantity_input[$index] != 0){
            $insert_sql = "INSERT INTO tbl_order_item(od_id, pd_id, od_qty, pd_price) 
            VALUES($order_id, $product_ids[$index], $change_item_quantity_input[$index], $products_prices[$index])";
            $insert_res = mysqli_query($conn, $insert_sql);
            $sub_total += ($change_item_quantity_input[$index] * $products_prices[$index]);
        }
    }
}

if($insert_res){
    $shipping_price = pick('tbl_order','od_shipping_cost',"od_id = $order_id");
    $grand_total = $shipping_price + $sub_total;
    $update_sql = "UPDATE tbl_order SET product_cost = $sub_total, total_cost = $grand_total, od_shipping_cost = $shipping_price WHERE od_id = $order_id";
    $res3 = mysqli_query($conn, $update_sql);
    if($res3){
        echo "Order Updated Successfully";
    }
}