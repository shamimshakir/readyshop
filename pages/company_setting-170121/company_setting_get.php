<?php include('../header.php');
session_start();
$sql = "SELECT * FROM tbl_company_setup";
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
                        <span>Company Setting</span>
                    </h4> 
                    <form action="" id="company_setting_form" novalidate="" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="company_name">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" value="<?php if(isset($rowNewsTls)) {echo $company_name;} ?>" required>
                                    <input type='hidden' name='user_id' value='<?php echo $user_id; ?>' />
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="website_slogan">Website Slogan</label>
                                <input type="text" class="form-control" id="website_slogan" name="website_slogan" value="<?php if(isset($rowNewsTls)) {echo $website_slogan;} ?>" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="comp_address">Company Address</label>
                                <input type="text" class="form-control" id="comp_address" name="comp_address" value="<?php if(isset($rowNewsTls)) {echo $comp_address;} ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="website_url">Website URL</label>
                                <input type="text" class="form-control" id="website_url" name="website_url" value="<?php if(isset($rowNewsTls)) {echo $website_url;} ?>" required>
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
                        
                        <div class="col-md-6">
                            <label for="logo">Logo</label>
                            <input class="form-control" type="file" name="logo" id="logo" value="<?php echo $logo; ?>">
                            <img style="width: auto; height: 60px; margin: 10px 0;" src="<?php echo $folder_admin.$logo;?>" alt="">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="favicon">Favicon </label>
                            <input class="form-control" type="file" name="favicon" id="favicon" value="<?php echo $favicon; ?>">
                            <img style="width: auto; height: 60px; margin: 10px 0;" src="<?php echo $folder_admin.$favicon;?>" alt=""> 
                        </div>
      <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label for="contact_map_location">Contact Map Location</label>
                  <textarea class="form-control" rows="6" name="contact_map_location" id="contact_map_location"><?php echo $contact_map_location; ?></textarea>
                </div>
              </div>
            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0 d-flex justify-content-end">
                        <div>
                            <button type="button" onclick="update_company_setting()" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
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
   
    function update_company_setting() {
		tinyMCE.triggerSave(); 
        if($('form').parsley().validate()){
            var form = $('form')[0];
            var formData = new FormData(form);
            $.ajax({
                type: "POST",
                url: "pages/company_setting/company_setting_save.php",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
            }).done(function(response) {
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
                console.log(response);
            }).fail(function() {
                alertify.notify(response, 'error', 3);
            });
        }
    }
</script>