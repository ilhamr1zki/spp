<?php  

	require '../php/config.php'; 

	session_start();

	$role = $_SESSION['c_accounting'];

	if (isset($_POST['dataNis'])) {
		$nis= $_POST['dataNis'];
		if ($role == 'accounting1') {
			// echo "data sd";exit;
			$dataHps = mysqli_query($con, "DELETE FROM data_murid_sd WHERE NIS = '$nis' ");
		} else if ($role == 'accounting2') {
			// echo "data tk";exit;
			$dataHps = mysqli_query($con, "DELETE FROM data_murid_tk WHERE NIS = '$nis' ");
		}
		

		$perubahanData = mysqli_affected_rows($con);
		
		if ($perubahanData != 0) {
			echo "sukses";
		} else {
			echo "gagal";
		}

	}

?>