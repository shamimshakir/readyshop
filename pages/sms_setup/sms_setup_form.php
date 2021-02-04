<?php
include( '../header.php' );
$mode = 1;
if ( isset( $_REQUEST[ 'id' ] ) ) {
  $id = $_REQUEST[ 'id' ];
  $mode = 2;
  $SeNTlist = "SELECT
									  `id`,
									  `name`,
									  `sms_url`,
									  `submit_param`,
									  `return_param`,
									  `return_value_type`,
									  type
									FROM
									  `tbl_sms_setup`
									WHERE id = '$id' ";
  $ExSeNTlist = mysqli_query( $conn, $SeNTlist )or die( mysqli_error() );
  $rowNewsTls = mysqli_num_rows( $ExSeNTlist );
  while ( $rowNewsTl = mysqli_fetch_array( $ExSeNTlist ) ) {
    extract( $rowNewsTl );
  }
}
?>
<div id="mainContent">
  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="card m-b-20">
        <div class="card-body">
          <?php if ($mode == 1){ ?>
          <h4 class="mt-0 header-title">Add SMS</h4>
          <?php }elseif ($mode = 2){ ?>
          <h4 class="mt-0 header-title">Edit SMS</h4>
          <?php }?>
          <form id="brandForm" class="" action="#" novalidate="">
            <input type="hidden" name="mode" value="<?php echo $mode;?>">
            <input type="hidden" name="id" value="<?php  if($mode==2){echo $id;}?>">
            <div class="row">
				<div class=" col-md-12">
				
				<label for="name">Name </label>
				<div class="col-sm-12 ">
	                <span id="name-info" class="info" ></span>
					<input type="text" class="form-control input-sm" name="name" id="name" value="<?php if(isset($rowNewsTls)) {echo $name;}?>" placeholder="Name">
				</div>
			</div>
              <div class=" col-md-12">
                <label for="thana_name">URL</label>
                <div class="col-sm-12 "> <span id="sms_url-info" class="info" ></span>
                  <input type="text" class="form-control input-sm" name="sms_url" id="sms_url" value="<?php if(isset($rowNewsTls)) {echo $sms_url;}?>" placeholder="URL">
                </div>
              </div>
              <div class=" col-md-12">
                <label for="thana_name">SMS Param (username =your user name, password=your password, receiver = {{mobile}},message = {{smsbody} Others parameters add like this ) Do not change {{mobile}},{{smsbody}} </label>
                <div class="col-sm-12 "> <span id="submit_param-info" class="info" ></span>
                  <textarea class="form-control " name="submit_param" id="submit_param" placeholder="" rows="4"><?php if(isset($rowNewsTls)) {echo $submit_param;}?>
</textarea>
                </div>
              </div>
              <div class="form-group col-md-12">
                <label for="SMTPAuth">Submit type</label>
                <div class="col-sm-12 "> <span id="SMTPAuth-info" class="info" ></span>
                  <select name="SMTPAuth" id="SMTPAuth" class="form-control input-sm">
                    <option value="">Select Any</option>
                    <option value="get" <?php if(isset($rowNewsTls)) {if($type=="get"){echo "selected";}}?>>get</option>
                    <option value="post" <?php if(isset($rowNewsTls)) {if($type=="post"){echo "selected";}}?>>post</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group mb-0 d-flex justify-content-end">
              <div>
                <button type="button" class="btn btn-secondary waves-effect" onclick="view_datas()">Cancel</button>
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
<?php include('../footer.php')?>
<script>
    function save() {
        if($('form').parsley().validate()){
            $.ajax({
                type: "POST",
                url: "pages/sms_setup/sms_setup_save.php",
                data: $('#brandForm').serialize()
            }).done(function(response) {
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_datas();
            }).fail(function() {
                alertify.notify(response, 'error', 3);
            });
        }
    }
	function view_datas(){		
		$.ajax({
                url: "pages/sms_setup/sms_setup.php?page=<?php echo $_REQUEST['page']?>",
                type: "GET",                
            }).done(function (response) {        			
        			$('#mainContent').html(response);
        		})
	}
</script> 
