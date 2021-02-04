
<?php include('../header.php');
    $mode = 1;
    if(isset($_REQUEST['id'])){
        $mode = 2;
        $id = $_REQUEST['id'];
        $SeNTlist = "SELECT coupons.*, 
                                Date(coupons.start_date) as startDate, 
                                Date(coupons.end_date) AS endDate 
                                FROM coupons 
                                WHERE id = '$id' ";
        $ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error($conn));
        $rowNewsTls=mysqli_num_rows($ExSeNTlist);
        $rowNewsTl=mysqli_fetch_array($ExSeNTlist);
        extract($rowNewsTl);
    }
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card m-b-20">
                <div class="card-body">
                    <?php if ($mode == 1){ ?>
                        <h4 class="mt-0 header-title">Add Coupon</h4>
                    <?php }elseif ($mode = 2){ ?>
                        <h4 class="mt-0 header-title">Edit Coupon</h4>
                    <?php }?>


                    <form id="couponForm" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="id" value="<?php  if($mode==2){echo $id;}?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="cat_name">Code <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Code" name="code" id="code" value="<?php echo $code; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="value">Value <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Value" name="value" id="value" value="<?php echo $value; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="start_date">Start Date</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="start_date" value="<?php echo $startDate; ?>" placeholder="mm/dd/yyyy" id="start_date">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="start_date">End Date</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="end_date" value="<?php echo $endDate; ?>" placeholder="mm/dd/yyyy" id="end_date">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="active">Status</label>
                                <?php echo "<select name='active' id='active' class='form-control'>";
                                createCombo("Status","tbl_status","stat_id","stat_desc","",$active);
                                echo "</select>"; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="">Description</label>
                                <textarea name="description" id="description" class="form-control"><?php echo $description; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group mb-0 mt-2 d-flex justify-content-end">
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
        if($('form').parsley().validate()){
            $.ajax({
                type: "POST",
                url: "pages/coupon/coupon_save.php",
                data: $('#couponForm').serialize()
            }).done(function(response) {
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
                console.log(response)
            }).fail(function() {
                alertify.notify(response, 'error', 3);
            });
        }
    }
    jQuery('#start_date').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    jQuery('#end_date').datepicker({
        autoclose: true,
        todayHighlight: true
    });
</script>
