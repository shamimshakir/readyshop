<?php
include( '../header.php' );

?>

<div id="mainContent">
  <div class="row">
    <div class="col-lg-6 offset-lg-3">
      <div class="card m-b-20">
        <div class="card-body" id="card-body">
          <h4 class="mt-0 header-title d-flex justify-content-between"> <span>Homepage Config</span> <span> <!--<a class="btn btn-primary" href="shop_setup_form.php" data-loc='pages/shop_setup'>Add new</a>--> </span> </h4>
          <table class="table table-bordered dt-responsive nowrap " >
            <thead>
              <tr>
                <th>Sl</th>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $res = mysqli_query( $conn, "SELECT * FROM tbl_home_page_config " );
              $i = 1;
              while ( $row = mysqli_fetch_array( $res ) ) {
                extract( $row );
                ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $name;?></td>
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
                    <input type="checkbox" id="switch<?php echo $i;?>" switch="none"  value="1" onclick="update_status(<?php echo $id.','.$status?>)" 
						   <?php if ( $status == 0 ) { echo "checked";}else{ }?>
						   >
                    <label for="switch<?php echo $i;?>" data-on-label="On" data-off-label="Off" ></label>
                    
                  </div>
                </td>
              </tr>
              <?php $i++; } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- end col --> 
  </div>
	<?php include('../footer.php')?>
</div>

<script>
	
    function update_status(id,ststus) {
        $.ajax({
            type: "POST",
            url: "pages/home_page_config/home_page_config_status_update.php",
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