<?php include('../header.php');
$mode = 1;

if(isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];
    $mode = 2;
    $SeNTlist = "SELECT * FROM tbl_size WHERE size_id = '$id' ";
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
                        <h4 id="myModalLabel">Add Product Size</h4>
                    <?php } if ($mode == '2'){ ?>
                        <h4 id="myModalLabel">Edit Product Size</h4>
                    <?php }?>


                    <form id="aboutForm" class="" action="#" novalidate="" enctype="multipart/form-data">

                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="size_id" value="<?php  if($mode==2){echo $size_id;}?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="phone">Size Display </label>
                                <input type="text" class="form-control" name="size_display" id="size_display" value="<?php echo $size_display; ?>">
                            </div>
                        
                            <div class="col-md-6">
                                <label for="phone">Remarks </label>
                                <input type="text" class="form-control" name="size_remarks" id="size_remarks" value="<?php echo $size_remarks; ?>">
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label"  for="status">Status</label>
                                    <select name='status' id='status' class='form-control'>
                                        <?php createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$status);  ?>
                                    </select>
                                </div>
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
                url: "pages/product_size/product_size_save.php",
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
