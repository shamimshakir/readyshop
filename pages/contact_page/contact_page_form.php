<?php
include( '../header.php' );
$mode = 1;
if ( isset( $_REQUEST[ 'id' ] ) ) {
  $id = $_REQUEST[ 'id' ];
  $SeNTlist = "SELECT * FROM tbl_contact_page_info WHERE id = '$id' ";
  $ExSeNTlist = mysqli_query( $conn, $SeNTlist )or die( mysqli_error( $conn ) );
  $rowNewsTls = mysqli_num_rows( $ExSeNTlist );
  $rowNewsTl = mysqli_fetch_array( $ExSeNTlist );
  extract( $rowNewsTl );
}

?>
<div id="mainContent">
  <div class="row">
    <div class="col-lg-10 offset-lg-1">
      <div class="card m-b-20">
        <div class="card-body">
          <h4 class="mt-0 header-title">Contact Page Setting</h4>
          <form id="contact_page_form" class="" action="#" novalidate="">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <label for="contact_address">Contact Address</label>
                  <input type="text" class="form-control" name="contact_address" id="contact_address" value="<?php echo $contact_address; ?>">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label for="contact_phone">Contact Phone</label>
                  <input type="text" class="form-control"  name="contact_phone" id="contact_phone" value="<?php echo $contact_phone; ?>">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label for="contact_email">Contact Email</label>
                  <input type="text" class="form-control" name="contact_email" id="contact_email" value="<?php echo $contact_email; ?>" >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label for="contact_map_location">Contact Map Location</label>
                  <textarea class="form-control" rows="6" name="contact_map_location" id="contact_map_location"><?php echo $contact_map_location; ?></textarea>
                </div>
              </div>
            </div>
            <div class="form-group mb-0 d-flex justify-content-end">
              <div>
                <button type="button" class="btn btn-secondary waves-effect" onclick="view_data()">Cancel</button>
                <button type="button" onclick="save()"  class="btn btn-primary waves-effect waves-light mr-1">Update</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
	if(tinyMCE.get('contact_map_location')){

 // Remove instance by id
 tinymce.remove('#contact_map_location');
	addTinyMCE();
}else{
   tinymce.remove('#contact_map_location');
addTinyMCE();
}

    // Add TinyMCE
function addTinyMCE(){
  // Initialize
  tinymce.init({
			selector: "textarea#contact_map_location",
			theme: "modern",
			height:300,
			plugins: [
				"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
				"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				"save table contextmenu directionality emoticons template paste textcolor"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
			style_formats: [
				{title: 'Bold text', inline: 'b'},
				{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
				{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
				{title: 'Example 1', inline: 'span', classes: 'example1'},
				{title: 'Example 2', inline: 'span', classes: 'example2'},
				{title: 'Table styles'},
				{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
			]
		});
}
    function save() {
		tinyMCE.triggerSave(); 
        if($('form#contact_page_form').parsley().validate()){
            $.ajax({
                type: "POST",
                url: "pages/contact_page/contact_page_save.php",
                data: $('#contact_page_form').serialize()
            }).done(function(response) {
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
            }).fail(function() {
                alertify.notify(response, 'error', 3)
            });
        }
    }

</script> 
