<?php include('../header.php');
$mode = 1;

if(isset($_REQUEST['id'])){
    $mode = 2;
    $id=$_REQUEST['id'];
    $SeNTlist = "SELECT * FROM meta_tags WHERE id = '$id' ";
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
                        <h4 id="myModalLabel">Add Meta</h4>
                    <?php } if ($mode == 2){ ?>
                        <h4 id="myModalLabel">Edit Meta</h4>
                    <?php }?>


                    <form id="advmanagementForm" class="" action="#" novalidate="" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="id" value="<?php  if($mode==2){echo $id;}?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="meta_page">Meta Page</label>
                                <input type="text" class="form-control" name="meta_page" id="meta_page" value="<?php echo $meta_page; ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="meta_name">Meta Name <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="meta_name" id="meta_name" value="<?php echo $meta_name; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="meta_content">Meta Content <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="meta_content" id="meta_content" size="10" value="<?php echo $meta_content; ?>" required>
                            </div>                            
                            <div class="col-md-6">
                                <label for="meta_type">Meta Type</label>
                                <select name="meta_type" id="meta_type" class="form-control">
                                    <option value="1" <?php echo $meta_type == '1' ? "selected" : ""; ?>>Meta</option>
                                    <option value="2" <?php echo $meta_type == '2' ? "selected" : ""; ?>>Title</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="status">Status</label>
                                <?php
                                echo "<select name='status' id='status' class='form-control'>";
                                createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$status);
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
        if($('form').parsley().validate()){
            var form = $('form')[0];
            var formData = new FormData(form);
            $.ajax({
                type: "POST",
                url: "pages/metatags/metatags_save.php",
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
