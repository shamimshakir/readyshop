<?php include('../header.php');
session_start();
$sql = "SELECT * FROM users WHERE user_id = '$_SESSION[SUserID]'";
$ExSeNTlist=mysqli_query($conn, $sql) or die(mysqli_error());
$rowNewsTls=mysqli_num_rows($ExSeNTlist);
while($rowNewsTl=mysqli_fetch_array($ExSeNTlist)){
    extract($rowNewsTl);
}
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Update Profile</span>
                    </h4>
                    <form action="" id="profile_update_form">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="real_name">Full Name</label>
                                    <input type="text" class="form-control" id="real_name" name="real_name" value="<?php if(isset($rowNewsTls)) {echo $real_name;} ?>" required>
                                    <input type='hidden' name='user_id' value='<?php echo $user_id; ?>' />
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="user_name"> User Name</label>
                                <input type="text" class="form-control" id="user_name" name="user_name" value="<?php if(isset($rowNewsTls)) {echo $user_name;} ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="Email"> Email</label>
                                <input type="text" class="form-control" id="user_email" name="user_email" value="<?php if(isset($rowNewsTls)) {echo $user_email;} ?>" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="Password">Password</label>
                                <input type="text" class="form-control" id="user_pass" name="user_pass" value="<?php if(isset($rowNewsTls)) {echo $user_pass;} ?>" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="mobile"> Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="<?php if(isset($rowNewsTls)) {echo $mobile;} ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="address"> Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php if(isset($rowNewsTls)) {echo $address;} ?>" required>
                            </div>
                        </div>
                        
                        </div>
                    </div>
                    <div class="form-group mb-0 d-flex justify-content-end">
                        <div>
                            <button type="button" class="btn btn-secondary waves-effect" onclick="view_data()">Cancel</button>
                            <button type="button" onclick="update_profile()" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>

<script>
    function update_profile() {
        $.ajax({
            type: "POST",
            url: "pages/profle_update/profile_update_save.php",
            data: $('#profile_update_form').serialize()
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
</script>