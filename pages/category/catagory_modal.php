<div class="modal-header">
  <?php
  if ( $_POST[ 'mode' ] == '1' ) {
    ?>
  <h5 class="modal-title" id="myModalsmall">Add Category</h5>
  <?php
  }
  if ( $_POST[ 'mode' ] == '2' ) {
    ?>
  <h5 class="modal-title" id="myModalsmall">Edit Category</h5>
  <?php }?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<form id="catagory_form" name="MyForm">
  <div class="modal-body">
    <?php
    include_once '../../library/dbconnect.php';
    include_once '../../library/library.php';
    if ( $_POST[ 'mode' ] == '2' ) {
      $cat_id = $_POST[ 'id' ];

      $SeNTlist = "SELECT 
									`cat_id`, 
									`cat_parent_id`, 
									`cat_name`, 
									`cat_description`, 
									`cat_image`, 
									`level_id`, 
									`act_status`, 
									`catagory_code`, 
									`sl` 
								FROM 
									`tbl_category`  
							WHERE cat_id = '$cat_id' ";
      $ExSeNTlist = mysqli_query( $conn, $SeNTlist )or die( mysqli_error( $conn ) );
      while ( $rowNewsTl = mysqli_fetch_array( $ExSeNTlist ) ) {
        extract( $rowNewsTl );
      }
    }
    ?>
    <div class=" col-md-12">
      <input type="hidden" name="cat_id" id="cat_id" value="<?php echo $_POST['id']; ?>">
      <label for="cat_name">Category Name</label>
      <input type="text" class="form-control input-sm" name="cat_name" id="cat_name" value="<?php echo $cat_name;?>" placeholder="Category Name">
    </div>
	  <div class=" col-md-12">
      <label for="cat_name">Category Code</label>
      <input type="text" class="form-control input-sm" name="catagory_code" id="catagory_code" value="<?php echo $catagory_code;?>" placeholder="Category Code">
    </div>
    <div class=" col-md-12">
      <label for="level_id">Level </label>
      <select name='level_id' id='level_id' class='form-control' required='' data-parsley-required-message="You must select at least one option." >
        <?php createCombo("Level","tbl_level","id","name"," ORDER BY name ",$level_id);?>
      </select>
    </div>
    <div class="col-md-12">
      <label for="level_id">Parent </label>
      <select name='cat_parent_id' id='cat_parent_id' class='form-control' required='' data-parsley-required-message="You must select at least one option." >
        <?php 
		  if($_POST[ 'mode' ]==2){
			  $lid=$level_id-1;
			  createCombo("Parent","tbl_category","cat_id","cat_name"," where level_id=$lid ORDER BY cat_name ",$cat_parent_id);}else{
			  ?>
		  <option value="0">Select Parent category</option>
		  <?php
		  }
		  ?>
      </select>
    </div>
    <div class="col-md-12">
      <label for="status">Status </label>
      <select name="act_status" class="form-control" id="act_status"   required>
        <?php createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$act_status);?>
      </select>
    </div>
  </div>
  <div class="clr"></div>
  <div class="modal-footer">
    <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
    <?php
    if ( $_POST[ 'mode' ] == '1' ) {
      ?>
    <input type="hidden" name="mode" value="1">
    <button type="button" class="btn btn-primary " onclick="save()" >Submit</button>
    <?php
    }
    if ( $_POST[ 'mode' ] == '2' ) {
      ?>
    <input type="hidden" name="mode" value="2">
    <button type="button" onclick="save()" class="btn btn-primary btn-sm">Update</button>
    <?php }?>
  </div>
</form>
<script>
	$(document).on('change', '#level_id', function(){
		var nowRow =$("#level_id").val()-1;
		$.ajax({
					url: "AjaxCode/loadajaxcombo.php?options=1&valueColumns=cat_id,cat_name&table=tbl_category&conditions=where level_id=" +nowRow+" &firstText=Select a Level&selectedValue=" ,
					success: function(html){
					$('#cat_parent_id').html(html);
				}
				});
		});
	function save() {
        $.ajax({
            type: "POST",
            url: "pages/category/catedory_save.php",
            data: $('#catagory_form').serialize(),
            
        }).done(function(response) {
			
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
			 $('#close').click();
           left();
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
</script>