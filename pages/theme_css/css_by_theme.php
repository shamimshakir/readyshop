<?php include('../header.php');
    $theme_id = $_POST['theme_id'];
    $SUserID =$_SESSION["SUserID"];
    $pageid = pick('_tree_entries', 'id', "file_name = 'theme_css.php'");
    $editper=PermissionVerification($SUserID,$pageid,'edit');
?>
<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
    <tr>
        <th>Sl</th>
        <th>Title</th>
        <th>Main Text</th>
        <?php if($slider_id == 1){?>
            <th>Alt Text</th>
        <?php }?>
        <th>URL</th>
        <th>Image</th>
        <th>Status</th>
        <th>Action</th>
        <th class="td-actions">Edit</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $res = mysqli_query($conn, "SELECT
			tbl_slider_images.*,
			tbl_slider.slider_name
		FROM
			tbl_slider_images
		LEFT JOIN tbl_slider ON tbl_slider_images.slider_id=tbl_slider.id
		WHERE tbl_slider_images.slider_id = $slider_id");
    $i = 1;
    while ($row = mysqli_fetch_array($res)) { extract($row); ?>

        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $row['title_text'];?></td>
            <td><?php echo $row['main_text'];?></td>
            <?php if($slider_id == 1){?>
            <td><?php echo $row['alt_text'];?></td>
            <?php }?>
            <td><?php echo $row['url'];?></td>
            <td>
                <img style="height: 50px;width: auto;" src="<?php echo $folder_admin; ?>/slider/<?php echo $row['bg_img'];?>" alt="">
            </td>
            <td><?php if ( $row['act_status'] == 1 ) { ?>
                  <span class="badge badge-pill badge-success">Active</span><br>
                  <?php }else{ ?>
                  <span class="badge badge-pill badge-danger">Inactive</span><br>
                  <?php }  ?> </td>
            <td>
                 <div>
                    <input type="checkbox" id="switch<?php echo $i;?>" switch="none"  value="1" onclick="update_status(<?php echo $row['id']; ?>)"
                        <?php if ( $row['act_status'] == 0 ) { echo "checked";}else{ }?>
                        >
                    <label for="switch<?php echo $i;?>" data-on-label="On" data-off-label="Off" ></label>
                </div>
            </td>
            <td>
                <?php if($editper>0){?><button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['id'];?>, <?php echo $row['slider_id'] ?>)"> Edit
                </button><?php } ?>
            </td>
        </tr>

        <?php $i++; } ?>
    </tbody>
</table>
<script>
$(document).ready(function() {
		$('#datatable').DataTable(
		{
			"searching": true,
			"stateSave": true,
			"pageLength": 100,
			"responsive": true,
			"bLengthChange": true,
		}
		);
	} );
</script>
