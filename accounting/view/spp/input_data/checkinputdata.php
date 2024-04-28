<?php 

    // echo $_SESSION['c_accounting'];exit;

    $code_accounting = $_SESSION['c_accounting'];

    $dataBulan = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    $opsiTx = [
        'TRANSFER',
        'CASH'
    ];

    function hariIndo ($hariInggris) {
      switch ($hariInggris) {
        case 'Sunday':
          return 'Minggu';
        case 'Monday':
          return 'Senin';
        case 'Tuesday':
          return 'Selasa';
        case 'Wednesday':
          return 'Rabu';
        case 'Thursday':
          return 'Kamis';
        case 'Friday':
          return 'Jumat';
        case 'Saturday':
          return 'Sabtu';
        default:
          return 'hari tidak valid';
      }
    }

    function bulan_indo($month) {
        $bulan = (int) $month;
        $arrBln = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        return $arrBln[$bulan];
    }

    function bulan_indo_stempel($month) {
        $bulan = (int) $month;
        $arrBln = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agust', 'Sept', 'Okt', 'Nov', 'Des');
        return $arrBln[$bulan];
    }

    function format_tanggal_indo($tgl) {
        $tanggal = substr($tgl, 8, 2);
        $bulan = bulan_indo(substr($tgl, 5, 2));
        $tahun = substr($tgl, 0, 4);
        $day = date('D', strtotime($tgl));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        return $tanggal . ' ' . $bulan . ' '. $tahun;  
    }

    function format_tanggal_stempel($tgl) {
        $tanggal = substr($tgl, 8, 2);
        $bulan = bulan_indo(substr($tgl, 5, 2));
        $tahun = substr($tgl, 0, 4);
        $day = date('D', strtotime($tgl));

        return $tanggal . ' ' . $bulan . ' '. $tahun;  
    }

    // echo format_tanggal_indo(date("Y-m-d"));

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan'] == 'tambah'){?>
          <div style="display: none;" class="alert alert-warning alert-dismissable">Setup Naik Juz Berhasil Disimpan
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['pesan']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan'] == 'edit'){?>
          <div style="display: none;" class="alert alert-info alert-dismissable">Data Naik Juz Berhasil Disimpan
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['pesan']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan'] == 'edit_catatan') { ?>
          <div style="display: none;" class="alert alert-success alert-dismissable"> Histori Catatan Berhasil Disimpan
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['pesan']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan'] == 'hapus') {?>
          <div style="display: none;" class="alert alert-info alert-dismissable">Data Naik Juz Berhasil Dihapus
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['pesan']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['err_warning']) && $_SESSION['err_warning'] == 'err_validation'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Mohon Cari Siswa Terlebih Dahulu
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php unset($_SESSION['err_warning']); ?>
          </div>
        <?php } ?>

    </div>
