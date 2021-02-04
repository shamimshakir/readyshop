
<?php include('../header.php')?>

<div id='mainContent'> 
<div class="row">
    <div class="col-12">
        <div class="card m-b-20">
            <div class="card-body" id="card-body">
                <h4 class="mt-0 header-title d-flex justify-content-between">
                    <span>Order List</span>
                </h4>
                    <form id="reportForm" class="form-group">
                        <div class="row">
                            <div class="col-lg-2">
                                <label for="txtod_status">Status</label>
                                <select name='txtod_status' id='txtod_status' class="form-control">
                                    <?php createCombo("Order","tbl_order_status","ord_status","ord_status","WHERE id IN (5,6) ORDER BY id DESC",$ord_status); ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="txtc_id">Customer</label>
                                <select name='txtc_id' id='txtc_id' class="form-control">
                                    <?php createCombo("Customer","tbl_customer","cl_id","firstname","ORDER BY firstname ",$cl_id); ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="txtfromrec_date" >From</label>
                                <input type="date" class="form-control" name="txtfromrec_date" id="txtfromrec_date" value="<?php echo $fromrec_date; ?>" />
                            </div>
                            <div class="col-lg-2">
                                <label for="txttorec_date">To</label>
                                <input type="date" class="form-control" name="txttorec_date" id="txttorec_date" value="<?php echo $torec_date; ?>" />
                            </div>
                            <div class="col-lg-2">
                                <label for="txtod_no">Order No</label>
                                <input class="form-control" name="txtod_no" id="txtod_no">
                            </div>
                            <div class="col-lg-2">
                                <input value='Show Report' type='button' name='btnsubmit' class='forms_button_e btn btn-primary' style="margin-top: 22px;" onclick='sendData()'>
                            </div>
                        </div>
                    </form>
                <div id="loadContetn" class="mt-5" style="overflow-x:auto;"></div>
            </div>
        </div>
    </div>
</div>
  </div>  


<script>
    function sendData(){
        $.ajax({
            type: "POST",
            url: "pages/rpt_salesreturn_lists/rpt_salesreturn_lists_get.php",
            data: $('#reportForm').serialize()
        }).done(function(msg) {
            $("#loadContetn").html(msg);
        }).fail(function() {
            alert("error");
        });
    }
    sendData();
    function show_details(od_id){
        $.ajax({
            type: "POST",
            url: "pages/rpt_salesreturn_lists/rpt_salesreturn_lists_details.php",
            data: {
                od_id: od_id
            }
        }).done(function(msg) {
            console.log(msg)
            $("#mainContent").html(msg);
            $("#reportForm").hide();
        }).fail(function() {
            alert("error");
        });
    }
</script>



