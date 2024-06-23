<?php  

	$dataSD_SebelumImport 		= "";
	$dataTK_SebelumImport 		= "";
	$dataSD_SesudahImport 		= "";
	$dataTK_SesudahImport 		= "";
	$total 						= "";
	$success_sess 				= 0;
	$dataSD_SebelumImport 		= mysqli_num_rows(mysqli_query($con, "SELECT * FROM data_murid_sd"));
	$dataTK_SebelumImport 		= mysqli_num_rows(mysqli_query($con, "SELECT * FROM data_murid_tk"));
	// echo $dataSD_SebelumImport;

	if (isset($_POST['uploadx'])) {

		// echo "SINI";exit;
		// session_start();
		require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
		require('spreadsheet-reader-master/SpreadsheetReader.php');

		// Validasi apakah type file ber type xlsx, xls
		$namaFile 			= $_FILES['file_excel']['name'];
		$ekstensiFileValid 	= ['xlsx', 'xls'];
		$ekstensiFile 		= explode('.', $namaFile);
		$ekstensiFile 		= strtolower(end($ekstensiFile) );
		$checkForm          = 0; 

		if ($ekstensiFile == '') {
			$checkForm = 1;
		}

		if ($checkForm == 1) {

			$_SESSION['form_success'] = "empty_form";

		} else {

			if( !in_array($ekstensiFile, $ekstensiFileValid) ) {
				// echo "Type File Invalid. Yang Anda Masukan File Ber Type " . $ekstensiFile;
				$_SESSION['form_success'] = "type_fail";
				// return true;
			} else {

				//upload data excel kedalam folder uploads
				$target_dir = "uploads/".basename($_FILES['file_excel']['name']);
				
				move_uploaded_file($_FILES['file_excel']['tmp_name'],$target_dir);

				$Reader = new SpreadsheetReader($target_dir);

				foreach ($Reader as $Key => $Row) {
					// import data excel mulai baris ke-2 (karena ada header pada baris 1)
					// echo "Nomer KEY : " . $Key . "<br>";
					if ($Key < 1) continue;

						$rmv = str_replace(["-"],"/",$Row[9]);
						// echo $rmv;exit;
						$date = date_create($rmv);
						$jadi = date_format($date,"Y/m/d H:i:s");

						
						// echo "Nama : " . $Row[4] . " ". $jadi;exit;

					// echo "<br> Isinya : " . mysqli_real_escape_string($con,htmlspecialchars($Row[1]));exit;
					$isi_nama 	= mysqli_real_escape_string($con,htmlspecialchars($Row[4]));
					$isi_pggl 	= mysqli_real_escape_string($con,htmlspecialchars($Row[5]));
					$tmpt_lahir = mysqli_real_escape_string($con,htmlspecialchars($Row[8]));
					$alamat 	= mysqli_real_escape_string($con,htmlspecialchars($Row[13]));
					$email 		= mysqli_real_escape_string($con,htmlspecialchars($Row[16]));

					$nm_ayah 	= mysqli_real_escape_string($con,htmlspecialchars($Row[17]));
					$pdkn_ayah 	= mysqli_real_escape_string($con,htmlspecialchars($Row[18]));
					$pkrjn_ayah = mysqli_real_escape_string($con,htmlspecialchars($Row[19]));
					$ttl_ayah 	= mysqli_real_escape_string($con,htmlspecialchars($Row[20]));

					$nm_ibu 	= mysqli_real_escape_string($con,htmlspecialchars($Row[21]));
					$pdkn_ibu 	= mysqli_real_escape_string($con,htmlspecialchars($Row[22]));
					$pkrjn_ibu 	= mysqli_real_escape_string($con,htmlspecialchars($Row[23]));
					$ttl_ibu 	= mysqli_real_escape_string($con,htmlspecialchars($Row[24]));

					// Jenjang Pendidikan Apa yang di pilih
					if ($_POST['jenjang_pend'] == 'tk') {

						$query = mysqli_query ($con, 
							"
								INSERT INTO data_murid_tk(
									id,thn_join,NIS,KELAS,Nama,Panggilan,
									KLP,jk,temlahir,tanglahir,berat_badan,tinggi_badan,
									ukuran_baju,Alamat,telp_rumah,HP,email,nama_ayah,
									pendidikan_a,pekerjaan_a,ttl_a,nama_ibu,pendidikan_i,pekerjaan_i,
									ttl_i
								) 
								VALUES (
									'".$Row[0]."', '".$Row[1]."','".$Row[2]."','".$Row[3]."','".$isi_nama."', '".$isi_pggl."',
									'".$Row[6]."', '".$Row[7]."','".$tmpt_lahir."','".$jadi."','".$Row[10]."', '".$Row[11]."',
									'".$Row[12]."', '".$alamat."','".$Row[14]."','".$Row[15]."','".$email."', '".$nm_ayah."',
									'".$pdkn_ayah."', '".$pkrjn_ayah."','".$ttl_ayah."','".$nm_ibu."','".$pdkn_ibu."', '".$pkrjn_ibu."',
									'".$ttl_ibu."'
								)
							"
						);

						if ($query) {

							$dataTK_SesudahImport = mysqli_num_rows(mysqli_query($con, "SELECT * FROM data_murid_tk"));
							// echo "Import data berhasil";
							$total = $dataTK_SesudahImport - $dataTK_SebelumImport;
							$_SESSION['import_success'] = "berhasil";
							$success_sess = 1;
							
						} else {
							mysqli_error($con);
							echo "Gagal";
						}

					} else if ( $_POST['jenjang_pend'] == 'sd') {

						$query = mysqli_query ($con, 
							"
								INSERT INTO data_murid_sd(
									id,tahun_join,NIS,KELAS,Nama,Panggilan,
									KLP,jk,tempat_lahir,tanggal_lahir,berat_badan,tinggi_badan,
									ukuran_baju,Alamat,telp_rumah,HP,alamat_email,nama_ayah,
									Pendidikan,Pekerjaan,tempat_tanggal_lahir,nama_ibu,Pendidikan1,Pekerjaan1,
									tempat_tanggal_lahir1
								) 
								VALUES (
									'".$Row[0]."', '".$Row[1]."','".$Row[2]."','".$Row[3]."','".$isi_nama."', '".$isi_pggl."',
									'".$Row[6]."', '".$Row[7]."','".$tmpt_lahir."','".$jadi."','".$Row[10]."', '".$Row[11]."',
									'".$Row[12]."', '".$alamat."','".$Row[14]."','".$Row[15]."','".$email."', '".$nm_ayah."',
									'".$pdkn_ayah."', '".$pkrjn_ayah."','".$ttl_ayah."','".$nm_ibu."','".$pdkn_ibu."', '".$pkrjn_ibu."',
									'".$ttl_ibu."'
								)
							"
						);

						if ($query) {

							$dataSD_SesudahImport = mysqli_num_rows(mysqli_query($con, "SELECT * FROM data_murid_sd"));
							// echo "Import data berhasil";
							$total = $dataSD_SesudahImport - $dataSD_SebelumImport;
							$_SESSION['import_success'] = "berhasil";
							$success_sess = 1;
							
						} else {
							mysqli_error($con);
							echo "<script>alert('Gagal')</script>";
						}

					}

				}

			}

		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title> Import Excel </title>
</head>
<body>

	<div class="row">
	    <div class="col-xs-12 col-md-12 col-lg-12">

	        <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'type_fail'){?>
	          <div style="display: none;" class="alert alert-danger alert-dismissable"> Silahkan Masukan file bertipe xls, atau xlsx
	             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	             <?php unset($_SESSION['form_success']); ?>
	          </div>
	        <?php } ?>

	        <?php if(isset($_SESSION['import_success']) && $_SESSION['import_success'] == 'berhasil'){?>
	          <div style="display: none;" class="alert alert-warning alert-dismissable"> <?php echo $total . " Data Berhasil di Import !"; ?>
	             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	             <?php unset($_SESSION['import_success']); ?>
	          </div>
	        <?php } ?>

	        <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'type_fail'){?>
	          <div style="display: none;" class="alert alert-danger alert-dismissable"> Silahkan Masukan file bertipe xls, atau xlsx
	             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	             <?php unset($_SESSION['form_success']); ?>
	          </div>
	        <?php } ?>

	        <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'empty_form'){?>
	          <div style="display: none;" class="alert alert-danger alert-dismissable"> Tidak Ada File Yang Di Upload
	             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	             <?php unset($_SESSION['form_success']); ?>
	          </div>
	        <?php } ?>

	        <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'size_too_big'){?>
	          <div style="display: none;" class="alert alert-danger alert-dismissable"> Ukuran File Terlalu Besar
	             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	             <?php unset($_SESSION['form_success']); ?>
	          </div>
	        <?php } ?>

	    </div>
	</div>

	<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Import Data Excel </h3>
       
    </div>

    <form action="<?= $basead; ?>importdatasiswa" enctype="multipart/form-data" method="post">
        <div class="box-body">

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Import File Excel</label>
                        <input type="file" name="file_excel" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="form-control" id="id_siswa" />
                        <input type="submit" name="uploadx" style="margin-top: 10px;" class="btn btn-sm btn-success" id="id_siswa" value="Import" />
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Jenjang Pendidikan</label>
                        <select class="form-control" name="jenjang_pend">
                        	<option value="tk"> KB/TKA/TKB </option>
                        	<option value="sd"> SD </option>
                        </select>
                    </div>
                </div>
            </div> 

            
        </div>
    </form>

	<!-- <h2>Data</h2>
	<table border="1">
		<tr>
			<th style="text-align: center; width: 5%;"> ID </th>
                 <th style="text-align: center;"> tahun_join </th>
                 <th style="text-align: center;"> NIS </th>
                 <th style="text-align: center;"> KELAS </th>
                 <th style="text-align: center;"> Nama </th>
                 <th style="text-align: center;"> Panggilan </th>
                 <th style="text-align: center;"> KLP </th>
                 <th style="text-align: center;"> jk </th>
                 <th style="text-align: center;"> tempat_lahir </th>
                 <th style="text-align: center;"> tanggal_lahir </th>
                 <th style="text-align: center;"> berat_badan </th>
                 <th style="text-align: center;"> tinggi_badan </th>
                 <th style="text-align: center;"> ukuran_baju  </th>
                 <th style="text-align: center;"> Alamat </th>
                 <th style="text-align: center;"> telp_rumah </th>
                 <th style="text-align: center;"> HP </th>
                 <th style="text-align: center;"> alamat_email </th>
                 <th style="text-align: center;"> nama_ayah </th>
                 <th style="text-align: center;"> Pendidikan </th>
                 <th style="text-align: center;"> Pekerjaan </th>
                 <th style="text-align: center;"> tempat_tanggal_lahir </th>
                 <th style="text-align: center;"> nama_ibu </th>
                 <th style="text-align: center;"> Pendidikan1 </th>
                 <th style="text-align: center;"> Pekerjaan1 </th>
                 <th style="text-align: center;"> tempat_tanggal_lahir1 </th>
		<?php

		$data = mysqli_query($con, "SELECT * FROM data_murid_sd");
		if ($data === FALSE){
			die(mysqli_error());
		}
		while($d = mysqli_fetch_assoc($data)){
			?>
			<tr>
				<td style="text-align: center;"> <?= $d['ID']; ?> </td>
                        <td style="text-align: center;"> <?= $d['tahun_join']; ?> </td>
                        <td style="text-align: center;"> <?= $d['NIS']; ?> </td>
                        <td style="text-align: center;"> <?= $d['KELAS']; ?> </td>
                        <td style="text-align: center;"> <?= $d['Nama']; ?> </td>
                        <td style="text-align: center;"> <?= $d['Panggilan']; ?> </td>

                        <?php if ($d['KLP'] == NULL || $d['KLP'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['KLP']; ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= $d['jk']; ?> </td>

                        <?php if ($d['tempat_lahir'] == NULL || $d['tempat_lahir'] == ''): ?>

                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                            
                            <td style="text-align: center;"> <?= $d['tempat_lahir']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['tanggal_lahir'] == NULL || $d['tanggal_lahir'] == '0000-00-00 00:00:00'): ?>

                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                            
                            <td style="text-align: center;"> <?= $d['tanggal_lahir']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['berat_badan'] == NULL || $d['berat_badan'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['berat_badan']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['tinggi_badan'] == NULL || $d['tinggi_badan'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['tinggi_badan']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['ukuran_baju'] == NULL || $d['ukuran_baju'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['ukuran_baju']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['Alamat'] == NULL || $d['Alamat'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['Alamat']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['telp_rumah'] == NULL || $d['telp_rumah'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['telp_rumah']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['HP'] == NULL || $d['HP'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['HP']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['alamat_email'] == NULL || $d['alamat_email'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['alamat_email']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['nama_ayah'] == NULL || $d['nama_ayah'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['nama_ayah']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['Pendidikan'] == NULL || $d['Pendidikan'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['Pendidikan']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['Pekerjaan'] == NULL || $d['Pekerjaan'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['Pekerjaan']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['tempat_tanggal_lahir'] == NULL || $d['tempat_tanggal_lahir'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['tempat_tanggal_lahir']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['nama_ibu'] == NULL || $d['nama_ibu'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['nama_ibu']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['Pendidikan1'] == NULL || $d['Pendidikan1'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['Pendidikan1']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['Pekerjaan1'] == NULL || $d['Pekerjaan1'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['Pekerjaan1']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($d['tempat_tanggal_lahir1'] == NULL || $d['tempat_tanggal_lahir1'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $d['tempat_tanggal_lahir1']; ?> </td>
                            
                        <?php endif ?>
			</tr>
			<?php 
		}
		?>
	</table> -->
    
</div>

<script type="text/javascript">

	$(document).ready(function(){
		$("#list_maintenance").click();
	    $("#importdatasiswa").css({
	        "background-color" : "#ccc",
	        "color" : "black"
	    });
	})

</script>

</body>
</html>