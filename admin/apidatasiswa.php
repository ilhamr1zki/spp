<?php  

	require '../php/config.php'; 

	$canDelete = 0;
	$deleteSD  = 0;
	$deleteTK  = 0;

	if (isset($_POST['dataNis'])) {
		$nis= $_POST['dataNis'];
		
		// Check Jika data siswa SD
		$checkDataSD = mysqli_query($con, "SELECT * FROM data_murid_sd WHERE NIS = '$nis' ");
		$checkDataSD = mysqli_num_rows($checkDataSD);

		// Check Jika data Siswa TK
		$checkDataTK = mysqli_query($con, "SELECT * FROM data_murid_tk WHERE NIS = '$nis' ");
		$checkDataTK = mysqli_num_rows($checkDataTK);

		if ($checkDataSD == 1 && $checkDataTK != 1) {
			$canDelete = 1;
			$deleteSD  = 1;
		} else if ($checkDataTK == 1 && $checkDataSD != 1) {
			$canDelete = 1;
			$deleteTK  = 1;
		} else if ($checkDataSD == 1 && $checkDataTK == 1) {
			$canDelete = 0;
		} 

		if ($canDelete == 1 && $deleteSD == 1) {
			
			$execDeleteSiswa = mysqli_query($con, "DELETE FROM data_murid_sd WHERE NIS = '$nis' ");

			$perubahanData = mysqli_affected_rows($con);
		
			if ($perubahanData != 0) {
				echo "sukses";
			}

		} elseif($canDelete == 1 && $deleteTK == 1) {

			$execDeleteSiswa = mysqli_query($con, "DELETE FROM data_murid_tk WHERE NIS = '$nis' ");

			$perubahanData = mysqli_affected_rows($con);
		
			if ($perubahanData != 0) {
				echo "sukses";
			}

		} elseif($canDelete == 0) {

			echo "gagal";

		}		

	}

?>