<?php include('../header.php');
$mode = 1;

if(isset($_REQUEST['id'])){
    $mode = 2;
    $banner_image_id=$_REQUEST['id'];
    $SeNTlist = "SELECT * FROM tbl_banner WHERE id = '$banner_image_id' ";
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
                    <?php if ($mode == 1){ ?>
                        <h4 id="myModalLabel">Add Banner</h4>
                    <?php } if ($mode == 2){ ?>
                        <h4 id="myModalLabel">Edit Banner</h4>
                    <?php }?>


                    <form id="advmanagementForm" class="" action="#" novalidate="" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="banner_image_id" value="<?php  if($mode==2){echo $banner_image_id;}?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="slider_title">Title <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="<?php echo $title; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="comp_url">Company URL <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="comp_url" id="comp_url" value="<?php echo $comp_url; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="comp_name">Company Name <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="comp_name" id="comp_name" size="10" value="<?php echo $comp_name; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="start_date">Start Date </label>
                                <input type="date" class="form-control" name="start_date" id="start_date" size="10" value="<?php echo $start_date; ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="end_date">End Date </label>
                                <input type="date" class="form-control" name="end_date" id="end_date" size="10" value="<?php echo $end_date; ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="act_status">Status</label>
                                <?php
                                echo "<select name='act_status' id='act_status' class='form-control'>";
                                createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$active_status);
                                echo "</select>";
                                ?>
                            </div>
                            <div class="col-md-6">
                                <label for="bg_img">Image <span style="color:red;">*</span> <br> <span style="color:red;"> (Image size must be 1154*145 pixel for better look.)</span></label>
                                <input type="file" class="form-control" name="image" id="image"  <?php  if($mode==1){echo 'required';}?>>
                                <img style="width: auto; height: 60px; margin: 10px 0;" src="uploads/banner/<?php echo $image;?>" alt="" >
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
        if($('form').parsley().validate()){
            var form = $('form')[0];
            var formData = new FormData(form);
            $.ajax({
                type: "POST",
                url: "pages/banner/banner_save.php",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
            }).done(function(response) {
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
                // console.log(response)
            }).fail(function() {
                alertify.notify(response, 'error', 3);
            });
        }
    }
</script>
