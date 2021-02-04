<!-- Guide Modal Start -->
<?php require '../library/dbconnect.php'; 

	$id = $_POST['id'];
    $res = mysqli_query( $conn, "SELECT * FROM user_guide WHERE id = $id " );
        while ( $row = mysqli_fetch_array( $res ) ) {
        extract( $row );
      echo "<div class='modal-header'>
        <h5 class='modal-title' id='exampleModalLabel'>{$question}</h5>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      <div class='modal-body'>
      		{$video}
      </div>";
	} ?>

<!-- Guide Modal End -->