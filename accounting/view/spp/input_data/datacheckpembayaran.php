<?php 

	if (isset($_POST['nextPage'])) {
		// code...
		$nextPage = $_POST['nextPage'];
	} else {
		echo "Ga ada";
	}

	$arr[] = $nextPage;
	
	echo json_encode(2);exit;

?>