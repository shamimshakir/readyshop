<?php
include( '../header.php' );
$pageid = $_REQUEST[ 'page' ];
$user_role = $_SESSION[ 'user_profile_id' ];
$addper = 0;
$addper = PermissionVerification( $user_role, $pageid, 'add' );
?>
<div id="mainContent">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-20">
        <div class="card-body">
          <form id="emailandsms" name="MyForm" method="post" action="mail&sms.php">
            <div class="row" style="padding-top:10px">
              <div class="col-sm-6" id="emaildiv" >
                <fieldset class="scheduler-border">
                  <legend class="scheduler-border">&nbsp; Email Test&nbsp;</legend>
                  <div class="form-group">
                    <label for="emailsubject">Email </label>
                    <input type="email" class="form-control" name="email" id="email">
                  </div>
                  <div class="form-group">
                    <label for="emailsubject">Subject</label>
                    <input type="text" class="form-control" name="subject" id="subject">
                  </div>
                  <div class="form-group">
                    <label for="emailbody">Body </label>
                    <textarea name="emailbody" id="emailbody" class="form-control"></textarea>
                  </div>
                  <div class="form-group" >
                    <label for="service_type_id" >Use Email</label>
                    <select class="form-control input-sm" name='email_id' id='email_id' required>
                      <?php
                      $email_id = 1;
                      createCombo( "API Name", "tbl_emailsetup", "id", "CONCAT(name,'=>',Username)", " Order by name", $email_id );
                      ?>
                    </select>
                  </div>
                </fieldset>
              </div>
            </div>
            <div class="row text-center">
              <div class="col-sm-12">
                <button type="submit" class="btn btn-primary btn-sm" id="btn-submit"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send </button>
              </div>
            </div>
          </form>
          <div id="content" class="col-md-12" > </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
                 
		function enabledate()
		{
	        if(document.MyForm.ckdatecontrol.checked==true)
	        {
	            document.MyForm.cbofDay.disabled=false;
	            document.MyForm.cbofMonth.disabled=false;
	            document.MyForm.cbofYear.disabled=false;
	            document.MyForm.cbotDay.disabled=false;
	            document.MyForm.cbotMonth.disabled=false;
	            document.MyForm.cbotYear.disabled=false;
	                
	        }
	        else
	        {
	            document.MyForm.cbofDay.disabled=true;
	            document.MyForm.cbofMonth.disabled=true;
	            document.MyForm.cbofYear.disabled=true;
	            document.MyForm.cbotDay.disabled=true;
	            document.MyForm.cbotMonth.disabled=true;
	            document.MyForm.cbotYear.disabled=true;
	        }
		}
	</script> 
<script type="text/javascript">
		$('.select2').select2();
	</script> 
<script type="text/javascript">
		$(document).ready(function(e){
	    	$("#emailandsms").on('submit', (function(e){
			e.preventDefault();  
	     	$.ajax({
	     	type : 'POST',
	     	url  : 'pages/email_test/mail&sms.php',
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
</script> 
