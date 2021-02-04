<?php include('../header.php');
$mode = 1;

if(isset($_REQUEST['color_id'])){
    $color_id = $_REQUEST['color_id'];
    $mode = 2;
    $SeNTlist = "SELECT * FROM tbl_color WHERE color_id = '$color_id' ";
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
                    <?php if ($mode == '1'){ ?>
                        <h4 id="myModalLabel">Add Color</h4>
                    <?php } if ($mode == '2'){ ?>
                        <h4 id="myModalLabel">Edit Color</h4>
                    <?php }?>


                    <form id="productColorForm" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="color_id" value="<?php  if($mode==2){echo $color_id;}?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="color_name">Color Name <span style="color:red;">*</span></label>
                                <input type="text" name="color_name" id="color_name" class="form-control" value="<?php echo $color_name; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="color_status">Color Status</label>
                                <?php
                                echo "<select name='color_status' id='color_status' class='form-control'>";
                                createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$color_status);
                                echo "</select>";
                                ?>
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
                url: "pages/product_color/product_color_save.php",
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
