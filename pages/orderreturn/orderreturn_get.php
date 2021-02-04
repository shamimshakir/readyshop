<?php include('../header.php')?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Brands</span>
<!--                        <span>-->
<!--                            <a class="btn btn-primary" href="brand_form.php" data-loc='pages/brands'>Add new</a>-->
<!--                        </span>-->
                    </h4>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Od_No</th>
                            <th>Product</th>
                            <th>Order Qty</th>
                            <th>Product Price</th>
                            <!-- <th class="td-actions">Acitons</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = mysqli_query($conn, "SELECT
			tbl_order.od_id as od_id,
			tbl_order.od_no as od_no,
			tbl_product.pd_name as pd_id,
			tbl_order_item.pd_id as tpd_id,
			tbl_order_item.od_qty,
			tbl_order_item.pd_price,
			tbl_order_item.hst,
			tbl_order_item.reward_point_avail,
			tbl_order_item.upscharge,
			tbl_order_item.rec_amnt,
			tbl_order_item.rec_remarks,
			tbl_order_item.rec_date,
			tbl_order_item.rec_by,
			tbl_order_item.rec_status,
			tbl_order_item.return_qty,
			tbl_order_item.return_amnt,
			tbl_order_item.return_point,
			tbl_order_item.return_date
		FROM 
			tbl_order_item						
			LEFT JOIN tbl_order ON  tbl_order.od_id = tbl_order_item.od_id
			LEFT JOIN tbl_product ON  tbl_product.pd_id = tbl_order_item.pd_id");
                        $i = 1;
                        while ($row = mysqli_fetch_array($res)) { extract($row); ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $row['od_no'];?></td>
                                <td><?php echo $row['pd_id'];?></td>
                                <td><?php echo $row['od_qty'];?></td>
                                <td><?php echo $row['pd_price'];?></td>
                                <!-- <td>
			<button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['vendor_id'];?>)" data-toggle="modal" data-target="#myModal">
				<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
			</button>
		</td> -->
                            </tr>

                            <?php $i++; } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>

<script>
    function edit(brand_id) {
        $.ajax({
            type: "POST",
            url: "pages/brands/brand_form.php",
            data: {
                mode: 2,
                brand_id : brand_id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
</script>