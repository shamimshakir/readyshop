<?php
include( '../header.php' );
$slider_id = $_REQUEST[ 'slider_id' ];

?>
<div id="mainContent">
  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="card m-b-20">
        <div class="card-body">
          <form id="sliderForm" class="" action="#" novalidate="" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                <label for="slider_title">Title </label>
                <input type="text" class="form-control" name="slider_title" id="slider_title" size="10" >
              </div>
              <div class="col-md-6">
                <label for="act_status">Status</label>
                <?php echo "<select name='act_status' id='act_status' class='form-control'>";
                createCombo( "Status", "tbl_status", "stat_id", "stat_desc", "ORDER BY stat_desc ", "" );
                echo "</select>";
                ?> </div>
              <input type="hidden" name="p_slider_id" id="p_slider_id" value="<?php echo $slider_id; ?>" >
              <div class="col-md-6">
                <label for="main_text">Main Text</label>
                <textarea name='main_text' class="form-control" id='main_text'  cols="40" rows="3"></textarea>
              </div>
              <div class="col-md-6">
                <label for="main_text">Alternative Text</label>
                <textarea name='alt_text' class="form-control" id='alt_text' cols="40" rows="3"></textarea>
              </div>
              <div class="col-md-6">
                <label for="bg_img">Image(width 517px*height 697px)</label>
                <input type="file" class="form-control" name="bg_img" id="bg_img">
              </div>
              <div class="col-md-6">
                <label for="main_text">URL</label>
                <input type="text" name='url' class="form-control" id='url' value="">
              </div>
            </div>
            <div class="form-group mb-0 mt-2 d-flex justify-content-end">
              <div>
                <button type="button" class="btn btn-secondary waves-effect" onclick="view_data()">Cancel</button>
                <button type="button" onclick="save()" class="btn btn-primary waves-effect waves-light mr-1">Save</button>
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
        var form = $('form')[0];
        var formData = new FormData(form);
        $.ajax({
            type: "POST",
            url: "pages/slider/slider_save.php",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
</script>