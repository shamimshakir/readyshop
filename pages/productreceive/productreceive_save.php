<?php
include('../header.php');
$inv_id = 0;

extract($_REQUEST);

if ($mode == 1) {
    $invnum=pick("mas_mat_receive","max(invoice_number)","")+1;
     $insertInvoice="INSERT INTO
            mas_mat_receive(
                invoice_date,
                client_id,
                invoice_number,
                comments,
                total_bill,
                entry_date) 
            VALUES(
                '$invoice_date',
                '$client_id',
                '$invnum',
                '$comments',
                '$total_bill',
                DATE(now()))";
                
    $runSql = mysqli_query($conn,$insertInvoice) or die(mysqli_error($conn));
    $inv_id = mysqli_insert_id($conn);
} 

elseif ($mode == 2){
   $UNews="UPDATE
                mas_mat_receive
            SET
                invoice_date = '$invoice_date',
                comments = '$comments',
                total_bill = '$total_bill',
                client_id = '$client_id'
            WHERE
                invoiceobjet_id =$invoiceobjet_id ";
    mysqli_query($conn,$UNews) or die(mysqli_error($conn));

    $SeNTlist="SELECT qty as pqty, prod_id, sl_no
            FROM 
                trn_mat_receive_detail 
            WHERE  	invoiceobject_id='$invoiceobjet_id'";
    $ExSeNTlist=mysqli_query($conn,$SeNTlist) or die(mysqli_error($conn));
    while($rowNewsTl=mysqli_fetch_array($ExSeNTlist)) {
        extract($rowNewsTl);
        $updateinventory="update tbl_product
            set
            pd_qty=pd_qty-$pqty,
            update_by='$SUserID',
            update_date=DATE(now())
            Where pd_id=$prod_id ";
        mysqli_query($conn,$updateinventory) or die(mysqli_error($conn));

        $searchInvoiceID="DELETE FROM trn_mat_receive_detail WHERE	invoiceobject_id ='$invoiceobjet_id' AND sl_no= '$sl_no' ";
        $resultInvoice = mysqli_query($conn,$searchInvoiceID) or die(mysqli_error($conn));
    }
    $inv_id = $invoiceobjet_id;
}

foreach($id as $a => $b){
    if($txtprod_id[$a]!=''>0 && $qty[$a]>0){
        $insertTrnChallan="INSERT INTO trn_mat_receive_detail (
                invoiceobject_id,
                sl_no,
                cat_id, 
                prod_id, 
                size_id, 
                color_id, 
                client_id, 
                qty, 
                total, 
                unit )
            VALUES (
                '$inv_id',
                '".$id[$a]."',
                '".$cat_id[$a]."',
                '".$txtprod_id[$a]."',
                '".$size_id[$a]."',
                '".$color_id[$a]."',
                '".$client_id."',
                '".$qty[$a]."',
                '".$total[$a]."',
                '".$unit[$a]."' )";
        mysqli_query($conn,$insertTrnChallan) or die(mysqli_error($conn));
        $updateinventory="UPDATE tbl_product
            SET
                pd_qty=pd_qty+'".$qty[$a]."',
                update_by='$SUserID',
                update_date=DATE(now())
            WHERE pd_id='".$txtprod_id[$a]."' ";
        mysqli_query($conn,$updateinventory) or die(mysqli_error($conn));
    }
	
	
}
$SeNTlist="SELECT qty as pqty, prod_id, sl_no,color_id,size_id
            FROM 
                trn_mat_receive_detail 
            WHERE  	invoiceobject_id='$invoiceobjet_id'";
    $ExSeNTlist=mysqli_query($conn,$SeNTlist) or die(mysqli_error($conn));
    while($rowNewsTl=mysqli_fetch_array($ExSeNTlist)) {
        extract($rowNewsTl);
		
		$has_trn=pick('trn_product_details','count(id)',"pd_id='.$prod_id.' and color_id='.$color_id.' and  size_id='.$size_id.'");
		if($has_trn>0){
			$updateinventory="UPDATE `trn_product_details` 
							SET
								   `qty` = qty-$pqty 
							WHERE  `pd_id` = '".$prod_id."' and `color_id` ='".$color_id."' and `size_id` ='".$size_id."'";
		}else{
			$updateinventory="INSERT INTO `trn_product_details` 
            ( `pd_id`, 
             `color_id`, 
             `size_id`, 
             `qty`) 
VALUES      ( '".$prod_id."', 
              '".$color_id."', 
              '".$size_id."', 
              '".$pqty."')";
		}	 
        mysqli_query($conn,$updateinventory) or die(mysqli_error($conn));
    }

if(mysqli_query($conn,"COMMIT")) {
    echo "successfully done";
} else {
    echo "Operation failed";
}
?>