
<?php include('../header.php')?>

<div id="mainContent"></div>

<script>
    function view_data() {
        $.ajax({
            type: "GET",
            url: "pages/recfrom_vendor/recfrom_vendor_get.php",
            dataType: "html"
        }).done(function(msg) {
            $("#mainContent").html(msg);
        })
    }
    view_data();

</script>



