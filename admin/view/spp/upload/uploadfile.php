<?php  

	$conn = mysqli_connect("localhost", "root", "", "pegawai");
	

	if (isset($_POST['import'])) {
		// echo $_POST['excel'];exit;
		$namaFile 	= $_FILES['excel']['name'];
		$ukuranFile = $_FILES['excel']['size'];
		$error 		= $_FILES['excel']['error'];
		$tmpName 	= $_FILES['excel']['tmp_name'];

		// cek apakah tidak ada gambar yang diupload
		if( $error === 4 ) {
			echo "<script>
					alert('Pilih File Terlebih Dahulu!');
				  </script>";
			return false;
		}

		// cek apakah yang diupload adalah gambar
		$ekstensiFileValid 	= ['xlsx', 'csv'];
		$ekstensiFile 		= explode('.', $namaFile);
		$ekstensiFile 		= strtolower(end($ekstensiFile) );

		if( !in_array($ekstensiFile, $ekstensiFileValid) ) {
			echo "<script>
					alert('Yang Anda Upload Bukan File Excel Atau CSV !');
				  </script>";
				return false;  
		}

		// cek jika ukurannya terlalu besar
		if( $ukuranFile > 5000000 ) {
			echo "<script>
					alert('Ukuran File Terlalu Besar !');
				  </script>";
				return false;
		} 

		// lolos pengecekan, gambar siap di upload

		$target = basename($_FILES['excel']['name']);
		move_uploaded_file($_FILES['excel']['tmp_name'], $target);

		chmod($_FILES['excel']['name'], 0777);

		$reader = new Spreadsheet_Excel_Reader($_FILES['excel']['name'], false);
		$jumlah_baris = $reader->rowCount($sheet_index = 0);


		$berhasil = 0;
		for ($i = 2; $i <= $jumlah_baris; $i++) {
			$nama = $reader->val($i, 1);
			$alamat = $reader->val($i, 2);
			$telp = $reader->val($i, 3);
			
			if ($nama != '' & $alamat != '' & $telp != '') {
				mysqli_query($conn, 'INSERT INTO data_pegawai VALUES ("", "$nama", "$alamat", "$telp") ');
				$berhasil++;
			}

		}

		unlink($_FILES['excel']['name']);


	}

	$data = mysqli_query($conn, "SELECT * FROM data_pegawai");

?>

<!DOCTYPE html>
<html>
<head>
	<title> Import Excel </title>
</head>
<body>

	<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Import Data Excel </h3>
       
    </div>
    <form action="<?= $basead; ?>upload" enctype="multipart/form-data" method="post">
        <div class="box-body">

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Import File Excel</label>
                        <input type="file" name="excel" class="form-control" id="id_siswa" />
                        <input type="submit" name="import" style="margin-top: 10px;" class="btn btn-sm btn-success" id="id_siswa" value="Import" />
                    </div>
                </div>
            </div> 

            
        </div>
    </form>

    <table border="1">
    	<thead>
    		<tr>
    			<th> Nama </th>
    			<th> Alamat </th>
    			<th> Telepon </th>
    		</tr>
    	</thead>
    	<tbody>
    		<?php foreach ($data as $dt): ?>
    		<tr>
    			<td> <?= $dt['nama']; ?> </td>
    			<td> <?= $dt['alamat']; ?> </td>
    			<td> <?= $dt['telepon']; ?> </td>
    		</tr>
    		<?php endforeach ?>
    	</tbody>
    </table>
    
</div>

<script type="text/javascript">

	$(document).ready(function(){
		$("#list_spp").click();
	    $("#upload_data").css({
	        "background-color" : "#ccc",
	        "color" : "black"
	    });
	})

</script>

</body>
</html>