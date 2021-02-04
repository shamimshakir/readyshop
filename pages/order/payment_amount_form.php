<?php include('../header.php');

extract($_POST);
$res = mysqli_query($conn, "SELECT payment_status,od_payment_date,od_payment_update_by FROM tbl_order WHERE od_id = '$od_id'");
$row = mysqli_fetch_assoc($res);
extract($row);
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card m-b-20">
                <div class="card-body">
                    <h5 id="myModalLabel">Change Payment Amount</h5>
                    <form id="order_amount_Form" class="" action="#" novalidate="">
                        <input type="hidden" name="od_id" value="<?php echo $od_id; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="total_cost">Payment Status</label>
                                <select class="form-control" name="payment_status" id="payment_status">
                                    <option>Select status</option>
                                    <option value='1' <?php if($payment_status==1){echo "selected"; } ?>>Paid</option>
                                    <option value='0' <?php if($payment_status==0){echo "selected"; } ?>>Unpaid</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="total_cost">Payment date</label>
                                <input type="date" name="od_payment_date" id="od_payment_date" class="form-control" value="<?php  echo date('Y-m-d', time()); ?>" >
                               
                            </div>
                            <div class="col-md-12">
                                
                                <input type="hidden" name="od_payment_update_by" id="od_payment_update_by" class="form-control" value="<?php echo $_SESSION['SUserID']; ?>" >
                               
                            </div>
                        </div>
                        <div class="form-group mt-2 mb-0 d-flex justify-content-end">
                            <div>
                                <button type="button" class="btn btn-secondary waves-effect" onclick="view_data()">Cancel</button>
                                <button type="button" onclick="payment_amount_update()" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


<script>

    function payment_amount_update() {
        $.ajax({
            type: "POST",
            url: "pages/order/payment_amount_update.php",
            data: $('#order_amount_Form').serialize()
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
</script>
