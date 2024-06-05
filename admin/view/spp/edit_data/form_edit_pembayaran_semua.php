<?php

	$namaMurid = $namaSiswa;
    $isiKeterangan = "";
    $isiNominal    = "";

    $tanggalDari    = $_POST['tanggal1'];
    $tanggalSampai  = $_POST['tanggal2'];
    $dataNIS_siswa  = $nis; 

    if ($_SESSION['c_admin'] == 'adm1') {

    	$queryGetDataSemua = "
	        SELECT 
			ID, NIS, DATE, BULAN, KELAS, 
			NAMA, PANGGILAN, TRANSAKSI, SPP, SPP_txt,
			PANGKAL, PANGKAL_txt, KEGIATAN, KEGIATAN_txt,
			BUKU, BUKU_txt, SERAGAM, SERAGAM_txt, REGISTRASI,
			REGISTRASI_txt, LAIN, LAIN_txt, STAMP 
			FROM input_data_sd
			WHERE 
			NIS = '$dataNIS_siswa'


			UNION 

			SELECT 
			ID, NIS, DATE, BULAN, KELAS, 
			NAMA, PANGGILAN, TRANSAKSI, SPP, SPP_txt,
			PANGKAL, PANGKAL_txt, KEGIATAN, KEGIATAN_txt,
			BUKU, BUKU_txt, SERAGAM, SERAGAM_txt, REGISTRASI,
			REGISTRASI_txt, LAIN, LAIN_txt, STAMP 
			FROM input_data_tk
			WHERE 
			NIS = '$dataNIS_siswa'
			ORDER BY ID DESC
	    ";

	    $execQueryDataSemua    = mysqli_query($con, $queryGetDataSemua);
	    $hitungDataFilterSemua = mysqli_num_rows($execQueryDataSemua);

	    $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

	    $ambildata_perhalaman = mysqli_query($con, "
	        SELECT 
			ID, NIS, DATE, BULAN, KELAS, 
			NAMA, PANGGILAN, TRANSAKSI, SPP, SPP_txt,
			PANGKAL, PANGKAL_txt, KEGIATAN, KEGIATAN_txt,
			BUKU, BUKU_txt, SERAGAM, SERAGAM_txt, REGISTRASI,
			REGISTRASI_txt, LAIN, LAIN_txt, INPUTER, STAMP 
			FROM input_data_sd
			WHERE 
			NIS = '$dataNIS_siswa'
			

			UNION 

			SELECT 
			ID, NIS, DATE, BULAN, KELAS, 
			NAMA, PANGGILAN, TRANSAKSI, SPP, SPP_txt,
			PANGKAL, PANGKAL_txt, KEGIATAN, KEGIATAN_txt,
			BUKU, BUKU_txt, SERAGAM, SERAGAM_txt, REGISTRASI,
			REGISTRASI_txt, LAIN, LAIN_txt, INPUTER, STAMP 
			FROM input_data_tk
			WHERE 
			NIS = '$dataNIS_siswa'
			ORDER BY ID DESC
	        LIMIT $dataAwal, $jumlahData
	    ");

        $countData = mysqli_num_rows($ambildata_perhalaman);

	    $jumlahPagination = ceil($hitungDataFilterSemua / $jumlahData);

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

                    <?php  

                        $uang_spp        = $data['SPP'];
                        $uang_pangkal    = $data['PANGKAL'];
                        $uang_kegiatan   = $data['KEGIATAN'];
                        $uang_buku       = $data['BUKU'];
                        $uang_seragam    = $data['SERAGAM'];
                        $uang_registrasi = $data['REGISTRASI'];
                        $uang_lain       = $data['LAIN'];

                        // Jika Hanya Ada Uang SPP saja
                        if ($uang_spp != 0 && $uang_pangkal == 0 && $uang_kegiatan == 0 &&  $uang_buku == 0 && $uang_seragam == 0 && $uang_registrasi == 0 && $uang_lain == 0) {
                            $isiNominal = $uang_spp;
                        } 

                        // Jika Hanya Ada Uang Pangkal saja
                        elseif ($uang_pangkal != 0 && $uang_spp == 0 &&  $uang_kegiatan == 0 &&  $uang_buku == 0 && $uang_seragam == 0 && $uang_registrasi == 0 && $uang_lain == 0) {
                            $isiNominal = $uang_pangkal;
                        }

                        // Jika Hanya Ada Uang Kegiatan saja
                        elseif ($uang_kegiatan != 0 && $uang_spp == 0 &&  $uang_pangkal == 0 &&  $uang_buku == 0 && $uang_seragam == 0 && $uang_registrasi == 0 && $uang_lain == 0) {
                            $isiNominal = $uang_kegiatan;
                        }

                        // Jika Hanya Ada Uang Buku saja
                        elseif ($uang_buku != 0 && $uang_spp == 0 &&  $uang_pangkal == 0 &&  $uang_kegiatan == 0 && $uang_seragam == 0 && $uang_registrasi == 0 && $uang_lain == 0) {
                            $isiNominal = $uang_buku;
                        }

                        // Jika Hanya Ada Uang Seragam saja
                        elseif ($uang_seragam != 0 && $uang_spp == 0 &&  $uang_pangkal == 0 &&  $uang_kegiatan == 0 && $uang_buku == 0 && $uang_registrasi == 0 && $uang_lain == 0) {
                            $isiNominal = $uang_seragam;
                        }

                        // Jika Hanya Ada Uang Registrasi saja
                        elseif ($uang_registrasi != 0 && $uang_spp == 0 &&  $uang_pangkal == 0 &&  $uang_kegiatan == 0 && $uang_buku == 0 && $uang_seragam == 0 && $uang_lain == 0) {
                            $isiNominal = $uang_registrasi;
                        }

                        // Jika Hanya Ada Uang Lain saja
                        elseif ($uang_lain != 0 && $uang_pangkal == 0 && $uang_spp == 0 &&  $uang_kegiatan == 0 &&  $uang_buku == 0 && $uang_seragam == 0 && $uang_registrasi == 0) {
                            $isiNominal = $uang_lain;
                        }

                        $ket_spp        = htmlspecialchars($data['SPP_txt']);
                        $ket_pangkal    = htmlspecialchars($data['PANGKAL_txt']);
                        $ket_kegiatan   = htmlspecialchars($data['KEGIATAN_txt']);
                        $ket_buku       = htmlspecialchars($data['BUKU_txt']);
                        $ket_seragam    = htmlspecialchars($data['SERAGAM_txt']);
                        $ket_registrasi = htmlspecialchars($data['REGISTRASI_txt']);
                        $ket_lain       = htmlspecialchars($data['LAIN_txt']);

                        // Jika Hanya Ada Ket SPP saja
                        if ($ket_spp != '' && $ket_pangkal == '' && $ket_kegiatan == '' &&  $ket_buku == '' && $ket_seragam == '' && $ket_registrasi == '' && $ket_lain == '') {
                            $isiKeterangan = $ket_spp;
                        } 

                        // Jika Hanya Ada Ket Pangkal Saja
                        elseif ($ket_pangkal != '' && $ket_spp == '' &&  $ket_kegiatan == '' &&  $ket_buku == '' && $ket_seragam == '' && $ket_registrasi == '' && $ket_lain == '') {
                            $isiKeterangan = $ket_pangkal;
                        }

                        // Jika Hanya Ada Ket Kegiatan Saja
                        elseif ($ket_kegiatan != '' && $ket_spp == '' &&  $ket_pangkal == '' &&  $ket_buku == '' && $ket_seragam == '' && $ket_registrasi == '' && $ket_lain == '') {
                            $isiKeterangan = $ket_kegiatan;
                        }

                        // Jika Hanya Ada Ket Buku Saja
                        elseif ($ket_buku != '' && $ket_spp == '' &&  $ket_pangkal == '' &&  $ket_kegiatan == '' && $ket_seragam == '' && $ket_registrasi == '' && $ket_lain == '') {
                            $isiKeterangan = $ket_buku;
                        }

                        // Jika Hanya Ada Ket Seragam Saja
                        elseif ($ket_seragam != '' && $ket_spp == '' &&  $ket_pangkal == '' &&  $ket_kegiatan == '' && $ket_buku == '' && $ket_registrasi == '' && $ket_lain == '') {
                            $isiKeterangan = $ket_seragam;
                        }

                        // Jika Hanya Ada Ket Registrasi Saja
                        elseif ($ket_registrasi != '' && $ket_spp == '' &&  $ket_pangkal == '' &&  $ket_kegiatan == '' && $ket_buku == '' && $ket_seragam == '' && $ket_lain == '') {
                            $isiKeterangan = $ket_registrasi;
                        }

                        // Jika Hanya Ada Ket Lain saja
                        elseif ($ket_lain != '' && $ket_pangkal == '' && $ket_spp == '' &&  $ket_kegiatan == '' &&  $ket_buku == '' && $ket_seragam == '' && $ket_registrasi == '') {
                            $isiKeterangan = $ket_lain;
                        }


                    ?>

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
                                    <input type="hidden" name="nominal_bayar" value="<?= $isiNominal; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $isiKeterangan; ?>">
                                    <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
                                    <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                                    <input type="hidden" name="isi_filter" value="<?= $isifilby; ?>">

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
                                    <input type="hidden" name="nominal_bayar" value="<?= $isiNominal; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $isiKeterangan; ?>">
                                    <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
                                    <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                                    <input type="hidden" name="isi_filter" value="<?= $isifilby; ?>">

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
                                    <input type="hidden" name="nominal_bayar" value="<?= $isiNominal; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $isiKeterangan; ?>">
                                    <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
                                    <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                                    <input type="hidden" name="isi_filter" value="<?= $isifilby; ?>">

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

    <?php if ($countData == 0): ?>

    <?php elseif($countData != 0): ?>

        <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

            <?php if ($halamanAktif > 1): ?>

                <form action="<?= $basead; ?>editdata" method="post">
                    <input type="hidden" name="iniFilterSemua" value="<?= $isifilby; ?>">
                    <input type="hidden" name="idSiswaFilterSemua" value="<?= $id; ?>">
                    <input type="hidden" name="namaSiswaFilterSemua" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="nisFormFilterSemua" value="<?= $nis; ?>">
                    <input type="hidden" name="kelasFormFilterSemua" value="<?= $kelas; ?>">
                    <input type="hidden" name="namaFormFilterSemua" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="panggilanFormFilterSemua" value="<?= $panggilan; ?>">
                    <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                    <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                    <input type="hidden" name="halamanSebelumnyaFilterSemua" value="<?= $halamanAktif - 1; ?>">
                    <button name="previousPageFilterSemua">
                        &laquo;
                        Previous
                    </button>
                </form>

            <?php endif; ?>

            <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                <?php if ($jumlahPagination == 1): ?>
                    
                <?php elseif ($halamanAktif == $i): ?>

                    <form action="checkpembayaran" method="post">
                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                        <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                            <?= $i; ?>
                        </button>
                    </form>

                <?php else: ?>

                    <form action="editdata" method="post">
                        <input type="hidden" name="halamanKeFilterSemua" value="<?= $i; ?>">
                        <input type="hidden" name="iniFilterSemua" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSemua" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSemua" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSemua" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSemua" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSemua" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSemua" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                        <button name="toPageFilterSemua">
                            <?= $i; ?>
                        </button>
                    </form>
                <?php endif; ?>

            <?php endfor; ?>

            <?php if ($halamanAktif < $jumlahPagination): ?>
                
                <form action="<?= $basead; ?>editdata" method="post">
                    <input type="hidden" name="halamanLanjutFilterSemua" value="<?= $halamanAktif + 1; ?>">
                    <input type="hidden" name="iniFilterSemua" value="<?= $isifilby; ?>">
                    <input type="hidden" name="idSiswaFilterSemua" value="<?= $id; ?>">
                    <input type="hidden" name="namaSiswaFilterSemua" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="nisFormFilterSemua" value="<?= $nis; ?>">
                    <input type="hidden" name="kelasFormFilterSemua" value="<?= $kelas; ?>">
                    <input type="hidden" name="namaFormFilterSemua" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="panggilanFormFilterSemua" value="<?= $panggilan; ?>">
                    <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                    <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                    <button name="nextPageFilterSemua" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                        next
                        &raquo;
                    </button>
                </form>

            <?php endif; ?>

        </div>

        <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

            <?php if ($halamanAktif > 1): ?>

                <form action="editdata" method="post">
                    <input type="hidden" name="halamanPertamaFilterSemua" value="<?= $halamanAktif - 1; ?>">
                    <input type="hidden" name="iniFilterSemua" value="<?= $isifilby; ?>">
                    <input type="hidden" name="idSiswaFilterSemua" value="<?= $id; ?>">
                    <input type="hidden" name="namaSiswaFilterSemua" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="nisFormFilterSemua" value="<?= $nis; ?>">
                    <input type="hidden" name="kelasFormFilterSemua" value="<?= $kelas; ?>">
                    <input type="hidden" name="namaFormFilterSemua" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="panggilanFormFilterSemua" value="<?= $panggilan; ?>">
                    <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                    <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                    <button name="firstPageFilterSemua">
                        &laquo;
                        First Page
                    </button>
                </form>

            <?php endif; ?>        

            <?php if ($hitungDataFilterSemua != 0): ?>

                <?php if ($halamanAktif == $jumlahPagination): ?>
                <?php else: ?>
                    
                    <form action="editdata" method="post">
                        <input type="hidden" name="halamanTerakhirFilterSemua" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSemua" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSemua" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSemua" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSemua" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSemua" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSemua" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSemua" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                        <button name="lastPageFilterSemua">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                <?php endif ?>
                
            <?php endif ?>

        </div>

        <br>
        
    <?php endif ?>

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
                        <input type="hidden" name="data_id_siswa" value="<?= $id; ?>">
                        <input type="hidden" name="data_nis_siswa" value="<?= $nis; ?>">
                        <input type="hidden" name="data_nama_siswa" value="<?= $namaSiswa; ?>">
                        <input type="hidden" name="data_kelas_siswa" value="<?= $kelas; ?>">
                        <input type="hidden" name="data_panggilan_siswa" value="<?= $panggilan; ?>">

                        <input type="hidden" name="currentFilter" value="<?= $isifilby; ?>">
                        <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                        <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">

			            <button type="submit" name="hapus_data_pembayaran" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-ok"></i> Lanjutkan</button> 
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