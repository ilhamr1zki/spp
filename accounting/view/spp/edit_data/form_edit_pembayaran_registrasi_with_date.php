<?php  

    $namaMurid = $namaSiswa;

    $tanggalDari    = $_POST['tanggal1'];
    $tanggalSampai  = $_POST['tanggal2'];

    if ($_SESSION['c_accounting'] == 'accounting1') { 

        $queryGetDataFilterRegistrasiWithDate = "
            SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_sd_lama1
            WHERE
            REGISTRASI != 0
            AND NAMA LIKE '%$namaMurid%'
            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
        ";

        $execQueryDataFilterRegistrasiWithDate    = mysqli_query($con, $queryGetDataFilterRegistrasiWithDate);
        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataFilterRegistrasiWithDate);
        $hitungDataFilterRegistrasiWithDate = mysqli_num_rows($execQueryDataFilterRegistrasiWithDate);
        // echo $hitungDataFilterRegistrasiWithDate . "<br>";

        // echo "Dari tanggal : " . $dariTanggal . "<br> ". "Sampai Tanggal : " . $sampaiTanggal . "<br> Jumlah Data : ". $hitungDataFilterRegistrasiWithDate;
        // echo $hitungDataFilterPANGKAL;exit;

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $ambildata_perhalaman = mysqli_query($con, "
            SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_sd_lama1
            WHERE
            REGISTRASI != 0
            AND NAMA LIKE '%$namaMurid%'
            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
            ORDER BY STAMP
            LIMIT $dataAwal, $jumlahData
        ");

        $jumlahPagination = ceil($hitungDataFilterRegistrasiWithDate / $jumlahData);

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

        $queryGetDataFilterRegistrasiWithDate = "
            SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_tk_lama
            WHERE
            REGISTRASI != 0
            AND NAMA LIKE '%$namaMurid%'
            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
        ";

        $execQueryDataFilterRegistrasiWithDate    = mysqli_query($con, $queryGetDataFilterRegistrasiWithDate);
        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataFilterRegistrasiWithDate);
        $hitungDataFilterRegistrasiWithDate = mysqli_num_rows($execQueryDataFilterRegistrasiWithDate);
        // echo $hitungDataFilterRegistrasiWithDate . "<br>";

        // echo "Dari tanggal : " . $dariTanggal . "<br> ". "Sampai Tanggal : " . $sampaiTanggal . "<br> Jumlah Data : ". $hitungDataFilterRegistrasiWithDate;
        // echo $hitungDataFilterPANGKAL;exit;

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $ambildata_perhalaman = mysqli_query($con, "
            SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_tk_lama
            WHERE
            REGISTRASI != 0
            AND NAMA LIKE '%$namaMurid%'
            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
            ORDER BY STAMP
            LIMIT $dataAwal, $jumlahData
        ");

        $jumlahPagination = ceil($hitungDataFilterRegistrasiWithDate / $jumlahData);

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
                <th style="text-align: center; width: 9%;"> UANG REGISTRASI </th>
                <th style="text-align: center; width: 9%;"> TANGGAL BAYAR</th>
                <th style="text-align: center; width: 9%;"> PEMBAYARAN BULAN </th>
                <th style="text-align: center; width: 13%;"> KET REGISTRASI </th>
                <th style="text-align: center; width: 5%;"> TRANSAKSI </th>
                <th style="text-align: center; width: 7%;"> DI INPUT OLEH </th>
                <th style="text-align: center; width: 10%;"> STAMP </th>
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
                        <td style="text-align: center;"> <?= rupiah($data['REGISTRASI']); ?> </td>

                        <?php if ($data['DATE'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?> 
                            <td style="text-align: center;"> <?= str_replace([" 00:00:00"], "", tglIndo($data['DATE'])); ?> </td>
                        <?php endif ?>

                        <?php if ($data['pembayaran_bulan'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                        <?php endif ?>

                        <td style="text-align: center;"> <?= $data['REGISTRASI_txt']; ?> </td>

                        <?php if ($data['TRANSAKSI'] == NULL): ?>
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
                                <input type="hidden" name="nominal_bayar" value="<?= $data['REGISTRASI']; ?>">
                                <input type="hidden" name="ket_pembayaran" value="<?= $data['REGISTRASI_txt']; ?>">
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
                                <input type="hidden" name="nominal_bayar" value="<?= $data['REGISTRASI']; ?>">
                                <input type="hidden" name="ket_pembayaran" value="<?= $data['REGISTRASI_txt']; ?>">
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
                    </tr>
                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

        <?php if ($halamanAktif > 1): ?>

            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanSebelumnyaFilterRegistrasiWithDate" value="<?= $halamanAktif - 1; ?>">
                <input type="hidden" name="iniFilterRegistrasiWithDate" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterRegistrasiWithDate" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterRegistrasiWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterRegistrasiWithDate" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterRegistrasiWithDate" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterRegistrasiWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterRegistrasiWithDate" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                <button name="previousPageFilterRegistrasiWithDate">
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
                    <input type="hidden" name="halamanKeFilterRegistrasiWithDate" value="<?= $i; ?>">
                    <input type="hidden" name="iniFilterRegistrasiWithDate" value="<?= $isifilby; ?>">
                    <input type="hidden" name="idSiswaFilterRegistrasiWithDate" value="<?= $id; ?>">
                    <input type="hidden" name="namaSiswaFilterRegistrasiWithDate" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="nisFormFilterRegistrasiWithDate" value="<?= $nis; ?>">
                    <input type="hidden" name="kelasFormFilterRegistrasiWithDate" value="<?= $kelas; ?>">
                    <input type="hidden" name="namaFormFilterRegistrasiWithDate" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="panggilanFormFilterRegistrasiWithDate" value="<?= $panggilan; ?>">
                    <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                    <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                    <button name="toPageFilterRegistrasiWithDate">
                        <?= $i; ?>
                    </button>
                </form>

            <?php endif; ?>

        <?php endfor; ?>

        <?php if ($halamanAktif < $jumlahPagination): ?>
            
            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanLanjutFilterRegistrasiWithDate" value="<?= $halamanAktif + 1; ?>">
                <input type="hidden" name="iniFilterRegistrasiWithDate" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterRegistrasiWithDate" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterRegistrasiWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterRegistrasiWithDate" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterRegistrasiWithDate" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterRegistrasiWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterRegistrasiWithDate" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                <button name="nextPageFilterRegistrasiWithDate">
                    next
                    &raquo;
                </button>
            </form>

        <?php endif; ?>

    </div>

    <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

        <?php if ($halamanAktif > 1): ?>

            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanPertamaFilterRegistrasiWithDate" value="<?= $halamanAktif - 1; ?>">
                <input type="hidden" name="iniFilterRegistrasiWithDate" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterRegistrasiWithDate" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterRegistrasiWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterRegistrasiWithDate" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterRegistrasiWithDate" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterRegistrasiWithDate" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterRegistrasiWithDate" value="<?= $panggilan; ?>">
                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                <button name="firstPageFilterRegistrasiWithDate">
                    &laquo;
                    First Page
                </button>
            </form>

        <?php endif; ?>        

        <?php if ($hitungDataFilterRegistrasiWithDate != 0): ?>
            
            <?php if ($halamanAktif == $jumlahPagination): ?>

            <?php else: ?>
                
                <form action="<?= $baseac; ?>editdata" method="post">
                    <input type="hidden" name="halamanTerakhirFilterRegistrasiWithDate" value="<?= $halamanAktif + 1; ?>">
                    <input type="hidden" name="iniFilterRegistrasiWithDate" value="<?= $isifilby; ?>">
                    <input type="hidden" name="idSiswaFilterRegistrasiWithDate" value="<?= $id; ?>">
                    <input type="hidden" name="namaSiswaFilterRegistrasiWithDate" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="nisFormFilterRegistrasiWithDate" value="<?= $nis; ?>">
                    <input type="hidden" name="kelasFormFilterRegistrasiWithDate" value="<?= $kelas; ?>">
                    <input type="hidden" name="namaFormFilterRegistrasiWithDate" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="panggilanFormFilterRegistrasiWithDate" value="<?= $panggilan; ?>">
                    <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                    <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                    <button name="lastPageFilterRegistrasiWithDate">
                        Last Page
                        &raquo;
                    </button>
                </form>

            <?php endif; ?>

        <?php endif ?>

    </div>

    <br>
