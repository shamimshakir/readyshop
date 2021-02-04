
<?php include('../header.php')?>


<div class="row">
    <div class="col-12">
        <div class="card m-b-20">
            <div class="card-body" id="card-body">
                <h4 class="mt-0 header-title d-flex justify-content-between">
                    <span>Store In</span>
                </h4>
                <form id="reportForm">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="client_id">Vendor </label>
                            <?php echo "<select name='client_id' id='client_id' class='form-control' required>";
                                createCombo("Vendor","tbl_vendor","vendor_id","vendor_name","ORDER BY vendor_name ",$client_id);
                            echo "</select>"; ?>
                        </div>
                        <div class="col-md-3">
                            <label for="txtpd_id">Category</label>
                            <select name='txtcat_id' id='txtcat_id' class="form-control" onchange="productOptionByCat(this.value)">
                                <?php createCombo("Category","tbl_category","cat_id","cat_name","ORDER BY cat_name ",$cat_id); ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Select Product</label>
                            <select class="form-control select2 s_product_id" name='s_product_id' id='s_product_id'>
                                <option value="">Select category first</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <label class="control-label">Bill No.</label>
                            <input class="form-control" name='bill_no' id="bill_no" />
                        </div>
                        <div class="col-md-3">
                            <label for="txtfromentry_date">Received date From</label>
                            <input type="date" class="form-control" name="txtfromentry_date" id="txtfromentry_date" value="<?php echo $fromentry_date; ?>"/>
                        </div>
                        <div class="col-md-3">
                            <label for="txttoentry_date">To</label>
                            <input type="date" class="form-control" name="txttoentry_date" id="txttoentry_date" value="<?php echo $toentry_date; ?>" />
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary" style="margin-top: 20px;" onclick='sendData()'>Show Report</button>
                        </div>
                    </div>
                </form>
                <div id="mainContent" class="mt-5" style="overflow-x:auto;"></div>
            </div>
        </div>
    </div>
</div>


<?php include('../footer.php')?>
<script>
    function sendData(){
        $.ajax({
            type: "POST",
            url: "pages/rpt_product_receive/rpt_product_receive_get.php",
            data: $('#reportForm').serialize()
        }).done(function(msg) {
            $("#mainContent").html(msg);
        }).fail(function() {
            alert("error");
        });
    }
    function productOptionByCat(cat) {
        $.ajax({
            type: "POST",
            url: "pages/rpt_product_receive/get_product_by_cat.php",
            data: {
                cat_id: cat
            }
        }).done(function(msg) {
            $("#s_product_id").html(msg);
        }).fail(function() {
            alert("error");
        });
    }
    $(document).ready(function() {
        $('.s_product_id').select2();
    });
</script>



