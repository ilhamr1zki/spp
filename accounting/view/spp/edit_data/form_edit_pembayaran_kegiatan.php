<?php  

    if ($_SESSION['c_accounting'] == 'accounting1' || $checkSession == 'sd') {

        $namaMurid = $namaSiswa;
    	$queryGetDataKegiatan = "
        SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
        FROM input_data_sd
        WHERE
        KEGIATAN_txt <> '' AND
        NIS = '$nis' ";

        $execQueryDataKegiatan    = mysqli_query($con, $queryGetDataKegiatan);
        $hitungDataFilterKegiatan = mysqli_num_rows($execQueryDataKegiatan);

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
        // echo $dataAwal . "<br>";
        $ambildata_perhalaman = mysqli_query($con, "
            SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_sd
            WHERE
            KEGIATAN_txt <> '' AND
            NIS = '$nis' 
            ORDER BY ID DESC
            LIMIT $dataAwal, $jumlahData");
        // print_r($ambildata_perhalaman->num_rows);
        $jumlahPagination = ceil($hitungDataFilterKegiatan / $jumlahData);

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

    } else if ($_SESSION['c_accounting'] == 'accounting2' || $checkSession == 'tk') {

        $namaMurid = $namaSiswa;
        $queryGetDataKegiatan = "
        SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
        FROM input_data_tk
        WHERE
        KEGIATAN_txt <> '' AND
        NIS = '$nis' ";

        $execQueryDataKegiatan    = mysqli_query($con, $queryGetDataKegiatan);
        $hitungDataFilterKegiatan = mysqli_num_rows($execQueryDataKegiatan);
        // echo $hitungDataFilterKegiatan;exit;

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
        // echo $dataAwal . "<br>";
        $ambildata_perhalaman = mysqli_query($con, "
            SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_tk
            WHERE
            KEGIATAN_txt <> '' AND
            NIS = '$nis' 
            ORDER BY ID DESC
            LIMIT $dataAwal, $jumlahData");
        // print_r($ambildata_perhalaman->num_rows);

        // $jumlah = mysqli_num_rows($ambildata_perhalaman);
        // echo $jumlah;exit;
        // foreach ($ambildata_perhalaman as $data) {
        //     echo $data['ID'] . "<br>";exit;
        // }

        $jumlahPagination = ceil($hitungDataFilterKegiatan / $jumlahData);

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
                <th style="text-align: center; width: 7%;"> NUMBER INVOICE </th>
                <th style="text-align: center; width: 5%;"> NIS </th>
                <th style="text-align: center; width: 13%;"> NAMA </th>
                <th style="text-align: center; width: 5%"> KELAS </th>
                <th style="text-align: center; width: 9%;"> UANG KEGIATAN </th>
                <th style="text-align: center; width: 6%;"> TANGGAL BAYAR </th>
                <th style="text-align: center; width: 6%;"> PEMBAYARAN BULAN </th>
                <th style="text-align: center; width: 10%;"> KET KEGIATAN </th>
                <th style="text-align: center; width: 1%;"> TRANSAKSI </th>
                <th style="text-align: center; width: 7%;"> DI INPUT OLEH </th>
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
                        <td style="text-align: center;"> <?= rupiah($data['KEGIATAN']); ?> </td>

                        <?php if ($data['DATE'] == NULL): ?>

                            <td style="text-align: center;"> <strong> - </strong> </td>
                        
                        <?php else: ?> 

                            <td style="text-align: center;"> <?= str_replace([" 00:00:00"], "", tglIndo($data['DATE'])) ; ?> </td>
                        
                        <?php endif ?>

                        <?php if ($data['pembayaran_bulan'] == '' || $data['pembayaran_bulan'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                        <?php endif ?>

                        <td style="text-align: center;"> <?= $data['KEGIATAN_txt']; ?> </td>
                        <?php if ($data['TRANSAKSI'] == '' || $data['TRANSAKSI'] == NULL || $data['TRANSAKSI'] == 'kosong'): ?>
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
                                    <input type="hidden" name="nominal_bayar" value="<?= $data['KEGIATAN']; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $data['KEGIATAN_txt']; ?>">
                                    <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
                                    <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                                    <input type="hidden" name="isi_filter" value="<?= $isifilby; ?>">
                                    <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                                    <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">

                                    <button id="edit_data" name="edit_data" class="btn btn-sm btn-primary btn-circle"> 
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
                                    <input type="hidden" name="nominal_bayar" value="<?= $data['KEGIATAN']; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $data['KEGIATAN_txt']; ?>">
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
                                    <input type="hidden" name="nominal_bayar" value="<?= $data['KEGIATAN']; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $data['KEGIATAN_txt']; ?>">
                                    <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
                                    <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                                    <input type="hidden" name="isi_filter" value="<?= $isifilby; ?>">
                                    <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                                    <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">

                                    <button id="edit_data" name="edit_data" class="btn btn-sm btn-primary btn-circle"> 
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
                                    <input type="hidden" name="nominal_bayar" value="<?= $data['KEGIATAN']; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $data['KEGIATAN_txt']; ?>">
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
                <input type="hidden" name="halamanSebelumnyaFilterKegiatan" value="<?= $halamanAktif - 1; ?>">
                <input type="hidden" name="iniFilterKegiatan" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterKegiatan" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterKegiatan" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterKegiatan" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterKegiatan" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterKegiatan" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterKegiatan" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                <button name="previousPageFilterKegiatan">
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
                    <input type="hidden" name="halamanKeFilterKegiatan" value="<?= $i; ?>">
                    <input type="hidden" name="iniFilterKegiatan" value="<?= $isifilby; ?>">
                    <input type="hidden" name="idSiswaFilterKegiatan" value="<?= $id; ?>">
                    <input type="hidden" name="namaSiswaFilterKegiatan" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="nisFormFilterKegiatan" value="<?= $nis; ?>">
                    <input type="hidden" name="kelasFormFilterKegiatan" value="<?= $kelas; ?>">
                    <input type="hidden" name="namaFormFilterKegiatan" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="panggilanFormFilterKegiatan" value="<?= $panggilan; ?>">
                    <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                    <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                    <button name="toPageFilterKegiatan">
                        <?= $i; ?>
                    </button>
                </form>

            <?php endif; ?>

        <?php endfor; ?>

        <?php if ($halamanAktif < $jumlahPagination): ?>
            
            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanLanjutFilterKegiatan" value="<?= $halamanAktif + 1; ?>">
                <input type="hidden" name="iniFilterKegiatan" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterKegiatan" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterKegiatan" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterKegiatan" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterKegiatan" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterKegiatan" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterKegiatan" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                <button name="nextPageFilterKegiatan" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                    next
                    &raquo;
                </button>
            </form>

        <?php endif; ?>

    </div>

    <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

        <?php if ($halamanAktif > 1): ?>

            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanPertamaFilterKegiatan" value="<?= $halamanAktif - 1; ?>">
                <input type="hidden" name="iniFilterKegiatan" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterKegiatan" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterKegiatan" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterKegiatan" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterKegiatan" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterKegiatan" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterKegiatan" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                <button name="firstPageFilterKegiatan">
                    &laquo;
                    First Page
                </button>
            </form>

        <?php endif; ?>

        <?php if ($hitungDataFilterKegiatan != 0): ?>
            
            <?php if ($halamanAktif == $jumlahPagination): ?>

            <?php else: ?>
            
                <form action="<?= $baseac; ?>editdata" method="post">
                    <input type="hidden" name="halamanTerakhirFilterKegiatan" value="<?= $halamanAktif + 1; ?>">
                    <input type="hidden" name="iniFilterKegiatan" value="<?= $isifilby; ?>">
                    <input type="hidden" name="idSiswaFilterKegiatan" value="<?= $id; ?>">
                    <input type="hidden" name="namaSiswaFilterKegiatan" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="nisFormFilterKegiatan" value="<?= $nis; ?>">
                    <input type="hidden" name="kelasFormFilterKegiatan" value="<?= $kelas; ?>">
                    <input type="hidden" name="namaFormFilterKegiatan" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="panggilanFormFilterKegiatan" value="<?= $panggilan; ?>">
                    <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                    <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                    <button name="lastPageFilterKegiatan">
                        Last Page
                        &raquo;
                    </button>
                </form>

            <?php endif; ?>

        <?php endif ?>

    </div>

    <br>


