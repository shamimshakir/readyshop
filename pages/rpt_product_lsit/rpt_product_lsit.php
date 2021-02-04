
<?php include('../header.php')?>


<div class="row">
    <div class="col-12">
        <div class="card m-b-20">
            <div class="card-body" id="card-body">
                <h4 class="mt-0 header-title d-flex justify-content-between">
                    <span>Product List</span>
                </h4>
                <form id="reportForm" class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="s_cat_id">Select Category</label>
                            <select name='s_cat_id' id='s_cat_id' class="form-control" onchange="productOptionByCat(this.value)">
                                <?php createCombo("Category","tbl_category","cat_id","cat_name","ORDER BY cat_name ",$cat_id); ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Select Product</label>
                                <select class="form-control select2 s_product_id" name='s_product_id' id='s_product_id'>
                                    <option value="-1">Select category first</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input value='Show Report'  type='button' name='btnsubmit' class='mt-3 btn btn-primary forms_button_e' onclick='sendData()'>
                        </div>
                    </div>


                </form>

                <div id="mainContent" class="mt-5"></div>
            </div>
        </div>
    </div>
</div>


<script>
    function sendData(){
        $.ajax({
            type: "POST",
            url: "pages/rpt_product_lsit/rpt_product_lsit_get.php",
            data: $('#reportForm').serialize()
        }).done(function(msg) {
            console.log(msg)
            $("#mainContent").html(msg);
        }).fail(function() {
            alert("error");
        });
    }
    
    function productOptionByCat(cat) {
        $.ajax({
            type: "POST",
            url: "pages/rpt_product_lsit/get_product_by_cat.php",
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



