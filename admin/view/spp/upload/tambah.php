<?php 
require 'functions.php';

// cek apakah tombol submit sudah di tekan atau belum
if ( isset($_POST["submit"]) ) {

	// cek apakah data berhasil di tambahkan atau tidak
	if( tambah($_POST) > 0 ) {
		echo "
			<script>
				alert('Data Berhasil Ditambahkan!');
				document.location.href = 'index.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Data Gagal Ditambahkan!');
				document.location.href = 'index.php';
			</script>
		";
	}

	
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title> Tambah Data </title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

</head>
<body>
	<h1> Tambah data  </h1>

	<form action="" method="post" enctype="multipart/form-data">
		<ul>
			<li>
				<label for="nama"> Nama : </label>
				<input type="text" name="nama" id="nama" required>
			</li>
			<li>
				<label for="ttl"> Tgl/Lahir : </label>
				<input type="text" name="ttl" id="ttl" required>
			</li>
			<li>
				<label for="email"> Email : </label>
				<input type="text" name="email" id="email" required>
			</li>
			<li>
				<label for="lulusan"> Lulusan : </label>
				<input type="text" name="lulusan" id="lulusan" required>
			</li>
			<li>
				<label for="jurusan"> Jurusan : </label>
				<input type="text" name="jurusan" id="jurusan" required>
			</li>
			<li>
				<label for="gambar"> Gambar : </label>
				<input type="file" name="gambar" id="gambar">
			</li>
			<li>
				<button type="submit" name="submit"> Tambah Data !</button>
			</li>
		</ul>
		

	</form>



<script src="js/bootstrap.min.js"></script>
</body>
</html>






























