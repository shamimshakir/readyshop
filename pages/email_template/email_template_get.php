<?php
include( '../header.php' );
$SUserID = $_SESSION[ "user_profile_id" ];
$pageid = pick( '_tree_entries', 'id', "file_name = 'email_template.php'" );
$addper = PermissionVerification( $SUserID, $pageid, 'add' );
$editper = PermissionVerification( $SUserID, $pageid, 'edit' );
?>
<div id="mainContent">
  <div class="row">
    <div class="col-12">
      <div class="card m-b-20">
        <div class="card-body" id="card-body">
          <h4 class="mt-0 header-title d-flex justify-content-between"> <span>Email Templates</span>
            <?php if($addper>0){?>
            <span> <a class="btn btn-primary" href="email_template_form.php" data-loc='pages/email_template'>Add new</a> </span>
            <?php } ?>
          </h4>
          <table id="datatable" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
              <tr>
                <th>Sl</th>
                <th>Title</th>
                <th>Subject</th>
                <th>Body</th>
                <th>Status</th>
                <th>Action</th>
                <th width="10%">Edit</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $res = mysqli_query( $conn, "SELECT * FROM email_template" );
              $i = 1;
              while ( $row = mysqli_fetch_array( $res ) ) {
                extract( $row );
                ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $row['title'];?></td>
                <td><?php echo $row['subject'];?></td>
                <td><?php echo  strip_tags($row['body']);?></td>
                <td><?php
                if ( $status == 1 ) {
                  ?>
                  <span class="badge badge-pill badge-success" id="pd_status"  >Active</span><br>
                  <?php }else{ ?>
                  <span class="badge badge-pill badge-danger" id="pd_status" >Inactive</span><br>
                  <?php }  ?></td>
                <td><div>
                    <input type="checkbox" id="switch<?php echo $i;?>" switch="none"  value="1" onclick="update_status(<?php echo $email_template_id.','.$status?>)" 
						   <?php if ( $status == 0 ) { echo "checked";}else{ }?>
						   >
                    <label for="switch<?php echo $i;?>" data-on-label="On" data-off-label="Off" ></label>
                  </div></td>
                <td><?php if($editper>0){?>
                  <button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['email_template_id'];?>)" > <i class="mdi mdi-grease-pencil"></i> Edit </button>
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
<?php include('../footer.php')?>
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
    function edit(email_template_id) {
        $.ajax({
            type: "POST",
            url: "pages/email_template/email_template_form.php",
            data: {
                mode: 2,
                email_template_id : email_template_id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
	function update_status(id,ststus) {
        $.ajax({
            type: "POST",
            url: "pages/email_template/email_config_status_update.php",
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
