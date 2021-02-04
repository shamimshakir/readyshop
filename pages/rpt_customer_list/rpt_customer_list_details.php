<?php include('../header.php');
$cl_id = $_POST['cl_id'];
$SeNTlist1="SELECT
			tbl_customer.cl_id,
			tbl_customer.cl_pin,
			tbl_customer.cl_code,
			tbl_customer.surname,
			tbl_customer.firstname,
			tbl_customer.lastname,
			tbl_customer.address,
			tbl_customer.address1,
			tbl_customer.street,
			tbl_customer.city,
			tbl_customer.postal_code,
			tbl_customer.province,
			tbl_customer.country,
			tbl_customer.company,
			tbl_customer.phone,
			tbl_customer.fax, 
			tbl_customer.email,
			tbl_customer.user_regdate,
			tbl_customer.user_last_login,
			tbl_customer.reward_point,
			tbl_customer_type.cl_type_description as customer_type,
			tbl_status.stat_desc as user_stat,
			tbl_shipping_costs.location as city,
			tbl_country.country_desc as country
		FROM 
			tbl_customer						
			LEFT JOIN tbl_customer_type ON  tbl_customer_type.cl_type = tbl_customer.customer_type
			LEFT JOIN tbl_status ON  tbl_status.stat_id = tbl_customer.user_stat
			LEFT JOIN tbl_shipping_costs ON  tbl_shipping_costs.id = tbl_customer.city
			LEFT JOIN tbl_country ON  tbl_country.id = tbl_customer.country
		WHERE cl_id = $cl_id";
$rSeNTlist1=mysqli_query($conn,$SeNTlist1) or die();
$data = mysqli_fetch_assoc($rSeNTlist1);
extract($data);

?>
<style>
    p{
        margin:0px;
    }
</style>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">
                    <div class="customerInfoDetail">
                    <h3><?php echo $firstname.' '.$lastname;?></h3>
                    <div class="row">
                        <div class="col-lg-3">
                            <table>
                                <tr>
                                    <td>Address: </td>
                                    <td><strong><?php echo $address; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Street: </td>
                                    <td><strong><?php echo $street; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>City: </td>
                                    <td><strong><?php echo  $city; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Postal Code: </td>
                                    <td><strong><?php echo  $postal_code; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Province: </td>
                                    <td><strong><?php echo  $province; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Country: </td>
                                    <td><strong><?php echo  $country; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Company: </td>
                                    <td><strong><?php echo  $company; ?></strong></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-3">
                            <table>
                                <tr>
                                    <td>Mobile:</td>
                                    <td><strong><?php echo  $phone; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Country:</td>
                                    <td><strong><?php echo  $country; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Fax:</td>
                                    <td><strong><?php echo  $fax; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td><strong><?php echo  $email; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Reg. date:</td>
                                    <td><strong><?php echo  $user_regdate; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Last Login:</td>
                                    <td><strong><?php echo  $user_last_login; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Customer Type:</td>
                                    <td><strong><?php echo  $customer_type; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Status:</td>
                                    <td><strong><?php echo  $user_stat; ?></strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    </div>
                    <h4>Customer Orders</h4>
                    <table class="table table-bordered">
                        <tr>
                            <th>Order No.</th>
                            <th>Order Date</th>
                            <th>Order Status</th>
                            <th>Total Cost</th>
                            <th>Payment Status</th>
                        </tr>
                        <?php 
                        $orSql = "SELECT tbl_order.* FROM tbl_order WHERE tbl_order.cl_id = $cl_id";
                        $res = mysqli_query($conn, $orSql);
                        while($orders = mysqli_fetch_assoc($res)){
                        ?>
                        <tr>
                            <td><?php echo $orders['od_no']; ?></td>
                            <td><?php echo $orders['od_date']; ?></td>
                            <td><?php echo $orders['od_status']; ?></td>
                            <td><?php echo $orders['total_cost']; ?></td>
                            <td><?php echo $orders['payment_status'] == 1 ? "paid" : 'unpaid'; ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                    
                    <button class="btn btn-sm btn-primary" onclick="view_data()">Back</button>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>
