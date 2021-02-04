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
						<div class="col-lg-6">
						<div class="form-group">
						  <label for="contact_phone">Contact Phone</label>
						  <input type="text" class="form-control"  name="contact_phone" id="contact_phone" value="<?php echo $contact_phone; ?>">
						</div>
					  </div>
					  <div class="col-lg-6">
						<div class="form-group">
						  <label for="contact_email">Contact Email</label>
						  <input type="text" class="form-control" name="contact_email" id="contact_email" value="<?php echo $contact_email; ?>" >
						</div>
					  </div>
                      <div class="col-lg-4">
                          <label for="cat_parent_id">Site Theme Color</label>
                          <?php 
                            $theme_sql=mysqli_query($conn, "SELECT * FROM tbl_parameter WHERE parameter_name='site_theme_color'");
                            $res_thm=mysqli_fetch_assoc($theme_sql);
                            echo "<select name='site_theme_color' id='site_theme_color' class='form-control' required>";
                            createCombo("Theme","tbl_theme","theme_name","theme_name","",$res_thm['parameter_value']);
                            echo "</select>";
                          ?>
                        
                      </div>
                      <div class="col-lg-4">
                          <label for="cat_parent_id">Product tab column Quantity</label>
                          <?php 
                            $qty_sql=mysqli_query($conn, "SELECT * FROM tbl_parameter WHERE parameter_name='product_tab_column_qty'");
                            $res_qty=mysqli_fetch_assoc($qty_sql);
                            // echo $res_thm['parameter_value'];
                          ?>

                          <select name="product_tab_column_qty" id="product_tab_column_qty" class="form-control" required>
                            <option <?php echo $res_qty['parameter_value'] == "3" ? 'selected' : ''; ?> value="3">3</option>
                            <option <?php echo $res_qty['parameter_value'] == "4" ? 'selected' : ''; ?> value="4">4</option>
                            <option <?php echo $res_qty['parameter_value'] == "6" ? 'selected' : ''; ?> value="5">5</option>
                            <option <?php echo $res_qty['parameter_value'] == "6" ? 'selected' : ''; ?> value="6">6</option>
                          </select>
                      </div>
                      <div class="col-lg-4">
                        <label for="cat_parent_id">Currency</label>
                          <?php
                          $c_sql=mysqli_query($conn, "SELECT * FROM tbl_parameter WHERE parameter_name='currency'");
                          $res_c=mysqli_fetch_assoc($c_sql);

                            echo "<select name='currency' id='currency' class='form-control' required>";
                            createCombo("Currency","tbl_currency","cy_code","cy_code","",$res_c['parameter_value']);
                            echo "</select>";
                          ?>
                      </div>
                      <div class="col-lg-4 mt-3">
                        <label for="cat_parent_id">Brand Filtering</label>
                          <?php
                          $b_sql=mysqli_query($conn, "SELECT * FROM tbl_parameter WHERE parameter_name='brand'");
                          $res_b=mysqli_fetch_assoc($b_sql);
                          ?>
                          <select name="brand" id="brand" class="form-control" required>
                            <option <?php echo $res_b['parameter_value'] == "ON" ? 'selected' : ''; ?> value="ON">ON</option>
                            <option <?php echo $res_b['parameter_value'] == "OFF" ? 'selected' : ''; ?> value="OFF">OFF</option>
                          </select>
                      </div>
                      <div class="col-lg-4 mt-3">
                        <label for="cat_parent_id">Color Filtering</label>
                          <?php
                          $clr_sql=mysqli_query($conn, "SELECT * FROM tbl_parameter WHERE parameter_name='color'");
                          $res_clr=mysqli_fetch_assoc($clr_sql);
                          ?>
                          <select name="color" id="color" class="form-control" required>
                            <option <?php echo $res_clr['parameter_value'] == "ON" ? 'selected' : ''; ?> value="ON">ON</option>
                            <option <?php echo $res_clr['parameter_value'] == "OFF" ? 'selected' : ''; ?> value="OFF">OFF</option>
                          </select>
                      </div>
                      <div class="col-lg-4 mt-3">
                        <label for="cat_parent_id">Price Filtering</label>
                          <?php
                          $p_sql=mysqli_query($conn, "SELECT * FROM tbl_parameter WHERE parameter_name='price'");
                          $res_p=mysqli_fetch_assoc($p_sql);
                          ?>
                          <select name="price" id="price" class="form-control" required>
                            <option <?php echo $res_p['parameter_value'] == "ON" ? 'selected' : ''; ?> value="ON">ON</option>
                            <option <?php echo $res_p['parameter_value'] == "OFF" ? 'selected' : ''; ?> value="OFF">OFF</option>
                          </select>
                      </div>



                     
                        
                        <div class="col-md-6 mt-3">
                            <label for="logo">Logo (width 230px * height 50px png/jpg)</label>
                            <input class="form-control" type="file" name="logo" id="logo" value="<?php echo $logo; ?>">
                            <img style="width: auto; height: 60px; margin: 10px 0;" src="<?php echo $folder_admin.$logo;?>" alt="">
                        </div>
                        
                        <div class="col-md-6 mt-3">
                            <label for="favicon">Favicon (width 50px * hight 50px png/jpg)</label>
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
