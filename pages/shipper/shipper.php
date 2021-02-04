
<?php include('../header.php')?>

<div id="mainContent"></div>

<script>
    function view_data() {
        $.ajax({
            type: "GET",
            url: "pages/shipper/shipper_get.php",
            dataType: "html"
        }).done(function(msg) {
            $("#mainContent").html(msg);
        })
    }
    view_data();


    function inactive_shipper(sp_id){
        $.ajax({
            type: "POST",
            url: "pages/update_field_ajax.php",
            data: { 
                table: 'tbl_shippers',
                field: 'status',
                value: 0,
                whereId: 'sp_id',
                whereValue: sp_id
            }
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
        })
    }
    function active_shipper(sp_id){
        $.ajax({
            type: "POST",
            url: "pages/update_field_ajax.php",
            data: { 
                table: 'tbl_shippers',
                field: 'status',
                value: 1,
                whereId: 'sp_id',
                whereValue: sp_id
            }
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
        })
    }

</script>



