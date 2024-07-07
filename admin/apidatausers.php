<?php  

	require '../php/config.php'; 

	$canDelete = 0;
	$deleteSD  = 0;
	$deleteTK  = 0;

	if (isset($_POST['datakey'])) {
		$idUsers = $_POST['datakey'];
		
		// Check Jika data siswa SD
		$checkDataSD = mysqli_query($con, "SELECT * FROM admin WHERE c_admin = '$idUsers' ");
		$checkDataSD = mysqli_num_rows($checkDataSD);

		// Check Jika data Siswa TK
		$checkDataTK = mysqli_query($con, "SELECT * FROM accounting WHERE c_accounting = '$idUsers' ");
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
			
			$execDeleteSiswa = mysqli_query($con, "DELETE FROM admin WHERE c_admin = '$idUsers' ");

			$perubahanData = mysqli_affected_rows($con);
		
			if ($perubahanData != 0) {
				echo "sukses";
			}

		} elseif($canDelete == 1 && $deleteTK == 1) {

			$execDeleteSiswa = mysqli_query($con, "DELETE FROM accounting WHERE c_accounting = '$idUsers' ");

			$perubahanData = mysqli_affected_rows($con);
		
			if ($perubahanData != 0) {
				echo "sukses";
			}

		} elseif($canDelete == 0) {

			echo "gagal";

		}		

	}

?>