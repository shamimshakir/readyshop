<?php include('../header.php')?>
<?php

if(isset($_REQUEST['txtpd_id']) && $_REQUEST['txtpd_id'] !="0"){
    if($cond!=NULL){
        $cond.=" AND tbl_order_item.pd_id='".$_REQUEST['txtpd_id']."'";
    }else{
        $cond=" WHERE tbl_order_item.pd_id='".$_REQUEST['txtpd_id']."'";
    }
}
if(isset($_REQUEST['txtpick_loc_id']) && $_REQUEST['txtpick_loc_id'] !="0"){
    if($cond!=NULL){
        $cond.=" AND tbl_order_item.pick_loc_id='".$_REQUEST['txtpick_loc_id']."'";
    }else{
        $cond=" WHERE tbl_order_item.pick_loc_id='".$_REQUEST['txtpick_loc_id']."'";
    }
}

if(isset($_REQUEST['txtfromrec_date']) && $_REQUEST['txttorec_date'] !=NULL){
    $pieces = explode("/",$_REQUEST['txtfromrec_date']);
    $txtfromrec_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
    $pieces = explode("/",$_REQUEST['txttorec_date']);
    $txttorec_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
    $condesc= "From ".$txtfromrec_date." To ".$txttorec_date;
    if($cond!=NULL){
        $cond.=" AND (tbl_order_item.rec_date>='".$txtfromrec_date."' AND tbl_order_item.rec_date<='".$txttorec_date."')";
    }else{
        $cond=" WHERE (tbl_order_item.rec_date>='".$txtfromrec_date."' AND tbl_order_item.rec_date<='".$txttorec_date."')";
    }
}

$SeNTlist1="SELECT
		tbl_order.od_id as od_id,
		tbl_product.pd_name as pd_id,
		tbl_order_item.od_qty,
		tbl_order_item.pd_price,
		tbl_order_item.hst,
		tbl_customer.firstname,
		tbl_customer.lastname,
		tbl_customer.surname,
		tbl_customer.email,
		tbl_order_item.reward_point_avail,
		tbl_order_item.reward_point_leastime,
		tbl_order_item.upscharge,
		tbl_pickup_location.location as pick_loc_id,
		tbl_order_item.rec_amnt,
		tbl_order_item.rec_remarks,
		DATE_FORMAT(tbl_order_item.rec_date,'%m/%d/%Y') as rec_date,
		DATE_FORMAT(tbl_order.od_date,'%m/%d/%Y') as od_date,
		tbl_order_item.rec_by,
		tbl_order_item.rec_status,
		tbl_order_item.return_qty,
		tbl_order_item.return_amnt,
		tbl_order_item.return_point,
		tbl_order_item.return_reward_point_leastime,
		tbl_order_item.return_date
	FROM
		tbl_order_item						
		LEFT JOIN tbl_order ON  tbl_order.od_id = tbl_order_item.od_id
		LEFT JOIN tbl_customer ON  tbl_customer.cl_id = tbl_order.cl_id
		LEFT JOIN tbl_product ON  tbl_product.pd_id = tbl_order_item.pd_id
		LEFT JOIN tbl_pickup_location ON  tbl_pickup_location.loc_id = tbl_order_item.pick_loc_id
		$cond ";
$rSeNTlist1=mysqli_query($conn,$SeNTlist1) or die();
$numrows=mysqli_num_rows($rSeNTlist1);
if($numrows>0){
    $i=0;
    echo "<table class='table table-bordered'>
			<thead>
			<tr>
				<th>Order No.</th>
				<th>Customer/Email</th>
				<th>Pickup Location</th>
				<th>Order date</th>
				<th>Receive date</th>
				<th>Product</th>
				<th>Qty</th>
				<th>Unit Price</th>
				<th>Customer Point</th>
				<th>Leastime Point</th>
			</tr>
			</thead> ";

    $treward_point_avail = 0;
    $treward_point_leastime = 0;
    while($rows=mysqli_fetch_array($rSeNTlist1)) {
        extract($rows);

        $treward_point_avail = $treward_point_avail + $reward_point_avail;
        $treward_point_leastime = $treward_point_leastime + $reward_point_leastime;

        echo" <tr>
		<td> $od_id </td>
		<td> $firstname $lastname $surname <br> $email</td>
		<td> $pick_loc_id </td>
		<td> $od_date </td>
		<td> $rec_date </td>
		<td> $pd_id </td>
		<td> $od_qty </td>
		<td> $pd_price </td>
		<td> $reward_point_avail </td>
		<td> $reward_point_leastime </td>
		</tr> ";
        $i++;

    }
    echo" <tr>
			<td colspan='8'><b>Total</b></td>
			<td> $treward_point_avail </td>
			<td>$treward_point_leastime</td>
		</tr>";
}else{
    echo "<center><b> Data Not Found.....</b>";
}

?>