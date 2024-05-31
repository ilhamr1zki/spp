<?php  
	
	$namaMurid = $namaSiswa;

    $tanggalDari    = $_POST['tanggal1'];
    $tanggalSampai  = $_POST['tanggal2'];
    $dataNIS_siswa  = $nis; 

    if ($_SESSION['c_admin'] == 'adm1') {

    	$queryGetDataSPP = "
	        SELECT 
			ID, NIS, DATE, BULAN, KELAS, 
			NAMA, PANGGILAN, TRANSAKSI, SPP, SPP_txt,
			PANGKAL, PANGKAL_txt, KEGIATAN, KEGIATAN_txt,
			BUKU, BUKU_txt, SERAGAM, SERAGAM_txt, REGISTRASI,
			REGISTRASI_txt, LAIN, LAIN_txt, STAMP 
			FROM input_data_sd_lama1
			WHERE 
			NIS = '$dataNIS_siswa'


			UNION 

			SELECT 
			ID, NIS, DATE, BULAN, KELAS, 
			NAMA, PANGGILAN, TRANSAKSI, SPP, SPP_txt,
			PANGKAL, PANGKAL_txt, KEGIATAN, KEGIATAN_txt,
			BUKU, BUKU_txt, SERAGAM, SERAGAM_txt, REGISTRASI,
			REGISTRASI_txt, LAIN, LAIN_txt, STAMP 
			FROM input_data_tk_lama
			WHERE 
			NIS = '$dataNIS_siswa'
			ORDER BY STAMP DESC
	    ";

	    $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
	    // $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);
	    $hitungDataFilterSPPDate = mysqli_num_rows($execQueryDataSPP);

	    $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

	    $ambildata_perhalaman = mysqli_query($con, "
	        SELECT 
			ID, NIS, DATE, BULAN, KELAS, 
			NAMA, PANGGILAN, TRANSAKSI, SPP, SPP_txt,
			PANGKAL, PANGKAL_txt, KEGIATAN, KEGIATAN_txt,
			BUKU, BUKU_txt, SERAGAM, SERAGAM_txt, REGISTRASI,
			REGISTRASI_txt, LAIN, LAIN_txt, INPUTER, STAMP 
			FROM input_data_sd_lama1
			WHERE 
			NIS = '$dataNIS_siswa'
			

			UNION 

			SELECT 
			ID, NIS, DATE, BULAN, KELAS, 
			NAMA, PANGGILAN, TRANSAKSI, SPP, SPP_txt,
			PANGKAL, PANGKAL_txt, KEGIATAN, KEGIATAN_txt,
			BUKU, BUKU_txt, SERAGAM, SERAGAM_txt, REGISTRASI,
			REGISTRASI_txt, LAIN, LAIN_txt, INPUTER, STAMP 
			FROM input_data_tk_lama
			WHERE 
			NIS = '$dataNIS_siswa'
			ORDER BY STAMP DESC
	        LIMIT $dataAwal, $jumlahData
	    ");

	    $jumlahPagination = ceil($hitungDataFilterSPPDate / $jumlahData);

	    $jumlahLink = 2;

	    if ($halamanAktif > $jumlahLink) {
	        $start_number = $halamanAktif - $jumlahLink;
	    } else {
	        $start_number = 1;
	    }

	    if ($halamanAktif < ($jumlahPagination - $jumlahLink)) {
	        $end_number = $halamanAktif + $jumlahLink;
	    } else {
	        $end_number = $jumlahPagination;
	    }
    }

?>

	<div style="overflow-x: auto; margin: 10px;">
                            
        <table id="example_semua" class="table table-bordered">
            <thead>
              <tr>
                 <th style="text-align: center; width: 5%;"> NUMBER INVOICE </th>
                 <th style="text-align: center;"> NIS </th>
                 <th style="text-align: center;"> NAMA </th>
                 <th style="text-align: center;"> PANGGILAN </th>
                 <th style="text-align: center;"> KELAS </th>
                 <th style="text-align: center;"> TANGGAL BAYAR </th>
                 <th style="text-align: center;"> BULAN </th>
                 <th style="text-align: center;"> TRANSAKSI </th>
                 <th style="text-align: center;"> SPP  </th>
                 <th style="text-align: center;"> KET SPP </th>
                 <th style="text-align: center;"> PANGKAL </th>
                 <th style="text-align: center;"> KET PANGKAL </th>
                 <th style="text-align: center;"> KEGIATAN </th>
                 <th style="text-align: center;"> KET KEGIATAN </th>
                 <th style="text-align: center;"> BUKU </th>
                 <th style="text-align: center;"> KET BUKU </th>
                 <th style="text-align: center;"> SERAGAM </th>
                 <th style="text-align: center;"> KET SERAGAM </th>
                 <th style="text-align: center;"> REGISTRASI </th>
                 <th style="text-align: center;"> KET REGISTRASI </th>
                 <th style="text-align: center;"> LAIN </th>
                 <th style="text-align: center;"> KET LAIN </th>
                 <th style="text-align: center;"> DI INPUT OLEH </th>
                 <th style="text-align: center; width: 7%;"> STAMP </th>
                 <th style="text-align: center;"> ACTION </th>
              </tr>
            </thead>
            <tbody>

                <?php foreach ($ambildata_perhalaman as $data) : ?>
                    <tr>
                        <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                        <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                        <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                        <td style="text-align: center;"> <?= $data['PANGGILAN']; ?> </td>
                        <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>

                        <?php if ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00'): ?>

                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                            
                            <td style="text-align: center;"> <?= str_replace([' 00:00:00'], "", tglIndo($data['DATE'])); ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= $data['BULAN']; ?> </td>

                        <?php if ($data['TRANSAKSI'] == NULL): ?>
                        	
                        	<td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>

                        	<td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>
                        	
                        <?php endif ?>

                        <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>
                        <?php if ($data['SPP_txt'] == NULL || $data['SPP_txt'] == ''): ?>
                            
                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= rupiah($data['PANGKAL']); ?> </td>
                        <?php if ($data['PANGKAL_txt'] == NULL || $data['PANGKAL_txt'] == ''): ?>
                            
                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['PANGKAL_txt']; ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= rupiah($data['KEGIATAN']); ?> </td>
                        <?php if ($data['KEGIATAN_txt'] == NULL || $data['KEGIATAN_txt'] == ''): ?>
                            
                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['KEGIATAN_txt']; ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= rupiah($data['BUKU']); ?> </td>
                        <?php if ($data['BUKU_txt'] == NULL || $data['BUKU_txt'] == ''): ?>
                            
                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['BUKU_txt']; ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= rupiah($data['SERAGAM']); ?> </td>
                        <?php if ($data['SERAGAM_txt'] == NULL || $data['SERAGAM_txt'] == ''): ?>
                            
                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['SERAGAM_txt']; ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= rupiah($data['REGISTRASI']); ?> </td>
                        <?php if ($data['REGISTRASI_txt'] == NULL || $data['REGISTRASI_txt'] == ''): ?>
                            
                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['REGISTRASI_txt']; ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= rupiah($data['LAIN']); ?> </td>
                        <?php if ($data['LAIN_txt'] == NULL || $data['LAIN_txt'] == ''): ?>
                            
                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['LAIN_txt']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['INPUTER'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= $data['INPUTER']; ?> </td>
                        <?php endif ?>

                        <?php if ($data['STAMP'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                            <td style="text-align: center;" id="tombol-cetak">

                                <form action="<?= $basead; ?>editdata" method="POST" target="blank">

                                    <input type="hidden" name="id_siswa" value="<?= $id; ?>">
                                    <input type="hidden" name="nis_siswa" value="<?= $nis; ?>">
                                    <input type="hidden" name="nama_siswa" value="<?= $namaSiswa; ?>">
                                    <input type="hidden" name="kelas_siswa" value="<?= $kelas; ?>">
                                    <input type="hidden" name="panggilan_siswa" value="<?= $panggilan; ?>">

                                    <input type="hidden" name="id_invoice" value="<?= $data['ID']; ?>">
                                    <input type="hidden" name="tgl_bukti_pembayaran" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("-") : ($data['DATE']); ?>">
                                    <input type="hidden" name="pembayaran_bulan" value="<?= $data['BULAN']; ?>">
                                    <input type="hidden" name="nominal_bayar" value="<?= $data['SPP']; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $data['SPP_txt']; ?>">
                                    <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
                                    <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                                    <input type="hidden" name="isi_filter" value="SPP">

                                    <button id="edit_data" name="edit_data" class="btn btn-sm btn-primary btn-circle"> 
                                        EDIT 
                                        <!-- <span class="glyphicon glyphicon-pencil">  -->
                                    </button>

                                </form>

                            	<!-- <input type="hidden" name="id_siswa" value="<?= $id; ?>"> -->

                                <button id="edit_data" name="edit_data" data-toggle="modal" onclick="modalDelete('<?= $data["ID"]; ?>', '<?= $namaSiswa; ?>')" class="btn btn-sm btn-danger btn-circle"> 
                                    DELETE 
                                    <!-- <span class="glyphicon glyphicon-pencil">  -->
                                </button>

                            </td>
                        <?php elseif($data['STAMP'] == '0000-00-00 00:00:00'): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                            <td style="text-align: center;" id="tombol-cetak">

                                <form action="<?= $basead; ?>editdata" method="POST" target="blank">

                                    <input type="hidden" name="id_siswa" value="<?= $id; ?>">
                                    <input type="hidden" name="nis_siswa" value="<?= $nis; ?>">
                                    <input type="hidden" name="nama_siswa" value="<?= $namaSiswa; ?>">
                                    <input type="hidden" name="kelas_siswa" value="<?= $kelas; ?>">
                                    <input type="hidden" name="panggilan_siswa" value="<?= $panggilan; ?>">

                                    <input type="hidden" name="id_invoice" value="<?= $data['ID']; ?>">
                                    <input type="hidden" name="tgl_bukti_pembayaran" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("-") : ($data['DATE']); ?>">
                                    <input type="hidden" name="pembayaran_bulan" value="<?= $data['BULAN']; ?>">
                                    <input type="hidden" name="nominal_bayar" value="<?= $data['SPP']; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $data['SPP_txt']; ?>">
                                    <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
                                    <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                                    <input type="hidden" name="isi_filter" value="SPP">

                                    <button id="edit_data" name="edit_data" class="btn btn-sm btn-primary btn-circle"> 
                                        EDIT 
                                        <!-- <span class="glyphicon glyphicon-pencil">  -->
                                    </button>

                                </form>

                            	<!-- <input type="hidden" name="id_siswa" value="<?= $id; ?>"> -->

                                <button id="edit_data" name="edit_data" data-toggle="modal" onclick="modalDelete('<?= $data["ID"]; ?>', '<?= $namaSiswa; ?>')" class="btn btn-sm btn-danger btn-circle"> 
                                    DELETE 
                                    <!-- <span class="glyphicon glyphicon-pencil">  -->
                                </button>

                            </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= tglIndo($data['STAMP']); ?> </td>
                            <td style="text-align: center;" id="tombol-cetak">

                                <form action="<?= $basead; ?>editdata" method="POST" target="blank">

                                    <input type="hidden" name="id_siswa" value="<?= $id; ?>">
                                    <input type="hidden" name="nis_siswa" value="<?= $nis; ?>">
                                    <input type="hidden" name="nama_siswa" value="<?= $namaSiswa; ?>">
                                    <input type="hidden" name="kelas_siswa" value="<?= $kelas; ?>">
                                    <input type="hidden" name="panggilan_siswa" value="<?= $panggilan; ?>">

                                    <input type="hidden" name="id_invoice" value="<?= $data['ID']; ?>">
                                    <input type="hidden" name="tgl_bukti_pembayaran" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("-") : ($data['DATE']); ?>">
                                    <input type="hidden" name="pembayaran_bulan" value="<?= $data['BULAN']; ?>">
                                    <input type="hidden" name="nominal_bayar" value="<?= $data['SPP']; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $data['SPP_txt']; ?>">
                                    <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
                                    <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                                    <input type="hidden" name="isi_filter" value="SPP">

                                    <button id="edit_data" name="edit_data" class="btn btn-sm btn-primary btn-circle"> 
                                        EDIT 
                                        <!-- <span class="glyphicon glyphicon-pencil">  -->
                                    </button>

                                </form>

                            	<!-- <input type="hidden" name="id_siswa" value="<?= $id; ?>"> -->

                                <button id="edit_data" name="edit_data" data-toggle="modal" onclick="modalDelete('<?= $data["ID"]; ?>', '<?= $namaSiswa; ?>')" class="btn btn-sm btn-danger btn-circle"> 
                                    DELETE 
                                    <!-- <span class="glyphicon glyphicon-pencil">  -->
                                </button>

                            </td>
                        <?php endif ?>
                    </tr>
                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <div id="modalHapusPembayaran" class="modal" data-bs-backdrop="static" data-bs-keyboard="false">
	    <div class="modal-dialog">
		    <form action="<?= $basead; ?>editdata" method="post">
		        <div class="modal-content">
		            <input type="hidden" id="idinvoice" name="idinvoice" class="form-control">
		            <div class="modal-header bg-green">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		                <h4 class="modal-title" id="myModalLabel">Konfirmasi Hapus Data Pembayaran </h4>
		            </div>
		            <div class="modal-body">
			            <p> Anda Yakin Ingin Hapus Data dengan NUMBER INVOICE <span id="isi_nama"></span> Ini ? </p>
		            </div>
		            <div class="modal-footer">
			            <button type="submit" name="hapus_data_pembayaran" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-ok"></i> Lanjutkan</button> 
			            <button class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Tutup</button>
		            </div>
		        </div>
	        </form>
	    </div>
	</div>

    <script type="text/javascript">
    	
    	function modalDelete(id, nama) {
    		$('#modalHapusPembayaran').modal("show");
    		$('#idinvoice').val(id);
    		$('#isi_nama').text(id);
    	}

    </script>