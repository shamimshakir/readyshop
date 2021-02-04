<?php include('../header.php')?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Pickup Location</span>
                        <span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span>
                    </h4>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Location</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT tbl_pickup_location.*, tbl_status.stat_desc 
                                FROM tbl_pickup_location 
                                LEFT JOIN tbl_status ON tbl_status.stat_id=tbl_pickup_location.loc_status";
                        $res = mysqli_query($conn, $sql);
                        $i = 0;
                        while ($pickup = mysqli_fetch_assoc($res)){
                            ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $pickup['location']; ?></td>
                                <td><?php echo $pickup['address']; ?></td>
                                <td><?php echo $pickup['city']; ?></td>
                                <td><?php echo $pickup['stat_desc']; ?></td>
                                <td>
                                    <button class="btn btn-primary btn-xs" onclick="edit(<?php echo $pickup['loc_id'];?>)">
                                        <i class="mdi mdi-grease-pencil"></i> Edit
                                    </button>
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
    function add() {
        $.ajax({
            type: "POST",
            url: "pages/pickup/pickup_form.php",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function edit(loc_id) {
        $.ajax({
            type: "POST",
            url: "pages/pickup/pickup_form.php",
            data: {
                mode: 2,
                loc_id : loc_id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
</script>