<?php include('../header.php');
    $SUserID =$_SESSION[ "user_profile_id" ];
    $pageid = pick('_tree_entries', 'id', "file_name = 'email_setup.php'");
    $addper=PermissionVerification($SUserID,$pageid,'add');
    $editper=PermissionVerification($SUserID,$pageid,'edit');
?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Email Setup</span>
                    </h4>

                    <table id="datatable" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Port</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>SMTPAuth</th>
                                <th>Host</th>
                                <th>SMTPsecure</th>
								<th>Status</th>
								<th>Action</th>
								<th width="10%">Edit</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = mysqli_query($conn, "SELECT * FROM tbl_emailsetup");
                            $i = 1;
                            while ($row = mysqli_fetch_array($res)) { extract($row); ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $row['name'];?></td>
                                    <td><?php echo $row['port'];?></td>
                                    <td><?php echo $row['Username'];?></td>
                                    <td><?php echo $row['Password'];?></td>
                                    <td><?php echo $row['SMTPAuth'];?></td>
                                    <td><?php echo $row['Host'];?></td>
                                    <td><?php echo $row['SMTPSecure'];?></td>
									<td><?php
								if ( $status == 1 ) {
								  ?>
								  <span class="badge badge-pill badge-success" id="pd_status"  >Active</span><br>
								  <?php }else{ ?>
								  <span class="badge badge-pill badge-danger" id="pd_status" >Inactive</span><br>
								  <?php }  ?></td>
								<td><div>
									<input type="checkbox" id="switch<?php echo $i;?>" switch="none"  value="1" onclick="update_status(<?php echo $row['id'].','.$row['status']?>)" 
										   <?php if ( $status == 0 ) { echo "checked";}else{ }?>
										   >
									<label for="switch<?php echo $i;?>" data-on-label="On" data-off-label="Off" ></label>
								  </div></td>
                                    <td>
                                        <?php if($editper>0){?><button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['id'];?>)" >
                                            <i class="mdi mdi-grease-pencil"></i> Edit
                                        </button><?php } ?>
                                    </td>

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
		$('#datatable').DataTable(
		{
			"searching": true,
			"stateSave": true,
			"pageLength": 100,
			"responsive": true,
			"bLengthChange": true,
		}
		);
	} );
    function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/email_setup/email_setup_form.php",
            data: {
                mode: 2,
                id : id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
	function update_status(id,ststus) {
        $.ajax({
            type: "POST",
            url: "pages/email_setup/email_config_status_update.php",
            data: {
                id : id,
				ststus:ststus
            },
            success: function (response){
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
            }
        });
    }
</script>
