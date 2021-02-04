<?php
include( '../header.php' );
$mode = 1;

if ( isset( $_REQUEST[ 'pd_id' ] ) ) {
  $mode = 2;
  $pd_id = $_POST[ 'pd_id' ];
  $SeNTlist = "SELECT * FROM tbl_product WHERE pd_id = '$pd_id' ";
  $ExSeNTlist = mysqli_query( $conn, $SeNTlist )or die( mysqli_error( $conn ) );
  $rowNewsTls = mysqli_num_rows( $ExSeNTlist );
  $rowNewsTl = mysqli_fetch_array( $ExSeNTlist );
  extract( $rowNewsTl );
}
?>
<link href="assets/duallistbox/bootstrap-duallistbox.min.css" rel="stylesheet">
<style>
label {
	margin-top: 17px;
}
h6 {
	margin: 0;
	margin-top: 30px;
}
.modalImgShowww img {
	height: 70px;
	margin-right: 10px;
	border-radius: 3px;
}
.proImgUplods div a {
	text-decoration: none;
	background: #333;
	color: #fff;
	height: 20px;
	width: 20px;
	text-align: center;
	display: flex;
	justify-content: center;
	border-radius: 30px;
	font-size: 20px;
	line-height: 17px;
}
.proImgUplods div {
	display: flex;
}
.proImgUplods div a.remove_button {
	background: red;
}
</style>
<div id="mainContent">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-20">
        <div class="card-body">
          <?php if ($mode == 1){ ?>
          <h4 id="myModalLabel">Add Product</h4>
          <?php } if ($mode == 2){ ?>
          <h4 id="myModalLabel">Edit Product</h4>
          <?php }?>
          <form id="productForm" role="form" method="post" class="" action="#" novalidate="" enctype="multipart/form-data">
            <input type="hidden" name="mode" value="<?php echo $mode;?>">
            <input type="hidden" name="pd_id" value="<?php  if($mode==2){echo $pd_id;}?>">
            <div class="row">
              <div class="col-lg-3">
                <label for="pd_name">Product Name <span style="color:red;">*</span></label>
                <input type="text" name="pd_name" class="form-control" id="pd_name" value="<?php if(isset($rowNewsTls)) {echo $pd_name;} ?>" onKeyUp="get_code()"  placeholder="Product Name" required >
              </div>
              <div class="col-lg-3">
                <label for="cat_id">Category <span style="color:red;">*</span></label>
                <select name='cat_id' id='cat_id' class='form-control' required='' data-parsley-required-message="You must select at least one option." onChange="get_code()">
                  <?php createCombo("Category","tbl_category","cat_id","cat_name","ORDER BY cat_name ",$cat_id);?>
                </select>
              </div>
              <!--<div class="col-lg-3">
                <label for="unit_type">Measurement Unit <span style="color:red;">*</span></label>
                <?php
                //echo "<select name='unit_type' id='unit_type' class='form-control' required>";
               // createCombo( "Unit", "tbl_unit", "unit_id", "unit_display", "ORDER BY unit_display ", $unit_type );
               // echo "</select>";
                ?>
              </div>-->
              <div class="col-lg-3">
                <label for="pd_price">Sell Price <span style="color:red;">*</span></label>
                <input type="text" data-parsley-type="number" class="form-control" placeholder="Sell Price" name="pd_price" id="pd_price" size="11" value="<?php echo $pd_price; ?>" required>
              </div>
              <div class="col-md-3">
                <label for="pd_prev_price">Prvious Price </label>
                <input type="text"  class="form-control" name="pd_prev_price" id="pd_prev_price" size="22" value="<?php echo $pd_prev_price; ?>" Maxlength="22" >
              </div>
              <div class="col-md-3">
                <label for="hst">VAT (%)</label>
                <input class="form-control" type="text" name="hst" id="hst" size="" value="<?php echo $hst; ?>">
              </div>
              <div class="col-lg-3">
                <label for="brand_id">Brand</label>
                <?php
                echo "<select name='brand_id' id='brand_id' class='form-control' onChange=\"get_code()\">";
                createCombo( "Brand", "tbl_brand", "brand_id", "brand_display", "ORDER BY brand_display ", $brand_id );
                echo "</select>";
                ?>
              </div>
              <div class="col-md-3">
                <label for="pd_qty">Store Quantiy </label>
				  <?php $stock_maintain=pick('tbl_parameter','parameter_status'," parameter_name= 'stock_inventory'");?>
                <input type="text" class="form-control" name="pd_qty" id="pd_qty" size="5" value="<?php echo $pd_qty; ?>" <?php 
					   if($stock_maintain!=1){
						   echo 'readonly';
					   }
					   ?>>
              </div>
              <div class="col-lg-3">
                <label for="pd_code">Product Code</label>
                <input type="text" name="pd_code" id="pd_code" placeholder="Product Code" class="form-control" size="" value="<?php echo $pd_code; ?>" readonly>
              </div>
              <div class="col-md-6">
                <label for="">Status / badge</label>
                <div> <span>
                  <input type="checkbox" name="upsstat" id="upsstat" size="1"  <?php echo !empty($upsstat)?"checked":""; ?> >
                  UpComing </span> <span>
                  <input type="checkbox" name="popular_stat" id="popular_stat" size="1"  <?php echo !empty($popular_stat)?"checked":""; ?> >
                  Popular </span> <span>
                  <input type="checkbox" name="feature_stat" id="feature_stat" size="1"  <?php echo !empty($feature_stat)?"checked":""; ?> >
                  Feature </span> <span>
                  <input type="checkbox" name="new_stat" id="new_stat" size="1"  <?php echo !empty($new_stat)?"checked":""; ?> >
                  New Arrival </span> <span>
                  <input type="checkbox" name="on_sale" id="on_sale" size="1"  <?php echo !empty($onsale_stat)?"checked":""; ?> >
                  On Sale </span> </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="col-md-12">
                  <label for="color_apply">Color Applicable</label>
                  <div> <span>
                    <input type="radio" name="color_apply" <?php if($color_apply=='0'){ echo 'checked';} ?> value="0" onclick='get_color()'>
                    Yes </span> <span>
                    <input type="radio" name="color_apply"  <?php if($color_apply=='1'){ echo 'checked';} ?> value="1" onclick='get_color()'>
                    NO </span> </div>
                </div>
                <div class="col-md-12" id='show_colors'></div>
              </div>
              <div class="col-md-6">
                <div class="col-md-12">
                  <label for="size_apply">Size Applicable</label>
                  <div> <span>
                    <input type="radio" name="size_apply" <?php if($size_apply=='0'){ echo 'checked';} ?> value="0" onclick='get_size()'>
                    Yes </span> <span>
                    <input type="radio" name="size_apply"  <?php if($size_apply=='1'){ echo 'checked';} ?> value="1" onclick='get_size()'>
                    NO </span> </div>
                </div>
                <div class="col-md-12" id='show_size'></div>
              </div>
            </div>
            <h6>Images</h6>
            <div class="row">
              <div class="col-lg-6">
                <label for="pd_thumbnail">Product Thumbnail <span style="color:red;">*(300px*300px)</span></label>
                <br>
                <input type="file" class="form-control" id="pd_thumbnail" name="pd_thumbnail" <?php if($mode==1){ echo 'required'; } ?> >
                <div class="modalImgShowww">
                  <?php
                  if ( $_POST[ 'mode' ] == '2' ) {
                    $sqlthum = "SELECT pd_thumbnail FROM tbl_product WHERE pd_id = '$pd_id'";
                    $Exsqlthum = mysqli_query( $conn, $sqlthum )or die( mysqli_error( $conn ) );
                    while ( $row = mysqli_fetch_array( $Exsqlthum ) ) {
                      extract( $row );
                      ?>
                  <img src="<?php echo $folder_admin.'products/thumbnails/'.$pd_thumbnail; ?>" alt="">
                  <?php }} ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="proImgUplods">
                  <h4 style="font-size: 14px; font-weight: 600;">Upload Products Images <span style="color:red;">*(720px*660px)</span></h4>
                  <div>
                    <input type="file" class="form-control" name="pro_img_name[]" value=""/>
                    <a href="javascript:void(0);" class="add_button">+</a> </div>
                </div>
                <div class="modalImgShowww">
                  <style>
						.delete{
							    position: absolute;
							margin-top: 7px;
							color: #ef0202;
							font-size: 17px;
						}
					</style>
                  <?php
                  if ( $_POST[ 'mode' ] == '2' ) {
                    $SeNTlist = "SELECT tbl_product_images.*, tbl_product.cat_id, tbl_product.pd_name, tbl_category.cat_name 
                                            FROM tbl_product
                                            LEFT JOIN tbl_product_images ON tbl_product_images.product_id = tbl_product.pd_id
                                            LEFT JOIN tbl_category ON tbl_category.cat_id = tbl_product.cat_id
                                            WHERE tbl_product_images.product_id = '$pd_id'";
                    $ExSeNTlist = mysqli_query( $conn, $SeNTlist )or die( mysqli_error( $conn ) );
                    while ( $row = mysqli_fetch_array( $ExSeNTlist ) ) {
                      extract( $row );
                      ?>
                  <span style="position: relative" id="<?php echo $pro_img_id;?>"> <span class="delete" onClick="delete_image('<?php echo $folder_admin.'products/'.$cat_name.'/'.$pd_name; ?>',<?php echo $pro_img_id;?>,'<?php echo $pro_img_name;?>')"><i class="fa fa-trash" aria-hidden="true"></i></span> <img src="<?php echo $folder_admin.'products/'.$cat_name.'/'.$pd_name.'/comm'.'/'.$pro_img_name ?>" alt="" > </span>
                  <?php }} ?>
                </div>
              </div>
            </div>
            <h6> Product Highlight </h6>
            <div class="row">
              <div class="col-lg-12">
                <textarea name="product_highlight" id="product_highlight" rows="10" cols="80">
                                    <?php if(isset($rowNewsTls)) {echo $product_highlight;} ?>
                                </textarea>
              </div>
            </div>
            <h6>
              <div> Product Detail &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" id="switch1" switch="none"  value="1" onclick="update_status(<?php echo $pd_id.", 'detail_status'"?>)" 
						   <?php if ( $detail_status == 0 ) { echo "checked";}else{ }?>
						   >
                <label for="switch1" data-on-label="On" data-off-label="Off" ></label>
              </div>
            </h6>
            <div class="row">
              <div class="col-lg-12">
                <textarea name="product_detail" id="product_detail" rows="10" cols="80">
                                    <?php if(isset($rowNewsTls)) {echo $product_detail;} ?>
                                </textarea>
              </div>
            </div>
            <h6>
              <div> Product Specification &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" id="switch2" switch="none"  value="1" onclick="update_status(<?php echo $pd_id.", 'specification_status'"?>)" 
						   <?php if ( $specification_status == 0 ) { echo "checked";}else{ }?>
						   >
                <label for="switch2" data-on-label="On" data-off-label="Off" ></label>
              </div>
            </h6>
            <div class="row">
              <div class="col-lg-12">
                <textarea name="product_specification" id="product_specification" rows="10" cols="80">
                                    <?php if(isset($rowNewsTls)) {echo $product_specification;} ?>
                                </textarea>
              </div>
            </div>
            <h6>
              <div> Warranties &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" id="switch3" switch="none"  value="1" onclick="update_status(<?php echo $pd_id.", 'warranties_status'"?>)" 
						   <?php if ( $warranties_status == 0 ) { echo "checked";}else{ }?>
						   >
                <label for="switch3" data-on-label="On" data-off-label="Off" ></label>
              </div>
            </h6>
            <div class="row">
              <div class="col-lg-12">
                <textarea name="product_warranty" id="product_warranty" rows="10" cols="80" style="margin-top: 10px;">
                                    <?php if(isset($rowNewsTls)) {echo $product_warranty;} ?>
                                </textarea>
              </div>
            </div>
            <div class="form-group mb-0 mt-2 d-flex justify-content-end">
              <div>
                <button type="button" class="btn btn-secondary waves-effect" onclick="view_datas()">Cancel</button>
                <?php if ($mode == 1){ ?>
                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Save</button>
                <?php }elseif($mode == 2){ ?>
                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                <?php }?>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="assets/duallistbox/jquery.bootstrap-duallistbox.min.js"></script> 
