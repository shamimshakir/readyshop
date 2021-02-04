<?php
include( '../header.php' );
$SUserID = $_SESSION[ "user_profile_id" ];
$pageid = pick( '_tree_entries', 'id', "file_name = 'banner.php'" );
$addper = PermissionVerification( $SUserID, $pageid, 'add' );
$editper = PermissionVerification( $SUserID, $pageid, 'edit' );
?>
<div id="mainContent">
  <div class="row">
    <div class="col-12">
      <div class="card m-b-20">
        <div class="card-body" id="card-body">
          <h4 class="mt-0 header-title d-flex justify-content-between"> <span>Advertisement Banner</span>
            <?php if($addper>0){?>
            <span>
            <button class="btn btn-primary" onclick="add()">Add new</button>
            </span>
            <?php } ?>
          </h4>
          <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
              <tr>
                <th>Sl</th>
                <th>Title</th>
                <th>Company URL</th>
                <th>Company Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Action</th>
                <th>Image</th>
                <th class="td-actions">Edit</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $res = mysqli_query( $conn, "SELECT * FROM tbl_banner" );
              $i = 1;
              while ( $row = mysqli_fetch_array( $res ) ) {
                extract( $row );
                ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $row['title'];?></td>
                <td><?php echo $row['comp_url'];?></td>
                <td><?php echo $row['comp_name'];?></td>
                <td><?php echo $row['start_date'];?></td>
                <td><?php echo $row['end_date'];?></td>
                <td><?php
                if ( $active_status == 1 ) {
                  ?>
                  <span class="badge badge-pill badge-success" id="pd_status"  >Active</span><br>
                  <?php }else{ ?>
                  <span class="badge badge-pill badge-danger" id="pd_status" >Inactive</span><br>
                  <?php }  ?></td>
                <td><div>
                    <input type="checkbox" id="switch<?php echo $i;?>" switch="none"  value="1" onclick="update_status(<?php echo $id;?>)" 
                                            <?php if ( $active_status == 0 ) { echo "checked";}else{ }?>
                                            >
                    <label for="switch<?php echo $i;?>" data-on-label="On" data-off-label="Off" ></label>
                  </div></td>
                <td><img style="height: 50px; max-width: 100px;" src="uploads/banner/<?php echo $row['image'];?>" alt=""></td>
                <td><?php if($editper>0){?>
                  <button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['id'];?>)"> <i class="mdi mdi-grease-pencil"></i> Edit </button>
                  <?php } ?></td>
              </tr>
              <?php $i++; } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- end col --> 
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
            url: "pages/banner/banner_form.php",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/banner/banner_form.php",
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
                table: "tbl_banner",
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