</div>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Input Data Baru </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
       
    </div>
    <form action="<?= $baseac; ?>checkdata" method="post" target="_blank">
        <div class="box-body table-responsive">

            <div class="row">
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>ID</label>
                        <input type="text" name="" readonly="" class="form-control" id="id_siswa" name="id_siswa" />
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>NIS</label>
                        <input type="text" class="form-control" id="nis_siswa" name="nis_siswa" readonly="" />
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>NAMA</label>
                        <input type="text" class="form-control" id="nama_siswa" readonly="" name="nama_siswa" />
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>PANGGILAN</label>
                        <input type="text" class="form-control" id="panggilan_siswa" readonly="" name="panggilan_siswa" />
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" class="form-control" readonly="" id="kelas_siswa" name="kelas_siswa" />
                    </div>
                </div>
            </div> 

            <div class="row">

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>TANGGAL</label>
                        <input type="date" class="form-control" name="tanggal_bukti_tf" id="tanggal_bukti_tf">
                    </div>
                </div>
                
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>BULAN</label>
                        <select class="form-control">
                            <option> -- PILIH -- </option>
                            <?php foreach ($dataBulan as $bln) : ?>
                                <option value="<?= $bln; ?>"> <?= $bln; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>TAHUN</label>
                        <input type="text" name="isi_tahun" class="form-control">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>TX</label>
                        <select class="form-control">
                            <option> -- PILIH -- </option>
                            <?php foreach ($opsiTx as $tx): ?>
                                <option value="<?= $tx; ?>"> <?= $tx; ?> </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

            </div>

            <hr class="new1" />

            <div class="flex-containers">

                <!-- SPP -->
                <div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 213px;"> UANG SPP </label>
                            <input type="text" id="rupiah_spp" class="uang_spp" value="0" name="nominal_spp">
                            <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp" placeholder="Keterangan">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 174px;"> UANG PANGKAL </label>
                            <input type="text" id="rupiah_pangkal" class="uang_pangkal" value="0" name="">
                            <input type="text" class="ket_uang_pangkal" name="" placeholder="Keterangan">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 69px;"> UANG REGISTRASI/Daftar Ulang </label>
                            <input type="text" id="rupiah_regis" class="uang_regis" value="0" name="">
                            <input type="text" class="ket_uang_regis" name="" placeholder="Keterangan">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 171px;"> UANG SERAGAM </label>
                            <input type="text" id="rupiah_seragam" class="uang_seragam" value="0" name="">
                            <input type="text" class="ket_uang_seragam" name="" placeholder="Keterangan">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 203px;"> UANG BUKU </label>
                            <input type="text" id="rupiah_buku" class="uang_buku" value="0" name="">
                            <input type="text" class="ket_uang_buku" name="" placeholder="Keterangan">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 172px;"> UANG KEGIATAN </label>
                            <input type="text" id="rupiah_kegiatan" class="uang_kegiatan" value="0" name="">
                            <input type="text" class="ket_uang_kegiatan" name="" placeholder="Keterangan">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 22px;"> LAIN2/INFAQ/Sumbangan/Antar Jemput </label>
                            <input type="text" id="rupiah_lain" class="lain2" value="0" name="">
                            <input type="text" class="ket_lain2" name="" placeholder="Keterangan">
                        </div>
                    </div>

                    <div class="tombol">
                        <div class="form-group">
                            <button id="save_record" class="btn btn-warning btn-circle"> Save Record </button>
                        </div>

    </form>
                    <form action="<?= $baseac; ?>Kuitansi.php" method="POST" target="_blank">
                        
                        <div class="form-group">
                            <input type="hidden" id="cetakKuitansi_uang_spp" name="cetak_kuitansi_uang_spp">
                            <input type="hidden" id="cetakKuitansi_id_siswa" name="cetak_kuitansi_id_siswa">
                            <input type="hidden" id="cetakKuitansi_nis_siswa" name="cetak_kuitansi_nis_siswa">
                            <input type="hidden" id="cetakKuitansi_nama_siswa" name="cetak_kuitansi_nama_siswa">
                            <input type="hidden" id="cetakKuitansi_bukti_tf" name="cetak_kuitansi_bukti_tf">
                            <input type="hidden" id="cetakKuitansi_ket_uang_spp" name="cetak_kuitansi_ket_uang_spp">
                            <button id="cetak_kuitansi" name="cetak_kuitansi" class="btn btn-success btn-circle"> Cetak Kuitansi <span class="glyphicon glyphicon-print"> </button>
                        </div>
                        
                    </form>

                        <div class="form-group">
                            <button id="cetak_slip_kuitansi" class="btn btn-success btn-circle"> Slip Kuitansi <span class="glyphicon glyphicon-print"> </button>
                        </div>
                    <!-- <form> -->
                        <div class="form-group">
                            <a href="javascript:void(0);" id="cek_pembayaran" class="btn btn-primary btn-circle"> Cek Pembayaran </a>
                            <!-- <button id="cek_pembayaran" class="btn btn-primary btn-circle"> Cek Pembayaran </button> -->
                        </div>
                    <!-- </form> -->

                    </div>

                </div>  

            </div>
            
        </div>
    
