
<?php include('../header.php');
    $mode = 1;
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        $mode = 2;
        $SeNTlist = "SELECT * FROM tbl_emailsetup WHERE id = '$id' ";
        $ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error($conn));
        $rowNewsTls=mysqli_num_rows($ExSeNTlist);
        $rowNewsTl=mysqli_fetch_array($ExSeNTlist);
        extract($rowNewsTl);
    }
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card m-b-20">
                <div class="card-body">
                    <?php if ($mode == 1){ ?>
                        <h4 id="myModalLabel">Add Page</h4>
                    <?php } if ($mode == 2){ ?>
                        <h4 id="myModalLabel">Edit Page</h4>
                    <?php }?>


                    <form id="pageContentForm" class="" action="#" novalidate="" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="id" value="<?php  if($mode==2){echo $id;}?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="page_name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" size="10" value="<?php echo $name; ?>" >
                            </div>
                            <div class="col-md-6 ">
                                <label for="page_name">Username</label>
                                <input type="text" class="form-control" name="Username" id="Username" size="10" value="<?php echo $Username; ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="page_name">Password</label>
                                <input type="password" class="form-control" name="Password" id="Password" size="10" value="<?php echo $Password; ?>" >
                            </div>
                            <div class="col-md-6 <?php if($id==1){echo 'd-none';}?>">
                                <label for="page_name">SMTPAuth</label>
                                <input type="text" class="form-control" name="SMTPAuth" id="SMTPAuth" size="10" value="<?php echo $SMTPAuth; ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="page_name">Host</label>
                                <input type="text" class="form-control" name="Host" id="Host" size="10" value="<?php echo $Host; ?>" <?php if($id==1){echo 'readonly';}?>>
                            </div>
                            <div class="col-md-6 <?php if($id==1){echo 'd-none';}?>">
                                <label for="page_name">SMTPsecure</label>
                                <input type="text" class="form-control" name="SMTPSecure" id="SMTPSecure" size="10" value="<?php echo $SMTPSecure; ?>" >
                            </div>
							
                            <div class="col-md-6 <?php if($id==1){echo 'd-none';}?>">
                                <label for="page_name">setFrom</label>
                                <input type="text" class="form-control" name="setFrom" id="setFrom" size="10" value="<?php echo $setFrom; ?>" >
                            </div>
                            <div class="col-md-6 <?php if($id==1){echo 'd-none';}?>">
                                <label for="page_name">addReplyTo</label>
                                <input type="text" class="form-control" name="addReplyTo" id="addReplyTo" size="10" value="<?php echo $addReplyTo; ?>" >
                            </div>
                            <div class="col-md-6 <?php if($id==1){echo 'd-none';}?>">
                                <label for="page_name">addCC</label>
                                <input type="text" class="form-control" name="addCC" id="addCC" size="10" value="<?php echo $addCC; ?>" >
                            </div>
                            <div class="col-md-6 <?php if($id==1){echo 'd-none';}?>">
                                <label for="page_name">addBCC</label>
                                <input type="text" class="form-control" name="addBCC" id="addBCC" size="10" value="<?php echo $addBCC; ?>" >
                            </div>
                            <div class="col-md-6 <?php if($id==1){echo 'd-none';}?>">
                                <label for="page_name">isHTML</label>
                                <input type="text" class="form-control" name="isHTML" id="isHTML" size="10" value="<?php echo $isHTML; ?>" >
                            </div>
                            <div class="col-md-6 <?php if($id==1){echo 'd-none';}?>">
                                <label for="page_name">Mailer</label>
                                <input type="text" class="form-control" name="Mailer" id="Mailer" size="10" value="<?php echo $Mailer; ?>" >
                            </div>
							<div class="col-md-6 <?php if($id==1){echo 'd-none';}?>">
                                <label for="page_name">Port</label>
                                <input type="text" class="form-control" name="port" id="port" size="10" value="<?php echo $port; ?>" >
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
            url: "pages/email_setup/email_setup_save.php",
            data: $('#pageContentForm').serialize()
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
</script>
