<?php 

    // echo $_SESSION['c_accounting'];exit;

    $code_accounting = $_SESSION['c_accounting'];

    $sqlJuz = mysqli_query($con,
    "select CONCAT('Juz ', tblall.juz_atau_keterangan_ayat,' Surah ', nmbagian) as nmjuzall, tblall.* from 
    (
        select tbl1.* from
        (
            select tj.id, tbl1.juz_atau_keterangan_ayat, tj.juz_atau_keterangan_ayat as nmbagian, count(sh.c_siswa) as jml, tj.seqjuz from tbl_juz tj
            left join sisjuz_h sh on tj.id = sh.idjuz 
            left join (select distinct tj2.id, tj2.juz_atau_keterangan_ayat from tbl_juz tj2 ) as tbl1 
            on tj.parentid  = tbl1.id
            where tj.parentid != 0
            
            and coalesce(sh.flag, 'N') = 'N'
            group by tj.id, tj.juz_atau_keterangan_ayat, tbl1.juz_atau_keterangan_ayat, tj.seqjuz
            order by tj.seqjuz
        ) as tbl1
    union 
        select tbl2.* from
        ( 
            select tj.id, '' juz_atau_keterangan_ayat, tj.juz_atau_keterangan_ayat as nmbagian, count(sh.c_siswa) as jml, tj.seqjuz  from tbl_juz tj
            left join sisjuz_h sh on tj.id = sh.idjuz  
            where tj.parentid = 0 and tj.seqjuz  > 14
            and coalesce(sh.flag, 'N') = 'N'
            group by tj.id, tj.juz_atau_keterangan_ayat, tj.seqjuz
            order by tj.seqjuz
        ) as tbl2
   ) as tblall
   order by seqjuz"); 

    $queryGetDataSeqJuz1 = mysqli_query($con, 
        "SELECT id, juz_atau_keterangan_ayat, seqjuz FROM tbl_juz WHERE seqjuz = '1' "
    );

    $getDataArr = mysqli_fetch_array($queryGetDataSeqJuz1);
    
    $getDataIdJuz  = $getDataArr['id'];
    $getDataSeqJuz = $getDataArr['seqjuz'];

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
    <form action="<?php echo $basegu; ?>a-guru/<?php echo md5('addnaikjuz'); ?>/access" method="post">
        <div class="box-body table-responsive">
            <input type="hidden" id="_entryby" name="_entryby" class="form-control" value="<?php echo $na['nama'] ?>">
            <input type="hidden" id="_idsiswa" name="_idsiswa" class="form-control">
            <input type="hidden" id="_idjuz" name="_idjuz" class="form-control">
            <input type="hidden" id="_idjuznext" name="_idjuznext" class="form-control">
            <input type="hidden" id="_nmjuznext" name="_nmjuznext" class="form-control">
            <input type="hidden" id="_seqnext" name="_seqnext" class="form-control">
            <input type="hidden" id="code_siswa" name="code_siswa" class="form-control">

            <input type="hidden" class="form-control" id="_nmsiswa" name="_nmsiswa">
            <input type="hidden" class="form-control" id="_juzcur" name="_juzcur"/>
            <input type="hidden" class="form-control" id="_juzutama" name="_juzutama"/>

            <input type="hidden" id="_idjuzmanual" name="_idjuzmanual" class="form-control">
            <input type="hidden" id="_seqnextmanual" name="_seqnextmanual" class="form-control">
            <input type="hidden" id="_nmjuzmanual" name="_nmjuzmanual" class="form-control">
            <input type="hidden" id="_nmbagianmanual" name="_nmbagianmanual" class="form-control">

            <div class="row">
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>ID</label>
                        <input type="text" name="" value="4739" readonly="" class="form-control" value="MUHAMMAD ELVARO RAFARDHAN" id="_nmsiswa2" name="_nmsiswa2" />
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>NIS</label>
                        <input type="text" class="form-control" id="_kelassiswa" value="202302002" name="_kelassiswa" />
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>NAMA</label>
                        <input type="text" name="" value="ZILLJIZAN" class="form-control" value="MUHAMMAD ELVARO RAFARDHAN" id="_nmsiswa2" name="_nmsiswa2" />
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>PANGGILAN</label>
                        <input type="text" name="" value="JIZAN" class="form-control" value="MUHAMMAD ELVARO RAFARDHAN" id="_nmsiswa2" name="_nmsiswa2" />
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="" value="1 SD" class="form-control" value="MUHAMMAD ELVARO RAFARDHAN" id="_nmsiswa2" name="_nmsiswa2" />
                    </div>
                </div>
            </div> 

            <div class="row">

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>TANGGAL</label>
                        <input type="text" class="form-control" value="26-Feb-24" name="_bagianjuzcur2" id="_bagianjuzcur2" readonly="">
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
                            <option> TRANSFER </option>
                            <option> CASH  </option>
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
                            <input type="text" id="rupiah_spp" class="uang_spp" value="0" name="">
                            <input type="text" class="ket_uang_spp" name="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 174px;"> UANG PANGKAL </label>
                            <input type="text" id="rupiah_pangkal" class="uang_pangkal" value="0" name="">
                            <input type="text" class="ket_uang_pangkal" name="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 69px;"> UANG REGISTRASI/Daftar Ulang </label>
                            <input type="text" id="rupiah_regis" class="uang_regis" value="0" name="">
                            <input type="text" class="ket_uang_regis" name="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 171px;"> UANG SERAGAM </label>
                            <input type="text" id="rupiah_seragam" class="uang_seragam" value="0" name="">
                            <input type="text" class="ket_uang_seragam" name="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 203px;"> UANG BUKU </label>
                            <input type="text" id="rupiah_buku" class="uang_buku" value="0" name="">
                            <input type="text" class="ket_uang_buku" name="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 172px;"> UANG KEGIATAN </label>
                            <input type="text" id="rupiah_kegiatan" class="uang_kegiatan" value="0" name="">
                            <input type="text" class="ket_uang_kegiatan" name="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 22px;"> LAIN2/INFAQ/Sumbangan/Antar Jemput </label>
                            <input type="text" id="rupiah_lain" class="lain2" value="100000" name="">
                            <input type="text" class="ket_lain2" name="">
                        </div>
                    </div>

                    <!-- <div class="row" id="tombol">
                        <div class="col-sm-4">
                            <div class="form-group" style="margin-left: 15px;">
                                <button id="save_record" class="btn btn-warning btn-circle"> Save Record </button>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" style="margin-left: 15px;">
                                <button id="cek_pembayaran" class="btn btn-primary btn-circle"> Cek Pembayaran </button>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group" style="margin-left: 44px; width: 145%;">
                                <button id="cek_pembayaran" class="btn btn-success btn-circle"> Cetak Kuitansi <span class="glyphicon glyphicon-print"> </button>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group" style="margin-left: 44px; width: 145%;">
                                <button id="cek_pembayaran" class="btn btn-success btn-circle"> Slip Kuitansi <span class="glyphicon glyphicon-print"> </button>
                            </div>
                        </div>
                    </div> -->

                    <div class="tombol">
                        <div class="form-group">
                            <button id="save_record" class="btn btn-warning btn-circle"> Save Record </button>
                        </div>

                        <div class="form-group">
                            <button id="cek_pembayaran" class="btn btn-primary btn-circle"> Cek Pembayaran </button>
                        </div>

                        <div class="form-group">
                            <button id="cek_pembayaran" class="btn btn-success btn-circle"> Cetak Kuitansi <span class="glyphicon glyphicon-print"> </button>
                        </div>

                        <div class="form-group">
                            <button id="cek_pembayaran" class="btn btn-success btn-circle"> Slip Kuitansi <span class="glyphicon glyphicon-print"> </button>
                        </div>
                    </div>

                </div>  

            </div>
            
        </div>
    </form>
    
</div>

<div id="datamassiswa" class="modal"  data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-calendar"></i> Data Siswa</h4>
            </div>
            <div class="modal-body"> 
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-hover">
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
                            <tr>
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

<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script> -->

<script language="javascript" type="text/javascript">

    /* Format Rupiah SPP */
    let rupiah_spp = document.getElementById('rupiah_spp');

    rupiah_spp.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // alert("ok")
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_spp.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        rupiah_spp          = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

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
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_pangkal.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
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
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_regis.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
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
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_seragam.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
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
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_buku.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
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
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_kegiatan.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
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
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_lain.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
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

    // $("#btnSimpanCatatan").click(function() {
    //     alert("Hello")
    //     $.ajax({
    //         url     : "../../a-guru/control.php",
    //         type    : "POST",
    //         data    : {
    //             datanama : document.getElementById("_nmsiswa2").value
    //         },
    //         success:function(data) {
    //             console.log(data);
    //         }
    //     });
    // })

});

    function OpenCarisiswaModal(){

        $('#datamassiswa').modal("show");
    }

    function OnSiswaSelectedModal(kode, nama, kelas, c_siswa, curjuz, idcurjuz, seqjuz, 
    nextSeq, nextnmjuz, nextidjuz, nmbagian, catatan, nextjuzutama){

        // alert(kode)

        $('#_idsiswa').val(kode);
        $('#_nmsiswa').val(nama);
        $('#_nmsiswa2').text(nama);
        $('#_kelassiswa').text(kelas);

        //$('#editorcatatan').summernote('reset');
        $('#editorcatatan').summernote('code', '<p><br></p>');

        // Jika code siswa tidak ada di tabel sisjuz_h
        if(c_siswa == undefined || c_siswa == null || c_siswa == '') {

            let btnnaikjuz              = document.getElementById("btnnaikjuz");
            btnnaikjuz.style.display    = "block";
            btnnaikjuz.style.marginTop  = "10px";

            alert(`${nama} belum ada di data naik juz`);
            document.getElementById('code_siswa').value = kode

            document.getElementById("isijuzsekarang").value = 30
            document.getElementById("_setmanualjuzselect").value = "kosong"
            $('#_juzcur').val("An Nas - Al Fajr");
            $('#_bagianjuzcur2').val("An Nas - Al Fajr");
            $('#_idjuz').val(`<?= $getDataIdJuz; ?>`);
            $('#_seqnext').val(`<?= $getDataSeqJuz; ?>`);
            
        } else {

            // Jika code siswa ada di table sisjuz_h tetapi di kolom juz dan kolom ketjuzsurah tidak ada data nya
            let btnnaikjuz              = document.getElementById("btnnaikjuz");
            btnnaikjuz.style.display    = "block";
            btnnaikjuz.style.marginTop  = "10px";

            $('#_idjuz').val(nextidjuz);
            $('#_seqnext').val(nextSeq);
            $('#_bagianjuzcur2').val(nmbagian ?? "");
            $('#_nmjuznext').val(nextnmjuz ?? "");
            
            $('#_juzutama').val(nextjuzutama ?? "");
            
            fetch("view/tahfidz/singledatajuz_h.php?c_siswa=" + c_siswa)
            .then((response) => {
                if(!response.ok){ // Before parsing (i.e. decoding) the JSON data,// check for any errors.// In case of an error, throw.
                    throw new Error("Terjadi kesalahan!");
                }

                return response.json(); // Parse the JSON data.
            })
            .then((data) => {
                // console.log(data.catatan)
                // alert('fetch');
                const myJSON                = JSON.stringify(data.catatan);
                const ketjuzsurahsekarang   = JSON.stringify(data.juz);
                const idjuzsekarang         = JSON.stringify(data.idjuz);
                document.getElementById("isijuzsekarang").value = ketjuzsurahsekarang.slice(1, -1).trim()
                // alert(ketjuzsurahsekarang.slice(1, -1).trim())

                // This is where you handle what to do with the response.
                $('#editorcatatan').summernote('pasteHTML', myJSON.slice(1, -1).trim());
                $('#_juzcur').val(ketjuzsurahsekarang.slice(1, -1).trim());

                if(idjuzsekarang.slice(1, -1).trim() == "23")
                {
                    _btnnaikjuz.style.display = "none";
                }

            })
            .catch((error) => {
                // This is where you handle errors.
            });

        }

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