</div>

<!-- Modal Cari Siswa -->
<div id="datamassiswa" class="modal"  data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-calendar"></i> Data Siswa</h4>
            </div>
            <div class="modal-body"> 
                <div class="box-body table-responsive">
                    <table id="example1x" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                              <th style="text-align: center;" width="5%">NO</th>
                            <?php 
                                if(empty($_GET['q'])) {
                                    echo '<th style="text-align: center;" width="12%">KELAS</th>';
                                } 
                            ?>
                              <th style="text-align: center;">NIS</th>
                              <th style="text-align: center;">NAMA</th>
                              <th style="text-align: center;">GENDER</th>
                            </tr>
                        </thead>
                        <?php

                            $no = 1;
                            
                            if(isset($_GET['q'])) {
                              $smk=mysqli_query($con,"SELECT * FROM siswa where c_kelas='$_GET[q]' order by nama asc ");
                            } else {

                                if ($code_accounting == 'accounting1') {
                                    $queryGetAllDataSiswa      = "SELECT * FROM data_murid_sd ORDER BY KELAS asc ";
                                    $execqueryGetAllDataSiswa  = mysqli_query($con, $queryGetAllDataSiswa);
                                } else {
                                    $queryGetAllDataSiswa      = "SELECT * FROM data_murid_tk";
                                    $execqueryGetAllDataSiswa  = mysqli_query($con, $queryGetAllDataSiswa);
                                }

                            } 

                        ?>
                        <tbody>
                            <?php foreach ($execqueryGetAllDataSiswa as $data): ?>
                            <tr onclick="
                                OnSiswaSelectedModal(
                                    '<?= $data['ID']; ?>', 
                                    '<?= $data['NIS']; ?>', 
                                    '<?= $data['Nama']; ?>', 
                                    '<?= $data['KELAS']; ?>', 
                                    '<?= $data['Panggilan']; ?>'
                                    )
                                ">
                                    <td style="text-align: center;"> <?= $no++; ?> </td>
                                    <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['Nama']; ?> </td>
                                    <?php if ($data['jk'] == 'L'): ?>
                                        <td style="text-align: center;"> Laki - Laki </td>
                                    <?php else: ?>
                                        <td style="text-align: center;"> Perempuan </td>
                                    <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>
<!-- Akhir Modal Cari Siswa -->

<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script> -->

