
<?php include('../header.php')?>


<div class="row">
    <div class="col-12">
        <div class="card m-b-20">
            <div class="card-body" id="card-body">
                <h4 class="mt-0 header-title d-flex justify-content-between">
                    <span>Reward Point</span>
                </h4>
                    <form id="reportForm">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="txtpd_id">Product</label>
                                <select name='txtpd_id' id='txtpd_id' class="form-control">
                                    <?php createCombo("Product","tbl_product","pd_id","pd_name","ORDER BY pd_name ",""); ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="txtpick_loc_id">Pickup Location</label>
                                <select name='txtpick_loc_id' id='txtpick_loc_id' class="form-control">
                                    <?php createCombo("Pickup Location","tbl_pickup_location","loc_id","location","ORDER BY location ",""); ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="txtfromrec_date">Receive date From</label>
                                <input type="date" class="form-control" name="txtfromrec_date" id="txtfromrec_date" value="<?php echo $fromrec_date; ?>" />
                            </div>
                            <div class="col-lg-2">
                                <label for="txttorec_date">To</label>
                                <input type="date" name="txttorec_date" class="form-control" id="txttorec_date" value="<?php echo $torec_date; ?>" />
                            </div>
                            <div class="col-lg-2">
                                <input value='Show Report' type='button' name='btnsubmit' class='btn btn-primary' style="margin-top: 27px;" onclick='sendData()'>
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
            url: "pages/rpt_reward_point/rpt_reward_point_get.php",
            data: $('#reportForm').serialize()
        }).done(function(msg) {
            console.log(msg)
            $("#mainContent").html(msg);
        }).fail(function() {
            alert("error");
        });
    }
</script>



