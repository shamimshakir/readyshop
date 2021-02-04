
<?php include('../header.php')?>

<div id="mainContent"></div>

<?php include('../footer.php')?>
<script>
    function view_data() {
        $.ajax({
            type: "GET",
            url: "pages/advmanagement/advmanagement_get.php",
            dataType: "html"
        }).done(function(msg) {
            $("#mainContent").html(msg);
        })
    }
    view_data();

</script>



