<?php
include( '../header.php' );
extract( $_POST );
$res = mysqli_query( $conn, "SELECT od_status, status_change_comment FROM tbl_order WHERE od_id = '$od_id'" );
$row = mysqli_fetch_assoc( $res );
$od_status = $row[ 'od_status' ];
$status_change_comment = $row[ 'status_change_comment' ];
//echo $od_status;
?>
<div id="mainContent">
  <div class="row">
    <div class="col-lg-6 offset-lg-3">
      <div class="card m-b-20 pt-3">
        <div class="card-body">
          <h5>Change Order Status</h5>
          <form id="order_status_Form" class="" action="#" novalidate="">
            <input type="hidden" name="od_id" value="<?php echo $od_id; ?>">
            <div class="row">
              <div class="col-md-12">
                <label for="od_status">Order Status </label>
                <?php echo "<select name='od_status' id='od_status' class='form-control'>";
                createCombo( "Order Status", "tbl_order_status", "id", "ord_status", " WHERE id > {$od_status} ORDER BY id ASC", $od_status );
                echo "</select>";
                ?> </div>
              <div class="col-md-12">
                <label for="od_status">Status Change Comments</label>
                <textarea name="status_change_comment" id="status_change_comment" rows="5" class="form-control"><?php echo $status_change_comment; ?></textarea>
              </div>
            </div>
            <div class="form-group mt-2 mb-0 d-flex justify-content-end">
              <div>
                <button type="button" class="btn btn-secondary waves-effect" onclick="view_data()">Cancel</button>
                <button type="button" onclick="order_status_update()" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
              </div>
            </div>
          </form>
          <h5>History</h5>
          <table class="table table-bordered table-conenced">
            <thead>
              <tr>
                <th>Status</th>
                <th>Comments</th>
                <th>Change Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT 
	`od_id`, 	
	`comments`, 
	`update_by`, 
	`update_date`, 
	tbl_order_status.ord_status
    FROM 
	`tbl_order_history` 
	left JOIN tbl_order_status ON tbl_order_status.id = tbl_order_history.status 
							WHERE `od_id` ='$od_id'";
              $ExSeNTlist = mysqli_query( $conn, $sql )or die( mysqli_error() );
              $rowNewsTls = mysqli_num_rows( $ExSeNTlist );
              while ( $rowNewsTl = mysqli_fetch_array( $ExSeNTlist ) ) {
                extract( $rowNewsTl );
                ?>
              <tr>
                <td><?php echo $ord_status;?></td>
                <td><?php echo $comments;?></td>
                <td><?php echo $update_date;?></td>
              </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script>

    function order_status_update() {
        $.ajax({
            type: "POST",
            url: "pages/order/order_status_update.php",
            data: $('#order_status_Form').serialize()
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
            console.log(response)
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
</script> 
