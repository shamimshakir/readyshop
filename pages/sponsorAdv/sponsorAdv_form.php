<?php include('../header.php');
$mode = 1;

if(isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];
    $mode = 2;
    $SeNTlist = "SELECT * FROM tbl_sponsors_ad WHERE id = '$id' ";
    $ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error($conn));
    $rowNewsTls=mysqli_num_rows($ExSeNTlist);
    while($rowNewsTl=mysqli_fetch_array($ExSeNTlist)){
        extract($rowNewsTl);
    }
}
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-8 offset-2">
            <div class="card m-b-20">
                <div class="card-body">
                    <?php if ($mode == '1'){ ?>
                        <h4 id="myModalLabel">Add Sponsor</h4>
                    <?php } if ($mode == '2'){ ?>
                        <h4 id="myModalLabel">Edit Sponsor</h4>
                    <?php }?>


                    <form id="advmanagementForm" class="" action="#" novalidate="" enctype="multipart/form-data">

                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="sponsor_id" value="<?php  if($mode==2){echo $id;}?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Name <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" size="10" value="<?php echo $name; ?>" required >
                            </div>
                            <div class="col-md-6">
                                <label for="link">Link <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="link" id="link" size="10" value="<?php echo $link; ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label for="act_status">Status</label>
                                <?php
                                echo "<select name='act_status' id='act_status' class='form-control'>";
                                createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$act_status);
                                echo "</select>";
                                ?>
                            </div>
                            <div class="col-md-6">
                                <label for="bg_img">Image <span style="color:red;display: block;"> (Image size must be 180*60 pixel for better look.)</span></label>
                                <input type="file" class="form-control" name="logo" id="logo">
                                <img style="width: auto; height: 60px; margin: 10px 0;" src="<?php echo $folder_admin; ?>sponsors_ad/<?php echo $logo;?>" alt="">
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
                url: "pages/sponsorAdv/sponsorAdv_save.php",
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
