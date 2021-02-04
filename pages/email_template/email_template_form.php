
<?php include('../header.php');
    $mode = 1;
    if(isset($_REQUEST['email_template_id'])){
        $id = $_REQUEST['email_template_id'];
        $mode = 2;
        $SeNTlist = "SELECT * FROM email_template WHERE email_template_id = '$id' ";
        $ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error($conn));
        $rowNewsTls=mysqli_num_rows($ExSeNTlist);
        $rowNewsTl=mysqli_fetch_array($ExSeNTlist);
        extract($rowNewsTl);
    }
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card m-b-20">
                <div class="card-body">
                    <?php if ($mode == 1){ ?>
                        <h4 id="myModalLabel">Add Page</h4>
                    <?php } if ($mode == 2){ ?>
                        <h4 id="myModalLabel">Edit Page</h4>
                    <?php }?>


                    <form id="pageContentForm" class="" action="#" novalidate="" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="id" value="<?php  if($mode==2){echo $id;}?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="page_name">Title </label>
                                <input type="text" class="form-control" name="title" id="title" size="10" value="<?php echo $title; ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="page_name">Subject </label>
                                <input type="text" class="form-control" name="subject" id="subject" size="10" value="<?php echo $subject; ?>" >
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="page_content">Page Content</label>
                                <textarea  id="page_content" name="page_content" rows="10" cols="80">
                                    <?php if(isset($rowNewsTls)) {echo $body;} ?>
                                </textarea>
                                
                            </div>
                        </div>
                        <div class="form-group mb-0 mt-2 d-flex justify-content-end">
                            <div>
                                <button type="button" class="btn btn-secondary waves-effect" onclick="view_data()">Cancel</button>
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
	// Check TinyMCE initialized or not
if(tinyMCE.get('page_content')){

 // Remove instance by id
 tinymce.remove('#page_content');
	addTinyMCE();
}else{
   tinymce.remove('#page_content');
addTinyMCE();
}

    // Add TinyMCE
function addTinyMCE(){
  // Initialize
  tinymce.init({
					selector: "textarea#page_content",
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
		//alert('here');
		
		tinyMCE.triggerSave(); 
		
       // var page_content = tinymce.get('page_content').getContent();
		
		//var data = $('#pageContentForm').serialize() + "&page_content=" + page_content;
		var data = $('#pageContentForm').serialize();
		
		
        
		//console.log(data);
        $.ajax({
            type: "POST",
            url: "pages/email_template/email_template_save.php",
            data: data
        }).done(function(response) {
			console.log(response);
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
</script>
