<?php include('../header.php');
$mode = 1;

if(isset($_REQUEST['id'])){
    $mode = 2;
}
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card m-b-20">
                <div class="card-body">
                    <?php if ($mode == 1){ ?>
                        <h4 id="myModalLabel">Add Slider</h4>
                    <?php } if ($mode == 2){ ?>
                        <h4 id="myModalLabel">Edit Slider</h4>
                    <?php }?>
                    <div class="row">
                        <div class="col-lg-5">
                            <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
                            <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                            <label for="slider_name">Select Slider to Add slide</label>
                            <select name="slider_name" id="slider_name" class="form-control" onchange="getSliderForm(this.value)">
                                <?php createCombo('Slider Name', 'tbl_slider', 'id', 'slider_name', '', ''); ?>
                            </select>
                        </div>
                    </div>
                    <div id="SliderFormSection" class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    function getSliderForm(val){
        $.ajax({
            type: "POST",
            url: "pages/slider/get_sliderForm_by_slider.php",
            data: {
                slider_id: val
            },
            success: function (response){
                $( '#SliderFormSection' ).html(response);
            }
        });
    }

</script>
