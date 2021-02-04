
<?php include('../header.php');
    $mode = 1;
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        $mode = 2;
        $SeNTlist = "SELECT * FROM tbl_css WHERE id = '$id' ";
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
                        <h4 class="mt-0 header-title">Add CSS</h4>
                    <?php }elseif ($mode = 2){ ?>
                        <h4 class="mt-0 header-title">Edit CSS</h4>
                    <?php }?>


                    <form id="theme_css_form" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="id" value="<?php  if($mode==2){echo $id;}?>">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="label">Label <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Label" name="label" id="label" value="<?php echo $label; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="item">Item / Selector Name <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Selector Name" name="item" id="item" value="<?php echo $item; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="item_value">Value <span style="color:red;">*</span></label>
                                    <input type="color" class="form-control" placeholder="Value" name="item_value" id="item_value" value="<?php echo $item_value; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="theme_id">Status<span style="color:red;">*</span></label>
                                <select name='status' id='status' class="form-control" required>
                                   <?php createCombo("Status","tbl_status","stat_id","stat_desc","",$status); ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                            <div class="mt-3">
                                <button type="button" class="btn btn-secondary waves-effect" onclick="view_datas()">Cancel</button>
                                <?php if ($mode == 1){ ?>
                                    <button type="button" onclick="save()" class="btn btn-primary waves-effect waves-light mr-1">Save</button>
                                <?php }elseif($mode == 2){ ?>
                                    <button type="button" onclick="save()" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                                <?php }?>
                            </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../footer.php')?>
<script>
    function save() {
        if($('form').parsley().validate()){
            $.ajax({
                type: "POST",
                url: "pages/theme_css/theme_css_save.php",
                data: $('#theme_css_form').serialize()
            }).done(function(response) {
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_datas();
            }).fail(function() {
                alertify.notify(response, 'error', 3);
            });
        }
    }
	function view_datas(){		
		$.ajax({
                url: "pages/theme_css/theme_css.php?page=<?php echo $_REQUEST['page']?>",
                type: "GET",                
            }).done(function (response) {        			
        			$('#mainContent').html(response);
        		})
	}
</script>
