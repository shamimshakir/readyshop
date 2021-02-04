<?php include('../header.php');
$mode = 1;

if(isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];
    $mode = 2;
    $SeNTlist = "SELECT * FROM product_tags WHERE tag_id = '$id' ";
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
                        <h4 id="myModalLabel">Add Footer Details</h4>
                    <?php } if ($mode == '2'){ ?>
                        <h4 id="myModalLabel">Edit Product Tag</h4>
                    <?php }?>


                    <form id="aboutForm" class="" action="#" novalidate="" enctype="multipart/form-data">

                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="tag_id" value="<?php  if($mode==2){echo $tag_id;}?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="phone">Tag Name </label>
                                <select name="tag_name" id="tag_name" class="form-control">
                                    <option>Select Name</option>
                                    <option value="new_stat" <?php echo $tag_name == "new_stat" ? "selected" : ""; ?>>new_stat</option>
                                    <option value="onsale_stat" <?php echo $tag_name == "onsale_stat" ? "selected" : ""; ?>>onsale_stat</option>
                                    <option value="popular_stat" <?php echo $tag_name == "popular_stat" ? "selected" : ""; ?>>popular_stat</option>
                                    <option value="upsstat" <?php echo $tag_name == "upsstat" ? "selected" : ""; ?>>upsstat</option>
                                    <option value="feature_stat" <?php echo $tag_name == "feature_stat" ? "selected" : ""; ?>>feature_stat</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="phone">Tag Label </label>
                                <input type="text" class="form-control" name="tag_label" id="tag_label" value="<?php echo $tag_label; ?>">
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
                url: "pages/tag/tag_save.php",
                data: $('#aboutForm').serialize()
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
