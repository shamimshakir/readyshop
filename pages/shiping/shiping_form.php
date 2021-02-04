
<?php include('../header.php');
    $mode = 1;
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        $mode = 2;
        $SeNTlist = "SELECT `id`, `location`, `price` FROM `tbl_shipping_costs` WHERE `id` = '$id' ";
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
                        <h4 class="mt-0 header-title">Add Shipping Cost</h4>
                    <?php }elseif ($mode = 2){ ?>
                        <h4 class="mt-0 header-title">Edit Shipping Cost</h4>
                    <?php }?>


                    <form id="brandForm" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="id" value="<?php  if($mode==2){echo $id;}?>">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="location">Location Name <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Location Name" name="location" id="location" value="<?php echo $location; ?>" required>
                                </div>
                            </div>
							<div class="col-lg-6">
                                <div class="form-group">
                                    <label for="price">Price <span style="color:red;">*</span></label>
                                    <input type="number" class="form-control" placeholder="Location Name" name="price" id="price" value="<?php echo $price; ?>" required>
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group mb-0 d-flex justify-content-end">
                            <div>
                                <button type="button" class="btn btn-secondary waves-effect" onclick="view_datas()">Cancel</button>
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

<?php include('../footer.php')?>
<script>
    function save() {
        if($('form').parsley().validate()){
            $.ajax({
                type: "POST",
                url: "pages/shiping/shiping_save.php",
                data: $('#brandForm').serialize()
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
                url: "pages/shiping/shiping.php?page=<?php echo $_REQUEST['page']?>",
                type: "GET",                
            }).done(function (response) {        			
        			$('#mainContent').html(response);
        		})
	}
</script>
