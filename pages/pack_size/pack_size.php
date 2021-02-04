<?php include('../header.php')?>
<div id="mainContent"></div>

<script>
    function view_data() {
        $.ajax({
            type: "GET",
            url: "pages/pack_size/pack_size_get.php",
            dataType: "html"
        }).done(function(msg) {
            $("#mainContent").html(msg);
        })
    }
    view_data();

</script>
