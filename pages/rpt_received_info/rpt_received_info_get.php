<?php include('../header.php');


if(isset($_REQUEST['txtpick_loc_id']) && $_REQUEST['txtpick_loc_id'] !="0"){
    if($cond!=NULL){
        $cond.=" AND tbl_order_item.pick_loc_id='".$_REQUEST['txtpick_loc_id']."'";
    }else{$cond=" WHERE tbl_order_item.pick_loc_id='".$_REQUEST['txtpick_loc_id']."'";}
}
if(isset($_REQUEST['txtfromrec_date']) && $_REQUEST['txttorec_date'] !=NULL){
    $pieces = explode("/",$_REQUEST['txtfromrec_date']);
    $txtfromrec_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
    $pieces = explode("/",$_REQUEST['txttorec_date']);
    $txttorec_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
    $subhead="Received Date From ".$txtfromrec_date." To ".$txttorec_date;
    if($cond!=NULL){
        $cond.=" AND (tbl_order_item.rec_date>='".$txtfromrec_date."' AND tbl_order_item.rec_date<='".$txttorec_date."')";
    }else{$cond=" WHERE (tbl_order_item.rec_date>='".$txtfromrec_date."' AND tbl_order_item.rec_date<='".$txttorec_date."')";}
}

$SeNTlist1="SELECT
	   tbl_order.od_id as od_id,
	   DATE_FORMAT(tbl_order.od_date,'%m/%d/%Y') as od_date,
	   tbl_product.pd_name as pd_id,
	   tbl_order_item.od_qty,
	   tbl_order_item.pd_price,
	   tbl_order_item.hst,
	   tbl_order_item.reward_point_avail,
	   tbl_order_item.upscharge,
	   tbl_pickup_location.location as pick_loc_id,
	   tbl_order_item.rec_amnt,
	   tbl_order_item.rec_remarks,
	   DATE_FORMAT(tbl_order_item.rec_date,'%m/%d/%Y') as rec_date,
	   tbl_order_item.rec_by,
	   tbl_order_item.rec_status
   FROM 
	   tbl_order_item						
	   LEFT JOIN tbl_order ON  tbl_order.od_id = tbl_order_item.od_id
	   LEFT JOIN tbl_product ON  tbl_product.pd_id = tbl_order_item.pd_id
	   LEFT JOIN tbl_pickup_location ON  tbl_pickup_location.loc_id = tbl_order_item.pick_loc_id
	   $cond ";
$rSeNTlist1=mysqli_query($conn,$SeNTlist1) or die();
$numrows=mysqli_num_rows($rSeNTlist1);
if($numrows>0)
{
    $i=0;
    echo "
			   <table class='table table-bordered'>
			   <thead>
				<tr>
					<th>Order No</th>
					<th>Order Date</th>
					<th>Product</th>
					<th>Pick Up Location</th>
					<th>Qty</th>
					<th>Price</th>
					<th>HST</th>
					<th>Total Price</th>
					<th>Rec. Amnt</th>
					<th>Rec. Date</th>
					<th>Remarks</th>
				</tr>
			   </thead>
			   ";
    $totsubtot=0;
    $totrec=0;
    $tothst=0;

    while($rows=mysqli_fetch_array($rSeNTlist1)) {
        extract($rows);
        $subtot=$od_qty*$pd_price+$hst;

        $totsubtot +=$subtot;
        $totrec +=$rec_amnt;
        $tothst +=$hst;
        echo"<TR >
						   <td>$od_id</td>
						   <td>$od_date</td>
						   <td>$pd_id</td>
						   <td>$pick_loc_id</td>
						   <td>$od_qty</td>
						   <td>". number_format($pd_price, 2, '.', ',')."</td>
						   <td>". number_format($hst, 2, '.', ',')."</td>
						   <td>". number_format($subtot, 2, '.', ',')."</td>
						   <td>". number_format($rec_amnt, 2, '.', ',')."</td>
						   <td>$rec_date</td>
						   <td>$rec_remarks</td>
						   </TR>
						   ";
        $i++;
    }
    echo" <TR >
					<td>Total</td>
					<td>". number_format($tothst, 2, '.', ',')."</td>
					<td>". number_format($totsubtot, 2, '.', ',')."</td>
					<td>". number_format($totrec, 2, '.', ',')."</td>
					<td></td>
					<td></td>
				</TR>";
}else{
    echo "<center><b> Data Not Found.....</b>";
}
?>