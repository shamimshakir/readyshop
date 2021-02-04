<?php include('../header.php');
$mode = 1;

if(isset($_REQUEST['id'])){
    $mode = 2;
    $id=$_REQUEST['id'];
    $SeNTlist = "SELECT * FROM  tbl_pages_content WHERE id = '$id' ";
    $ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error($conn));
    $rowNewsTls=mysqli_num_rows($ExSeNTlist);
    while($rowNewsTl=mysqli_fetch_array($ExSeNTlist)){
        extract($rowNewsTl);
    }
}
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-12">
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
                                <label for="page_title">Page Title </label>
                                <input type="text" class="form-control" name="page_title" id="page_title" value="<?php echo $page_title; ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="page_name">Page Name </label>
                                <input type="text" class="form-control" name="page_name" id="page_name" size="10" value="<?php echo $page_name; ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="act_status">Status</label>
                                <?php
                                echo "<select name='act_status' id='act_status' class='form-control'>";
                                createCombo("Status","tbl_status","stat_id","stat_desc","ORDER BY stat_desc ",$active_status);
                                echo "</select>";
                                ?>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="page_content">Page Content</label>
                                <textarea name="page_content" id="page_content" rows="10" cols="80">
                                    <?php if(isset($rowNewsTls)) {echo $page_content;} ?>
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
			tinyMCE.triggerSave(); 
            //var page_content = tinyMCE.get('page_content').getContent();
            var data = $('#pageContentForm').serialize() ;
            $.ajax({
                type: "POST",
                url: "pages/page_content/page_content_save.php",
                data: data
            }).done(function(response) {
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
            }).fail(function() {
                alertify.notify(response, 'error', 3);
            });
        }

        
</script>
