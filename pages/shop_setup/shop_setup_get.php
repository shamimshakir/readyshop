<?php include('../header.php')?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Shop Details</span>
                        <span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span>
                    </h4>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap " >
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>URL</th>
                                <th>Logo</th>
                                <th>Favicon</th>
                                <th>Status</th>
                                <th class="td-actions">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = mysqli_query($conn, "SELECT 
                                        tbl_shop_config.*, tbl_status.stat_desc 
                                      FROM 
                                        tbl_shop_config 
                                      LEFT JOIN 
                                        tbl_status 
                                      ON 
                                        tbl_shop_config.active_status=tbl_status.stat_id");
                        $i = 1;
                        while ($row = mysqli_fetch_array($res)) { 
                        extract($row); 
                        ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $sc_name;?></td>
                                <td><?php echo $sc_email;?></td>
                                <td><?php echo $sc_address;?></td>
                                <td><?php echo $sc_phone;?></td>
                                <td><?php echo $url;?></td>
                                <td>
                                    <img style="height: 50px;max-width: 100px;" src="uploads/shop_setup/<?php echo $row['sc_logo'];?>" alt="">
                                </td>
                                <td>
                                    <img style="height: 50px;max-width: 100px;" src="uploads/shop_setup/<?php echo $row['favicon'];?>" alt="">
                                </td>
                                <td><?php echo $active_status; ?></td>
                                <td>
                                    <button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['id'];?>)" > Edit</button>
                                </td>
                            </tr>

                            <?php $i++; } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>

<script>
    function add() {
        $.ajax({
            type: "POST",
            url: "pages/shop_setup/shop_setup_form.php",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/shop_setup/shop_setup_form.php",
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