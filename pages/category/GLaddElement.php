<?php
session_start();

if ( isset( $_SESSION[ 'SUserName' ] ) )$SUserName = $_SESSION[ 'SUserName' ];
if ( isset( $_SESSION[ 'SUserID' ] ) )$SUserID = $_SESSION[ 'SUserID' ];
include_once( "../../library/dbconnect.php" );
include_once( '../../library/Library.php' );

$pid = $_REQUEST[ 'pid' ];
$id = $_REQUEST[ 'id' ];

if ( $pid == null )
  echo "<script>
            
            showError();
          
         </script>";
else {

  $parent_query = "select *, cat_name
                  from tbl_category
                  where cat_id='$id'
                  ";

  $rset = mysqli_query( $conn, $parent_query )or die( "Error: " . mysql_error() );

  $row = mysqli_fetch_assoc( $rset );

  extract( $row );
  //echo "Cat Type ".$cat_type_id." Lid".$_REQUEST['lid']." Id".$_REQUEST['id'];   


  ?>
<style>
.blog-btn-group .btn {
	margin: 0 3px 3px 0;
	float: left;
}
.blog {
	margin-bottom: 25px;
	background: #f9fbfc;
	position: relative;
}
.blog:before {
	content: "";
	position: absolute;
	top: 0;
	right: 0;
	z-index: 40;
	border-width: 0 12px 12px 0;
	border-style: solid;
	border-color: #a9bcd2 white #a9bcd2 #a9bcd2;
	background: transparent;
	display: block;
	width: 0;
}
.blog-header {
	position: relative;
	padding: 12px 15px;
	border: 1px solid #dfe6ee;
	border-bottom: 0;
}
.blog-header p.date-time {
	margin: 0;
	color: #666666;
	font-size: 11px;
}
.blog-header p.date-time span {
	display: inline;
	margin-right: 10px;
}
.blog-header p.date-time span i {
	margin-right: 2px;
	font-size: 12px;
}
.blog-header img.blog-post-user {
	max-width: 48px;
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
	float: right;
}
h4.blog-title {
	font-size: 16px;
	font-weight: 600;
	text-transform: uppercase;
	color: #5b90bf;
	margin-top: 0;
}
h5.blog-title {
	font-size: 14px;
	font-weight: 600;
	color: #31559B;
	margin: 0;
}
.blog-body {
	padding: 15px;
	position: relative;
	overflow: hidden;
	border: 1px solid #dfe6ee;
}
.blog-body .blog-img {
	border: 2px solid #a9bcd2;
	min-height: 160px;
	margin-bottom: 10px;
}
.blog-body .blog-content {
	font-size: 15px;
	line-height: 20px;
	color: #595959;
}

@media (max-width: 767px) {
.blog-body .blog-img {
	min-height: 60px;
}
.blog-body .blog-content {
	font-size: 12px;
	line-height: 16px;
}
}
.blog-footer {
	padding: 15px;
	border: 1px solid #e2e8f0;
	border-top: 0;
	border-bottom: 2px solid #e2e8f0;
	position: relative;
}
.blog-footer:before {
	content: "";
	position: absolute;
	top: -10px;
	right: 15px;
	z-index: 40;
	border-width: 0 10px 10px;
	border-style: solid;
	border-color: #e2e8f0 white #e2e8f0;
	background: transparent;
	display: block;
	width: 0;
}
.blog-info {
	background-color: #5b90bf;
}
.blog-info:before {
	border-color: #3a6994 #fafafa #3a6994 #3a6994;
}
.blog-info .blog-header {
	border: 1px solid #5b90bf;
}
.blog-info .blog-header h5.blog-title {
	color: white;
}
.blog-info .blog-body {
	border: 1px solid #5b90bf;
	background: white;
}
</style>
<div class="">
  <?php
  if ( $_REQUEST[ 'lid' ] < 3 && $_REQUEST[ 'id' ] <> 0 ) {
    ?>
  <div class="blog blog-info">
    <div class="blog-header text-center">
      <h5 class="blog-title">Add Level-<?php echo $_REQUEST['lid']; ?> Category</h5>
    </div>
    <div class="blog-body ">
      <div class="col-sm-12 ">
        <form name='frm' method='post' id='frm' class="form-horizontal" >
          <input type='hidden' name='lid' value='<?php echo $_REQUEST['lid'];?>'>
          <input type='hidden' name='cat_id' value='<?php echo $id;?>'>
          <input type="hidden" name="cat_type_id" value="<?php echo $cat_type_id;?>">
          <div class="form-group">
            <label for="nodename" class="col-sm-4 control-label">Level-<?php echo $_REQUEST['lid']; ?> Category Name</label>
            <div class="col-sm-8">
              <input type="text" class="form-control input-sm" id="nodename"  name='nodename'  placeholder="Category Name" required>
            </div>
          </div>
          <?php if($_REQUEST['lid']>1){ ?>
          <div class="form-group">
            <label for="nodename" class="col-sm-4 control-label">Category code</label>
            <div class="col-sm-8"> <span id="cate_code-info" class="info" style="position: absolute; margin: -1px; font-size: 10px; color: red; left: 17px; width: 100%;" >
              <input type="hidden" value="1" name="code_status">
              </span>
              <input type="text" class="form-control input-sm" id="cate_code"  name='cate_code'  placeholder="Category Code" maxlength='4' onKeyUp="check_code()">
            </div>
          </div>
          <?php }?>
          <div class="col-sm-12 text-center ">
            <button type='submit'  class="btn btn-primary btn-sm" name="submit" id="submit" ><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
            <button type='reset' class="btn btn-danger btn-sm"><i class="fa fa-refresh" aria-hidden="true"></i> Clear</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php }?>
  <div class="blog blog-info">
    <div class="blog-header text-center">
      <h5 class="blog-title">Edit Level-<?php echo $_REQUEST['lid']-1; ?> Category </h5>
    </div>
    <div class="blog-body ">
      <div class="col-sm-12 ">
        <form name='frm1' id='frm1' method='post'  class="form-horizontal">
          <input type='hidden' name='lid' value='<?php echo $_REQUEST['lid'];?>'>
          <input type='hidden' name='cat_id' value='<?php echo $id;?>'>
          <div class="form-group">
            <label for="nodename" class="col-sm-4 control-label">Level-<?php echo $_REQUEST['lid']-1; ?> Category Name</label>
            <div class="col-sm-8">
              <input type="text" class="form-control input-sm" id="nodename"  name='nodename' value='<?php echo $cat_name;?>' placeholder="Category Name">
            </div>
          </div>
          <?php if($_REQUEST['lid']>1){ ?>
          <div class="form-group">
            <label for="nodename" class="col-sm-4 control-label">Category code</label>
            <div class="col-sm-8"> <span id="cate_code-info" class="info" style="position: absolute; margin: -1px; font-size: 10px; color: red; left: 17px;" width: 100%;></span>
              <input type="text" class="form-control input-sm" id="cate_code"  name='cate_code' value='<?php echo $cate_code;?>' placeholder="Category Code" maxlength='4' onKeyUp="check_code()">
            </div>
          </div>
          <?php }?>
          <div class="form-group">
            <div class="col-sm-12 text-center ">
              <input type='hidden' name='sid' value='<?php echo $id;?>'>
              <button type='submit' name='editBtn' class="btn btn-primary btn-sm" ><i class="fa fa-upload" aria-hidden="true"></i> UPDATE</button>
              <button type='reset' name='addBtn' class="btn btn-danger btn-sm"><i class="fa fa-refresh" aria-hidden="true"></i> Clear</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php }?>
