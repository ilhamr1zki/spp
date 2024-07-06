<?php  

	$namaMurid = $namaSiswa;

    $tanggalDari    = $_POST['tanggal1'];
    $tanggalSampai  = $_POST['tanggal2'];

    if ($_SESSION['c_accounting'] == 'accounting1' || $checkSession == 'sd') {

        $queryGetDataPangkal = "
            SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_sd
            WHERE
            PANGKAL != 0
            AND NIS = '$nis'
            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
        ";

        $execQueryDataPangkal    = mysqli_query($con, $queryGetDataPangkal);
        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataPangkal);
        $hitungDataFilterPangkalDate = mysqli_num_rows($execQueryDataPangkal);
        // echo "Jumlah Data : ". $hitungDataFilterPangkalDate;exit;
        // echo $hitungDataFilterPANGKAL;exit;

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $ambildata_perhalaman = mysqli_query($con, "
            SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_sd
            WHERE
            PANGKAL != 0
            AND NIS = '$nis'
            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
            order by stamp
            LIMIT $dataAwal, $jumlahData
        ");

        $jumlahPagination = ceil($hitungDataFilterPangkalDate / $jumlahData);

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

        $queryGetDataPangkal = "
            SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_tk
            WHERE
            PANGKAL != 0
            AND NIS = '$nis'
            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
        ";

        $execQueryDataPangkal    = mysqli_query($con, $queryGetDataPangkal);

        $hitungDataFilterPangkalDate = mysqli_num_rows($execQueryDataPangkal);

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $ambildata_perhalaman = mysqli_query($con, "
            SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_tk
            WHERE
            PANGKAL != 0
            AND NIS = '$nis'
            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
            ORDER BY STAMP
            LIMIT $dataAwal, $jumlahData
        ");

        $jumlahPagination = ceil($hitungDataFilterPangkalDate / $jumlahData);

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
                <th style="text-align: center; width: 3%;"> NUMBER INVOICE </th>
                <th style="text-align: center; width: 1%;"> NIS </th>
                <th style="text-align: center; width: 7%;"> NAMA </th>
                <th style="text-align: center; width: 1%;"> KELAS </th>
                <th style="text-align: center; width: 3%;"> PANGKAL </th>
                <th style="text-align: center; width: 3%;"> TANGGAL BAYAR </th>
                <th style="text-align: center; width: 3%;"> PEMBAYARAN BULAN </th>
                <th style="text-align: center; width: 5%;"> KET PANGKAL </th>
                <th style="text-align: center; width: 1%;"> TRANSAKSI </th>
                <th style="text-align: center; width: 3%;"> DI INPUT OLEH </th>
                <th style="text-align: center; width: 7%;"> STAMP </th>
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
                        <td style="text-align: center;"> <?= rupiah($data['PANGKAL']); ?> </td>
                        <td style="text-align: center;"> <?= str_replace([" 00:00:00"], "", tglIndo($data['DATE'])); ?> </td>
                        <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                        <td style="text-align: center;"> <?= $data['PANGKAL_txt']; ?> </td>
                        <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>

                        <?php if ($data['di_input_oleh'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                        <?php endif ?>

                        <?php if ($data['tanggal_diupdate'] == NULL || $data['tanggal_diupdate'] == '0000-00-00 00:00:00'): ?>
                            <td style="text-align: center; width: 10px;"> <strong> - </strong> </td>
                            <td style="text-align: center; justify-content: center;" id="tombol-cetak-pangkal">
                            
                                <form action="<?= $baseac; ?>editdata" method="POST" target="blank">

	                                <input type="hidden" name="id_siswa" value="<?= $id; ?>">
	                                <input type="hidden" name="nis_siswa" value="<?= $nis; ?>">
	                                <input type="hidden" name="nama_siswa" value="<?= $namaSiswa; ?>">
	                                <input type="hidden" name="kelas_siswa" value="<?= $kelas; ?>">
	                                <input type="hidden" name="panggilan_siswa" value="<?= $panggilan; ?>">

	                                <input type="hidden" name="id_invoice" value="<?= $data['ID']; ?>">
	                                <input type="hidden" name="tgl_bukti_pembayaran" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("-") : ($data['DATE']); ?>">
	                                <input type="hidden" name="pembayaran_bulan" value="<?= $data['pembayaran_bulan']; ?>">
	                                <input type="hidden" name="nominal_bayar" value="<?= $data['PANGKAL']; ?>">
	                                <input type="hidden" name="ket_pembayaran" value="<?= $data['PANGKAL_txt']; ?>">
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
                                    <input type="hidden" name="nominal_bayar" value="<?= $data['PANGKAL']; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $data['PANGKAL_txt']; ?>">
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
                            <td style="text-align: center; justify-content: center;" id="tombol-cetak-pangkal">
                            
                                <form action="<?= $baseac; ?>editdata" method="POST" target="blank">

	                                <input type="hidden" name="id_siswa" value="<?= $id; ?>">
	                                <input type="hidden" name="nis_siswa" value="<?= $nis; ?>">
	                                <input type="hidden" name="nama_siswa" value="<?= $namaSiswa; ?>">
	                                <input type="hidden" name="kelas_siswa" value="<?= $kelas; ?>">
	                                <input type="hidden" name="panggilan_siswa" value="<?= $panggilan; ?>">

	                                <input type="hidden" name="id_invoice" value="<?= $data['ID']; ?>">
	                                <input type="hidden" name="tgl_bukti_pembayaran" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("-") : ($data['DATE']); ?>">
	                                <input type="hidden" name="pembayaran_bulan" value="<?= $data['pembayaran_bulan']; ?>">
	                                <input type="hidden" name="nominal_bayar" value="<?= $data['PANGKAL']; ?>">
	                                <input type="hidden" name="ket_pembayaran" value="<?= $data['PANGKAL_txt']; ?>">
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
                                    <input type="hidden" name="nominal_bayar" value="<?= $data['PANGKAL']; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $data['PANGKAL_txt']; ?>">
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
                <input type="hidden" name="halamanSebelumnyaFilterPangkalWithDate" value="<?= $halamanAktif - 1; ?>">
                <input type="hidden" name="iniFilterPangkalWithDate" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterPangkalWithDate" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterPangkalWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterPangkalWithDate" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterPangkalWithDate" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterPangkalWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterPangkalWithDate" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                <button name="previousPageFilterPangkalWithDate">
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
                    <input type="hidden" name="halamanKeFilterPangkalWithDate" value="<?= $i; ?>">
                    <input type="hidden" name="iniFilterPangkalWithDate" value="<?= $isifilby; ?>">
                    <input type="hidden" name="idSiswaFilterPangkalWithDate" value="<?= $id; ?>">
                    <input type="hidden" name="namaSiswaFilterPangkalWithDate" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="nisFormFilterPangkalWithDate" value="<?= $nis; ?>">
                    <input type="hidden" name="kelasFormFilterPangkalWithDate" value="<?= $kelas; ?>">
                    <input type="hidden" name="namaFormFilterPangkalWithDate" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="panggilanFormFilterPangkalWithDate" value="<?= $panggilan; ?>">
                    <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                    <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                    <button name="toPageFilterPangkalWithDate">
                        <?= $i; ?>
                    </button>
                </form>

            <?php endif; ?>

        <?php endfor; ?>

        <?php if ($halamanAktif < $jumlahPagination): ?>
            
            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanLanjutFilterPangkalWithDate" value="<?= $halamanAktif + 1; ?>">
                <input type="hidden" name="iniFilterPangkalWithDate" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterPangkalWithDate" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterPangkalWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterPangkalWithDate" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterPangkalWithDate" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterPangkalWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterPangkalWithDate" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                <button name="nextPageFilterPangkalWithDate">
                    next
                    &raquo;
                </button>
            </form>

        <?php endif; ?>

    </div>

    <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

        <?php if ($halamanAktif > 1): ?>

            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanPertamaFilterPangkalWithDate" value="<?= $halamanAktif - 1; ?>">
                <input type="hidden" name="iniFilterPangkalWithDate" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterPangkalWithDate" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterPangkalWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterPangkalWithDate" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterPangkalWithDate" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterPangkalWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterPangkalWithDate" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                <button name="firstPageFilterPangkalWithDate">
                    &laquo;
                    First Page
                </button>
            </form>

        <?php endif; ?>        

        <?php if ($hitungDataFilterPangkalDate != 0): ?>
        	
        	<?php if ($halamanAktif == $jumlahPagination): ?>

	        <?php else: ?>
	            
	            <form action="<?= $baseac; ?>editdata" method="post">
	                <input type="hidden" name="iniFilterPangkalWithDate" value="<?= $isifilby; ?>">
	                <input type="hidden" name="idSiswaFilterPangkalWithDate" value="<?= $id; ?>">
	                <input type="hidden" name="namaSiswaFilterPangkalWithDate" value="<?= $namaMurid; ?>">
	                <input type="hidden" name="nisFormFilterPangkalWithDate" value="<?= $nis; ?>">
	                <input type="hidden" name="kelasFormFilterPangkalWithDate" value="<?= $kelas; ?>">
	                <input type="hidden" name="namaFormFilterPangkalWithDate" value="<?= $namaMurid; ?>">
	                <input type="hidden" name="panggilanFormFilterPangkalWithDate" value="<?= $panggilan; ?>">
                    <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                    <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
	                <button name="lastPageFilterPangkalWithDate">
	                    Last Page
	                    &raquo;
	                </button>
	            </form>

	        <?php endif; ?>

        <?php endif ?>

    </div>

    <br>
