<?php
include( '../header.php' );
$mode = 1;
if ( isset( $_REQUEST[ 'id' ] ) ) {
  $id = $_REQUEST[ 'id' ];
  $mode = 2;
  $SeNTlist = "SELECT `id`, `command`, `description`,status FROM `tbl_sms_template` where id= '$id' ";
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
          <h4 class="mt-0 header-title">Add SMS Template</h4>
          <?php }elseif ($mode = 2){ ?>
          <h4 class="mt-0 header-title">Edit SMS Template</h4>
          <?php }?>
          <form id="brandForm" class="" action="#" novalidate="">
            <input type="hidden" name="mode" value="<?php echo $mode;?>">
            
            <div class="row">
              <div class=" col-md-12">
                <input type="hidden" name="id" id="id" value="<?php if(isset($rowNewsTls)) {echo $_REQUEST['id'];} ?>">
                <label for="command">For </label>
                <div class="col-sm-12 pl0"> <span id="command-info" class="info" ></span>
                  <input type="text" class="form-control input-sm" name="command" id="command" value="<?php if(isset($rowNewsTls)) {echo $command;}?>" placeholder="For" <?php if($_REQUEST['mode'] == '2'){ echo 'readonly';}?> >
                </div>
              </div>
              <div class=" col-md-12">
                <label for="description">SMS Body </label>
                <div class="col-sm-12 pl0"> <span id="description-info" class="info" ></span>
                  <label for="smsbody">Body- Keyword: <span>{{clients_name}}</span> , <span>{{update_date}}</span> , <span>{{amount}}</span> , <span>{{order_id}}</span> </label>
                  <textarea name="description" id="description" class="form-control " ><?php if(isset($rowNewsTls)) {echo $description;}?> 
</textarea>
                  Total Characters: <span id="totalChars">
                  <?php if ($_REQUEST['mode'] == '2'){ echo strlen($description);}else{ echo '0';}?>
                  </span><br/>
                </div>
              </div>
              <div class="col-md-12">
                <label for="status">status </label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-black-tie"></i></div>
                  <span id="status-info" class="info" ></span>
                  <select class="form-control input-sm" name="status" id="status">
                    <?php
                    $a = '';
                    $b = '';
                    if ( isset( $rowNewsTls ) ) {


                      if ( $status == 1 ) {
                        $a = 'selected';
                      } elseif ( $status == 2 ) {
                        $b = 'selected';
                      }
                    }
                    ?>
                    <option value="0">Select a option</option>
                    <option value="1" <?php if($a!=''){ echo $a;}?>>On</option>
                    <option value="2" <?php if($b!=''){echo $b;}?>>Off</option>
                  </select>
                </div>
              </div>
              <br>
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
			//console.log($('#brandForm').serialize());
            $.ajax({
                type: "POST",
                url: "pages/sms_template/sms_template_save.php",
                data: $('#brandForm').serialize()
            }).done(function(response) {
				//console.log(response);
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
                url: "pages/sms_template/sms_template.php?page=<?php echo $_REQUEST['page']?>",
                type: "GET",                
            }).done(function (response) {        			
        			$('#mainContent').html(response);
        		})
	}
</script> 
<script>
$(document).ready(function() {
	counter = function() {
    var value = $('#description').val();

    if (value.length == 0) {
        $('#totalChars').html(0);
        return;
    }
    var regex = /\s+/gi;
    var wordCount = value.trim().replace(regex, ' ').split(' ').length;
    var totalChars = value.length;
    var charCount = value.trim().length;
    var charCountNoSpace = value.replace(regex, '').length;
    $('#totalChars').html(totalChars);
};
});
$(document).ready(function() {
    $('#description').change(counter);
    $('#description').keydown(counter);
    $('#description').keypress(counter);
    $('#description').keyup(counter);
    $('#description').blur(counter);
    $('#description').focus(counter);
});

$('span').click(function(e) {
  var txtarea = $('#description').val();
  var txt = $(e.target).text();
  $('#description').val(txtarea + txt + ' ');
});
</script> 
