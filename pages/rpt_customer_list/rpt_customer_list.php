
<?php include('../header.php')?>


<div id='mainContent'> 
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">
                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Customer List</span>
                    </h4>
                        <form id="reportForm" class="form-group">
                            <div class="row">
                                <div class="col-lg-2">
                                    <label for="firstname">FirstName</label>
                                    <input type="text" class="form-control" name="firstname" id="firstname">
                                </div>
                                <div class="col-lg-2">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>
                                <div class="col-lg-2">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone">
                                </div>
                                <div class="col-lg-2">
                                    <label for="varified_status">Status</label>
                                    <select name='varified_status' id='varified_status' class="form-control">
                                        <option value="">Select One</option>
                                        <option value="1">Verified</option>
                                        <option value="0">Non Verified</option>
                                    </select>
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
            url: "pages/rpt_customer_list/rpt_customer_list_get.php",
            data: $('#reportForm').serialize()
        }).done(function(msg) {
            $("#loadContetn").html(msg);
            console.log(msg)
        }).fail(function() {
            alert("error");
        });
    }
    sendData();
</script>


