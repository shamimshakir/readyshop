<?php 
    include('../header.php');
    $order_id = $_POST['od_id'];
    $sql = "SELECT
        tbl_order.od_no,
        CONCAT(
            tbl_order.od_payment_first_name,
            ' ',
            tbl_order.od_payment_last_name
        ) AS customer_billing_name,
        tbl_order.od_payment_phone,
        tbl_order.od_payment_email,
        tbl_order.od_payment_address1,
        CONCAT(
            tbl_order.od_shipping_first_name,
            ' ',
            tbl_order.od_shipping_last_name
        ) AS customer_shipping_name,
        tbl_order.od_shipping_address1,
        tbl_order.od_shipping_email,
        tbl_order.od_shipping_phone,
        Date(tbl_order.od_date) AS order_date,
        tbl_order.order_payment_method,
        tbl_order.product_cost,
        tbl_order.total_cost,
        tbl_order.od_shipping_cost
    FROM
        tbl_order
    WHERE
        tbl_order.od_id = $order_id";
    $res = mysqli_query($conn, $sql);
    $order_info = mysqli_fetch_assoc($res);
?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="invoice-title">
                                <h4 class="float-right font-16"><strong>Order No. <?php echo $order_info['od_no']; ?></strong></h4>
                                <h3 class="mt-0">
                                    Nextstore
                                </h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <address>
                                        <strong>Billed To:</strong><br>
                                        <?php echo $order_info['customer_billing_name']; ?><br>
                                        <?php echo $order_info['od_payment_email']; ?><br>
                                        <?php echo $order_info['od_payment_phone']; ?><br>
                                        <?php echo $order_info['od_payment_address1']; ?>
                                    </address>
                                </div>
                                <div class="col-6 text-right">
                                    <address>
                                        <strong>Shipped To:</strong><br>
                                        <?php echo $order_info['customer_shipping_name']; ?><br>
                                        <?php echo $order_info['od_shipping_email']; ?><br>
                                        <?php echo $order_info['od_shipping_phone']; ?><br>
                                        <?php echo $order_info['od_shipping_address1']; ?>
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 m-t-30">
                                    <address>
                                        <strong>Payment Method:</strong><br>
                                        <?php echo $order_info['order_payment_method']; ?>
                                    </address>
                                </div>
                                <div class="col-6 m-t-30 text-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        <?php echo $order_info['order_date']; ?><br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div>
                                <div class="p-2">
                                    <h3 class="font-16"><strong>Order summary</strong></h3>
                                </div>
                                <div class="">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <td><strong>Item</strong></td>
                                                <td class="text-center"><strong>Price</strong></td>
                                                <td class="text-center"><strong>Quantity</strong>
                                                </td>
                                                <td class="text-right"><strong>Totals</strong></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            $items_sql = "SELECT
                                                    tbl_product.pd_name,
                                                    tbl_order_item.pd_price,
                                                    tbl_order_item.od_qty,
                                                    tbl_order_item.pd_price * tbl_order_item.od_qty AS item_subtotal
                                                FROM
                                                    tbl_order_item
                                                LEFT JOIN tbl_product ON tbl_product.pd_id = tbl_order_item.pd_id
                                                WHERE tbl_order_item.od_id = $order_id";
                                            $res = mysqli_query($conn, $items_sql);
                                            while($o_items = mysqli_fetch_assoc($res)){ ?>
                                            <tr>
                                                <td><?php echo $o_items['pd_name']; ?></td>
                                                <td class="text-center">$<?php echo $o_items['pd_price']; ?></td>
                                                <td class="text-center"><?php echo $o_items['od_qty']; ?></td>
                                                <td class="text-right">$<?php echo $o_items['item_subtotal']; ?></td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td class="thick-line"></td>
                                                <td class="thick-line"></td>
                                                <td class="thick-line text-center">
                                                    <strong>Subtotal</strong></td>
                                                <td class="thick-line text-right">$<?php echo $order_info['product_cost']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line text-center">
                                                    <strong>Shipping</strong></td>
                                                <td class="no-line text-right">$<?php echo $order_info['od_shipping_cost']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line text-center">
                                                    <strong>Total</strong></td>
                                                <td class="no-line text-right"><h4 class="m-0">$<?php echo $order_info['total_cost']; ?></h4></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-secondary waves-effect" onclick="view_datacd()">Back</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- end row -->

                </div>
            </div>
        </div> <!-- end col -->
    </div>
    
</div>
<script>
    function view_datacd() {
        $.ajax({
            type: "GET",
            url: "pages/order/ordercd.php",
            dataType: "html"
        }).done(function(msg) {
            $("#mainContent").html(msg);
        })
    }
    
</script>