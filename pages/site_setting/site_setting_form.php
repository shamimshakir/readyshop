
<?php include('../header.php');
    $mode = 1;
    if(isset($_REQUEST['parameter_id'])){
        $mode = 2;
        $parameter_id=$_REQUEST['parameter_id'];
        $SeNTlist = "SELECT * FROM tbl_parameter WHERE parameter_id = '$parameter_id' ";
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
                    <?php if ($mode == 1){ ?>
                        <h4 class="mt-0 header-title">Add Parameter</h4>
                    <?php }elseif ($mode = 2){ ?>
                        <h4 class="mt-0 header-title">Edit Parameter</h4>
                    <?php }?>


                    <form id="brandForm" class="" action="#" novalidate="">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="parameter_id" value="<?php  if($mode==2){echo $parameter_id;}?>">
                        <div class="row">

                            <div class="col-md-6">
                                <label for="cat_name">Parameter Name </label>
                                <input type="text" class="form-control" name="parameter_name" id="parameter_name" value="<?php echo $parameter_name; ?>" <?php if ($mode==2){echo 'readonly' ;}?> required>
                            </div>
                            <div class="col-md-6">
                                <label for="cat_parent_id">Parameter Value</label>
                                <?php if ($_POST['mode'] == '2' AND ($parameter_name == "admin_primary_color" ) ){ ?>
                                    <input type="color" class="form-control" name="parameter_value" id="parameter_value" value="<?php echo $parameter_value; ?>" >
                                <?php }else if($parameter_name == "site_theme_color"){ ?>
                                    <select name="parameter_value" id="parameter_value" class="form-control" required>
                                        <option <?php echo $parameter_value == "black" ? 'selected' : ''; ?> value="black">Black</option>
                                        <option <?php echo $parameter_value == "blue" ? 'selected' : ''; ?> value="blue">Blue</option>
                                        <option <?php echo $parameter_value == "flat-blue" ? 'selected' : ''; ?> value="flat-blue">Flat Blue</option>
                                        <option <?php echo $parameter_value == "dark-green" ? 'selected' : ''; ?> value="dark-green">Dark Green</option>
                                        <option <?php echo $parameter_value == "gold" ? 'selected' : ''; ?> value="gold">Gold</option>
                                        <option <?php echo $parameter_value == "green" ? 'selected' : ''; ?> value="green">Green</option>
                                        <option <?php echo $parameter_value == "navy" ? 'selected' : ''; ?>  value="navy">Navy</option>
                                        <option <?php echo $parameter_value == "orange" ? 'selected' : ''; ?> value="orange">Orange</option>
                                        <option <?php echo $parameter_value == "pink" ? 'selected' : ''; ?> value="pink">Pink</option>
                                        <option <?php echo $parameter_value == "red" ? 'selected' : ''; ?> value="red">Red</option>
                                        <option <?php echo $parameter_value == "yellow" ? 'selected' : ''; ?> value="yellow">Yellow</option>
                                    </select>
                                <?php }elseif($parameter_name == "active_slider"){ ?>
                                    <?php
                                    echo "<select name='parameter_value' id='parameter_value' class='form-control' required>";
                                    createCombo("Slider","tbl_slider","id","slider_name","",$parameter_value);
                                    echo "</select>";
                                    ?>
                                <?php } 
                                elseif($parameter_name=="product_tab_column_qty"){ ?>
                                    <select name="parameter_value" id="parameter_value" class="form-control" required>
                                        <option <?php echo $parameter_value == "3" ? 'selected' : ''; ?> value="3">3</option>
                                        <option <?php echo $parameter_value == "4" ? 'selected' : ''; ?> value="4">4</option>
                                        <option <?php echo $parameter_value == "6" ? 'selected' : ''; ?> value="5">5</option>
                                        <option <?php echo $parameter_value == "6" ? 'selected' : ''; ?> value="6">6</option>
                                    </select>
                                <?php }
                                
                                else if($parameter_name=='currency')
                                {
                                   
                                    echo "<select name='parameter_value' id='parameter_value' class='form-control' required>";
                                    createCombo("Currency","tbl_currency","cy_code","cy_code","",$parameter_value);
                                    echo "</select>";
                                }
                                else
                                { ?>
                                    <select class="form-control" name="parameter_value" id="parameter_value" required>
                                        <option value="ON" <?php if ($parameter_value=='ON'){echo 'selected'; } ?> >ON</option>
                                        <option value="OFF" <?php if ($parameter_value=='OFF'){echo 'selected'; } ?>>OFF</option>
                                    </select>
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <label for="act_status">Status</label>
                                <?php
                                echo "<select name='parameter_status' id='parameter_status' class='form-control' required>";
                                createCombo("Status","tbl_status","stat_id","stat_desc","",$parameter_status);
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
            url: "pages/site_setting/site_setting_save.php",
            data: $('#brandForm').serialize()
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
