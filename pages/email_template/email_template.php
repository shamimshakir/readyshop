<?php include('../header.php')?>

<div id="mainContent"></div>

<?php include('../footer.php')?>
<script>
    function view_data() {
        $.ajax({
            type: "GET",
            url: "pages/email_template/email_template_get.php",
            dataType: "html"
        }).done(function(msg) {
            $("#mainContent").html(msg);
        })
    }
    view_data();

</script>



