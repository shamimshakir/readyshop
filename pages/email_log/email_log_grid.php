<?php include('../header.php')?>

<div class="row">
  <div class="col-12">
    <div class="card m-b-20">
      <div class="card-body" id="card-body">
        <h4 class="mt-0 header-title d-flex justify-content-between"> <span>Email LOG</span> </h4>
        <form id="reportForm">
          <div class="row">
          <div class="col-md-3">
            <label for="txtfromopen_date">From</label>
            <input type="date" class="form-control" name="txtfromopen_date" id="txtfromopen_date" value=""/>
          </div>
          <div class="col-md-3">
            <label for="txttoopen_date">To</label>
            <input type="date" class="form-control" name="txttoopen_date" id="txttoopen_date" value="" />
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-primary" style="margin-top: 20px;" id="Searchbt">Show Report</button>
          </div>
        </form>
			</div><br><br>
		<div class="row">
		        <div id="mainContent" style="overflow-x:auto; width: 100%;"></div>
	
			</div>	
      
    </div>
  </div>
</div>
<?php include('../footer.php')?>
<script>
	
	function sendData(page){
		$.ajax({
			url:"pages/email_log/email_log_get.php",
			type:"POST",
			data:$('#search').serialize()+"&actionfunction=showData&page="+page,
			cache: false,
			success: function(response){
				$('#mainContent').html(response);
			}
		});
		return false;
	};
	$('#Searchbt').on('click',function(){
				$.ajax({
					url:"pages/email_log/email_log_get.php",
					type:"POST",
					data:$('#search').serialize()+"&actionfunction=showData&page=1",
					cache: false,
					success: function(response){
						$('#mainContent').html(response);
					}
				});
			});	
	
   
    
</script> 
