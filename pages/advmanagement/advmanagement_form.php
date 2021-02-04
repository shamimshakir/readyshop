<?php include('../header.php');
$mode = 1;

if(isset($_REQUEST['adv_id'])){
    $adv_id=$_REQUEST['adv_id'];
    $mode = 2;
    $SeNTlist = "SELECT * FROM tbl_adv WHERE adv_id = '$adv_id' ";
    $ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error($conn));
    $rowNewsTls=mysqli_num_rows($ExSeNTlist);
    while($rowNewsTl=mysqli_fetch_array($ExSeNTlist)){
        extract($rowNewsTl);
    }
}
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <?php if ($mode == '1'){ ?>
                        <h4 id="myModalLabel">Add Advertisement</h4>
                    <?php } if ($mode == '2'){ ?>
                        <h4 id="myModalLabel">Edit Advertisement</h4>
                    <?php }?>


                    <form id="advmanagementForm" class="" action="#" novalidate="" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="adv_id" value="<?php  if($mode==2){echo $adv_id;}?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="comp_name">Compnay Name <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="comp_name" id="comp_name" size="10" value="<?php echo $comp_name; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="business_type">Business Type</label>
                                <?php
                                echo "<select name='business_type' id='business_type' class='form-control'>";
                                createCombo("Business Type","tbl_business_type","btype_id","business_type","ORDER BY business_type ",$business_type);
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="comp_url">Company URL <span style="color:red;">*</span> </label>
                                <input type="text" class="form-control" name="comp_url" id="comp_url" size="10" value="<?php echo $comp_url; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="comp_status">Status</label>
                                <?php
                                echo "<select name='comp_status' id='comp_status' class='form-control'>";
                                createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$comp_status);
                                echo "</select>";
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="start_date">Start Date <span style="color:red;">*</span></label>
                                <input type="date" class="form-control" name="start_date" id="start_date" size="10" value="<?php echo $start_date; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="end_date">End Date <span style="color:red;">*</span></label>
                                <input type="date" class="form-control" name="end_date" id="end_date" size="10" value="<?php echo $end_date; ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="adv_position">Position</label>
                                <input type="text" class="form-control" name="adv_position" id="adv_position" size="10" value="<?php echo $adv_position; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="comp_image">Image <span style="color:red;">*</span></label>
                                <input class="form-control" type="file" name="comp_image" id="comp_image" value="<?php echo $comp_image; ?>" required>
                                <img style="width: auto; height: 60px; margin: 10px 0;" src="<?php echo $folder_admin; ?>adv/<?php echo $comp_image;?>" alt="">
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
            var form = $('form')[0];
            var formData = new FormData(form);
            $.ajax({
                type: "POST",
                url: "pages/advmanagement/advmanagement_save.php",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
            }).done(function(response) {
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
                // alert(response);
            }).fail(function() {
                alertify.notify(response, 'error', 3);
            });
        }
    }
</script>
