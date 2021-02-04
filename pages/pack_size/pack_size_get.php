<?php include('../header.php');
    $SUserID =$_SESSION[ "user_profile_id" ];
    $pageid = pick('_tree_entries', 'id', "file_name = 'pack_size.php'");
    $addper=PermissionVerification($SUserID,$pageid,'add');
    $editper=PermissionVerification($SUserID,$pageid,'edit');
?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Pack size</span>
                        <?php if($addper>0){?><span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span><?php } ?>
                    </h4>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Weight</th>
                            <th>Height</th>
                            <th>Width</th>
                            <th>Lenght</th>
                            <th>Cubic</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM tbl_pack_size";
                        $res = mysqli_query($conn, $sql);
                        $i = 0;
                        while ($ress = mysqli_fetch_array($res)){
                            extract($ress);
                            ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $packweight; ?></td>
                                <td><?php echo $packheight; ?></td>
                                <td><?php echo $packwidth; ?></td>
                                <td><?php echo $packlength; ?></td>
                                <td><?php echo $cubicsize; ?></td>
                                <td><?php
                                    if ( $status == 1 ) {
                                      ?>
                                      <span class="badge badge-pill badge-success" id="pd_status"  >Active</span><br>
                                      <?php }else{ ?>
                                      <span class="badge badge-pill badge-danger" id="pd_status" >Inactive</span><br>
                                      <?php }  ?>
                                </td>
                                <td>
                                    <div>
                                        <input type="checkbox" id="switch<?php echo $i;?>" switch="none"  value="1" onclick="update_status(<?php echo $ct_id;?>)" 
                                            <?php if ( $status == 0 ) { echo "checked";}else{ }?>
                                            >
                                        <label for="switch<?php echo $i;?>" data-on-label="On" data-off-label="Off" ></label>
                                    </div>
                                </td>
                                <td>
                                    <?php if($editper>0){?>
                                    <button class="btn btn-primary btn-xs" onclick="edit(<?php echo $ct_id;?>)">
                                        <i class="mdi mdi-grease-pencil"></i> Edit
                                    </button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
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
            url: "pages/pack_size/packsize_form.php",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }    
    function edit(ct_id) {
        $.ajax({
            type: "POST",
            url: "pages/pack_size/packsize_form.php",
            data: {
                mode: 2,
                ct_id : ct_id
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
                table: "tbl_pack_size",
                idField: "ct_id",
                id: id,
                status: "status"
            },
            success: function (response){
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
            }
        });
    }
</script>