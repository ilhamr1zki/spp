<?php  

    $namaMurid = $namaSiswa;

    $tanggalDari    = $_POST['tanggal1'];
    $tanggalSampai  = $_POST['tanggal2'];

    if ($_SESSION['c_accounting'] == 'accounting1') {

        $namaMurid = $namaSiswa;

        $tanggalDari    = $_POST['tanggal1'];
        $tanggalSampai  = $_POST['tanggal2']; 

        $queryGetDataFilterSeragamWithDate = "
            SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_sd
            WHERE
            SERAGAM != 0
            AND NAMA LIKE '%$namaMurid%'
            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
        ";

        $execQueryDataFilterSeragamWithDate    = mysqli_query($con, $queryGetDataFilterSeragamWithDate);
        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataFilterSeragamWithDate);
        $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataFilterSeragamWithDate);
        // echo $hitungDataFilterSeragamWithDate . "<br>";

        // echo "Dari tanggal : " . $dariTanggal . "<br> ". "Sampai Tanggal : " . $sampaiTanggal . "<br> Jumlah Data : ". $hitungDataFilterSeragamWithDate;
        // echo $hitungDataFilterPANGKAL;exit;

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $ambildata_perhalaman = mysqli_query($con, "
            SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_sd
            WHERE
            SERAGAM != 0
            AND NAMA LIKE '%$namaMurid%'
            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
            ORDER BY STAMP
            LIMIT $dataAwal, $jumlahData
        ");

        $jumlahPagination = ceil($hitungDataFilterSeragamWithDate / $jumlahData);

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

    } elseif ($_SESSION['c_accounting'] == 'accounting2') {

        $namaMurid = $namaSiswa;

        $tanggalDari    = $_POST['tanggal1'];
        $tanggalSampai  = $_POST['tanggal2']; 

        $queryGetDataFilterSeragamWithDate = "
            SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_tk
            WHERE
            SERAGAM != 0
            AND NAMA LIKE '%$namaMurid%'
            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
        ";

        $execQueryDataFilterSeragamWithDate    = mysqli_query($con, $queryGetDataFilterSeragamWithDate);
        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataFilterSeragamWithDate);
        $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataFilterSeragamWithDate);
        // echo $hitungDataFilterSeragamWithDate . "<br>";

        // echo "Dari tanggal : " . $dariTanggal . "<br> ". "Sampai Tanggal : " . $sampaiTanggal . "<br> Jumlah Data : ". $hitungDataFilterSeragamWithDate;
        // echo $hitungDataFilterPANGKAL;exit;

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $ambildata_perhalaman = mysqli_query($con, "
            SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_tk
            WHERE
            SERAGAM != 0
            AND NAMA LIKE '%$namaMurid%'
            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
            ORDER BY STAMP
            LIMIT $dataAwal, $jumlahData
        ");

        $jumlahPagination = ceil($hitungDataFilterSeragamWithDate / $jumlahData);

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
                <th style="text-align: center; width: 15%;"> NAMA </th>
                <th style="text-align: center; width: 3%;"> KELAS </th>
                <th style="text-align: center; width: 9%;"> UANG SERAGAM </th>
                <th style="text-align: center; width: 9%;"> TANGGAL BAYAR </th>
                <th style="text-align: center; width: 9%;"> PEMBAYARAN BULAN </th>
                <th style="text-align: center; width: 13%;"> KET SERAGAM </th>
                <th style="text-align: center; width: 5%;"> TRANSAKSI </th>
                <th style="text-align: center; width: 7%;"> DI INPUT OLEH </th>
                <th style="text-align: center; width: 10%;"> STAMP </th>
                <th style="text-align: center; width: 1%;"> CETAK </th>
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
                        <td style="text-align: center;"> <?= rupiah($data['SERAGAM']); ?> </td>
                        <td style="text-align: center;"> <?= str_replace([" 00:00:00"], "", tglIndo($data['DATE'])); ?> </td>
                        <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                        <td style="text-align: center;"> <?= $data['SERAGAM_txt']; ?> </td>
                        <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>

                        <?php if ($data['di_input_oleh'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                        <?php endif ?>

                        <?php if ($data['tanggal_diupdate'] == NULL): ?>

                            <td style="text-align: center;"> - </td>

                        <?php else: ?>
                            
                            <td style="text-align: center;"> <?= tglIndo($data['tanggal_diupdate']); ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;" id="tombol-cetak">

                            <form action="<?= $baseac; ?>editdata" method="POST" target="blank">

                                <input type="hidden" name="id_siswa" value="<?= $id; ?>">
                                <input type="hidden" name="nis_siswa" value="<?= $nis; ?>">
                                <input type="hidden" name="nama_siswa" value="<?= $namaSiswa; ?>">
                                <input type="hidden" name="kelas_siswa" value="<?= $kelas; ?>">
                                <input type="hidden" name="panggilan_siswa" value="<?= $panggilan; ?>">

                                <input type="hidden" name="id_invoice" value="<?= $data['ID']; ?>">
                                <input type="hidden" name="tgl_bukti_pembayaran" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("-") : ($data['DATE']); ?>">
                                <input type="hidden" name="pembayaran_bulan" value="<?= $data['pembayaran_bulan']; ?>">
                                <input type="hidden" name="nominal_bayar" value="<?= $data['SERAGAM']; ?>">
                                <input type="hidden" name="ket_pembayaran" value="<?= $data['SERAGAM_txt']; ?>">
                                <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
                                <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                                <input type="hidden" name="isi_filter" value="<?= $isifilby; ?>">
                                <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                                <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">

                                <button id="edit_data" name="edit_data_with_date" class="btn btn-sm btn-primary btn-circle"> 
                                    EDIT 
                                    <!-- <span class="glyphicon glyphicon-pencil">  -->
                                </button>

                            </form>

                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

        <?php if ($halamanAktif > 1): ?>

            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanSebelumnyaFilterSeragamWithDate" value="<?= $halamanAktif - 1; ?>">
                <input type="hidden" name="iniFilterSeragamWithDate" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterSeragamWithDate" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterSeragamWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterSeragamWithDate" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterSeragamWithDate" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterSeragamWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterSeragamWithDate" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                <button name="previousPageFilterSeragamWithDate">
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
                    <input type="hidden" name="halamanKeFilterSeragamWithDate" value="<?= $i; ?>">
                    <input type="hidden" name="iniFilterSeragamWithDate" value="<?= $isifilby; ?>">
                    <input type="hidden" name="idSiswaFilterSeragamWithDate" value="<?= $id; ?>">
                    <input type="hidden" name="namaSiswaFilterSeragamWithDate" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="nisFormFilterSeragamWithDate" value="<?= $nis; ?>">
                    <input type="hidden" name="kelasFormFilterSeragamWithDate" value="<?= $kelas; ?>">
                    <input type="hidden" name="namaFormFilterSeragamWithDate" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="panggilanFormFilterSeragamWithDate" value="<?= $panggilan; ?>">
                    <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                    <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                    <button name="toPageFilterSeragamWithDate">
                        <?= $i; ?>
                    </button>
                </form>

            <?php endif; ?>

        <?php endfor; ?>

        <?php if ($halamanAktif < $jumlahPagination): ?>
            
            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanLanjutFilterSeragamWithDate" value="<?= $halamanAktif + 1; ?>">
                <input type="hidden" name="iniFilterSeragamWithDate" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterSeragamWithDate" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterSeragamWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterSeragamWithDate" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterSeragamWithDate" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterSeragamWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterSeragamWithDate" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                <button name="nextPageFilterSeragamWithDate">
                    next
                    &raquo;
                </button>
            </form>

        <?php endif; ?>

    </div>

    <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

        <?php if ($halamanAktif > 1): ?>

            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanPertamaFilterSeragamWithDate" value="<?= $halamanAktif - 1; ?>">
                <input type="hidden" name="iniFilterSeragamWithDate" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterSeragamWithDate" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterSeragamWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterSeragamWithDate" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterSeragamWithDate" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterSeragamWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterSeragamWithDate" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                <button name="firstPageFilterSeragamWithDate">
                    &laquo;
                    First Page
                </button>
            </form>

        <?php endif; ?>        

        <?php if ($hitungDataFilterSeragamWithDate != 0): ?>
            
            <?php if ($halamanAktif == $jumlahPagination): ?>

            <?php else: ?>
                
                <form action="<?= $baseac; ?>editdata" method="post">
                    <input type="hidden" name="halamanTerakhirFilterSeragamWithDate" value="<?= $halamanAktif + 1; ?>">
                    <input type="hidden" name="iniFilterSeragamWithDate" value="<?= $isifilby; ?>">
                    <input type="hidden" name="idSiswaFilterSeragamWithDate" value="<?= $id; ?>">
                    <input type="hidden" name="namaSiswaFilterSeragamWithDate" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="nisFormFilterSeragamWithDate" value="<?= $nis; ?>">
                    <input type="hidden" name="kelasFormFilterSeragamWithDate" value="<?= $kelas; ?>">
                    <input type="hidden" name="namaFormFilterSeragamWithDate" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="panggilanFormFilterSeragamWithDate" value="<?= $panggilan; ?>">
                    <input type="hidden" name="tanggal1" value="<?= $tanggalDari; ?>">
                    <input type="hidden" name="tanggal2" value="<?= $tanggalSampai; ?>">
                    <button name="lastPageFilterSeragamWithDate">
                        Last Page
                        &raquo;
                    </button>
                </form>

            <?php endif; ?>

        <?php endif ?>

    </div>

    <br>
