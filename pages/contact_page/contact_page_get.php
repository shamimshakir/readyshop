<?php include('../header.php');
    $SUserID =$_SESSION[ "user_profile_id" ];
    $pageid = pick('_tree_entries', 'id', "file_name = 'contact_page.php'");
    $editper=PermissionVerification($SUserID,$pageid,'edit');
?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Contact Page Setting</span>
                    </h4>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Contact Address</th>
                            <th>Contact Phone</th>
                            <th>Contact Email</th>
                            <th>Map Location ( Iframe )</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM tbl_contact_page_info";
                        $res = mysqli_query($conn, $sql);
                        $i = 0;
                        while ($ress = mysqli_fetch_array($res)){
                            ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $ress['contact_address']; ?></td>
                                <td><?php echo $ress['contact_phone']; ?></td>
                                <td><?php echo $ress['contact_email']; ?></td>
                                <td width="100px"><?php echo $ress['contact_map_location']; ?></td>
                                <td>
                                    <?php if($editper>0){?><button class="btn btn-primary btn-xs" onclick="edit(<?php echo $ress['id'];?>)">
                                        <i class="mdi mdi-grease-pencil"></i> Edit
                                    </button><?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>

<script>
    function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/contact_page/contact_page_form.php",
            data: {
                id : id
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
</script>