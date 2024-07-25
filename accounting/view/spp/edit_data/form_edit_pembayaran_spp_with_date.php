<?php 

	$namaMurid = $namaSiswa;

    $tanggalDari    = $_POST['tanggal1'];
    $tanggalSampai  = $_POST['tanggal2'];

    if ($_SESSION['c_accounting'] == 'accounting1' || $checkSession == 'sd') {

    	$queryGetDataSPP = "
	        SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
	        FROM input_data_sd
	        WHERE
	        SPP_txt <> '' AND
	        NIS = '$nis'
	        AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
	    ";

	    $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
	    // $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);
	    $hitungDataFilterSPPDate = mysqli_num_rows($execQueryDataSPP);

	    $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

	    $ambildata_perhalaman = mysqli_query($con, "
	        SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
	        FROM input_data_sd
	        WHERE
	        SPP_txt <> '' AND
	        NIS = '$nis'
	        AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
            order by STAMP
	        LIMIT $dataAwal, $jumlahData
	    ");

	    $htg = mysqli_num_rows($ambildata_perhalaman);
	    // echo $htg;

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

    } elseif ($_SESSION['c_accounting'] == 'accounting2' || $checkSession == 'tk') {

    	$queryGetDataSPP = "
	        SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
	        FROM input_data_tk
	        WHERE
	        SPP_txt <> '' AND
	        NIS = '$nis'
	        AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
	    ";

	    $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
	    // $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);
	    $hitungDataFilterSPPDate = mysqli_num_rows($execQueryDataSPP);
	    // echo $hitungDataFilterSPPDate;exit;

	    $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

	    $ambildata_perhalaman = mysqli_query($con, "
	        SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
	        FROM input_data_tk
	        WHERE
	        SPP_txt <> '' AND
	        NIS = '$nis'
	        AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
	        order by STAMP 
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
                                
        <table id="example1" class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center; width: 5%;"> NUMBER INVOICE </th>
                <th style="text-align: center; width: 1%;"> NIS </th>
                <th style="text-align: center; width: 10%;"> NAMA </th>
                <th style="text-align: center; width: 3%;"> KELAS </th>
                <th style="text-align: center; width: 5%;"> SPP </th>
                <th style="text-align: center; width: 3%;"> TANGGAL BAYAR </th>
                <th style="text-align: center; width: 3%;"> PEMBAYARAN BULAN </th>
                <th style="text-align: center; width: 7%;"> KET SPP </th>
                <th style="text-align: center; width: 2%;"> TRANSAKSI </th>
                <th style="text-align: center; width: 4%;"> DI INPUT OLEH </th>
                <th style="text-align: center; width: 6%;"> STAMP </th>
                <th style="text-align: center; width: 1%;"> ACTION </th>
              </tr>
            </thead>
            <tbody>

                <?php $no = 1; ?>
                <?php foreach ($ambildata_perhalaman as $data) : ?>
                    <tr>
                        <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                        <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                        <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                        <td style="text-align: center;"> <?= $data['kelas']; ?> </td>
                        <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>

                        <?php if ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00'): ?>

                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                            
                            <td style="text-align: center;"> <?= str_replace([' 00:00:00'], "", tglIndo($data['DATE'])); ?> </td>
                            
                        <?php endif ?>
                        
                        <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>

                        <?php if ($data['SPP_txt'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                        <?php endif ?>

                        <?php if ($data['TRANSAKSI'] == '' || $data['TRANSAKSI'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>
                        <?php endif ?>

                        <?php if ($data['di_input_oleh'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                        <?php endif ?>

                        <?php if ($data['tanggal_diupdate'] == NULL || $data['tanggal_diupdate'] == '0000-00-00 00:00:00'): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                            <td style="text-align: center; justify-content: center;" id="tombol-cetak">

                                <form action="<?= $baseac; ?>editdata" method="POST" target="blank">

	                                <input type="hidden" name="id_siswa" value="<?= $id; ?>">
	                                <input type="hidden" name="nis_siswa" value="<?= $nis; ?>">
	                                <input type="hidden" name="nama_siswa" value="<?= $namaSiswa; ?>">
	                                <input type="hidden" name="kelas_siswa" value="<?= $kelas; ?>">
	                                <input type="hidden" name="panggilan_siswa" value="<?= $panggilan; ?>">

	                                <input type="hidden" name="id_invoice" value="<?= $data['ID']; ?>">
	                                <input type="hidden" name="tgl_bukti_pembayaran" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("-") : ($data['DATE']); ?>">
	                                <input type="hidden" name="pembayaran_bulan" value="<?= $data['pembayaran_bulan']; ?>">
	                                <input type="hidden" name="nominal_bayar" value="<?= $data['SPP']; ?>">
	                                <input type="hidden" name="ket_pembayaran" value="<?= $data['SPP_txt']; ?>">
	                                <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
	                                <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

	                                <input type="hidden" name="isi_filter" value="<?= $isifilby; ?>">
	                                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
               		 				<input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">

	                                <button id="edit_data" name="edit_data_with_date" class="btn btn-sm btn-primary btn-circle"> 
	                                    EDIT 
	                                    <!-- <span class="glyphicon glyphicon-pencil">  -->
	                                </button>

	                            </form>

                                <form action="<?= $baseac; ?>editdata" method="POST" target="blank">

                                    <input type="hidden" name="id_siswa" value="<?= $id; ?>">
                                    <input type="hidden" name="nis_siswa" value="<?= $nis; ?>">
                                    <input type="hidden" name="nama_siswa" value="<?= $namaSiswa; ?>">
                                    <input type="hidden" name="kelas_siswa" value="<?= $kelas; ?>">
                                    <input type="hidden" name="panggilan_siswa" value="<?= $panggilan; ?>">

                                    <input type="hidden" name="id_invoice" value="<?= $data['ID']; ?>">
                                    <input type="hidden" name="tgl_bukti_pembayaran" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("-") : ($data['DATE']); ?>">
                                    <input type="hidden" name="pembayaran_bulan" value="<?= $data['pembayaran_bulan']; ?>">
                                    <input type="hidden" name="nominal_bayar" value="<?= $data['SPP']; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $data['SPP_txt']; ?>">
                                    <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
                                    <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                                    <input type="hidden" name="isi_filter" value="<?= $isifilby; ?>">
                                    <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                                    <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">

                                    <button id="edit_data" name="tambah_data" class="btn btn-sm btn-success btn-circle"> 
                                        TAMBAH
                                        <!-- <span class="glyphicon glyphicon-pencil">  -->
                                    </button>

                                </form>

                            </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= tglIndo($data['tanggal_diupdate']); ?> </td>
                            <td style="text-align: center; justify-content: center;" id="tombol-cetak">

                                <form action="<?= $baseac; ?>editdata" method="POST" target="blank">

	                                <input type="hidden" name="id_siswa" value="<?= $id; ?>">
	                                <input type="hidden" name="nis_siswa" value="<?= $nis; ?>">
	                                <input type="hidden" name="nama_siswa" value="<?= $namaSiswa; ?>">
	                                <input type="hidden" name="kelas_siswa" value="<?= $kelas; ?>">
	                                <input type="hidden" name="panggilan_siswa" value="<?= $panggilan; ?>">

	                                <input type="hidden" name="id_invoice" value="<?= $data['ID']; ?>">
	                                <input type="hidden" name="tgl_bukti_pembayaran" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("-") : ($data['DATE']); ?>">
	                                <input type="hidden" name="pembayaran_bulan" value="<?= $data['pembayaran_bulan']; ?>">
	                                <input type="hidden" name="nominal_bayar" value="<?= $data['SPP']; ?>">
	                                <input type="hidden" name="ket_pembayaran" value="<?= $data['SPP_txt']; ?>">
	                                <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
	                                <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

	                                <input type="hidden" name="isi_filter" value="<?= $isifilby; ?>">
	                                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                					<input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">

	                                <button id="edit_data" name="edit_data_with_date" class="btn btn-sm btn-primary btn-circle"> 
	                                    EDIT 
	                                    <!-- <span class="glyphicon glyphicon-pencil">  -->
	                                </button>

	                            </form>

                                <form action="<?= $baseac; ?>editdata" method="POST" target="blank">

                                    <input type="hidden" name="id_siswa" value="<?= $id; ?>">
                                    <input type="hidden" name="nis_siswa" value="<?= $nis; ?>">
                                    <input type="hidden" name="nama_siswa" value="<?= $namaSiswa; ?>">
                                    <input type="hidden" name="kelas_siswa" value="<?= $kelas; ?>">
                                    <input type="hidden" name="panggilan_siswa" value="<?= $panggilan; ?>">

                                    <input type="hidden" name="id_invoice" value="<?= $data['ID']; ?>">
                                    <input type="hidden" name="tgl_bukti_pembayaran" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("-") : ($data['DATE']); ?>">
                                    <input type="hidden" name="pembayaran_bulan" value="<?= $data['pembayaran_bulan']; ?>">
                                    <input type="hidden" name="nominal_bayar" value="<?= $data['SPP']; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $data['SPP_txt']; ?>">
                                    <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
                                    <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                                    <input type="hidden" name="isi_filter" value="<?= $isifilby; ?>">
                                    <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                                    <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">

                                    <button id="edit_data" name="tambah_data" class="btn btn-sm btn-success btn-circle"> 
                                        TAMBAH
                                        <!-- <span class="glyphicon glyphicon-pencil">  -->
                                    </button>

                                </form>

                            </td>
                        <?php endif ?>
                    </tr>
                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

        <?php if ($halamanAktif > 1): ?>

            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanSebelumnyaFilterSPPWithDate" value="<?= $halamanAktif - 1; ?>">
                <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                <button name="previousPageFilterSPPWithDate">
                    &laquo;
                    Previous
                </button>
            </form>

        <?php endif; ?>

        <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

            <?php if ($jumlahPagination == 1): ?>
                
            <?php elseif ($halamanAktif == $i): ?>

                <form action="<?= $baseac; ?>editdata" method="post">
                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                    <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                        <?= $i; ?>
                    </button>
                </form>

            <?php else: ?>

                <form action="<?= $baseac; ?>editdata" method="post">
                    <input type="hidden" name="halamanKeFilterSPPWithDate" value="<?= $i; ?>">
                    <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                    <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                    <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                    <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                    <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                    <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                    <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                    <button name="toPageFilterSPPWithDate">
                        <?= $i; ?>
                    </button>
                </form>

            <?php endif; ?>

        <?php endfor; ?>

        <?php if ($halamanAktif < $jumlahPagination): ?>
            
            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanLanjutFilterSPPWithDate" value="<?= $halamanAktif + 1; ?>">
                <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                <button name="nextPageFilterSPPWithDate">
                    next
                    &raquo;
                </button>
            </form>

        <?php endif; ?>

    </div>

    <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

        <?php if ($halamanAktif > 1): ?>

            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanPertamaFilterSPPWithDate" value="<?= $halamanAktif - 1; ?>">
                <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                <button name="firstPageFilterSPPWithDate">
                    &laquo;
                    First Page
                </button>
            </form>

        <?php endif; ?>        

        <?php if ($hitungDataFilterSPPDate != 0): ?>
        	
        	<?php if ($halamanAktif == $jumlahPagination): ?>

	        <?php else: ?>

	            <form action="<?= $baseac; ?>editdata" method="post">
	                <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
	                <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
	                <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
	                <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
	                <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
	                <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
	                <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                    <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                    <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
	                <button name="lastPageFilterSPPWithDate">
	                    Last Page
	                    &raquo;
	                </button>
	            </form>

	        <?php endif; ?>

        <?php endif ?>

    </div>

    <br>