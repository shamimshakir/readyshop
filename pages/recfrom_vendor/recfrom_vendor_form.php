
<?php include('../header.php');
    $mode = 1;
    if(isset($_REQUEST['brand_id'])){
        $brand_id = $_REQUEST['brand_id'];
        $mode = 2;
        $SeNTlist = "SELECT * FROM tbl_brand WHERE brand_id = '$brand_id' ";
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
                        <h4 class="mt-0 header-title">Add Brand</h4>
                    <?php }elseif ($mode = 2){ ?>
                        <h4 class="mt-0 header-title">Edit Brand</h4>
                    <?php }?>


                    <form id="brandForm" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="brand_id" value="<?php  if($mode==2){echo $brand_id;}?>">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="brand_display">Brand Name</label>
                                    <input type="text" class="form-control" placeholder="Brand Name" name="brand_display" id="brand_display" value="<?php echo $brand_display; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="brand_detail">Brand Details</label>
                                    <input type="text" class="form-control" placeholder="Brand Details" name="brand_detail" id="brand_detail" value="<?php echo $brand_detail; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="brand_remarks">Brand Remarks</label>
                                    <textarea class="form-control" name="brand_remarks" id="brand_remarks" rows="5"><?php echo $brand_remarks; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0 d-flex justify-content-end">
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
            url: "pages/brands/brand_save.php",
            data: $('#brandForm').serialize()
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
</script>
