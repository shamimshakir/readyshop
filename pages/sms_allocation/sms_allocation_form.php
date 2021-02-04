<?php include('../header.php');
$mode = 1;

if(isset($_REQUEST['color_id'])){
    $id=$_POST['id'];
    $mode = 2;
    $SeNTlist = "SELECT
								  `id`,
								  `name`,
								  `allocate_ammount`,
								  `allocation_date`
								FROM
								  `tbl_sms_allocation_details`
									WHERE id = '$sms_id' ";
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
                        <h4 id="myModalLabel">Add Allocation</h4>
                    

                    <form id="productColorForm" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="id" value="<?php  if($mode==2){echo $id;}?>">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="color_name">Amount <span style="color:red;">*</span></label>
                               <input type="number" class="form-control" name="amount" id="amount" value="<?php if(isset($rowNewsTls)) {echo $allocate_ammount;}?>" placeholder="Amount">
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
                url: "pages/sms_allocation/sms_allocation_save.php",
                data: $('#productColorForm').serialize()
            }).done(function(response) {
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
            }).fail(function() {
                alertify.notify(response, 'error', 3);
            });
        }
    }
</script>
