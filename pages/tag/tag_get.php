<?php include('../header.php');
    $SUserID =$_SESSION['user_profile_id'];
    $pageid = pick('_tree_entries', 'id', "file_name = 'tag.php'");
    $addper=PermissionVerification($SUserID,$pageid,'add');
    $editper=PermissionVerification($SUserID,$pageid,'edit');
?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Product Tags</span>
                    </h4>

                    <table id="datatable" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Tag Location</th>
                                <th>Name</th>
                                <th>Label</th>
                                <th class="td-actions">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = mysqli_query($conn, "SELECT 
                                        *
                                      FROM 
                                        product_tags
                                      ORDER BY tag_id ASC");
                        while ($row = mysqli_fetch_array($res)) { extract($row); ?>
                            <tr>
                                <td><?php echo $location_detail;?></td>
                                <td><?php echo $tag_name ;?></td>
                                <td><?php echo $tag_label ;?></td>
                                
                                <td>
                                    <?php if($editper>0){?><button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['tag_id'];?>)" data-toggle="modal" data-target="#myModal">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                                    </button><?php } ?>
                                </td>
                            </tr>

                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>

<script>
    function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/tag/tag_form.php",
            data: {
                mode: 2,
                id : id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
</script>
