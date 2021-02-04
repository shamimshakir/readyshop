
<?php include('../header.php');
    $mode = 1;
    if(isset($_REQUEST['loc_id'])){
        $loc_id = $_REQUEST['loc_id'];
        $mode = 2;
        $SeNTlist = "SELECT * FROM tbl_pickup_location WHERE loc_id = '$loc_id' ";
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
                        <h4 class="mt-0 header-title">Add Pickup Location</h4>
                    <?php }elseif ($mode = 2){ ?>
                        <h4 class="mt-0 header-title">Edit Pickup Location</h4>
                    <?php }?>


                    <form id="pickupForm" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="loc_id" value="<?php  if($mode==2){echo $loc_id;}?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="location">Location Name <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="location" id="location" value="<?php echo $location; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="city">City <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="city" id="city" value="<?php echo $city; ?>"  required>
                            </div>
                            <div class="col-md-6">
                                <label for="loc_status">Status</label>
                                <?php
                                echo "<select name='loc_status' id='loc_status' class='form-control'>";
                                createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$loc_status);
                                echo "</select>";
                                ?>
                            </div>
                            <div class="col-md-6">
                                <label for="address">Address <span style="color:red;">*</span></label>
                                <textarea name='address' class="form-control" id='address' wrap="VIRTUAL" cols="40" rows="4" required><?php echo $address; ?></textarea>
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
                url: "pages/pickup/pickup_save.php",
                data: $('#pickupForm').serialize()
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
