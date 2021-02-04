<?php

include( '../header.php' );
include "../../library/common_function.php";
include "../../library/sms_function.php";
$cl_id = $_POST[ 'cl_id' ];

$billing_first_name = $_POST[ 'billing_first_name' ];
$billing_email = $_POST[ 'billing_email' ];
$billing_phone = $_POST[ 'billing_phone' ];
$billing_country = $_POST[ 'billing_country' ];
$billing_address_1 = $_POST[ 'billing_address_1' ];
$billing_address_2 = $_POST[ 'billing_address_2' ];
$billing_district = $_POST[ 'billing_district' ];
$billing_street = $_POST[ 'billing_street' ];
$billing_postcode = $_POST[ 'billing_postcode' ];
$order_comments = $_POST[ 'order_comments' ];
$shiping_first_name = $_POST[ 'shiping_first_name' ];
$shiping_email = $_POST[ 'shiping_email' ];
$shiping_phone = $_POST[ 'shiping_phone' ];
$shiping_country = $_POST[ 'shiping_country' ];
$shiping_address_1 = $_POST[ 'shiping_address_1' ];
$shiping_address_2 = $_POST[ 'shiping_address_2' ];
$shiping_district = $_POST[ 'shiping_district' ];
$shiping_street = $_POST[ 'shiping_street' ];
$shiping_postcode = $_POST[ 'shiping_postcode' ];
$product_id = $_POST[ 'txtprod_id' ];
$sippingPrice = $_POST[ 'sippingPrice' ];
$cart_item_qty = $_POST[ 'qty' ];
$cart_item_price = $_POST[ 'unit' ];
$size_id = $_POST[ 'size_id' ];
$color_id = $_POST[ 'color_id' ];

$cart_item_name = $_POST[ 'cart_item_name' ];
$cartSubtotalAmount = $_POST[ 'cartSubtotalAmount' ];
$sippingPrice = $_POST[ 'sippingPrice' ];
$finalTotal = $_POST[ 'total_bill' ];
$payment_method = $_POST[ 'payment_method' ];
$terms = $_POST[ 'terms' ];
$terms_field = $_POST[ 'terms-field' ];

$date = date( 'dmy' );

$shop_sql = mysqli_query( $conn, "SELECT * FROM tbl_shop_config ORDER BY id ASC LIMIT 1" );
$row = mysqli_fetch_assoc( $shop_sql );
$shopName = strtoupper( substr( $row[ 'sc_name' ], 0, 3 ) );
$random = rand( 0000, 9999 );
$od_no = $shopName . $date . $random;


$sql = "INSERT INTO  tbl_order(
        od_payment_first_name,
        od_payment_email,
        od_payment_phone,
        od_payment_country,
        od_payment_address1,
        od_payment_postal_code,
        od_shipping_first_name,
        od_shipping_email,
        od_shipping_phone,
        od_shipping_address1,
        od_shipping_address2,
        od_shipping_postal_code,
        product_cost,
        total_cost,
        order_payment_method,
        od_shipping_cost,
        od_shipping_country,
        od_date,
        cl_id,
        od_no,
        od_payment_city
    ) VALUES (
        '$billing_first_name',
        '$billing_email',
        '$billing_phone',
        '$billing_country',
        '$billing_address_1',
        '$billing_postcode',
        '$shiping_first_name',
        '$shiping_email',
        '$shiping_phone',
        '$shiping_address_1',
        '$shiping_address_2',
        '$shiping_postcode',
        '$cartSubtotalAmount',
        '$finalTotal + $sippingPrice',
        '$payment_method',
        '$sippingPrice',
        '$shiping_country',
        NOW(),
        '$cl_id',
        '$od_no',
        '$billing_district'
    )";
$runSql = mysqli_query( $conn, $sql );
$last_id = mysqli_insert_id( $conn );
foreach ( $product_id as $i => $pid ) {
  $iSql = "INSERT INTO tbl_order_item(
            od_id,
            pd_id,
            od_qty,
            size_id,
            color_id,
            pd_price
        ) VALUES (
            '$last_id',
            '$pid',
            '$cart_item_qty[$i]',
            '$size_id[$i]',
            '$color_id[$i]',
            '$cart_item_price[$i]'
        )";
  mysqli_query( $conn, $iSql );
	 $updateinventory = "UPDATE `trn_product_details` 
							SET
								   `qty` = qty-$cart_item_qty[$i] 
							WHERE  `pd_id` = '" . $pid . "' and `color_id` ='" . $color_id[ $i ] . "' and `size_id` ='" . $size_id[ $i ] . "'";
  mysqli_query( $conn, $updateinventory )or die( mysqli_error( $conn ) );
}

$clid = pick( 'tbl_order', 'cl_id', "od_id = '$last_id'" );
$order_id = pick( 'tbl_order', 'od_no', "od_id = '$last_id'" );
$clients_name = pick( 'tbl_customer', 'firstname', "cl_id = '$clid'" );
$mobile = pick( 'tbl_customer', 'phone', "cl_id = '$clid'" );
$row = array( 'clients_name' => $clients_name, 'order_id' => $order_id, );
 $smsstatus = pick( 'tbl_sms_template', 'status', " command='order_submit'" );
  if ( $smsstatus > 0 ) {
    $smsbody = pick( 'tbl_sms_template', 'description', " command='order_submit'" );
    $api_id = 1;
    $smsbody = bind_to_template( $row, $smsbody );
    if ( $mobile != "" ) {
      SmsSendSystem( $mobile, $smsbody, $api_id );
    }
  }


if ( $runSql ) {
  echo "Data successfully added";
} else {
  echo "Failed to add data";
}