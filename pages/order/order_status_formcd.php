<?php include('../header.php');
extract($_POST);
$res = mysqli_query($conn, "SELECT od_status, status_change_comment FROM tbl_order WHERE od_id = '$od_id'");
$row = mysqli_fetch_assoc($res);
$od_status = $row['od_status'];
$status_change_comment = $row['status_change_comment'];
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
                                createCombo("Order Status","tbl_order_status","ord_status","ord_status","ORDER BY id",$od_status);
                                echo "</select>"; ?>
                            </div>
                            <div class="col-md-12">
                                <label for="od_status">Status Change Comments</label>
                                <textarea name="status_change_comment" id="status_change_comment" rows="5" class="form-control"><?php echo $status_change_comment; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group mt-2 mb-0 d-flex justify-content-end">
                            <div>
                                <button type="button" class="btn btn-secondary waves-effect" onclick="view_datacd()">Cancel</button>
                                <button type="button" onclick="order_status_update()" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                            </div>
                        </div>
                    </form>

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
            view_datacd();
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
</script>
