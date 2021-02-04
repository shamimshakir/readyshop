<?php include('../header.php');
    $SUserID = $_SESSION[ "user_profile_id" ];
     $pageid = pick('_tree_entries', 'id', "file_name = 'social_links.php'");
    $addper=PermissionVerification($SUserID,$pageid,'add');
    $editper=PermissionVerification($SUserID,$pageid,'edit');
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Social Links</span>
                        <?php if($addper>0){?><span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span><?php } ?>
                    </h4>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Social Name</th>
                            <th>URL</th>
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM tbl_social_links";
                        $res = mysqli_query($conn, $sql);
                        $i = 0;
                        while ($socials = mysqli_fetch_assoc($res)){
                            extract($socials);
                            ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $socials['social_name']; ?></td>
                                <td><?php echo $socials['url']; ?></td>
                                <td><?php echo $socials['icon']; ?></td>
                                <td><?php if ( $active_status == 1 ) { ?>
                                      <span class="badge badge-pill badge-success">Active</span><br>
                                      <?php }else{ ?>
                                      <span class="badge badge-pill badge-danger">Inactive</span><br>
                                      <?php }  ?> </td>
                                <td>
                                     <div>
                                        <input type="checkbox" id="switch<?php echo $i;?>" switch="none"  value="1" onclick="update_status(<?php echo $id; ?>)" 
                                            <?php if ( $active_status == 0 ) { echo "checked";}else{ }?>
                                            >
                                        <label for="switch<?php echo $i;?>" data-on-label="On" data-off-label="Off" ></label>
                                    </div>
                                </td>
                                <td>
                                    <?php if($editper>0){?><button class="btn btn-primary btn-xs" onclick="edit(<?php echo $socials['id'];?>)" > Edit
                                    </button><?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
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
    function add() {
        $.ajax({
            type: "POST",
            url: "pages/social_links/social_links_form.php",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/social_links/social_links_form.php",
            data: {
                mode: 2,
                id : id,
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
                table: "tbl_social_links",
                idField: "id",
                id: id,
                status: "active_status"
            },
            success: function (response){
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
            }
        });
    }
</script>