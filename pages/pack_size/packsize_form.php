<?php include('../header.php');
$mode = 1;
if(isset($_REQUEST['ct_id'])){
    $ct_id = $_REQUEST['ct_id'];
    $mode = 2;
    $SeNTlist = "SELECT * FROM tbl_pack_size WHERE ct_id = '$ct_id' ";
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
                        <h4 class="mt-0 header-title">Add Pack Size</h4>
                    <?php }elseif ($mode = 2){ ?>
                        <h4 class="mt-0 header-title">Edit Pack Size</h4>
                    <?php }?>


                    <form id="packsizeFrom" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="ct_id" value="<?php  if($mode==2){echo $ct_id;}?>">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="brand_detail">Height <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control"  name="height" id="height" value="<?php echo $packheight; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="brand_remarks">Width <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="width" id="width" value="<?php echo $packwidth; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="brand_remarks">Lenght <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="length" id="length" value="<?php echo $packlength; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="brand_display">Weight</label>
                                    <input type="text" class="form-control" name="weight" id="weight" value="<?php echo $packweight; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="brand_remarks">Cubik</label>
                                    <input type="text" class="form-control"  name="cubic" id="cubic" value="<?php echo $cubicsize; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label"  for="status">Status</label>
                                    <select name='status' id='status' class='form-control'>
                                        <?php createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$status);  ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0 d-flex justify-content-end">
                            <div>
                                <button type="button" class="btn btn-secondary waves-effect" onclick="view_data()">Cancel</button>
                                <?php if ($mode == 1){ ?>
                                    <button type="button" onclick="save()" class="btn btn-primary waves-effect waves-light mr-1">Save</button>
                                <?php }elseif($mode == 2){ ?>
                                    <button type="button" onclick="save()"  class="btn btn-primary waves-effect waves-light mr-1">Update</button>
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
                url: "pages/pack_size/pack_save.php",
                data: $('#packsizeFrom').serialize()
            }).done(function(response) {
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
            }).fail(function() {
                alertify.notify(response, 'error', 3)
            });
        }
    }

</script>


