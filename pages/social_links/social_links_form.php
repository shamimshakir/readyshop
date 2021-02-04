
<?php include('../header.php');
    $mode = 1;
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        $mode = 2;
        $SeNTlist = "SELECT * FROM tbl_social_links WHERE id = '$id' ";
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
                        <h4 class="mt-0 header-title">Add Social</h4>
                    <?php }elseif ($mode = 2){ ?>
                        <h4 class="mt-0 header-title">Edit Social</h4>
                    <?php }?>


                    <form id="socialForm" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="id" value="<?php  if($mode==2){echo $id;}?>">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="social_name">Social Name</label>
                                    <input type="text" class="form-control" placeholder="Social Name" name="social_name" id="social_name" value="<?php echo $social_name; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="brand_detail">URL</label>
                                    <input type="text" class="form-control" placeholder="URL" name="url" id="url" value="<?php echo $url; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="brand_display">Icon</label>
                                    <input type="text" class="form-control" placeholder="Icon" name="icon" id="icon" value="<?php echo $icon; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="act_status">Status</label>
                                <?php
                                echo "<select name='act_status' id='act_status' class='form-control'>";
                                createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$active_status);
                                echo "</select>";
                                ?>
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
            url: "pages/social_links/social_links_save.php",
            data: $('#socialForm').serialize()
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
</script>