<script language="javascript" type="text/javascript">

    /* Format Rupiah SPP */
    let rupiah_spp                  = document.getElementById('rupiah_spp')

    // Form Data Siswa 
    let dataNamaSiswa               = document.getElementById('nama_siswa')
    let dataKetUangSPP              = document.getElementById('ket_uang_spp')
    let dataTglBuktiTf              = document.getElementById('tanggal_bukti_tf');

    // Kirim Data Tombol Cetak Kuitansi
    let dataCetakKuitansiNamaSiswa  = document.getElementById('cetakKuitansi_nama_siswa')
    let dataCetakKuitansiUangSPP    = document.getElementById('cetakKuitansi_uang_spp')
    let dataCetakKuitansiTglTf      = document.getElementById('cetakKuitansi_bukti_tf')
    let dataCetakKuitansiKetUangSPP = document.getElementById('cetakKuitansi_ket_uang_spp')

    dataNamaSiswa.addEventListener('keyup', function(e) {
        dataCetakKuitansiNamaSiswa.value = dataNamaSiswa.value
    })

    dataKetUangSPP.addEventListener('keyup', function(e) {
        dataCetakKuitansiKetUangSPP.value = dataKetUangSPP.value
    })

    dataTglBuktiTf.addEventListener('change', function(e) {
        dataCetakKuitansiTglTf.value = dataTglBuktiTf.value
    })

    rupiah_spp.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // alert("ok")
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_spp.value = formatRupiahSPP(this.value, 'Rp. ');
        dataCetakKuitansiUangSPP.value = rupiah_spp.value
    });

    let buttonCheckPayment = document.getElementById('cek_pembayaran')
    buttonCheckPayment.addEventListener('click', function() {
        window.open(`<?= $baseac; ?>checkpembayarandaninputdata`)
    })

    let namaSiswa = document.getElementById('nama_siswa')

    /* Fungsi formatRupiahSPP */
    function formatRupiahSPP(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split             = number_string.split(','),
        sisa              = split[0].length % 3,
        rupiah_spp        = split[0].substr(0, sisa),
        ribuan            = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah_spp += separator + ribuan.join('.');
        }

        rupiah_spp = split[1] != undefined ? rupiah_spp + ',' + split[1] : rupiah_spp;
        return prefix == undefined ? rupiah_spp : (rupiah_spp ? 'Rp. ' + rupiah_spp : '');
    }

    /* Akhir Format Rupiah SPP */

    /* Format Rupiah Pangkal */
    let rupiah_pangkal = document.getElementById('rupiah_pangkal');

    rupiah_pangkal.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // alert("ok")
        // gunakan fungsi formatRupiahPangkal() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_pangkal.value = formatRupiahPangkal(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiahPangkal */
    function formatRupiahPangkal(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        rupiah_pangkal          = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah_pangkal += separator + ribuan.join('.');
        }

        rupiah_pangkal = split[1] != undefined ? rupiah_pangkal + ',' + split[1] : rupiah_pangkal;
        return prefix == undefined ? rupiah_pangkal : (rupiah_pangkal ? 'Rp. ' + rupiah_pangkal : '');
    }

    /* Akhir Format Rupiah Pangkal */

    /* Format Rupiah Regis */
    let rupiah_regis = document.getElementById('rupiah_regis');

    rupiah_regis.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // alert("ok")
        // gunakan fungsi formatRupiahRegistrasi() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_regis.value = formatRupiahRegistrasi(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiahRegistrasi */
    function formatRupiahRegistrasi(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        rupiah_regis          = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah_regis += separator + ribuan.join('.');
        }

        rupiah_regis = split[1] != undefined ? rupiah_regis + ',' + split[1] : rupiah_regis;
        return prefix == undefined ? rupiah_regis : (rupiah_regis ? 'Rp. ' + rupiah_regis : '');
    }

    /* Akhir Format Rupiah Regis */

    /* Format Rupiah Seragam */
    let rupiah_seragam = document.getElementById('rupiah_seragam');

    rupiah_seragam.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // alert("ok")
        // gunakan fungsi formatRupiahSeragam() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_seragam.value = formatRupiahSeragam(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiahSeragam */
    function formatRupiahSeragam(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        rupiah_seragam          = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah_seragam += separator + ribuan.join('.');
        }

        rupiah_seragam = split[1] != undefined ? rupiah_seragam + ',' + split[1] : rupiah_seragam;
        return prefix == undefined ? rupiah_seragam : (rupiah_seragam ? 'Rp. ' + rupiah_seragam : '');
    }

    /* Akhir Format Rupiah Seragam */

    /* Format Rupiah Buku */
    let rupiah_buku = document.getElementById('rupiah_buku');

    rupiah_buku.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // alert("ok")
        // gunakan fungsi formatRupiahBuku() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_buku.value = formatRupiahBuku(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiahBuku */
    function formatRupiahBuku(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        rupiah_buku          = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah_buku += separator + ribuan.join('.');
        }

        rupiah_buku = split[1] != undefined ? rupiah_buku + ',' + split[1] : rupiah_buku;
        return prefix == undefined ? rupiah_buku : (rupiah_buku ? 'Rp. ' + rupiah_buku : '');
    }

    /* Akhir Format Rupiah Buku */

    /* Format Rupiah Kegiatan */
    let rupiah_kegiatan = document.getElementById('rupiah_kegiatan');

    rupiah_kegiatan.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // alert("ok")
        // gunakan fungsi formatRupiahKegiatan() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_kegiatan.value = formatRupiahKegiatan(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiahKegiatan */
    function formatRupiahKegiatan(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        rupiah_kegiatan          = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah_kegiatan += separator + ribuan.join('.');
        }

        rupiah_kegiatan = split[1] != undefined ? rupiah_kegiatan + ',' + split[1] : rupiah_kegiatan;
        return prefix == undefined ? rupiah_kegiatan : (rupiah_kegiatan ? 'Rp. ' + rupiah_kegiatan : '');
    }

    /* Akhir Format Rupiah Kegiatan */

    /* Format Rupiah Lain */
    let rupiah_lain = document.getElementById('rupiah_lain');

    rupiah_lain.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // alert("ok")
        // gunakan fungsi formatRupiahLain() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_lain.value = formatRupiahLain(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiahLain */
    function formatRupiahLain(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        rupiah_lain          = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah_lain += separator + ribuan.join('.');
        }

        rupiah_lain = split[1] != undefined ? rupiah_lain + ',' + split[1] : rupiah_lain;
        return prefix == undefined ? rupiah_lain : (rupiah_lain ? 'Rp. ' + rupiah_lain : '');
    }

    /* Akhir Format Rupiah Lain */

