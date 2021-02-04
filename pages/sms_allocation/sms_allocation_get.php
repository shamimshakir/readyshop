<?php include('../header.php');
    $SUserID =$_SESSION[ "user_profile_id" ];
    $pageid = pick('_tree_entries', 'id', "file_name = 'product_color.php'");
    $addper=PermissionVerification($SUserID,$pageid,'add');
    $editper=PermissionVerification($SUserID,$pageid,'edit');
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>SMS Allocation</span>
                        <?php if($addper>0){?><span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span><?php } ?>
                    </h4>

                    <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>#SL</th>
								<th>Name</th>
								<th>Amount</th>    
								<th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = mysqli_query($conn, "SELECT
									 tbl_sms_allocation_details.`allocate_ammount`,
									 tbl_sms_allocation_details.`allocation_date`,
									  tbl_sms_allocation.name
									FROM
									  `tbl_sms_allocation_details`
									LEFT JOIN tbl_sms_allocation ON tbl_sms_allocation.id=tbl_sms_allocation_details.name
									ORDER BY
									  allocation_date DESC");
                            $i = 1;
                            while ($row = mysqli_fetch_array($res)) { extract($row); ?>
                                <tr>
                                   <td><?php echo $i;?></td>
									<td><?php echo $row['name'];?></td>
								   <td><?php echo $row['allocate_ammount'];?></td>
								   <td><?php echo $row['allocation_date'];?></td>
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
	$(document).ready(function() {
    	$('#datatable').DataTable({
			"searching": true,
			"stateSave": true,
			"pageLength": 100,
			"bLengthChange": true,
		});
	});
    function add() {
        $.ajax({
            type: "POST",
            url: "pages/sms_allocation/sms_allocation_form.php",
            data: { },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function edit(color_id) {
        $.ajax({
            type: "POST",
            url: "pages/sms_allocation/sms_allocation_form.php",
            data: {
                mode: 2,
                color_id : color_id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }

    function update_status(id) {
        $.ajax({
            type: "POST",
            url: "pages/update_status_ajax.php",
            data: {
                table: "tbl_color",
                idField: "color_id",
                id: id,
                status: "color_status"
            },
            success: function (response){
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
            }
        });
    }

</script>