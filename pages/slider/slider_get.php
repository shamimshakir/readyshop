<?php include('../header.php');
    $SUserID =$_SESSION[ "user_profile_id" ];
    $pageid = pick('_tree_entries', 'id', "file_name = 'slider.php'");
    $addper=PermissionVerification($SUserID,$pageid,'add');
?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Slider</span>
                        <?php if($addper>0){?><span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span><?php } ?>
                    </h4>

                    <div class="row">
                        <div class="col-lg-3">
                            <label for="slider_name">Select Slider to show slides</label>
                            <select name="slider_name" id="slider_name" class="form-control" onchange="getSliderData(this.value)" disabled>
                                <?php 
								$sstatus=pick('tbl_slider','id','status=1');
								createCombo('Slider Name', 'tbl_slider', 'id', 'slider_name', '', $sstatus); ?>
                            </select>
                        </div>
						<!--<div class="col-lg-2">
                                <input value='Apply For Home Page' type='button' name='btnsubmit' class='forms_button_e btn btn-primary' style="margin-top: 22px;" onclick='saveData()'>
                            </div>-->
                    </div>
<h3><?php echo $sstatus=pick('tbl_slider','slider_name','status=1');?> Slider Selected For Home Page</h3>
                    <div id="slidesShowTable" class="mt-4"></div>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>

<script>
    function getSliderData(val) {
        $.ajax({
            type: "POST",
            url: "pages/slider/get_slides_by_slider.php",
            data: {
                slider_id: val
            },
            success: function (response){
                $( '#slidesShowTable' ).html(response);
            }
        });
    }
    getSliderData($("#slider_name").val());

    function add() {
		var slider_id=$('#slider_name').val();
        $.ajax({
            type: "POST",
            url: "pages/slider/get_sliderForm_by_slider.php",
            data: {
				slider_id:slider_id
			},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function edit(slide_id, slider_id) {
        $.ajax({
            type: "POST",
            url: "pages/slider/slider_update_form.php",
            data: {
                slide_id: slide_id,
                slider_id : slider_id
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
	function saveData(){
		var slider_id=$('#slider_name').val();
        $.ajax({
            type: "POST",
            url: "pages/slider/status_save.php",
            data: {
			slider_id:slider_id	
			}
        }).done(function(msg) {
           alertify.set('notifier','position', 'bottom-right');
            alertify.success(msg);
			view_data();
        }).fail(function() {
            alert("error");
			view_data();
        });
    }

    function update_status(id) {
        $.ajax({
            type: "POST",
            url: "pages/update_status_ajax.php",
            data: {
                table: "tbl_slider_images",
                idField: "id",
                id: id,
                status: "act_status"
            },
            success: function (response){
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
            }
        });
    }
</script>