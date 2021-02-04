
<?php include('../header.php');
    $mode = 1;
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        $mode = 2;
        $SeNTlist = "SELECT * FROM tbl_faq WHERE id = '$id' ";
        $ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error($conn));
        $rowNewsTls=mysqli_num_rows($ExSeNTlist);
        $rowNewsTl=mysqli_fetch_array($ExSeNTlist);
        extract($rowNewsTl);
    }
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card m-b-20">
                <div class="card-body">
                    <?php if ($mode == 1){ ?>
                        <h4 class="mt-0 header-title">Add FAQ</h4>
                    <?php }elseif ($mode = 2){ ?>
                        <h4 class="mt-0 header-title">Edit FAQ</h4>
                    <?php }?>


                    <form id="faqForm" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="id" value="<?php  if($mode==2){echo $id;}?>">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="faq_question">FAQ Question <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" placeholder="FAQ Question" name="faq_question" id="faq_question" value="<?php echo $faq_question; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="faq_answer">FAQ Answer <span style="color:red;">*</span></label>
                                    <textarea class="form-control" name="faq_answer" id="faq_answer" placeholder="FAQ Answer" cols="30" rows="10" required><?php echo $faq_answer; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="status">Status</label>
                                <?php
								if($mode==1){
									$active_status=1;
								}
                                echo "<select name='status' id='status' class='form-control'>";
                                createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$active_status);
                                echo "</select>";
                                ?>
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
		if($('form').parsley().validate()){
        $.ajax({
            type: "POST",
            url: "pages/faq/faq_save.php",
            data: $('#faqForm').serialize()
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
