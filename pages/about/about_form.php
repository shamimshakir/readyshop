<?php include('../header.php');
$mode = 1;
echo $pageid = $_REQUEST[ 'page' ];
$user_role = $_SESSION[ 'user_profile_id' ];
if(isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];
    $mode = 2;
    $SeNTlist = "SELECT * FROM tbl_about_us WHERE id = '$id' ";
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
                    <?php if ($mode == '1'){ ?>
                        <h4 id="myModalLabel">Add About Us</h4>
                    <?php } if ($mode == '2'){ ?>
                        <h4 id="myModalLabel">Edit About Us</h4>
                    <?php }?>


                    <form id="aboutForm" class="" action="#" novalidate="" enctype="multipart/form-data">

                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <input type="hidden" name="about_id" value="<?php  if($mode==2){echo $id;}?>">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="name">Description </label>
                                <textarea rows="10" class="form-control" name="description" id="description" value=""><?php echo $au_description; ?></textarea>
                            </div>
                        </div>
                        <label for="bg_img">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        <img style="width: auto; height: 60px; margin: 10px 0;" src="<?php echo $folder_admin; ?>about_us/<?php echo $au_image;?>" alt="">
                            </div>
                        </div>

                        <div class="form-group mt-2 mb-0 d-flex justify-content-end">
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
if(tinyMCE.get('description')){

 // Remove instance by id
 tinymce.remove('#description');
	addTinyMCE();
}else{
   tinymce.remove('#description');
addTinyMCE();
}

    // Add TinyMCE
function addTinyMCE(){
  // Initialize
  tinymce.init({
					selector: "textarea#description",
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
        var form = $('form')[0];
        var formData = new FormData(form);
        
        $.ajax({
            type: "POST",
            url: "pages/about/about_save.php",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
	
	function view_data() {
        $('.active').click()
	};
	
</script>
