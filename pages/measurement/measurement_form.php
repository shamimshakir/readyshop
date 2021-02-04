<?php include('../header.php');
$mode = 1;

if(isset($_REQUEST['unit_id'])){
    $unit_id=$_REQUEST['unit_id'];
    $mode = 2;
    $SeNTlist = "SELECT * FROM tbl_unit WHERE unit_id = '$unit_id' ";
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
                    <?php if ($_POST['mode'] == '1'){ ?>
                        <h4 id="myModalLabel">Add Measurement</h4>
                    <?php } if ($_POST['mode'] == '2'){ ?>
                        <h4 id="myModalLabel">Edit Measurement</h4>
                    <?php }?>


                    <form id="measurementForm" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="unit_id" value="<?php  if($mode==2){echo $unit_id;}?>">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="unit_name">Unit Name <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="unit_name" id="unit_name" size="10" value="<?php echo $unit_display; ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="status">Status</label>
                                <?php
                                    echo "<select name='status' id='status' class='form-control'>";
                                    createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$status);
                                    echo "</select>";
                                ?>
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
                url: "pages/measurement/measurement_save.php",
                data: $('#measurementForm').serialize()
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
