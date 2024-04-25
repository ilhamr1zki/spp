<?php  

    // require 'check_pembayaran_dan_inputdata.php';

?>
    
    <?php if ($code_accounting == 'accounting1'): ?>
        
        <?php if (isset($_POST['filter_by'])): ?>
    
            <?php if ($_POST['isi_filter'] != 'kosong'): ?>
                
                <?php  

                    $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
                    $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

                ?>

                <!-- <?= "Nama : " . $_POST['_nmsiswa2'] . "<br> Filter : " . $_POST['isi_filter'] . "<br> Dari Tanggal : " . $dariTanggal . "<br> Sampai Tanggal : " . $sampaiTanggal; ?> -->

                <?php if ($_POST['isi_filter'] == 'SPP') : ?>

                    <?php if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") : ?>

                        <!-- <?php echo "Semua Data Muncul berdasarkan filter " . $_POST['isi_filter'] . " Atas nama " . $_POST['nama_siswa']; ?> -->

                        <?php  

                            // Data SPP
                            $namaMurid = $_POST['nama_siswa'];
                            $nis       = $_POST['nis_siswa'];
                            $queryGetDataSPP = "
                            SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            SPP != 0
                            AND NAMA LIKE '%$namaMurid%' ";
                            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
                            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);
                            // echo $hitungDataFilterSPP;
                            $getDataArr          = mysqli_fetch_array($execQueryDataSPP);

                            // Akhir Data SPP

                        ?>

                        <!-- SPP -->
                        <div style="overflow-x: auto;">
                                    
                            <table id="example1" class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th style="text-align: center; width: 100px;"> ID </th>
                                    <th style="text-align: center;"> NIS </th>
                                    <th style="text-align: center;"> NAMA </th>
                                    <th style="text-align: center;"> KELAS </th>
                                    <th style="text-align: center;"> SPP </th>
                                    <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                                    <th style="text-align: center;"> KET SPP </th>
                                    <th style="text-align: center;"> Tanggal DiUpdate </th>
                                    <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                            <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                        <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="previousPage">
                                        &laquo;
                                        Previous
                                    </button>
                                </form>

                            <?php endif; ?>

                            <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                                <?php if ($jumlahPagination == 1): ?>
                                    
                                <?php elseif ($halamanAktif == $i): ?>

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                        <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                            <?= $i; ?>
                                        </button>
                                    </form>

                                <?php else: ?>

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="halamanKeFilterSPP" value="<?= $i; ?>">
                                        <input type="hidden" name="iniFilterSPP" value="<?= $_POST['isi_filter']; ?>">
                                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                                        <button name="toPageFilterSPP">
                                            <?= $i; ?>
                                        </button>
                                    </form>
                                <?php endif; ?>

                            <?php endfor; ?>

                            <?php if ($halamanAktif < $jumlahPagination): ?>
                                
                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="halamanLanjutFilterSPP" value="<?= $halamanAktif + 1; ?>">
                                    <input type="hidden" name="iniFilterSPP" value="<?= $_POST['isi_filter']; ?>">
                                    <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                                    <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                                    <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                                    <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                                    <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                                    <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                                    <button name="nextPageJustFilterSPP" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                                        next
                                        &raquo;
                                    </button>
                                </form>

                            <?php endif; ?>

                        </div>

                        <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="previousPage">
                                        &laquo;
                                        First Page
                                    </button>
                                </form>
                            <?php endif; ?>        

                            <?php if ($hitungDataFilterSPP < 5): ?>
                            <?php else: ?>
                                
                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="halamanTerakhirFilterSPP" value="<?= $halamanAktif + 1; ?>">
                                    <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                                    <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                                    <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                                    <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                                    <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                                    <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                                    <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                                    <button name="lastPageFilterSPP">
                                        Last Page
                                        &raquo;
                                    </button>
                                </form>

                            <?php endif ?>

                        </div>

                        <br>

                    <?php elseif($dariTanggal != ' 00:00:00' && $sampaiTanggal == ' 23:59:59'): ?>

                        <div style="overflow-x: auto;">
                            
                            <table id="example1" class="table table-bordered">
                                <thead>
                                  <tr>
                                     <th style="text-align: center; width: 100px;"> ID </th>
                                     <th style="text-align: center;"> NIS </th>
                                     <th style="text-align: center;"> DATE </th>
                                     <th style="text-align: center;"> BULAN </th>
                                     <th style="text-align: center;"> KELAS </th>
                                     <th style="text-align: center;"> NAMA KELAS</th>
                                     <th style="text-align: center;"> NAMA </th>
                                     <th style="text-align: center;"> PANGGILAN </th>
                                     <th style="text-align: center;"> TRANSAKSI </th>
                                     <th style="text-align: center;"> SPP SET </th>
                                     <th style="text-align: center;"> PANGKAL SET </th>
                                     <th style="text-align: center;"> SPP  </th>
                                     <th style="text-align: center;"> KET SPP </th>
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
                                     <th style="text-align: center;"> STAMP </th>

                                  </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($ambildata_perhalaman as $data) : ?>
                                        <tr>
                                            <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['DATE']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['BULAN']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NAMA_KELAS']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['PANGGILAN']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['SPP_SET']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['PANGKAL_SET']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['KEGIATAN']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['KEGIATAN_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['BUKU']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['BUKU_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['SERAGAM']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['SERAGAM_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['REGISTRASI']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['REGISTRASI_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['LAIN']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['LAIN_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['INPUTER']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['STAMP']; ?> </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                        <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="previousPage">
                                        &laquo;
                                        Previous
                                    </button>
                                </form>

                            <?php endif; ?>

                            <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                                <?php if ($jumlahPagination == 1): ?>
                                    
                                <?php elseif ($halamanAktif == $i): ?>

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                        <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                            <?= $i; ?>
                                        </button>
                                    </form>

                                <?php else: ?>
                                    <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                                        <?= $i; ?>
                                    </a> -->
                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="halamanKe" value="<?= $i; ?>">
                                        <button name="toPage">
                                            <?= $i; ?>
                                        </button>
                                    </form>
                                <?php endif; ?>

                            <?php endfor; ?>

                            <?php if ($halamanAktif < $jumlahPagination): ?>
                                
                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="halamanLanjut" value="<?= $halamanAktif + 1; ?>">
                                    <button name="nextPage" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                                        next
                                        &raquo;
                                    </button>
                                </form>

                            <?php endif; ?>

                        </div>

                        <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>

                                <?php if ($halamanAktif > 100): ?>
                                    
                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                        <input type="hidden" name="paginationSekarangKurang100" value="<?= $halamanAktif; ?>">
                                        <button name="reductionPage100">
                                            &laquo;&laquo;
                                        </button>
                                    </form>

                                <?php else: ?>

                                <?php endif; ?>

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="firstPage">
                                        &laquo;
                                        First Page
                                    </button>
                                </form>
                            <?php endif; ?>      

                            <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                            <button name="findGetPage" onclick="findOpenPage()">
                                On Page
                            </button>

                            <?php if ($halamanAktif == $jumlahPagination): ?>
                                
                            <?php else: ?>

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                                    <button name="nextLastPage">
                                        Last Page
                                        &raquo;
                                    </button>
                                </form>

                                <?php if ($showAddPage100 == "muncul" ): ?>

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                        <input type="hidden" name="paginationSekarangTambah100" value="<?= $halamanAktif; ?>">
                                        <button name="addPage100">
                                            &raquo;&raquo;
                                        </button>
                                    </form>

                                <?php else: ?>


                                <?php endif ?>

                                

                            <?php endif ?>

                        </div>

                        <br>

                    <?php elseif($dariTanggal > $sampaiTanggal): ?>

                        <!-- <?php echo "Filter Tanggal dari tidak boleh lebih besar dari filter tanggal sampai " . $dariTanggal . " " . $sampaiTanggal; ?> -->

                        <div style="overflow-x: auto;">
                            
                            <table id="example1" class="table table-bordered">
                                <thead>
                                  <tr>
                                     <th style="text-align: center; width: 100px;"> ID </th>
                                     <th style="text-align: center;"> NIS </th>
                                     <th style="text-align: center;"> DATE </th>
                                     <th style="text-align: center;"> BULAN </th>
                                     <th style="text-align: center;"> KELAS </th>
                                     <th style="text-align: center;"> NAMA KELAS</th>
                                     <th style="text-align: center;"> NAMA </th>
                                     <th style="text-align: center;"> PANGGILAN </th>
                                     <th style="text-align: center;"> TRANSAKSI </th>
                                     <th style="text-align: center;"> SPP SET </th>
                                     <th style="text-align: center;"> PANGKAL SET </th>
                                     <th style="text-align: center;"> SPP  </th>
                                     <th style="text-align: center;"> KET SPP </th>
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
                                     <th style="text-align: center;"> STAMP </th>

                                  </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($ambildata_perhalaman as $data) : ?>
                                        <tr>
                                            <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['DATE']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['BULAN']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NAMA_KELAS']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['PANGGILAN']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['SPP_SET']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['PANGKAL_SET']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['KEGIATAN']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['KEGIATAN_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['BUKU']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['BUKU_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['SERAGAM']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['SERAGAM_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['REGISTRASI']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['REGISTRASI_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['LAIN']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['LAIN_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['INPUTER']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['STAMP']; ?> </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                        <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>
                            
                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="previousPage">
                                        &laquo;
                                        Previous
                                    </button>
                                </form>

                            <?php endif; ?>

                            <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                                <?php if ($jumlahPagination == 1): ?>
                                    
                                <?php elseif ($halamanAktif == $i): ?>

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                        <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                            <?= $i; ?>
                                        </button>
                                    </form>

                                <?php else: ?>
                                    <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                                        <?= $i; ?>
                                    </a> -->
                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="halamanKe" value="<?= $i; ?>">
                                        <button name="toPage">
                                            <?= $i; ?>
                                        </button>
                                    </form>
                                <?php endif; ?>

                            <?php endfor; ?>

                            <?php if ($halamanAktif < $jumlahPagination): ?>
                                
                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="halamanLanjut" value="<?= $halamanAktif + 1; ?>">
                                    <button name="nextPage" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                                        next
                                        &raquo;
                                    </button>
                                </form>

                            <?php endif; ?>

                        </div>

                        <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>

                                <?php if ($halamanAktif > 100): ?>
                                    
                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                        <input type="hidden" name="paginationSekarangKurang100" value="<?= $halamanAktif; ?>">
                                        <button name="reductionPage100">
                                            &laquo;&laquo;
                                        </button>
                                    </form>

                                <?php else: ?>

                                <?php endif; ?>

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="firstPage">
                                        &laquo;
                                        First Page
                                    </button>
                                </form>
                            <?php endif; ?>      

                            <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                            <button name="findGetPage" onclick="findOpenPage()">
                                On Page
                            </button>

                            <?php if ($halamanAktif == $jumlahPagination): ?>
                                
                            <?php else: ?>

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                                    <button name="nextLastPage">
                                        Last Page
                                        &raquo;
                                    </button>
                                </form>

                                <?php if ($showAddPage100 == "muncul" ): ?>

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                        <input type="hidden" name="paginationSekarangTambah100" value="<?= $halamanAktif; ?>">
                                        <button name="addPage100">
                                            &raquo;&raquo;
                                        </button>
                                    </form>

                                <?php else: ?>


                                <?php endif ?>

                                

                            <?php endif ?>

                        </div>

                        <br>                        
                    
                    <?php elseif($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59'): ?>

                        <!-- SPP Filter Date -->
                        <div style="overflow-x: auto;">
                                    
                            <table id="example1" class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th style="text-align: center; width: 100px;"> ID </th>
                                    <th style="text-align: center;"> NIS </th>
                                    <th style="text-align: center;"> NAMA </th>
                                    <th style="text-align: center;"> KELAS </th>
                                    <th style="text-align: center;"> SPP </th>
                                    <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                                    <th style="text-align: center;"> KET SPP </th>
                                    <th style="text-align: center;"> Tanggal DiUpdate </th>
                                    <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                            <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                        <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="previousPage">
                                        &laquo;
                                        Previous
                                    </button>
                                </form>

                            <?php endif; ?>

                            <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                                <?php if ($jumlahPagination == 1): ?>
                                    
                                <?php elseif ($halamanAktif == $i): ?>

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                        <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                            <?= $i; ?>
                                        </button>
                                    </form>

                                <?php else: ?>
                                    
                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="halamanKeFilterSPPWithDate" value="<?= $i; ?>">
                                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $_POST['isi_filter']; ?>">
                                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                                        <button name="toPageFilterSPPWithDate">
                                            <?= $i; ?>
                                        </button>
                                    </form>
                                <?php endif; ?>

                            <?php endfor; ?>

                            <?php if ($halamanAktif < $jumlahPagination): ?>
                                
                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="halamanLanjutFilterSPPWithDate" value="<?= $halamanAktif + 1; ?>">
                                    <input type="hidden" name="iniFilterSPPWithDate" value="<?= $_POST['isi_filter']; ?>">
                                    <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                                    <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                                    <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                                    <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                                    <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                                    <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                                    <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                                    <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                                    <button name="nextPageFilterSPPWithDate" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                                        next
                                        &raquo;
                                    </button>
                                </form>

                            <?php endif; ?>

                        </div>

                        <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>    

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="previousPage">
                                        &laquo;
                                        First Page
                                    </button>
                                </form>

                            <?php endif; ?>        

                            <?php if ($hitungDataFilterSPPDate <= 5): ?>

                            <?php else: ?>
                                
                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="halamanTerakhirFilterSPPWithDate" value="<?= $halamanAktif + 1; ?>">
                                    <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                                    <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                                    <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                                    <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                                    <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                                    <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                                    <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                                    <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                                    <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                                    <button name="lastPageFilterSPPWithDate">
                                        Last Page
                                        &raquo;
                                    </button>
                                </form>

                            <?php endif ?>

                        </div>

                        <br>
                        
                    <?php else: ?>

                        <?= "Nama : " . $_POST['_nmsiswa2'] . "<br> Filter : " . $_POST['isi_filter'] . "<br> Dari Tanggal : " . $dariTanggal . "<br> Sampai Tanggal : " . $sampaiTanggal. "<br>";?>

                        <?php  

                            // Data SPP
                            $namaMurid = $_POST['_nmsiswa2'];
                            $queryGetDataSPP = "
                            SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            SPP != 0
                            AND STAMP >= '$dariTanggal' AND STAMP < '$sampaiTanggal' 
                            AND NAMA LIKE '%$namaMurid%' ";
                            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
                            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);
                            $getDataArr          = mysqli_fetch_array($execQueryDataSPP);

                            // echo $hitungDataFilterSPP;exit;
                            // foreach ($execQueryDataSPP as $data) {
                            //     echo $data['NAMA'] . $data['pembayaran_bulan'] . $data['SPP'] . $data['SPP_txt'] . "<br>";
                            // }
                            // exit;
                            // Akhir Data SPP

                        ?>

                        <!-- SPP -->
                        <div style="overflow-x: auto;">
                                    
                            <table id="example1" class="table table-bordered">
                                <thead>
                                  <tr>
                                     <th style="text-align: center; width: 100px;"> ID </th>
                                     <th style="text-align: center;"> NIS </th>
                                     <th style="text-align: center;"> NAMA </th>
                                     <th style="text-align: center;"> KELAS </th>
                                     <th style="text-align: center;"> SPP </th>
                                     <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                                     <th style="text-align: center;"> KET SPP </th>
                                     <th style="text-align: center;"> Tanggal DiUpdate </th>
                                     <th style="text-align: center;"> DI INPUT OLEH </th>

                                  </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($execQueryDataSPP as $data) : ?>
                                        <tr>
                                            <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['kelas']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                        <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>
                            
                                <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                                    &laquo;
                                </a> -->

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="previousPage">
                                        &laquo;
                                        Previous
                                    </button>
                                </form>

                            <?php endif; ?>

                            <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                                <?php if ($jumlahPagination == 1): ?>
                                    
                                <?php elseif ($halamanAktif == $i): ?>
                                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                                        <?= $i; ?>
                                    </a> -->

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                        <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                            <?= $i; ?>
                                        </button>
                                    </form>

                                <?php else: ?>
                                    <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                                        <?= $i; ?>
                                    </a> -->
                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="halamanKe" value="<?= $i; ?>">
                                        <button name="toPage">
                                            <?= $i; ?>
                                        </button>
                                    </form>
                                <?php endif; ?>

                            <?php endfor; ?>

                            <?php if ($halamanAktif < $jumlahPagination): ?>
                                
                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="halamanLanjut" value="<?= $halamanAktif + 1; ?>">
                                    <button name="nextPage" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                                        next
                                        &raquo;
                                    </button>
                                </form>

                            <?php endif; ?>

                        </div>

                        <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>
                            
                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                    <button name="nextPage">
                                        &laquo;&laquo;
                                    </button>
                                </form>

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="previousPage">
                                        &laquo;
                                        First Page
                                    </button>
                                </form>
                            <?php endif; ?>      

                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                                <button name="nextLastPage">
                                    On Page
                                </button>
                            </form>  

                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                                <button name="nextLastPage">
                                    Last Page
                                    &raquo;
                                </button>
                            </form>

                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                <button name="nextPage">
                                    &raquo;&raquo;
                                </button>
                            </form>

                        </div>

                        <br>
                        
                    <?php endif ?>

                    <!-- Akhir Bagian SPP -->

                <?php endif; ?>
            
            <?php else: ?>

                <div style="overflow-x: auto;">
                            
                    <table id="example1" class="table table-bordered">
                        <thead>
                          <tr>
                             <th style="text-align: center; width: 100px;"> ID </th>
                             <th style="text-align: center;"> NIS </th>
                             <th style="text-align: center;"> DATE </th>
                             <th style="text-align: center;"> BULAN </th>
                             <th style="text-align: center;"> KELAS </th>
                             <th style="text-align: center;"> NAMA KELAS</th>
                             <th style="text-align: center;"> NAMA </th>
                             <th style="text-align: center;"> PANGGILAN </th>
                             <th style="text-align: center;"> TRANSAKSI </th>
                             <th style="text-align: center;"> SPP SET </th>
                             <th style="text-align: center;"> PANGKAL SET </th>
                             <th style="text-align: center;"> SPP  </th>
                             <th style="text-align: center;"> KET SPP </th>
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
                             <th style="text-align: center;"> STAMP </th>

                          </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($ambildata_perhalaman as $data) : ?>
                                <tr>
                                    <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['DATE']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['BULAN']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['NAMA_KELAS']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['PANGGILAN']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['SPP_SET']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['PANGKAL_SET']; ?> </td>
                                    <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>
                                    <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                    <td style="text-align: center;"> <?= rupiah($data['KEGIATAN']); ?> </td>
                                    <td style="text-align: center;"> <?= $data['KEGIATAN_txt']; ?> </td>
                                    <td style="text-align: center;"> <?= rupiah($data['BUKU']); ?> </td>
                                    <td style="text-align: center;"> <?= $data['BUKU_txt']; ?> </td>
                                    <td style="text-align: center;"> <?= rupiah($data['SERAGAM']); ?> </td>
                                    <td style="text-align: center;"> <?= $data['SERAGAM_txt']; ?> </td>
                                    <td style="text-align: center;"> <?= rupiah($data['REGISTRASI']); ?> </td>
                                    <td style="text-align: center;"> <?= $data['REGISTRASI_txt']; ?> </td>
                                    <td style="text-align: center;"> <?= rupiah($data['LAIN']); ?> </td>
                                    <td style="text-align: center;"> <?= $data['LAIN_txt']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['INPUTER']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['STAMP']; ?> </td>
                                </tr>
                            <?php endforeach; ?>

                            <!-- <tr>
                                <td style="text-align: center;"> 1 </td>
                                <td style="text-align: center;"><a style="cursor:pointer;"> NISWA </a> </td>
                                <td style="text-align: center;"> lorem </td>
                                <td style="text-align: center;"> ipsum </td>
                                <td style="text-align: center;"> test </td>
                                <td style="text-align: center;"> lorem ipsum </td>
                            </tr>

                            <tr>
                                <td style="text-align: center;"> 2 </td>
                                <td style="text-align: center;"><a style="cursor:pointer;"> GATHAN </a> </td>
                                <td style="text-align: center;"> Bekasi </td>
                                <td style="text-align: center;"> 16 Desember 2002 </td>
                                <td style="text-align: center;"> Trisakti </td>
                                <td style="text-align: center;"> English </td>
                            </tr> -->

                        </tbody>

                    </table>

                </div>

                <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                    <?php if ($halamanAktif > 1): ?>
                    
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                            &laquo;
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="previousPage">
                                &laquo;
                                Previous
                            </button>
                        </form>

                    <?php endif; ?>

                    <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                        <?php if ($jumlahPagination == 1): ?>
                            
                        <?php elseif ($halamanAktif == $i): ?>
                            <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                                <?= $i; ?>
                            </a> -->

                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                    <?= $i; ?>
                                </button>
                            </form>

                        <?php else: ?>
                            <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                                <?= $i; ?>
                            </a> -->
                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="halamanKe" value="<?= $i; ?>">
                                <button name="toPage">
                                    <?= $i; ?>
                                </button>
                            </form>
                        <?php endif; ?>

                    <?php endfor; ?>

                    <?php if ($halamanAktif < $jumlahPagination): ?>
                        
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanLanjut" value="<?= $halamanAktif + 1; ?>">
                            <button name="nextPage" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                                next
                                &raquo;
                            </button>
                        </form>

                    <?php endif; ?>

                </div>

                <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                    <?php if ($halamanAktif > 1): ?>

                        <?php if ($halamanAktif > 100): ?>
                            
                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                <input type="hidden" name="paginationSekarangKurang100" value="<?= $halamanAktif; ?>">
                                <button name="reductionPage100">
                                    &laquo;&laquo;
                                </button>
                            </form>

                        <?php else: ?>

                        <?php endif; ?>

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="firstPage">
                                &laquo;
                                First Page
                            </button>
                        </form>
                    <?php endif; ?>      

                    <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                    <button name="findGetPage" onclick="findOpenPage()">
                        On Page
                    </button>

                    <?php if ($halamanAktif == $jumlahPagination): ?>
                        
                    <?php else: ?>

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                            <button name="nextLastPage">
                                Last Page
                                &raquo;
                            </button>
                        </form>

                        <?php if ($showAddPage100 == "muncul" ): ?>

                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                <input type="hidden" name="paginationSekarangTambah100" value="<?= $halamanAktif; ?>">
                                <button name="addPage100">
                                    &raquo;&raquo;
                                </button>
                            </form>

                        <?php else: ?>


                        <?php endif ?>

                        

                    <?php endif ?>

                </div>

                <br>

            <?php endif; ?>

        <?php elseif(isset($_POST['nextPageJustFilterSPP'])): ?>

            <!-- SPP -->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>
                
                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                        &laquo;
                    </a> -->

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="previousPageJustFilterSPP">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                            <?= $i; ?>
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                            <?= $i; ?>
                        </a> -->
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPP" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                            <button name="toPageFilterSPP">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="nextPageJustFilterSPP" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanPertamaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="firstPageFilterSPP">
                            &laquo;
                            First Page
                        </button>
                    </form>

                <?php endif; ?>

                <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                <?php else: ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanTerakhirFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="lastPageFilterSPP">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                <?php endif ?>

            </div>

            <br>

        <?php elseif(isset($_POST['previousPageJustFilterSPP'])): ?>

            <!-- SPP -->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>
                
                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                        &laquo;
                    </a> -->

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="previousPageJustFilterSPP">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                            <?= $i; ?>
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                            <?= $i; ?>
                        </a> -->
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPP" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                            <button name="toPageFilterSPP">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="nextPageJustFilterSPP" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanPertamaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="firstPageFilterSPP">
                            &laquo;
                            First Page
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                <?php else: ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanTerakhirFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="lastPageFilterSPP">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                <?php endif ?>

            </div>

            <br>

        <?php elseif(isset($_POST['toPageFilterSPP'])): ?>

            <!-- SPP -->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>
                
                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                        &laquo;
                    </a> -->

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="previousPageJustFilterSPP">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                            <?= $i; ?>
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                            <?= $i; ?>
                        </a> -->
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPP" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                            <button name="toPageFilterSPP">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="nextPageJustFilterSPP" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="firstPageFilterSPP">
                            &laquo;
                            First Page
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                <?php else: ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanTerakhirFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="lastPageFilterSPP">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                <?php endif ?>

            </div>

            <br>

        <?php elseif(isset($_POST['firstPageFilterSPP'])): ?>

            <!-- SPP -->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>
                
                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                        &laquo;
                    </a> -->

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="previousPageJustFilterSPP">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                            <?= $i; ?>
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                            <?= $i; ?>
                        </a> -->
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPP" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                            <button name="toPageFilterSPP">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $_POST['isi_filter']; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="nextPageJustFilterSPP" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanPertamaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <button name="firstPageFilterSPP">
                            &laquo;
                            First Page
                        </button>
                    </form>
                <?php endif; ?>        

                <?php if ($hitungDataFilterSPP < 5): ?>
                <?php else: ?>
                    
                    <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                    <?php else: ?>
                        
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanTerakhirFilterSPP" value="<?= $halamanAktif + 1; ?>">
                            <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                            <button name="lastPageFilterSPP">
                                Last Page
                                &raquo;
                            </button>
                        </form>

                    <?php endif ?>

                <?php endif ?>

            </div>      

            <br>

        <?php elseif(isset($_POST['lastPageFilterSPP'])) : ?>

            <!-- SPP -->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>
                
                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                        &laquo;
                    </a> -->

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="previousPageJustFilterSPP">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                            <?= $i; ?>
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                            <?= $i; ?>
                        </a> -->
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPP" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                            <button name="toPageFilterSPP">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $_POST['isi_filter']; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <button name="nextPageJustFilterSPP" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanPertamaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="firstPageFilterSPP">
                            &laquo;
                            First Page
                        </button>
                    </form>
                <?php endif; ?>        

                <?php if ($hitungDataFilterSPP < 5): ?>
                <?php else: ?>
                    
                    <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                    <?php else: ?>
                        
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanTerakhirFilterSPP" value="<?= $halamanAktif + 1; ?>">
                            <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                            <button name="lastPageFilterSPP">
                                Last Page
                                &raquo;
                            </button>
                        </form>

                    <?php endif ?>

                <?php endif ?>

            </div>      

            <br>

        <?php elseif(isset($_POST['nextPageFilterSPPWithDate'])): ?>

            <!-- SPP With Date -->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPPWithDate" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="previousPageFilterSPPWithDate">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPPWithDate" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                            <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                            <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                            <button name="toPageFilterSPPWithDate">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPPWithDate" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="nextPageFilterSPPWithDate" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanPertamaFilterSPPWithDate" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="firstPageFilterSPPWithDate">
                            &laquo;
                            First Page
                        </button>
                    </form>

                <?php endif; ?>

                <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                <?php else: ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanTerakhirFilterSPPWithDate" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="lastPageFilterSPPWithDate">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                <?php endif ?>

            </div>

            <br>

        <?php elseif(isset($_POST['previousPageFilterSPPWithDate'])): ?>

            <!-- SPP with filter date-->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPPWithDate" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="previousPageFilterSPPWithDate">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                            <?= $i; ?>
                        </a> -->
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPPWithDate" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                            <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                            <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                            <button name="toPageFilterSPPWithDate">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPPWithDate" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="nextPageFilterSPPWithDate" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanPertamaFilterSPPWithDate" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="firstPageFilterSPPWithDate">
                            &laquo;
                            First Page
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                <?php else: ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanTerakhirFilterSPPWithDate" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="lastPageFilterSPPWithDate">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                <?php endif ?>

            </div>

            <br>

        <?php elseif(isset($_POST['firstPageFilterSPPWithDate'])): ?>

            <!-- SPP -->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPPWithDate" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="previousPageFilterSPPWithDate">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPPWithDate" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                            <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                            <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                            <button name="toPageFilterSPPWithDate">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPPWithDate" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="nextPageFilterSPPWithDate" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanPertamaFilterSPPWithDate" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="firstPageFilterSPPWithDate">
                            &laquo;
                            First Page
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($halamanAktif == $jumlahPagination): ?>
                
                <?php else: ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanTerakhirFilterSPPWithDate" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="lastPageFilterSPPWithDate">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                <?php endif ?>

            </div>      

            <br>

        <?php elseif(isset($_POST['lastPageFilterSPPWithDate'])): ?>

            <!-- SPP With Date -->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPPWithDate" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="previousPageFilterSPPWithDate">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPPWithDate" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                            <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                            <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                            <button name="toPageFilterSPPWithDate">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPPWithDate" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="nextPageFilterSPPWithDate" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanPertamaFilterSPPWithDate" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="firstPageFilterSPPWithDate">
                            &laquo;
                            First Page
                        </button>
                    </form>

                <?php endif; ?>

                <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                <?php else: ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanTerakhirFilterSPPWithDate" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="lastPageFilterSPPWithDate">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                <?php endif ?>

            </div>

            <br>

        <?php elseif(isset($_POST['toPageFilterSPPWithDate'])) : ?>

            <!-- SPP -->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>
                
                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                        &laquo;
                    </a> -->

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPPWithDate" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="previousPageFilterSPPWithDate">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                            <?= $i; ?>
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                            <?= $i; ?>
                        </a> -->
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPPWithDate" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                            <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                            <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                            <button name="toPageFilterSPPWithDate">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPPWithDate" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="nextPageFilterSPPWithDate" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="firstPageFilterSPPWithDate">
                            &laquo;
                            First Page
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                <?php else: ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanTerakhirFilterSPPWithDate" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPPWithDate" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPPWithDate" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPPWithDate" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPPWithDate" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPPWithDate" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPPWithDate" value="<?= $panggilan; ?>">
                        <input type="hidden" name="tanggalDariFormFilterSPPWithDate" value="<?= $tanggalDari; ?>">
                        <input type="hidden" name="tanggalSampaiFormFilterSPPWithDate" value="<?= $tanggalSampai; ?>">
                        <button name="lastPageFilterSPPWithDate">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                <?php endif ?>

            </div>

            <br>

        <?php else: ?>

            <div style="overflow-x: auto;">
                            
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                         <th style="text-align: center; width: 100px;"> ID </th>
                         <th style="text-align: center;"> NIS </th>
                         <th style="text-align: center;"> DATE </th>
                         <th style="text-align: center;"> BULAN </th>
                         <th style="text-align: center;"> KELAS </th>
                         <th style="text-align: center;"> NAMA KELAS</th>
                         <th style="text-align: center;"> NAMA </th>
                         <th style="text-align: center;"> PANGGILAN </th>
                         <th style="text-align: center;"> TRANSAKSI </th>
                         <th style="text-align: center;"> SPP SET </th>
                         <th style="text-align: center;"> PANGKAL SET </th>
                         <th style="text-align: center;"> SPP  </th>
                         <th style="text-align: center;"> KET SPP </th>
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
                         <th style="text-align: center;"> STAMP </th>

                      </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($ambildata_perhalaman as $data) : ?>
                            <tr>
                                <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                                <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                                <td style="text-align: center;"> <?= $data['DATE']; ?> </td>
                                <td style="text-align: center;"> <?= $data['BULAN']; ?> </td>
                                <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>
                                <td style="text-align: center;"> <?= $data['NAMA_KELAS']; ?> </td>
                                <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                                <td style="text-align: center;"> <?= $data['PANGGILAN']; ?> </td>
                                <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_SET']; ?> </td>
                                <td style="text-align: center;"> <?= $data['PANGKAL_SET']; ?> </td>
                                <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= rupiah($data['KEGIATAN']); ?> </td>
                                <td style="text-align: center;"> <?= $data['KEGIATAN_txt']; ?> </td>
                                <td style="text-align: center;"> <?= rupiah($data['BUKU']); ?> </td>
                                <td style="text-align: center;"> <?= $data['BUKU_txt']; ?> </td>
                                <td style="text-align: center;"> <?= rupiah($data['SERAGAM']); ?> </td>
                                <td style="text-align: center;"> <?= $data['SERAGAM_txt']; ?> </td>
                                <td style="text-align: center;"> <?= rupiah($data['REGISTRASI']); ?> </td>
                                <td style="text-align: center;"> <?= $data['REGISTRASI_txt']; ?> </td>
                                <td style="text-align: center;"> <?= rupiah($data['LAIN']); ?> </td>
                                <td style="text-align: center;"> <?= $data['LAIN_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['INPUTER']; ?> </td>
                                <td style="text-align: center;"> <?= $data['STAMP']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                        <!-- <tr>
                            <td style="text-align: center;"> 1 </td>
                            <td style="text-align: center;"><a style="cursor:pointer;"> NISWA </a> </td>
                            <td style="text-align: center;"> lorem </td>
                            <td style="text-align: center;"> ipsum </td>
                            <td style="text-align: center;"> test </td>
                            <td style="text-align: center;"> lorem ipsum </td>
                        </tr>

                        <tr>
                            <td style="text-align: center;"> 2 </td>
                            <td style="text-align: center;"><a style="cursor:pointer;"> GATHAN </a> </td>
                            <td style="text-align: center;"> Bekasi </td>
                            <td style="text-align: center;"> 16 Desember 2002 </td>
                            <td style="text-align: center;"> Trisakti </td>
                            <td style="text-align: center;"> English </td>
                        </tr> -->

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>
                
                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                        &laquo;
                    </a> -->

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                        <button name="previousPage">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                            <?= $i; ?>
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                            <?= $i; ?>
                        </a> -->
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKe" value="<?= $i; ?>">
                            <button name="toPage">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjut" value="<?= $halamanAktif + 1; ?>">
                        <button name="nextPage" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <?php if ($halamanAktif > 100): ?>
                        
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                            <input type="hidden" name="paginationSekarangKurang100" value="<?= $halamanAktif; ?>">
                            <button name="reductionPage100">
                                &laquo;&laquo;
                            </button>
                        </form>

                    <?php else: ?>

                    <?php endif; ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                        <button name="firstPage">
                            &laquo;
                            First Page
                        </button>
                    </form>
                <?php endif; ?>      

                <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                <button name="findGetPage" onclick="findOpenPage()">
                    On Page
                </button>

                <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                <?php else: ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                        <button name="nextLastPage">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                    <?php if ($showAddPage100 == "muncul" ): ?>

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                            <input type="hidden" name="paginationSekarangTambah100" value="<?= $halamanAktif; ?>">
                            <button name="addPage100">
                                &raquo;&raquo;
                            </button>
                        </form>

                    <?php else: ?>


                    <?php endif ?>

                    

                <?php endif ?>

            </div>

            <br>
        
        <?php endif; ?>

         <!-- Modal Cari Siswa -->
            <div id="findPage" class="modal"  data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-calendar"></i> Cari Halaman </h4>
                        </div>
                        <div class="modal-body"> 
                            <form action="checkpembayarandaninputdata" method="post">
                                <div class="box-body">
                                    <div class="row">

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label> Cari Halaman Ke Berapa : </label>
                                                <input type="text" class="form-control" id="cari_halaman" name="cari_halaman" placeholder="Wajib Di Tulis Angka">
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label style="color: white;"> Cari Halaman Ke Berapa : </label>
                                                <button name="findPageData" class="btn btn-success btn-sm">
                                                    Find Page
                                                </button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>    
            </div>
        <!-- Akhir Modal Cari Siswa -->

    <?php else: ?>

        <?php if (isset($_POST['filter_by'])): ?>
    
            <?php if ($_POST['isi_filter'] != 'kosong'): ?>
                
                <?php  

                    $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
                    $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

                ?>

                <!-- <?= "Nama : " . $_POST['_nmsiswa2'] . "<br> Filter : " . $_POST['isi_filter'] . "<br> Dari Tanggal : " . $dariTanggal . "<br> Sampai Tanggal : " . $sampaiTanggal; ?> -->

                <?php if ($_POST['isi_filter'] == 'SPP') : ?>

                    <?php if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") : ?>

                        <!-- <?php echo "Semua Data Muncul berdasarkan filter " . $_POST['isi_filter'] . " Atas nama " . $_POST['nama_siswa']; ?> -->

                        <?php  

                            // Data SPP
                            $namaMurid = $_POST['nama_siswa'];
                            $nis       = $_POST['nis_siswa'];
                            $queryGetDataSPP = "
                            SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            SPP != 0
                            AND NAMA LIKE '%$namaMurid%' ";
                            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
                            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);
                            // echo $hitungDataFilterSPP;
                            $getDataArr          = mysqli_fetch_array($execQueryDataSPP);

                            // echo $hitungDataFilterSPP;exit;
                            // foreach ($execQueryDataSPP as $data) {
                            //     echo $data['NAMA'] . $data['pembayaran_bulan'] . $data['SPP'] . $data['SPP_txt'] . "<br>";
                            // }
                            // exit;
                            // Akhir Data SPP

                        ?>

                        <?php if ($hitungDataFilterSPP == 0): ?>

                            <div style="overflow-x: auto;">
                            
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                      <tr>
                                         <th style="text-align: center; width: 100px;"> ID </th>
                                         <th style="text-align: center;"> NIS </th>
                                         <th style="text-align: center;"> DATE </th>
                                         <th style="text-align: center;"> BULAN </th>
                                         <th style="text-align: center;"> KELAS </th>
                                         <th style="text-align: center;"> NAMA </th>
                                         <th style="text-align: center;"> PANGGILAN </th>
                                         <th style="text-align: center;"> TRANSAKSI </th>
                                         <th style="text-align: center;"> SPP SET </th>
                                         <th style="text-align: center;"> PANGKAL SET </th>
                                         <th style="text-align: center;"> SPP  </th>
                                         <th style="text-align: center;"> KET SPP </th>
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
                                         <th style="text-align: center;"> STAMP </th>

                                      </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($ambildata_perhalaman as $data) : ?>
                                            <tr>
                                                <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                                                <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                                                <td style="text-align: center;"> <?= $data['DATE']; ?> </td>
                                                <td style="text-align: center;"> <?= $data['BULAN']; ?> </td>
                                                <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>
                                                <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                                                <td style="text-align: center;"> <?= $data['PANGGILAN']; ?> </td>
                                                <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>
                                                <td style="text-align: center;"> <?= $data['SPP_SET']; ?> </td>
                                                <td style="text-align: center;"> <?= $data['PANGKAL_SET']; ?> </td>
                                                <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>
                                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                                <td style="text-align: center;"> <?= rupiah($data['KEGIATAN']); ?> </td>
                                                <td style="text-align: center;"> <?= $data['KEGIATAN_txt']; ?> </td>
                                                <td style="text-align: center;"> <?= rupiah($data['BUKU']); ?> </td>
                                                <td style="text-align: center;"> <?= $data['BUKU_txt']; ?> </td>
                                                <td style="text-align: center;"> <?= rupiah($data['SERAGAM']); ?> </td>
                                                <td style="text-align: center;"> <?= $data['SERAGAM_txt']; ?> </td>
                                                <td style="text-align: center;"> <?= rupiah($data['REGISTRASI']); ?> </td>
                                                <td style="text-align: center;"> <?= $data['REGISTRASI_txt']; ?> </td>
                                                <td style="text-align: center;"> <?= rupiah($data['LAIN']); ?> </td>
                                                <td style="text-align: center;"> <?= $data['LAIN_txt']; ?> </td>
                                                <td style="text-align: center;"> <?= $data['INPUTER']; ?> </td>
                                                <td style="text-align: center;"> <?= $data['STAMP']; ?> </td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <!-- <tr>
                                            <td style="text-align: center;"> 1 </td>
                                            <td style="text-align: center;"><a style="cursor:pointer;"> NISWA </a> </td>
                                            <td style="text-align: center;"> lorem </td>
                                            <td style="text-align: center;"> ipsum </td>
                                            <td style="text-align: center;"> test </td>
                                            <td style="text-align: center;"> lorem ipsum </td>
                                        </tr>

                                        <tr>
                                            <td style="text-align: center;"> 2 </td>
                                            <td style="text-align: center;"><a style="cursor:pointer;"> GATHAN </a> </td>
                                            <td style="text-align: center;"> Bekasi </td>
                                            <td style="text-align: center;"> 16 Desember 2002 </td>
                                            <td style="text-align: center;"> Trisakti </td>
                                            <td style="text-align: center;"> English </td>
                                        </tr> -->

                                    </tbody>

                                </table>

                            </div>

                            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                                <?php if ($halamanAktif > 1): ?>
                                
                                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                                        &laquo;
                                    </a> -->

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                        <button name="previousPage">
                                            &laquo;
                                            Previous
                                        </button>
                                    </form>

                                <?php endif; ?>

                                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                                    <?php if ($jumlahPagination == 1): ?>
                                        
                                    <?php elseif ($halamanAktif == $i): ?>
                                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                                            <?= $i; ?>
                                        </a> -->

                                        <form action="checkpembayarandaninputdata" method="post">
                                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                                <?= $i; ?>
                                            </button>
                                        </form>

                                    <?php else: ?>
                                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                                            <?= $i; ?>
                                        </a> -->
                                        <form action="checkpembayarandaninputdata" method="post">
                                            <input type="hidden" name="halamanKe" value="<?= $i; ?>">
                                            <button name="toPage">
                                                <?= $i; ?>
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                <?php endfor; ?>

                                <?php if ($halamanAktif < $jumlahPagination): ?>
                                    
                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="halamanLanjut" value="<?= $halamanAktif + 1; ?>">
                                        <button name="nextPage" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                                            next
                                            &raquo;
                                        </button>
                                    </form>

                                <?php endif; ?>

                            </div>

                            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                                <?php if ($halamanAktif > 1): ?>

                                    <?php if ($halamanAktif > 100): ?>
                                        
                                        <form action="checkpembayarandaninputdata" method="post">
                                            <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                            <input type="hidden" name="paginationSekarangKurang100" value="<?= $halamanAktif; ?>">
                                            <button name="reductionPage100">
                                                &laquo;&laquo;
                                            </button>
                                        </form>

                                    <?php else: ?>

                                    <?php endif; ?>

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                        <button name="firstPage">
                                            &laquo;
                                            First Page
                                        </button>
                                    </form>
                                <?php endif; ?>      

                                <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                                <button name="findGetPage" onclick="findOpenPage()">
                                    On Page
                                </button>

                                <?php if ($halamanAktif == $jumlahPagination): ?>
                                    
                                <?php else: ?>

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                                        <button name="nextLastPage">
                                            Last Page
                                            &raquo;
                                        </button>
                                    </form>

                                    <?php if ($showAddPage100 == "muncul" ): ?>

                                        <form action="checkpembayarandaninputdata" method="post">
                                            <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                            <input type="hidden" name="paginationSekarangTambah100" value="<?= $halamanAktif; ?>">
                                            <button name="addPage100">
                                                &raquo;&raquo;
                                            </button>
                                        </form>

                                    <?php else: ?>


                                    <?php endif ?>

                                    

                                <?php endif ?>

                            </div>

                            <br>

                        <?php else: ?>

                            <!-- SPP -->
                            <div style="overflow-x: auto;">
                                        
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th style="text-align: center; width: 100px;"> ID </th>
                                        <th style="text-align: center;"> NIS </th>
                                        <th style="text-align: center;"> NAMA </th>
                                        <th style="text-align: center;"> KELAS </th>
                                        <th style="text-align: center;"> SPP </th>
                                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                                        <th style="text-align: center;"> KET SPP </th>
                                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>

                                </table>

                            </div>

                            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                                <?php if ($halamanAktif > 1): ?>
                                
                                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                                        &laquo;
                                    </a> -->

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                        <button name="previousPage">
                                            &laquo;
                                            Previous
                                        </button>
                                    </form>

                                <?php endif; ?>

                                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                                    <?php if ($jumlahPagination == 1): ?>
                                        
                                    <?php elseif ($halamanAktif == $i): ?>
                                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                                            <?= $i; ?>
                                        </a> -->

                                        <form action="checkpembayarandaninputdata" method="post">
                                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                                <?= $i; ?>
                                            </button>
                                        </form>

                                    <?php else: ?>
                                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                                            <?= $i; ?>
                                        </a> -->
                                        <form action="checkpembayarandaninputdata" method="post">
                                            <input type="hidden" name="halamanKeFilterSPP" value="<?= $i; ?>">
                                            <input type="hidden" name="iniFilterSPP" value="<?= $_POST['isi_filter']; ?>">
                                            <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                                            <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                                            <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                                            <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                                            <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                                            <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                                            <button name="toPageFilterSPP">
                                                <?= $i; ?>
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                <?php endfor; ?>

                                <?php if ($halamanAktif < $jumlahPagination): ?>
                                    
                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="halamanLanjutFilterSPP" value="<?= $halamanAktif + 1; ?>">
                                        <input type="hidden" name="iniFilterSPP" value="<?= $_POST['isi_filter']; ?>">
                                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                                        <button name="nextPageJustFilterSPP" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                                            next
                                            &raquo;
                                        </button>
                                    </form>

                                <?php endif; ?>

                            </div>

                            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                                <?php if ($halamanAktif > 1): ?>

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                        <button name="firstPageFilterSPP">
                                            &laquo;
                                            First Page
                                        </button>
                                    </form>
                                <?php endif; ?>        

                                <?php if ($hitungDataFilterSPP < 5): ?>
                                <?php else: ?>
                                    
                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="halamanTerakhirFilterSPP" value="<?= $halamanAktif + 1; ?>">
                                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                                        <button name="lastPageFilterSPP">
                                            Last Page
                                            &raquo;
                                        </button>
                                    </form>

                                <?php endif ?>

                            </div>

                            <br>

                        <?php endif ?>

                    <?php elseif($dariTanggal != ' 00:00:00' && $sampaiTanggal == ' 23:59:59'): ?>

                        <?php echo "<script> alert('Filter Sampai Tanggal Juga Harus di isi') </script>"; ?>

                        <!-- SPP -->
                        <div style="overflow-x: auto;">
                            
                            <table id="example1" class="table table-bordered">
                                <thead>
                                  <tr>
                                     <th style="text-align: center; width: 100px;"> ID </th>
                                     <th style="text-align: center;"> NIS </th>
                                     <th style="text-align: center;"> DATE </th>
                                     <th style="text-align: center;"> BULAN </th>
                                     <th style="text-align: center;"> KELAS </th>
                                     <th style="text-align: center;"> NAMA KELAS</th>
                                     <th style="text-align: center;"> NAMA </th>
                                     <th style="text-align: center;"> PANGGILAN </th>
                                     <th style="text-align: center;"> TRANSAKSI </th>
                                     <th style="text-align: center;"> SPP SET </th>
                                     <th style="text-align: center;"> PANGKAL SET </th>
                                     <th style="text-align: center;"> SPP  </th>
                                     <th style="text-align: center;"> KET SPP </th>
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
                                     <th style="text-align: center;"> STAMP </th>

                                  </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($ambildata_perhalaman as $data) : ?>
                                        <tr>
                                            <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['DATE']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['BULAN']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NAMA_KELAS']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['PANGGILAN']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['SPP_SET']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['PANGKAL_SET']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['KEGIATAN']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['KEGIATAN_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['BUKU']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['BUKU_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['SERAGAM']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['SERAGAM_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['REGISTRASI']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['REGISTRASI_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['LAIN']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['LAIN_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['INPUTER']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['STAMP']; ?> </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <!-- <tr>
                                        <td style="text-align: center;"> 1 </td>
                                        <td style="text-align: center;"><a style="cursor:pointer;"> NISWA </a> </td>
                                        <td style="text-align: center;"> lorem </td>
                                        <td style="text-align: center;"> ipsum </td>
                                        <td style="text-align: center;"> test </td>
                                        <td style="text-align: center;"> lorem ipsum </td>
                                    </tr>

                                    <tr>
                                        <td style="text-align: center;"> 2 </td>
                                        <td style="text-align: center;"><a style="cursor:pointer;"> GATHAN </a> </td>
                                        <td style="text-align: center;"> Bekasi </td>
                                        <td style="text-align: center;"> 16 Desember 2002 </td>
                                        <td style="text-align: center;"> Trisakti </td>
                                        <td style="text-align: center;"> English </td>
                                    </tr> -->

                                </tbody>

                            </table>

                        </div>

                        <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>
                            
                                <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                                    &laquo;
                                </a> -->

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="previousPage">
                                        &laquo;
                                        Previous
                                    </button>
                                </form>

                            <?php endif; ?>

                            <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                                <?php if ($jumlahPagination == 1): ?>
                                    
                                <?php elseif ($halamanAktif == $i): ?>
                                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                                        <?= $i; ?>
                                    </a> -->

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                        <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                            <?= $i; ?>
                                        </button>
                                    </form>

                                <?php else: ?>
                                    <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                                        <?= $i; ?>
                                    </a> -->
                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="halamanKe" value="<?= $i; ?>">
                                        <button name="toPage">
                                            <?= $i; ?>
                                        </button>
                                    </form>
                                <?php endif; ?>

                            <?php endfor; ?>

                            <?php if ($halamanAktif < $jumlahPagination): ?>
                                
                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="halamanLanjut" value="<?= $halamanAktif + 1; ?>">
                                    <button name="nextPage" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                                        next
                                        &raquo;
                                    </button>
                                </form>

                            <?php endif; ?>

                        </div>

                        <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>
                            
                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                    <button name="nextPage">
                                        &laquo;&laquo;
                                    </button>
                                </form>

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="previousPage">
                                        &laquo;
                                        First Page
                                    </button>
                                </form>
                            <?php endif; ?>      

                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                                <button name="nextLastPage">
                                    On Page
                                </button>
                            </form>  

                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                                <button name="nextLastPage">
                                    Last Page
                                    &raquo;
                                </button>
                            </form>

                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                <button name="nextPage">
                                    &raquo;&raquo;
                                </button>
                            </form>

                        </div>

                        <br>

                    <?php elseif($dariTanggal > $sampaiTanggal): ?>

                        <?php echo "Filter Tanggal dari tidak boleh lebih besar dari filter tanggal sampai " . $dariTanggal . " " . $sampaiTanggal; ?>

                    <!-- Menampilkan Data SPP sesuai filter tanggal dari dan filter sampai tanggal  -->

                    <?php elseif($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59"): ?>

                        <div style="overflow-x: auto;">
                            
                            <table id="example1" class="table table-bordered">
                                <thead>
                                  <tr>
                                     <th style="text-align: center; width: 100px;"> ID </th>
                                     <th style="text-align: center;"> NIS </th>
                                     <th style="text-align: center;"> DATE </th>
                                     <th style="text-align: center;"> BULAN </th>
                                     <th style="text-align: center;"> KELAS </th>
                                     <th style="text-align: center;"> NAMA KELAS</th>
                                     <th style="text-align: center;"> NAMA </th>
                                     <th style="text-align: center;"> PANGGILAN </th>
                                     <th style="text-align: center;"> TRANSAKSI </th>
                                     <th style="text-align: center;"> SPP SET </th>
                                     <th style="text-align: center;"> PANGKAL SET </th>
                                     <th style="text-align: center;"> SPP  </th>
                                     <th style="text-align: center;"> KET SPP </th>
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
                                     <th style="text-align: center;"> STAMP </th>

                                  </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($ambildata_perhalaman as $data) : ?>
                                        <tr>
                                            <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['DATE']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['BULAN']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NAMA_KELAS']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['PANGGILAN']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['SPP_SET']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['PANGKAL_SET']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['KEGIATAN']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['KEGIATAN_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['BUKU']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['BUKU_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['SERAGAM']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['SERAGAM_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['REGISTRASI']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['REGISTRASI_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['LAIN']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['LAIN_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['INPUTER']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['STAMP']; ?> </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                        <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>
                            
                                <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                                    &laquo;
                                </a> -->

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="previousPage">
                                        &laquo;
                                        Previous
                                    </button>
                                </form>

                            <?php endif; ?>

                            <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                                <?php if ($jumlahPagination == 1): ?>
                                    
                                <?php elseif ($halamanAktif == $i): ?>

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                        <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                            <?= $i; ?>
                                        </button>
                                    </form>

                                <?php else: ?>

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="halamanKe" value="<?= $i; ?>">
                                        <button name="toPage">
                                            <?= $i; ?>
                                        </button>
                                    </form>
                                <?php endif; ?>

                            <?php endfor; ?>

                            <?php if ($halamanAktif < $jumlahPagination): ?>
                                
                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="halamanLanjut" value="<?= $halamanAktif + 1; ?>">
                                    <button name="nextPage" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                                        next
                                        &raquo;
                                    </button>
                                </form>

                            <?php endif; ?>

                        </div>

                        <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>

                                <?php if ($halamanAktif > 100): ?>
                                    
                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                        <input type="hidden" name="paginationSekarangKurang100" value="<?= $halamanAktif; ?>">
                                        <button name="reductionPage100">
                                            &laquo;&laquo;
                                        </button>
                                    </form>

                                <?php else: ?>

                                <?php endif; ?>

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="firstPage">
                                        &laquo;
                                        First Page
                                    </button>
                                </form>
                            <?php endif; ?>      

                            <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                            <button name="findGetPage" onclick="findOpenPage()">
                                On Page
                            </button>

                            <?php if ($halamanAktif == $jumlahPagination): ?>
                                
                            <?php else: ?>

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                                    <button name="nextLastPage">
                                        Last Page
                                        &raquo;
                                    </button>
                                </form>

                                <?php if ($showAddPage100 == "muncul" ): ?>

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                        <input type="hidden" name="paginationSekarangTambah100" value="<?= $halamanAktif; ?>">
                                        <button name="addPage100">
                                            &raquo;&raquo;
                                        </button>
                                    </form>

                                <?php else: ?>


                                <?php endif ?>

                                

                            <?php endif ?>

                        </div>

                        <br>

                    <?php else: ?>

                        <?= "Nama : " . $_POST['_nmsiswa2'] . "<br> Filter : " . $_POST['isi_filter'] . "<br> Dari Tanggal : " . $dariTanggal . "<br> Sampai Tanggal : " . $sampaiTanggal. "<br>";?>

                        <?php  

                            // Data SPP
                            $namaMurid = $_POST['_nmsiswa2'];
                            $queryGetDataSPP = "
                            SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            SPP != 0
                            AND STAMP >= '$dariTanggal' AND STAMP < '$sampaiTanggal' 
                            AND NAMA LIKE '%$namaMurid%' ";
                            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
                            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);
                            $getDataArr          = mysqli_fetch_array($execQueryDataSPP);

                            // echo $hitungDataFilterSPP;exit;
                            // foreach ($execQueryDataSPP as $data) {
                            //     echo $data['NAMA'] . $data['pembayaran_bulan'] . $data['SPP'] . $data['SPP_txt'] . "<br>";
                            // }
                            // exit;
                            // Akhir Data SPP

                        ?>

                        <!-- SPP -->
                        <div style="overflow-x: auto;">
                                    
                            <table id="example1" class="table table-bordered">
                                <thead>
                                  <tr>
                                     <th style="text-align: center; width: 100px;"> ID </th>
                                     <th style="text-align: center;"> NIS </th>
                                     <th style="text-align: center;"> NAMA </th>
                                     <th style="text-align: center;"> KELAS </th>
                                     <th style="text-align: center;"> SPP </th>
                                     <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                                     <th style="text-align: center;"> KET SPP </th>
                                     <th style="text-align: center;"> Tanggal DiUpdate </th>
                                     <th style="text-align: center;"> DI INPUT OLEH </th>

                                  </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($execQueryDataSPP as $data) : ?>
                                        <tr>
                                            <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['kelas']; ?> </td>
                                            <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>
                                            <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                            <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                        <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>
                            
                                <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                                    &laquo;
                                </a> -->

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="previousPage">
                                        &laquo;
                                        Previous
                                    </button>
                                </form>

                            <?php endif; ?>

                            <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                                <?php if ($jumlahPagination == 1): ?>
                                    
                                <?php elseif ($halamanAktif == $i): ?>
                                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                                        <?= $i; ?>
                                    </a> -->

                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                        <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                            <?= $i; ?>
                                        </button>
                                    </form>

                                <?php else: ?>
                                    <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                                        <?= $i; ?>
                                    </a> -->
                                    <form action="checkpembayarandaninputdata" method="post">
                                        <input type="hidden" name="halamanKe" value="<?= $i; ?>">
                                        <button name="toPage">
                                            <?= $i; ?>
                                        </button>
                                    </form>
                                <?php endif; ?>

                            <?php endfor; ?>

                            <?php if ($halamanAktif < $jumlahPagination): ?>
                                
                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="halamanLanjut" value="<?= $halamanAktif + 1; ?>">
                                    <button name="nextPage" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                                        next
                                        &raquo;
                                    </button>
                                </form>

                            <?php endif; ?>

                        </div>

                        <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                            <?php if ($halamanAktif > 1): ?>
                            
                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                    <button name="nextPage">
                                        &laquo;&laquo;
                                    </button>
                                </form>

                                <form action="checkpembayarandaninputdata" method="post">
                                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                    <button name="previousPage">
                                        &laquo;
                                        First Page
                                    </button>
                                </form>
                            <?php endif; ?>      

                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                                <button name="nextLastPage">
                                    On Page
                                </button>
                            </form>  

                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                                <button name="nextLastPage">
                                    Last Page
                                    &raquo;
                                </button>
                            </form>

                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                <button name="nextPage">
                                    &raquo;&raquo;
                                </button>
                            </form>

                        </div>

                        <br>
                        
                    <?php endif ?>

                    <!-- Akhir Bagian SPP -->

                <?php endif; ?>
            
            <?php else: ?>

                <div style="overflow-x: auto;">
                            
                    <table id="example1" class="table table-bordered">
                        <thead>
                          <tr>
                             <th style="text-align: center; width: 100px;"> ID </th>
                             <th style="text-align: center;"> NIS </th>
                             <th style="text-align: center;"> DATE </th>
                             <th style="text-align: center;"> BULAN </th>
                             <th style="text-align: center;"> KELAS </th>
                             <th style="text-align: center;"> NAMA </th>
                             <th style="text-align: center;"> PANGGILAN </th>
                             <th style="text-align: center;"> TRANSAKSI </th>
                             <th style="text-align: center;"> SPP SET </th>
                             <th style="text-align: center;"> PANGKAL SET </th>
                             <th style="text-align: center;"> SPP  </th>
                             <th style="text-align: center;"> KET SPP </th>
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
                             <th style="text-align: center;"> STAMP </th>

                          </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($ambildata_perhalaman as $data) : ?>
                                <tr>
                                    <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['DATE']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['BULAN']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['PANGGILAN']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['SPP_SET']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['PANGKAL_SET']; ?> </td>
                                    <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>
                                    <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                    <td style="text-align: center;"> <?= rupiah($data['KEGIATAN']); ?> </td>
                                    <td style="text-align: center;"> <?= $data['KEGIATAN_txt']; ?> </td>
                                    <td style="text-align: center;"> <?= rupiah($data['BUKU']); ?> </td>
                                    <td style="text-align: center;"> <?= $data['BUKU_txt']; ?> </td>
                                    <td style="text-align: center;"> <?= rupiah($data['SERAGAM']); ?> </td>
                                    <td style="text-align: center;"> <?= $data['SERAGAM_txt']; ?> </td>
                                    <td style="text-align: center;"> <?= rupiah($data['REGISTRASI']); ?> </td>
                                    <td style="text-align: center;"> <?= $data['REGISTRASI_txt']; ?> </td>
                                    <td style="text-align: center;"> <?= rupiah($data['LAIN']); ?> </td>
                                    <td style="text-align: center;"> <?= $data['LAIN_txt']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['INPUTER']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['STAMP']; ?> </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

                <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                    <?php if ($halamanAktif > 1): ?>
                    
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                            &laquo;
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="previousPage">
                                &laquo;
                                Previous
                            </button>
                        </form>

                    <?php endif; ?>

                    <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                        <?php if ($jumlahPagination == 1): ?>
                            
                        <?php elseif ($halamanAktif == $i): ?>
                            <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                                <?= $i; ?>
                            </a> -->

                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                    <?= $i; ?>
                                </button>
                            </form>

                        <?php else: ?>
                            <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                                <?= $i; ?>
                            </a> -->
                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="halamanKe" value="<?= $i; ?>">
                                <button name="toPage">
                                    <?= $i; ?>
                                </button>
                            </form>
                        <?php endif; ?>

                    <?php endfor; ?>

                    <?php if ($halamanAktif < $jumlahPagination): ?>
                        
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanLanjut" value="<?= $halamanAktif + 1; ?>">
                            <button name="nextPage" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                                next
                                &raquo;
                            </button>
                        </form>

                    <?php endif; ?>

                </div>

                <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                    <?php if ($halamanAktif > 1): ?>

                        <?php if ($halamanAktif > 100): ?>
                            
                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                <input type="hidden" name="paginationSekarangKurang100" value="<?= $halamanAktif; ?>">
                                <button name="reductionPage100">
                                    &laquo;&laquo;
                                </button>
                            </form>

                        <?php else: ?>

                        <?php endif; ?>

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="firstPage">
                                &laquo;
                                First Page
                            </button>
                        </form>
                    <?php endif; ?>      

                    <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                    <button name="findGetPage" onclick="findOpenPage()">
                        On Page
                    </button>

                    <?php if ($halamanAktif == $jumlahPagination): ?>
                        
                    <?php else: ?>

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                            <button name="nextLastPage">
                                Last Page
                                &raquo;
                            </button>
                        </form>

                        <?php if ($showAddPage100 == "muncul" ): ?>

                            <form action="checkpembayarandaninputdata" method="post">
                                <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                                <input type="hidden" name="paginationSekarangTambah100" value="<?= $halamanAktif; ?>">
                                <button name="addPage100">
                                    &raquo;&raquo;
                                </button>
                            </form>

                        <?php else: ?>


                        <?php endif ?>

                        

                    <?php endif ?>

                </div>

                <br>

            <?php endif; ?>

        <?php elseif(isset($_POST['nextPageJustFilterSPP'])): ?>

            <!-- SPP -->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>
                
                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                        &laquo;
                    </a> -->

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="previousPageJustFilterSPP">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                            <?= $i; ?>
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                            <?= $i; ?>
                        </a> -->
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPP" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                            <button name="toPageFilterSPP">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="nextPageJustFilterSPP" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanPertamaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="firstPageFilterSPP">
                            &laquo;
                            First Page
                        </button>
                    </form>

                <?php endif; ?>

                <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                <?php else: ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanTerakhirFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="lastPageFilterSPP">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                <?php endif ?>

            </div>

            <br>

        <?php elseif(isset($_POST['previousPageJustFilterSPP'])): ?>

            <!-- SPP -->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>
                
                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                        &laquo;
                    </a> -->

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="previousPageJustFilterSPP">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                            <?= $i; ?>
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                            <?= $i; ?>
                        </a> -->
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPP" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                            <button name="toPageFilterSPP">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="nextPageJustFilterSPP" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanPertamaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="firstPageFilterSPP">
                            &laquo;
                            First Page
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                <?php else: ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanTerakhirFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="lastPageFilterSPP">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                <?php endif ?>

            </div>

            <br>

        <?php elseif(isset($_POST['toPageFilterSPP'])): ?>

            <!-- SPP -->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>
                
                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                        &laquo;
                    </a> -->

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="previousPageJustFilterSPP">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                            <?= $i; ?>
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                            <?= $i; ?>
                        </a> -->
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPP" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                            <button name="toPageFilterSPP">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="nextPageJustFilterSPP" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="firstPageFilterSPP">
                            &laquo;
                            First Page
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                <?php else: ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanTerakhirFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="lastPageFilterSPP">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                <?php endif ?>

            </div>

            <br>

        <?php elseif(isset($_POST['firstPageFilterSPP'])): ?>

            <?php echo "First Page " . $halamanAktif . $hitungDataFilterSPP; ?>
            <!-- SPP -->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>
                
                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                        &laquo;
                    </a> -->

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="previousPageJustFilterSPP">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                            <?= $i; ?>
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                            <?= $i; ?>
                        </a> -->
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPP" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                            <button name="toPageFilterSPP">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $_POST['isi_filter']; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="nextPageJustFilterSPP" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanPertamaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <button name="firstPageFilterSPP">
                            &laquo;
                            First Page
                        </button>
                    </form>
                <?php endif; ?>
                    
                <?php if ($halamanAktif == $jumlahPagination): ?>
                
                <?php else: ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanTerakhirFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="lastPageFilterSPP">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                <?php endif ?>

            </div>      

            <br>

        <?php elseif(isset($_POST['lastPageFilterSPP'])) : ?>

            <!-- SPP -->
            <div style="overflow-x: auto;">
                        
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 100px;"> ID </th>
                        <th style="text-align: center;"> NIS </th>
                        <th style="text-align: center;"> NAMA </th>
                        <th style="text-align: center;"> KELAS </th>
                        <th style="text-align: center;"> SPP </th>
                        <th style="text-align: center;"> PEMBAYARAN BULAN </th>
                        <th style="text-align: center;"> KET SPP </th>
                        <th style="text-align: center;"> Tanggal DiUpdate </th>
                        <th style="text-align: center;"> DI INPUT OLEH </th>

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
                                <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['tanggal_diupdate']; ?> </td>
                                <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>
                
                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                        &laquo;
                    </a> -->

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanSebelumnyaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="previousPageJustFilterSPP">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                            <?= $i; ?>
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                            <?= $i; ?>
                        </a> -->
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKeFilterSPP" value="<?= $i; ?>">
                            <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                            <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                            <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                            <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                            <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                            <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                            <button name="toPageFilterSPP">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjutFilterSPP" value="<?= $halamanAktif + 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $_POST['isi_filter']; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <button name="nextPageJustFilterSPP" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanPertamaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                        <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                        <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                        <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                        <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                        <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                        <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                        <button name="firstPageFilterSPP">
                            &laquo;
                            First Page
                        </button>
                    </form>
                <?php endif; ?>        

                <?php if ($hitungDataFilterSPP < 5): ?>
                <?php else: ?>
                    
                    <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                    <?php else: ?>
                        
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanTerakhirFilterSPP" value="<?= $halamanAktif + 1; ?>">
                            <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                            <button name="lastPageFilterSPP">
                                Last Page
                                &raquo;
                            </button>
                        </form>

                    <?php endif ?>

                <?php endif ?>

            </div>      

            <br>

        <?php else: ?>

            <div style="overflow-x: auto;">
                            
                <table id="example1" class="table table-bordered">
                    <thead>
                      <tr>
                         <th style="text-align: center; width: 100px;"> ID </th>
                         <th style="text-align: center;"> NIS </th>
                         <th style="text-align: center;"> DATE </th>
                         <th style="text-align: center;"> BULAN </th>
                         <th style="text-align: center;"> KELAS </th>
                         <th style="text-align: center;"> NAMA </th>
                         <th style="text-align: center;"> PANGGILAN </th>
                         <th style="text-align: center;"> TRANSAKSI </th>
                         <th style="text-align: center;"> SPP SET </th>
                         <th style="text-align: center;"> PANGKAL SET </th>
                         <th style="text-align: center;"> SPP  </th>
                         <th style="text-align: center;"> KET SPP </th>
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
                         <th style="text-align: center;"> STAMP </th>

                      </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($ambildata_perhalaman as $data) : ?>
                            <tr>
                                <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                                <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                                <td style="text-align: center;"> <?= $data['DATE']; ?> </td>
                                <td style="text-align: center;"> <?= $data['BULAN']; ?> </td>
                                <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>
                                <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                                <td style="text-align: center;"> <?= $data['PANGGILAN']; ?> </td>
                                <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_SET']; ?> </td>
                                <td style="text-align: center;"> <?= $data['PANGKAL_SET']; ?> </td>
                                <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>
                                <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                                <td style="text-align: center;"> <?= rupiah($data['KEGIATAN']); ?> </td>
                                <td style="text-align: center;"> <?= $data['KEGIATAN_txt']; ?> </td>
                                <td style="text-align: center;"> <?= rupiah($data['BUKU']); ?> </td>
                                <td style="text-align: center;"> <?= $data['BUKU_txt']; ?> </td>
                                <td style="text-align: center;"> <?= rupiah($data['SERAGAM']); ?> </td>
                                <td style="text-align: center;"> <?= $data['SERAGAM_txt']; ?> </td>
                                <td style="text-align: center;"> <?= rupiah($data['REGISTRASI']); ?> </td>
                                <td style="text-align: center;"> <?= $data['REGISTRASI_txt']; ?> </td>
                                <td style="text-align: center;"> <?= rupiah($data['LAIN']); ?> </td>
                                <td style="text-align: center;"> <?= $data['LAIN_txt']; ?> </td>
                                <td style="text-align: center;"> <?= $data['INPUTER']; ?> </td>
                                <td style="text-align: center;"> <?= $data['STAMP']; ?> </td>
                            </tr>
                        <?php endforeach; ?>

                        <!-- <tr>
                            <td style="text-align: center;"> 1 </td>
                            <td style="text-align: center;"><a style="cursor:pointer;"> NISWA </a> </td>
                            <td style="text-align: center;"> lorem </td>
                            <td style="text-align: center;"> ipsum </td>
                            <td style="text-align: center;"> test </td>
                            <td style="text-align: center;"> lorem ipsum </td>
                        </tr>

                        <tr>
                            <td style="text-align: center;"> 2 </td>
                            <td style="text-align: center;"><a style="cursor:pointer;"> GATHAN </a> </td>
                            <td style="text-align: center;"> Bekasi </td>
                            <td style="text-align: center;"> 16 Desember 2002 </td>
                            <td style="text-align: center;"> Trisakti </td>
                            <td style="text-align: center;"> English </td>
                        </tr> -->

                    </tbody>

                </table>

            </div>

            <div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>
                
                    <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>">
                        &laquo;
                    </a> -->

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                        <button name="previousPage">
                            &laquo;
                            Previous
                        </button>
                    </form>

                <?php endif; ?>

                <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

                    <?php if ($jumlahPagination == 1): ?>
                        
                    <?php elseif ($halamanAktif == $i): ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?nextPage=<?= $halamanAktif - 1; ?>&page=<?= $i; ?>" style="color: red; font-weight: bold; font-size: 19px;">
                            <?= $i; ?>
                        </a> -->

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                            <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                                <?= $i; ?>
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- <a href="check_pembayaran_dan_inputdata.php?page=<?= $i; ?>" id="nextsPage" data-next="<?= $i; ?>">
                            <?= $i; ?>
                        </a> -->
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="halamanKe" value="<?= $i; ?>">
                            <button name="toPage">
                                <?= $i; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahPagination): ?>
                    
                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="halamanLanjut" value="<?= $halamanAktif + 1; ?>">
                        <button name="nextPage" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                            next
                            &raquo;
                        </button>
                    </form>

                <?php endif; ?>

            </div>

            <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                <?php if ($halamanAktif > 1): ?>

                    <?php if ($halamanAktif > 100): ?>
                        
                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                            <input type="hidden" name="paginationSekarangKurang100" value="<?= $halamanAktif; ?>">
                            <button name="reductionPage100">
                                &laquo;&laquo;
                            </button>
                        </form>

                    <?php else: ?>

                    <?php endif; ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                        <button name="firstPage">
                            &laquo;
                            First Page
                        </button>
                    </form>
                <?php endif; ?>      

                <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                <button name="findGetPage" onclick="findOpenPage()">
                    On Page
                </button>

                <?php if ($halamanAktif == $jumlahPagination): ?>
                    
                <?php else: ?>

                    <form action="checkpembayarandaninputdata" method="post">
                        <input type="hidden" name="endPage" value="<?= $halamanAktif + 1; ?>">
                        <button name="nextLastPage">
                            Last Page
                            &raquo;
                        </button>
                    </form>

                    <?php if ($showAddPage100 == "muncul" ): ?>

                        <form action="checkpembayarandaninputdata" method="post">
                            <input type="hidden" name="teslg" value="<?= $halamanAktif + 1; ?>">
                            <input type="hidden" name="paginationSekarangTambah100" value="<?= $halamanAktif; ?>">
                            <button name="addPage100">
                                &raquo;&raquo;
                            </button>
                        </form>

                    <?php else: ?>


                    <?php endif ?>

                    

                <?php endif ?>

            </div>

            <br>
        
        <?php endif; ?>

         <!-- Modal Cari Siswa -->
            <div id="findPage" class="modal"  data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-calendar"></i> Cari Halaman </h4>
                        </div>
                        <div class="modal-body"> 
                            <form action="checkpembayarandaninputdata" method="post">
                                <div class="box-body">
                                    <div class="row">

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label> Cari Halaman Ke Berapa : </label>
                                                <input type="text" class="form-control" id="cari_halaman" name="cari_halaman" placeholder="Wajib Di Tulis Angka">
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label style="color: white;"> Cari Halaman Ke Berapa : </label>
                                                <button name="findPageData" class="btn btn-success btn-sm">
                                                    Find Page
                                                </button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>    
            </div>
        <!-- Akhir Modal Cari Siswa -->

    <?php endif ?>