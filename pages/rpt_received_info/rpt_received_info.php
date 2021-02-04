
<?php include('../header.php')?>


<div class="row">
    <div class="col-12">
        <div class="card m-b-20">
            <div class="card-body" id="card-body">
                <h4 class="mt-0 header-title d-flex justify-content-between">
                    <span>Product received information</span>
                </h4>
                <form id="reportForm">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="txtpick_loc_id">Pick Up Location</label>
                            <select name='txtpick_loc_id' id='txtpick_loc_id' class="form-control">
                                <?php createCombo("Pick Up Location","tbl_pickup_location","loc_id","location","ORDER BY location ",$pick_loc_id); ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="txtfromrec_date">Rec. Date From</label>
                            <input type="date" class="form-control" name="txtfromrec_date" id="txtfromrec_date" value="<?php echo $fromrec_date; ?>" />
                        </div>
                        <div class="col-md-3">
                            <label for="txttorec_date">To</label>
                            <input type="date" class="form-control" name="txttorec_date" id="txttorec_date" value="<?php echo $torec_date; ?>"/>
                        </div>
                        <div class="col-md-3">
                            <input value='Show Report' type='button' style="margin-top: 27px;" name='btnsubmit' class='btn btn-primary forms_button_e' onclick='sendData()'>
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
            url: "pages/rpt_received_info/rpt_received_info_get.php",
            data: $('#reportForm').serialize()
        }).done(function(msg) {
            console.log(msg)
            $("#mainContent").html(msg);
        }).fail(function() {
            alert("error");
        });
    }
</script>



