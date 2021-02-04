
<?php include('../header.php');
    $mode = 1;
    if(isset($_REQUEST['user_id'])){
        $mode = 2;
        $user_id=$_POST['user_id'];
        $SeNTlist = "SELECT * FROM users WHERE user_id = '$user_id' ";
        $ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error());
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
                        <h4 class="mt-0 header-title">Add User</h4>
                    <?php }elseif ($mode = 2){ ?>
                        <h4 class="mt-0 header-title">Edit User</h4>
                    <?php }?>


                    <form id="userForm" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="user_id" value="<?php  if($mode==2){echo $user_id;}?>">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="company_name"> Comapany Name  <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="company_name" placeholder="Comapany Name" name="company_name" value="<?php if(isset($rowNewsTls)) {echo $company_name;} ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="real_name"> Full Name  <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control span3" id="real_name" placeholder="Full Name" name="real_name" value="<?php if(isset($rowNewsTls)) {echo $real_name;} ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="mobile"> Mobile  <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control span3" id="mobile" placeholder="Mobile" name="mobile" value="<?php if(isset($rowNewsTls)) {echo $mobile;} ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="firstname">User Profile  <span style="color:red;">*</span></label>
                                    <select name='user_profile_id' id='user_profile_id' class="form-control" required>
                                        <?php createCombo("Profile","user_profile","user_profile_id","profile_name","ORDER BY profile_name","$user_profile_id"); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="comp_address"> Address  <span style="color:red;">*</span></label>
                                    <textarea type="text" class="form-control span3" name='comp_address' placeholder="Address" id='comp_address' placeholder="Address" required><?php if(isset($rowNewsTls)) {echo str_replace('<br />', '', $comp_address);} ?></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Password">Password  <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control span3" id="user_pass" placeholder="Password" name="user_pass" value="<?php if(isset($rowNewsTls)) {echo $user_pass;} ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Email"> Email  <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="user_email" name="user_email" placeholder="Email" value="<?php if(isset($rowNewsTls)) {echo $user_email;} ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label"  for="status">User Status  <span style="color:red;">*</span></label>
                                    <select name='status' id='status' class='form-control' required>
                                        <?php createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$status);  ?>
                                    </select>
                                </div>
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
        $.ajax({
            type: "POST",
            url: "pages/userlist/user_save.php",
            data: $('#userForm').serialize()
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
