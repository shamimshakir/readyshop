
<?php include('../header.php');
    $mode = 1;
    if(isset($_REQUEST['user_profile_id'])){
        $mode = 2;
        $user_profile_id = $_POST['user_profile_id'];
        $SeNTlist = "SELECT * FROM user_profile WHERE user_profile_id = '$user_profile_id' ";
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
                        <h4 class="mt-0 header-title">Add Profile</h4>
                    <?php }elseif ($mode = 2){ ?>
                        <h4 class="mt-0 header-title">Edit Profile</h4>
                    <?php }?>


                    <form id="userForm" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="user_profile_id" value="<?php  if($mode==2){echo $user_profile_id;}?>">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label" for="firstname">Name</label>
                                    <input type="text" class="form-control span3" id="profile_name" name="profile_name" value="<?php if(isset($rowNewsTls)) {echo $profile_name;} ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0 mt-2 d-flex justify-content-end">
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
            url: "pages/profile/profile_save.php",
            data: $('#userForm').serialize()
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
</script>