$(document).ready(function() {

    $('#_idsiswa').val("");
    $('#_nmsiswa').val("");
    $('#_nmsiswa2').text("");
    $('#_kelassiswa').text("");

    $('#editorcatatan').summernote({
        placeholder: 'Isi Catatan',
        tabsize: 2,
        height: 150
      });

});

    function OpenCarisiswaModal(){

        $('#datamassiswa').modal("show");
    }

    function OnSiswaSelectedModal(id, nis, nmsiswa, kelas, panggilan){

        // alert(nmsiswa)

        $('#id_siswa').val(id);
        $('#nis_siswa').val(nis);
        $('#nama_siswa').val(nmsiswa);
        $('#kelas_siswa').val(kelas);
        $('#panggilan_siswa').val(panggilan)

        $('#cetakKuitansi_id_siswa').val(id)
        $('#cetakKuitansi_nis_siswa').val(nis)
        $('#cetakKuitansi_nama_siswa').val(nmsiswa)
        $('#datamassiswa').modal("hide");
    }

    function SelectilidChanged(juzval) {

        if($('#_idsiswa').val() == null || $('#_idsiswa').val() == "")
        {
            alert("Silahkan pilih siswa");
            return $('#_setmanualjuzselect').val("");
        }

        fetch("view/tahfidz/apiservicemasterjuz.php?idjuz=" + $('#_setmanualjuzselect').val())
            .then((response) => {
                if(!response.ok){ // Before parsing (i.e. decoding) the JSON data,// check for any errors.// In case of an error, throw.
                    throw new Error("Terjadi kesalahan!");
                }

                return response.json(); // Parse the JSON data.
            })
            .then((data) => {
                var valjuz = JSON.stringify(data.nmjuz2);
                var valnmbagian = JSON.stringify(data.nmbagian);
                var valseq = JSON.stringify(data.seqjuz);

                $('#_idjuzmanual').val($('#_setmanualjuzselect').val());
                $('#_seqnextmanual').val(valseq.slice(1, -1).trim());
                $('#_nmjuzmanual').val(valjuz.slice(1, -1).trim());
                $('#_nmbagianmanual').val(valnmbagian.slice(1, -1).trim());


                //alert("id: " + $('#_setmanualjuzselect').val() + "- jilid: " + valjuz + "- bagian: " + valnmbagian);
            })
            .catch((error) => {
                // This is where you handle errors.
            });

    } 

</script>

<!-- jQuery 2.2.3 -->

<script type="text/javascript" src="<?php echo $base; ?>theme/datetime/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo $base; ?>theme/datetime/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
        showMeridian: 1
    });
  $('.form_date').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
    });
  $('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0
    });
</script>




