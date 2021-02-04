<?php include('../header.php');
$mode = 1;

if(isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];
    $mode = 2;
    $SeNTlist = "SELECT * FROM tbl_shop_config WHERE id = '$id' ";
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
                        <h4 id="myModalLabel">Add Shop</h4>
                    <?php } if ($mode == '2'){ ?>
                        <h4 id="myModalLabel">Edit Shop</h4>
                    <?php }?>


                    <form id="advmanagementForm" class="" action="#" novalidate="" enctype="multipart/form-data">

                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="id" value="<?php  if($mode==2){echo $id;}?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Shop Name <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="sc_name" id="sc_name" value="<?php echo $sc_name; ?>" required >
                            </div>
                            <div class="col-md-6">
                                <label for="link">Email </label>
                                <input type="text" class="form-control" name="sc_email" id="sc_email" value="<?php echo $sc_email; ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="link">Address </label>
                                <input type="text" class="form-control" name="sc_address" id="sc_address" value="<?php echo $sc_address; ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="link">Phone </label>
                                <input type="text" class="form-control" name="sc_phone" id="sc_phone" value="<?php echo $sc_phone; ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="link">URL </label>
                                <input type="text" class="form-control" name="url" id="url" value="<?php echo $url; ?>" >
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
                                <label for="bg_img">Logo </label>
                                <input type="file" class="form-control" name="sc_logo" id="sc_logo" >
                                <img style="width: auto; height: 60px; margin: 10px 0;" src="uploads/shop_setup/<?php echo $sc_logo;?>" alt="">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="bg_img">Favicon </label>
                                <input type="file" class="form-control" name="favicon" id="favicon" >
                                <img style="width: auto; height: 60px; margin: 10px 0;" src="uploads/sponsors_ad/<?php echo $favicon;?>" alt="">
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
                url: "pages/shop_setup/shop_setup_save.php",
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
