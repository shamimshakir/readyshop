<?php include('../header.php');
$mode = 1;

if(isset($_REQUEST['od_id'])){
    $od_id=$_REQUEST['od_id'];
    $mode = 2;
    $SeNTlist = "SELECT * FROM tbl_order WHERE od_id = '$od_id' ";
    $ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error($conn));
    $rowNewsTls=mysqli_num_rows($ExSeNTlist);
    while($rowNewsTl=mysqli_fetch_array($ExSeNTlist)){
        extract($rowNewsTl);
    }
}
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <?php if ($_POST['mode'] == '1'){ ?>
                        <h4 id="myModalLabel">New Order</h4>
                    <?php } if ($_POST['mode'] == '2'){ ?>
                        <h4 id="myModalLabel">Edit Order</h4>
                    <?php }?>


                    <form id="orderForm" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="od_id" value="<?php  if($mode==2){echo $od_id;}?>">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="cl_id">Client</label>
                                <?php
                                echo "<select name='cl_id' id='cl_id' class='form-control'>";
                                createCombo("Client","tbl_customer","cl_id","cl_pin","ORDER BY cl_pin ",$cl_id);
                                echo "</select>";
                                ?>
                            </div>
                            <?php if ($mode==1){ ?>
                            <div class="col-md-4">
                                <label for="od_date">Order Date</label>
                                <input type="date" name="od_date" id="od_date" value="<?php echo $od_date; ?>" class="form-control" maxlength="35" />
                            </div>
                            <?php } ?>Order
                            <div class="col-md-4">
                                <label for="od_payment_first_name">Name</label>
                                <input type="text" name="od_payment_first_name" id="od_payment_first_name" class="form-control" value="<?php echo $od_payment_first_name; ?>" >
                            </div>
                        </div>

                        <h4>Order Details</h4>

                        <div class="row">
                            <div class="col-md-3">
                                <label for="total_cost">Order Amount</label>
                                <input type="text" name="total_cost" id="total_cost" class="form-control" value="<?php echo $total_cost; ?>" Maxlength="50" >
                            </div>
                            <div class="col-md-3">
                                <label for="od_payment_amount">Received Amount </label>
                                <input type="text" name="od_payment_amount" id="od_payment_amount" class="form-control" value="<?php echo $od_payment_amount; ?>" Maxlength="50" >
                            </div>
                            <div class="col-md-3">
                                <label for="od_status">Order Status </label>
                                <?php
                                echo "<select name='od_status' id='od_status' class='form-control'>";
                                createCombo("Order Status","tbl_order_status","ord_status","ord_status","ORDER BY ord_status ",$od_status);
                                echo "</select>";
                                ?>
                            </div>
                            <div class="col-md-3">
                                <label for="od_receive_date">Receive date</label>
                                <input type="date" name="od_receive_date" id="od_receive_date" class="form-control" value="<?php echo $od_receive_date; ?>" Maxlength="50" >
                            </div>
                        </div>
                        <div class="form-group mt-2 mb-0 d-flex justify-content-end">
                            <div>
                                <button type="button" class="btn btn-secondary waves-effect" onclick="view_data()">Cancel</button>
                                <?php if ($mode == 1){ ?>
                                    <button type="button" onclick="save()" class="btn btn-primary waves-effect waves-light mr-1">Save</button>
                                <?php }elseif($mode == 2){ ?>
                                    <button type="button" onclick="save()" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                                <?php }?>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function save() {
        $.ajax({
            type: "POST",
            url: "pages/order/order_save.php",
            data: $('#orderForm').serialize()
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
</script>
