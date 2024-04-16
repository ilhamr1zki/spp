<?php  

    // require 'check_pembayaran_dan_inputdata.php';

?>
    <?php if (isset($_POST['filter_by'])): ?>
    

        <?php if ($_POST['isi_filter'] != 'kosong'): ?>
            
            <?php echo $_POST['isi_filter'] . " " . $_POST['_nmsiswa2']; ?>
        
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
    
    <?php endif; ?>