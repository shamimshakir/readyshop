<?php 
    include('../header.php');
    // echo '<pre>';
    // print_r($_POST);
    // exit();
    if(isset($_REQUEST['firstname']) && !empty($_REQUEST['firstname'])){
        if($cond!=NULL){
            $cond.=" AND tbl_customer.firstname='".$_REQUEST['firstname']."'";
        }else{
            $cond=" WHERE tbl_customer.firstname='".$_REQUEST['firstname']."'";
        }
    }
    if(isset($_REQUEST['email']) && !empty($_REQUEST['email'])){
        if($cond!=NULL){
            $cond.=" AND tbl_customer.email='".$_REQUEST['email']."'";
        }else{
            $cond=" WHERE tbl_customer.email='".$_REQUEST['email']."'";
        }
    }
    if(isset($_REQUEST['phone']) && !empty($_REQUEST['phone'])){
        if($cond!=NULL){
            $cond.=" AND tbl_customer.phone='".$_REQUEST['phone']."'";
        }else{
            $cond=" WHERE tbl_customer.phone='".$_REQUEST['phone']."'";
        }
    }

    if(isset($_REQUEST['varified_status'])  && $_REQUEST['varified_status'] !='-1'){
        if($cond!=NULL){
            $cond.=" AND tbl_customer.varified_status='".$_REQUEST['varified_status']."'";
        }
//     else{
        //    $cond=" WHERE tbl_customer.varified_status='".$_REQUEST['varified_status']."'";
      //  }
    }
?>

<?php
$SeNTlist1="SELECT
			tbl_customer.*,
			tbl_customer_type.cl_type_description as customer_type,
			tbl_status.stat_desc as user_stat,
			tbl_shipping_costs.location as city_name
		FROM 
			tbl_customer						
			LEFT JOIN tbl_customer_type ON  tbl_customer_type.cl_type = tbl_customer.customer_type
			LEFT JOIN tbl_status ON  tbl_status.stat_id = tbl_customer.user_stat
			LEFT JOIN tbl_shipping_costs ON  tbl_shipping_costs.id = tbl_customer.city
        $cond
		ORDER BY tbl_customer.firstname ";
$rSeNTlist1=mysqli_query($conn,$SeNTlist1) or die();
$numrows=mysqli_num_rows($rSeNTlist1);
if($numrows>0)
{
    $i=0;
    echo "
            <table id='datatable' class='table table-bordered'>
				<thead>
					<tr>
						<th>First Name</th>
						<th>Address</th>
						<th>City</th>
						<th>Postal Code</th>
						<th>Mobile</th>
						<th>Email</th>
						<th>Reward Point</th>
						<th>Varification</th>
						<th></th>
					</tr>
				</thead> ";
    while($rows=mysqli_fetch_array($rSeNTlist1)) {
        extract($rows);?>
                    <tr>
						<td><?php echo $firstname; ?></td>
						<td><?php echo $address; ?></td>
						<td><?php echo $city_name; ?></td>
						<td><?php echo $postal_code; ?></td>
						<td><?php echo $phone; ?> </td>
						<td><?php echo $email; ?></td>
						<td><?php echo $reward_point; ?></td>
						<td><?php echo $varified_status == 1 ? 'Verified' : 'Not Verified'; ?> </td>
						<td><button class='btn btn-primary btn-sm' onclick='edit(<?php echo $cl_id;?>)'>Details</button></td>
                    </tr>
    <?php $i++;
    }
}else{
    echo "<center><b> Data Not Found.....</b>";
}
?>

<script>
    function edit(cl_id){
        $.ajax({
            type: "POST",
            url: "pages/rpt_customer_list/rpt_customer_list_details.php",
            data: {
                cl_id : cl_id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
</script>
