<?php include('../header.php');
$slide_id = $_REQUEST['slide_id'];
$slider_id = $_REQUEST['slider_id'];
$sql = "SELECT * FROM tbl_slider_images WHERE id = $slide_id AND slider_id = $slider_id";
$res = mysqli_query($conn, $sql);
$slide = mysqli_fetch_assoc($res);
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 id="myModalLabel">Edit Slider</h4>
                    <form id="sliderForm" class="" action="#" novalidate="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="slider_title">Title </label>
                                <input type="text" class="form-control" name="slider_title" id="slider_title" size="10" value="<?php echo $slide['title_text']; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="act_status">Status</label>
                                <?php echo "<select name='act_status' id='act_status' class='form-control'>";
                                createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ", "$slide[act_status]");
                                echo "</select>"; ?>
                            </div>
                            <input type="hidden" name="p_slider_id" id="p_slider_id" value="<?php echo $slider_id; ?>" >
                            <input type="hidden" name="slide_id" id="slide_id" value="<?php echo $slide_id; ?>" >
                            <div class="col-md-6">
                                <label for="main_text">Main Text</label>
                                <textarea name='main_text' class="form-control" id='main_text'  cols="40" rows="3"><?php echo $slide['main_text']; ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="main_text">Alternative Text</label>
                                <textarea name='alt_text' class="form-control" id='alt_text' cols="40" rows="3"><?php echo $slide['alt_text']; ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="bg_img">Image( <span style="font-size: 11px">(width 517px*height 697px)</span> )</label>
                                <input type="file" class="form-control" name="bg_img" id="bg_img">
                                <img style="max-height: 100px;" src="uploads/slider/<?php echo $slide['bg_img']; ?>" alt="">
                            </div>
                            <div class="col-md-6">
                                <label for="main_text">URL</label>
                                <input type="text" name='url' class="form-control" id='url' value="<?php echo $slide['url']; ?>">
                            </div>
                        </div>
                        <div class="form-group mb-0 d-flex justify-content-end">
                            <div>
                                <button type="button" class="btn btn-secondary waves-effect" onclick="view_data()">Cancel</button>
                                <button type="button" onclick="slider_update()" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function slider_update() {
        var form = $('form')[0];
        var formData = new FormData(form);
        $.ajax({
            type: "POST",
            url: "pages/slider/slider_update.php",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
            //console.log(response);
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
</script>