<script>
	function check_code(){
	   var cate_code=document.getElementById( "cate_code" ).value;
	   if(cate_code)
	   {
	        $.ajax({
			   type: 'post',
			   url: 'pages/category/checkcode.php',
			   data: {
				   cate_code:cate_code
				   },
			   success: function (response) {
			 
			   $('#cate_code-info').html(response);
  		          if(response=="OK")	
                  {
                   return true;	
                  }
                  else
                  {
                     return false;	
                  }
                }
		      });
	
	   }
	   else
	   {
		   $( '#name_status' ).html("");
		   return false;
	   }
	}
	
	$(document).ready(function () {

   /*$('#frm').validate({  
   ignore: "",
	rules: {
		 nodename: {
			required: true			
		},
		 cate_code: {
			required: true,
			minlength: 4,
		},
		code_status: {
			number:true,
			required: true,
			max: 1
		}			
	},
	messages: {
		nodename: "Please Type Category Name",
		cate_code: "Please Type Category Code",
		code_status: "Please enter Valid Code"
		
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			// Add the `help-block` class to the error element
			error.addClass( "help-block" );

			if ( element.prop( "type" ) === "checkbox" ) {
				error.insertAfter( element.parent( "label" ) );
			} else {
				error.insertAfter( element );
			}
		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
		},
		unhighlight: function (element, errorClass, validClass) {
			$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
		},
		submitHandler: function (form) {
			form.submit();
			// alert('valid form submitted'); // for demo
			//return false; // ajax used, block the normal submit
		}
	 });
   $('#frm1').validate({  
   ignore: "",
	rules: {
		 nodename: {
			required: true			
		},
		 cate_code: {
			required: true,
			minlength: 4,
		},
		code_status: {
			number:true,
			required: true,
			max: 1
		}			
	},
	messages: {
		nodename: "Please Type Category Name",
		cate_code: "Please Type Category Code",
		code_status: "Please enter Valid Code"
		
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			// Add the `help-block` class to the error element
			error.addClass( "help-block" );

			if ( element.prop( "type" ) === "checkbox" ) {
				error.insertAfter( element.parent( "label" ) );
			} else {
				error.insertAfter( element );
			}
		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
		},
		unhighlight: function (element, errorClass, validClass) {
			$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
		},
		submitHandler: function (form) {
			form.submit();
			// alert('valid form submitted'); // for demo
			//return false; // ajax used, block the normal submit
		}
	 });
*/


	
	
	
	
	});
	
	
	$(document).ready(function(e) {
    $("#frm").on('submit', (function(e) {
        //alert('hello');
        var data = new FormData(this)
        e.preventDefault();
        $("#load").show();
        $.ajax({
            url: "pages/category/GLadd.php", // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false // To send DOMDocument or non processed data file it is set to false
        }).done(function(msg) {
            if (msg == 1) {
                alertify.success('Data successfully added');
               $("#load").hide();
				left();
            } else if (msg == 2) {
                alertify.error('Failed to add data');
				$("#load").hide();
				left();
            } else if (msg == 3) {
                alertify.error('You Already Entry This Time Slot');
				$("#load").hide();
            } else if (msg == 4) {
                alertify.success('Data successfully Updated');
               $("#load").hide();
            } else if (msg == 5) {
				$("#load").hide();
                alertify.error('Failed to Updated data');
            } else {
                alertify.error(msg);
				$("#load").hide();
            }
        }).fail(function() {
			$("#load").hide();
            alertify.error('Error');
        }).complete(function() {
			$("#load").hide();
            
        });
    }));
		$("#frm1").on('submit', (function(e) {
        //alert('hello');
        var data = new FormData(this)
        e.preventDefault();
        $("#load").show();
        $.ajax({
            url: "pages/category/GLedit.php", // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false // To send DOMDocument or non processed data file it is set to false
        }).done(function(msg) {
            if (msg == 1) {
                alertify.success('Data successfully added');
               $("#load").hide();
            } else if (msg == 2) {
                alertify.error('Failed to add data');
				$("#load").hide();
            } else if (msg == 3) {
                alertify.error('You Already Entry This Time Slot');
				$("#load").hide();
            } else if (msg == 4) {
                alertify.success('Data successfully Updated');
				left();
               $("#load").hide();
            } else if (msg == 5) {
				$("#load").hide();
				left();
                alertify.error('Failed to Updated data');
            } else {
                alertify.error(msg);
				$("#load").hide();
            }
        }).fail(function() {
			$("#load").hide();
            alertify.error('Error');
        }).complete(function() {
			$("#load").hide();
            
        });
    }));
});
</script> 
