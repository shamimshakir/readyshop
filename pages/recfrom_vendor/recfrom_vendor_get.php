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
                            <th>Vendor Name	</th>
                            <th>Received Date</th>
                            <th>Amount</th>
                            <th>Remarks</th>
                            <!-- <th class="td-actions">Acitons</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = mysqli_query($conn, "SELECT
			tbl_recfrom_vendor.recieved_id,
			tbl_pickup_location.location as vendor_id,
			DATE_FORMAT(tbl_recfrom_vendor.rec_date,'%m/%d/%Y') as rec_date,
			tbl_recfrom_vendor.rec_amnt,
			tbl_recfrom_vendor.rec_remarks,
			tbl_recfrom_vendor.entry_by,
			tbl_recfrom_vendor.entry_date
		FROM 
			tbl_recfrom_vendor						
			LEFT JOIN tbl_pickup_location ON  tbl_pickup_location.loc_id = tbl_recfrom_vendor.vendor_id ");
                        $i = 1;
                        while ($row = mysqli_fetch_array($res)) { extract($row); ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $row['vendor_id'];?></td>
                                <td><?php echo $row['rec_date'];?></td>
                                <td><?php echo $row['rec_amnt'];?></td>
                                <td><?php echo $row['rec_remarks'];?></td>
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