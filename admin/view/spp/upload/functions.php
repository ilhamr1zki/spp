<?php 
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");


function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}

function tambah($data) {
	 global $conn;

	 $nama = htmlspecialchars ($data["nama"]);
	 $ttl = htmlspecialchars ($data["ttl"]);
	 $email = htmlspecialchars ($data["email"]);
	 $lulusan = htmlspecialchars ($data["lulusan"]);
	 $gambar = upload();
	 if( !$gambar) {
	 	return false;
	 }
	 $jurusan = htmlspecialchars ($data["jurusan"]);

	$query = "INSERT INTO mahasiswa VALUES ('', '$nama', '$ttl', '$email', '$lulusan', '$gambar', '$jurusan')";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}


function upload(){

	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah tidak ada gambar yang diupload
	if( $error === 4 ) {
		echo "<script>
				alert('Pilih Gambar Terlebih Dahulu!');
			  </script>";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar) );
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
		echo "<script>
				alert('Yang Anda Upload Bukan File Gambar !');
			  </script>";
			return false;  
	}

	// cek jika ukurannya terlalu besar
	if( $ukuranFile > 5000000 ) {
		echo "<script>
				alert('Ukuran Gambar Terlalu Besar !');
			  </script>";
			return false;
	} 

	// lolos pengecekan, gambar siap di upload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	
		move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

	return $namaFileBaru;



}






function hapus($id) {
	global $conn;
	mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

	return mysqli_affected_rows($conn); 
}

function ubah($data) {
	global $conn;

	 $id = $data["id"];
	 $TTL = htmlspecialchars ($data["TTL"]);
	 $nama = htmlspecialchars ($data["nama"]);
	 $email = htmlspecialchars ($data["email"]);
	 $jurusan = htmlspecialchars ($data["jurusan"]);
	 $gambar = $data["gambar"];
    $lulusan = htmlspecialchars ($data["lulusan"]);

	$query = "UPDATE mahasiswa SET
				TTL = '$TTL',
				nama = '$nama',
				email = '$email',
				jurusan = '$jurusan',
				gambar = '$gambar',
				lulusan = '$lulusan'
			 WHERE id = $id
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	

	
	
}

function cari($keyword) {
	$query = "SELECT * FROM mahasiswa
			 	WHERE
			 nama LIKE '%$keyword%' OR TTL LIKE '%$keyword%' OR email LIKE '%$keyword%' OR jurusan LIKE '%$keyword%' OR lulusan LIKE '%$keyword%'
			";
	return query($query);
}


function registrasi($data) {
	global $conn;

	$username = strtolower(stripcslashes($data["username"]) );
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	// cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
	if( mysqli_fetch_assoc($result) ) {
		echo "<script>
			alert('username yang dipilih sudah terdaftar!');
			  </script>";
		return false;
	}

	// cek konfirmasi password
	if ( $password !== $password2 ) {
		echo "<script>
				alert('konfirmasi password tidak sesuai!');
			  </script>";
			  return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);


	// tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");

	return mysqli_affected_rows($conn);

}


 ?>