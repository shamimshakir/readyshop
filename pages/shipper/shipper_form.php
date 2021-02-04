<?php include('../header.php');
$mode = 1;

if(isset($_REQUEST['sp_id'])){
    $sp_id=$_REQUEST['sp_id'];
    $mode = 2;
    $SeNTlist = "SELECT * FROM tbl_shippers WHERE sp_id = '$sp_id' ";
    $ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error($conn));
    $rowNewsTls=mysqli_num_rows($ExSeNTlist);
    while($rowNewsTl=mysqli_fetch_array($ExSeNTlist)){
        extract($rowNewsTl);
    }
}
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card m-b-20">
                <div class="card-body">
                    <?php if ($mode == '1'){ ?>
                        <h4 id="myModalLabel">Add Shipper</h4>
                    <?php } if ($mode == '2'){ ?>
                        <h4 id="myModalLabel">Edit Shipper</h4>
                    <?php }?>


                    <form id="shipperForm" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="sp_id" value="<?php  if($mode==2){echo $sp_id;}?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="sp_name">Shipper Name <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="sp_name" id="sp_name" size="10" value="<?php echo $sp_name; ?>" Maxlength="10" required>
                            </div>
                            <div class="col-md-6">
                                <label for="sp_email">Email <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="sp_email" id="sp_email" size="30" value="<?php echo $sp_email; ?>" Maxlength="30" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="sp_contact_person">Contact Person <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="sp_contact_person" id="sp_contact_person" size="10" value="<?php echo $sp_contact_person; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="sp_mobile">Phone <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="sp_mobile" id="sp_mobile" size="10" value="<?php echo $sp_mobile; ?>" Maxlength="10" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="sp_sddress">Address <span style="color:red;">*</span></label>
                                <textarea name='sp_sddress' class="form-control" id='sp_sddress' wrap="VIRTUAL" cols="40" rows="3" required><?php echo $sp_sddress; ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="status">Status </label>
                                <select name="status" class="form-control" id="status"   required>
                                    <?php createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$status);?>
                                </select>
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
        if($('form').parsley().validate()){
            $.ajax({
                type: "POST",
                url: "pages/shipper/shipper_save.php",
                data: $('#shipperForm').serialize()
            }).done(function(response) {
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
            }).fail(function() {
                alertify.notify(response, 'error', 3);
            });
        }
    }
</script>
