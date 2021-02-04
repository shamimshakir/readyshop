<?php
include( '../header.php' );
$mode = 1;
$pageid = $_REQUEST[ 'page' ];
$user_role = $_SESSION[ 'user_profile_id' ];

?>
<div id="mainContent">
  <div class="row">
    <div class="col-sm-12 ">
      <div style="margin-top: 10px;" id="viewdata">
        <form id="emailandsms" name="MyForm" method="post" action="mail&sms.php">
          <div class="row" style="padding-top:10px">
            <div class="col-sm-6" id="emaildiv" >
              <fieldset class="scheduler-border">
                <legend class="scheduler-border">&nbsp;SMS &nbsp;</legend>
                <div class="form-group">
                  <label for="emailsubject">Mobile No (01711111111) </label>
                  <input type="text" class="form-control" name="mobile" id="mobile">
                </div>
                <div class="form-group">
                  <label for="emailbody">Body </label>
                  <textarea name="smsbody" id="smsbody" class="form-control"></textarea>
                </div>
                <div class="form-group" >
                  <label for="service_type_id" >Use api</label>
                  <select class="form-control input-sm" name='api_id' id='api_id' required>
                    <?php
                    $api_id = 1;
                    createCombo( "API Name", "tbl_sms_setup", "id", "name", " Order by name", $api_id );
                    ?>
                  </select>
                </div>
              </fieldset>
            </div>
          </div>
          <div class="row text-center">
            <div class="col-sm-6">
              <button type="submit" class="btn btn-primary btn-sm" id="btn-submit"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send </button>
            </div>
          </div>
        </form>
      </div>
      <div id="content" class="col-md-12" > </div>
    </div>
  </div>
</div>
<?php 
include('../footer.php');
?>
<script type="text/javascript">

		$(document).ready(function(e){
	    	$("#emailandsms").on('submit', (function(e){
			e.preventDefault();  
	     	$.ajax({
	     	type : 'POST',
	     	url  : 'pages/sms_test/sms_test_send.php',
	     	data: new FormData(this), 
			contentType: false, 
			cache: false, 
			processData: false,
	     	beforeSend: function()
	     	{
				//alert('0');
	     		$("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Sending <i class="fa fa-spin fa-spinner" aria-hidden="true"></i>');
				$("#content").html('<br><br><div class="alert alert-warning" id="success-alert"><button type="button" class="close" data-dismiss="alert">x</button><strong>Sending <i class="fa fa-spin fa-spinner" aria-hidden="true"></i></div>');
	     	},
	     	success :  function(data)
	     	{
				
				//alert (data);
				// $('#content').html(data);
	     		
	     		if(data==1)
	     		{
	     			$("#content").html('<div class="alert alert-success" id="success-alert"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success! </strong>Send Successfully.</div> ');
					$("#btn-submit").html('<i class="fa fa-paper-plane" aria-hidden="true"></i> &nbsp; Send');
					//$('#content').html(data);
	     		}
	     		else{
	     			$("#content").html('<div class="alert alert-success" id="success-alert"><button type="button" class="close" data-dismiss="alert">x</button><strong>Error! </strong>Error to Send.</div> ');
					$("#btn-submit").html('<i class="fa fa-paper-plane" aria-hidden="true"></i> &nbsp; send');
					//$('#content').html(data);
	     		}
	     		$("#content").fadeTo(2000, 500).slideUp(500, function(){
	     				//$("#content").alert('close');
	     			});
	     		$('#search').trigger("reset");
	     	}
	     	});
	     	return false;
			
	     }));
	     });


		
	</script> 
