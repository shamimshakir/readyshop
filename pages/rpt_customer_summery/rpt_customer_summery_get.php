<?php include('../header.php');
if(isset($_REQUEST['txtcat_id']) && $_REQUEST['txtcat_id'] !="0"){
    if($cond!=NULL){
        $cond.=" AND trn_mat_receive_detail.cat_id='".$_REQUEST['txtcat_id']."'";
    }else{
        $cond=" WHERE trn_mat_receive_detail.cat_id='".$_REQUEST['txtcat_id']."'";
    }
}
if(isset($_REQUEST['txtprod_id']) && $_REQUEST['txtprod_id'] !="0"){
    if($cond!=NULL){
        $cond.=" AND trn_mat_receive_detail.prod_id='".$_REQUEST['txtprod_id']."'";
    }else{
        $cond=" WHERE trn_mat_receive_detail.prod_id='".$_REQUEST['txtprod_id']."'";
    }
}
if(isset($_REQUEST['txtfromentry_date']) && $_REQUEST['txttoentry_date'] !=NULL){
    $pieces = explode("/",$_REQUEST['txtfromentry_date']);
    $txtfromentry_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
    $pieces = explode("/",$_REQUEST['txttoentry_date']);
    $txttoentry_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
    if($cond!=NULL){
        $cond.=" AND (trn_mat_receive_detail.entry_date>='".$txtfromentry_date."' AND trn_mat_receive_detail.entry_date<='".$txttoentry_date."')";
    }else{
        $cond=" WHERE (trn_mat_receive_detail.entry_date>='".$txtfromentry_date."' AND trn_mat_receive_detail.entry_date<='".$txttoentry_date."')";
    }
}

echo $SeNTlist1="SELECT
			mas_mat_receive.invoiceobjet_id as invoiceobject_id,
			trn_mat_receive_detail.sl_no,
			tbl_category.cat_name as cat_id,
			tbl_product.pd_name as prod_id,
			trn_mat_receive_detail.prod_description,
			trn_mat_receive_detail.client_id,
			trn_mat_receive_detail.rate,
			trn_mat_receive_detail.qty,
			trn_mat_receive_detail.unit,
			trn_mat_receive_detail.vat,
			trn_mat_receive_detail.total,
			trn_mat_receive_detail.entry_by,
			DATE_FORMAT(mas_mat_receive.invoice_date,'%m/%d/%Y') as entry_date,
			trn_mat_receive_detail.update_by,
			trn_mat_receive_detail.update_date,
			trn_mat_receive_detail.out_qty,
			trn_mat_receive_detail.	color_id,
			trn_mat_receive_detail.	size_id,
			tbl_size.size_display as size,
			tbl_color.color_display as color
		FROM 
			trn_mat_receive_detail						
			LEFT JOIN mas_mat_receive ON  mas_mat_receive.invoiceobjet_id = trn_mat_receive_detail.invoiceobject_id
			LEFT JOIN tbl_category ON  tbl_category.cat_id = trn_mat_receive_detail.cat_id
			LEFT JOIN tbl_product ON  tbl_product.pd_id = trn_mat_receive_detail.prod_id
			LEFT JOIN tbl_size ON  tbl_size.size_id = trn_mat_receive_detail.size_id
			LEFT JOIN tbl_color ON  tbl_color.color_id = trn_mat_receive_detail.color_id
			$cond 
		ORDER BY mas_mat_receive.invoiceobjet_id ";
$rSeNTlist1=mysqli_query($conn,$SeNTlist1) or die();
$numrows=mysqli_num_rows($rSeNTlist1);

if($numrows>0) {
    $i=0;
    echo "
            <table class='table table-bordered'>
            <thead>
				<tr>
					<th>Receive No.</th>
					<th>Received Date</th>
					<th>Category</th>
					<th>Product</th>
					<th>Color</th>
					<th>Size</th>
					<th>qty</th>
				</tr>
            </thead>
            ";
    while($rows=mysqli_fetch_array($rSeNTlist1)){
        extract($rows);
        echo"<tr>
						<td> $invoiceobject_id </td>
						<td> $entry_date </td>
						<td> $cat_id </td>
						<td> $prod_id </td>
						<td> $color </td>
						<td> $size </td>
						<td> $qty </td>
                    </tr> ";
        $i++;
    }
}else{
    echo "<center><b> Data Not Found.....</b>";
}