<script type="text/javascript">
   // Check TinyMCE initialized or not
if(tinyMCE.get('product_detail')){

 // Remove instance by id
 tinymce.remove('#product_detail');
 tinymce.remove('#product_specification');
 tinymce.remove('#product_warranty');
 tinymce.remove('#product_highlight');
	addTinyMCE();
}else{
   tinymce.remove('#product_detail');
   tinymce.remove('#product_specification');
   tinymce.remove('#product_warranty');
   tinymce.remove('#product_highlight');
addTinyMCE();
}
function addTinyMCE(){	
tinymce.init({
	selector: "textarea#product_detail",
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

tinymce.init({
	selector: "textarea#product_specification",
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

tinymce.init({
                selector: "textarea#product_warranty",
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
	
tinymce.init({
                selector: "textarea#product_highlight",
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
    $("#productForm").on('submit', (function(e) {
        e.preventDefault();
        if($('form').parsley().validate()){
            var data = new FormData(this);
            data.append('product_detail', tinyMCE.get('product_detail').getContent());
            data.append('product_specification', tinyMCE.get('product_specification').getContent());
            data.append('product_warranty', tinyMCE.get('product_warranty').getContent());
    
            $.ajax({
                url: "pages/product/product_save.php",
                type: "POST",
                data: data,
                contentType: false,
                cache: false,
                processData: false
            }).done(function(response) {
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_datas();
                //console.log(response);
            });
        }
    }));
        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.proImgUplods'); //Input field wrapper
            var fieldHTML =
                `<div>
        <input type="file" class="form-control mt-1" name="pro_img_name[]" value=""/>
        <a href="javascript:void(0);" class="remove_button">-</a>
    </div>`;
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
        
       function get_color() {
        	var values = $("input[name='color_apply']:checked").val();
        	if (values == 0) {
        		//alert('sdasdsa');
        		$.ajax({
        			url: "pages/product/get_colors.php",
        			type: "POST",
        			data: {
        				pd_id: <?php if($pd_id==''){echo '0';}else{echo $pd_id;}?>,
        				mode: <?php echo $mode;?>,
        			},
        
        		}).done(function (response) {
        			//alert(response);
        			$('#show_colors').html(response);
        		});
        
        	} else {
        		$('#show_colors').html('');
        	}
        };
        get_color();
        
        function get_size() {
        	var size_values = $("input[name='size_apply']:checked").val();
        	if (size_values == 0) {
        		//alert('sdasdsa');
        		$.ajax({
        			url: "pages/product/get_size.php",
        			type: "POST",
        			data: {
        				pd_id: <?php if($pd_id==''){echo '0';}else{echo $pd_id;}?>,
        				mode: <?php echo $mode;?>,
        			},
        
        		}).done(function (response) {
        			//alert(response);
        			$('#show_size').html(response);
        		});
        
        	} else {
        		$('#show_size').html('');
        	}
        };
        get_size();
	function view_datas(){		
		$.ajax({
                url: "pages/product/product.php",
                type: "GET",
                
            }).done(function (response) {        			
        			$('#mainContent').html(response);
        		})
	}
	function get_code() {
		
        	var cat_id = $("#cat_id").val();
        	var brand_id = $("#brand_id").val();
			var pd_name = $("#pd_name").val();
        	if (cat_id >0 && brand_id>0 && pd_name!='') {
				
        		$.ajax({
        			url: "pages/product/get_code.php",
        			type: "POST",
        			data: {
        				cat_id: cat_id,
        				brand_id: brand_id,
						pd_name:pd_name
        			},
        
        		}).done(function (response) {
        			
        			$('#pd_code').val(response);
        		});
        
        	} else {
        		$('#pd_code').val('');
        	}
        };
     function update_status(id,field) {
        $.ajax({
            type: "POST",
            url: "pages/product/product_details_status.php",
            data: {
                id : id,
				field:field
            },
            success: function (response){
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                
            }
        });
    }   
	function delete_image(loc,id,p_name){
		$.ajax({
            type: "POST",
            url: "pages/product/product_delete.php",
            data: {
                id : id,
				loc:loc,
				p_name:p_name
            },
            success: function (response){
				console.log(response);
                alertify.set('notifier','position', 'bottom-right');
                alertify.success('Remove successfully');
				$('#'+id).html('');
                
            }
        });
		
	}
</script> 
