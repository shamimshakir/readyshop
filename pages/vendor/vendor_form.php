<?php 
$mode = 1;
include('../header.php');
if(isset($_REQUEST['vendor_id'])){
    $vendor_id=$_REQUEST['vendor_id'];
    $mode = 2;
    $SeNTlist = "SELECT tbl_vendor.*, Date(tbl_vendor.user_regdate) AS userRegDate FROM tbl_vendor WHERE vendor_id = '$vendor_id' ";
    $ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error($conn));
    $rowNewsTls=mysqli_num_rows($ExSeNTlist);
    while($rowNewsTl=mysqli_fetch_array($ExSeNTlist)){
        extract($rowNewsTl);
    }
}
?>
<div id="mainContent">
<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="card m-b-20">
            <div class="card-body">
                <?php if ($mode == '1'){ ?>
                    <h4 id="myModalLabel">Add Vendor</h4>
                <?php } if ($mode == '2'){ ?>
                    <h4 id="myModalLabel">Edit Vendor</h4>
                <?php }?>


                <form id="vendorForm" class="" action="#" novalidate="">
                    <input type="hidden" name="mode" value="<?php echo $mode;?>">
                    <input type="hidden" name="vendor_id" value="<?php  if($mode==2){echo $vendor_id;}?>">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="vendor_name">Name <span style="color:red;">*</span></label>
                            <input type="text" name="vendor_name" id="vendor_name" class="form-control" value="<?php echo $vendor_name; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="company_name">Company Name <span style="color:red;">*</span></label>
                            <input type="text" name="company_name" id="company_name" class="form-control" value="<?php echo $company_name; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="od_date">Phone <span style="color:red;">*</span></label>
                            <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $phone; ?>" Maxlength="30" required>
                        </div>
                        <div class="col-md-4">
                            <label for="email">Email <span style="color:red;">*</span></label>
                            <input type="text" name="email" id="email" class="form-control" value="<?php echo $email; ?>" Maxlength="30" required>
                        </div>
                        <div class="col-md-8">
                            <label for="address">Address <span style="color:red;">*</span></label>
                            <textarea name='address' id='address' class="form-control" wrap="VIRTUAL" cols="20" rows="2" required><?php echo $address; ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="user_regdate">Reg Date  <span style="color:red;">* </span></label>
                            
                            <input type="date" name="user_regdate" class="form-control" id="user_regdate" value="<?php if($mode == 2){ echo $userRegDate; }else{echo date('Y-m-d');} ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="status">Status </label>
                            <select name="status" class="form-control" id="status"   required>
                                <?php createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$status);?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-2 mb-0 d-flex justify-content-end">
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

<script>
    function save() {
        if($('form').parsley().validate()){
            $.ajax({
                type: "POST",
                url: "pages/vendor/vendor_save.php",
                data: $('#vendorForm').serialize()
            }).done(function(response) {
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_datas();
                console.log(response)
            }).fail(function() {
                alertify.notify(response, 'error', 3);
            });
        }
    }
	function view_datas(){		
		$.ajax({
            url: "pages/vendor/vendor.php?page=<?php echo $_REQUEST['page']?>",
            type: "GET",                
        }).done(function (response) {        			
    		$('#mainContent').html(response);
    	})
	}
</script>
