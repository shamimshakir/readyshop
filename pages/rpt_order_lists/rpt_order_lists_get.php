<?php 
    include('../header.php');
    $cond= " where tbl_order.od_status in ('1','2','3','4')";
if(isset($_REQUEST['txtc_id']) && $_REQUEST['txtc_id'] !=""){
    if($cond!=NULL){
        $cond.=" AND tbl_order.cl_id='".$_REQUEST['txtc_id']."'";
    }else{
        $cond=" WHERE tbl_order.cl_id='".$_REQUEST['txtc_id']."'";
    }
}
if(isset($_REQUEST['txtod_no']) && $_REQUEST['txtod_no'] !=""){
    if($cond!=NULL){
        $cond.=" AND tbl_order.od_no='".$_REQUEST['txtod_no']."'";
    }else{
        $cond=" WHERE tbl_order.od_no='".$_REQUEST['txtod_no']."'";
    }
}
if(isset($_REQUEST['txtod_status']) && $_REQUEST['txtod_status'] !=""){
    if($cond!=NULL){
        $cond.=" AND tbl_order.od_status='".$_REQUEST['txtod_status']."'";
    }else{
        $cond=" WHERE tbl_order.od_status='".$_REQUEST['txtod_status']."'";
    }
}


if(isset($_REQUEST['txtfromrec_date']) && $_REQUEST['txtfromrec_date'] !=NULL){
    $pieces = explode("/",$_REQUEST['txtfromrec_date']);
    $txtfromrec_date=trim($pieces[2]."-".$pieces[0]."-".$pieces[1], '-');
    $pieces = explode("/",$_REQUEST['txttorec_date']);
    $txttorec_date=trim($pieces[2]."-".$pieces[0]."-".$pieces[1], '-');
    if($cond!=NULL){
        $cond.=" AND (tbl_order.od_date>='$txtfromrec_date' AND tbl_order.od_date<='$txttorec_date')";
    }else{
        $cond=" WHERE (tbl_order.od_date>='$txtfromrec_date' AND tbl_order.od_date<='$txttorec_date')";
    }
}
?>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Order No.</th>
                <th>Order Date</th>
                <th>Customer</th>
                <th>Order Status</th>
                <th>Order Item</th>
                <th>Payment Status</th>
                <th>Total Amount</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                <?php 
                    $sql = "SELECT
                        tbl_order.od_no,
                        tbl_order.od_id,
                        DATE_FORMAT (tbl_order.od_date, '%Y-%m-%d') AS order_date,
                        tbl_order.od_status,
                        tbl_order.od_payment_first_name,
                        tbl_order.total_cost,
                        tbl_order.od_payment_amount,
                        tbl_order.payment_status,
                        tbl_order_status.ord_status as order_status,
                        COUNT(tbl_order_item.od_id) AS order_item_count
                    FROM
                        tbl_order
                    LEFT JOIN tbl_order_item ON tbl_order_item.od_id = tbl_order.od_id
                    LEFT JOIN tbl_order_status ON tbl_order_status.id = tbl_order.od_status

                    $cond
                    GROUP BY
                        tbl_order.od_id";
                    $res = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($res)){
                    extract($row);
                ?>
                <tr>
                    <td><?php echo $od_no; ?></td>
                    <td><?php echo $order_date; ?></td>
                    <td><?php echo $od_payment_first_name; ?></td>
                    <td><?php echo $order_status; ?></td>
                    <td><?php echo $order_item_count; ?></td>
                    <td><?php echo $payment_status == 1 ? "Paid" : "Unpaid"; ?></td>
                    <td><?php echo $total_cost; ?></td>
                    <td><button class="btn btn-sm btn-primary" onclick="show_details(<?php echo $od_id; ?>)">Details</button></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
