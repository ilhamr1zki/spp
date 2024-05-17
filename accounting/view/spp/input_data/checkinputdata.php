<?php 

    // echo $_SESSION['c_accounting'];exit;

    $code_accounting = $_SESSION['c_accounting'];

    $dataBulan = [
        'JANUARI',
        'FEBRUARI',
        'MARET',
        'APRIL',
        'MEI',
        'JUNI',
        'JULI',
        'AGUSTUS',
        'SEPTEMBER',
        'OKTOBER',
        'NOVEMBER',
        'DESEMBER'
    ];

    $opsiTx = [
        'TRANSFER',
        'CASH'
    ];

    function rupiahFormat($angkax){
    
        $hasil_rupiahx = "Rp " . number_format($angkax,0,'.',',');
        return $hasil_rupiahx;
     
    }

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

    $tanggalInput = date('Y-m-d') . " 00:00:00";

    $data_uang_spp        = 0;
    $data_uang_pangkal    = 0;
    $data_uang_kegiatan   = 0;
    $data_uang_buku       = 0;
    $data_uang_seragam    = 0;
    $data_uang_registrasi = 0;
    $data_uang_lain       = 0;

    $data_ket_spp         = NULL;
    $data_ket_pangkal     = NULL;
    $data_ket_kegiatan    = NULL;
    $data_ket_buku        = NULL;
    $data_ket_seragam     = NULL;
    $data_ket_registrasi  = NULL;
    $data_ket_lain        = NULL;

    $queryFindNamaInputer = mysqli_query($con, "SELECT username FROM accounting WHERE c_accounting = '$_SESSION[c_accounting]' ");
    $getDataNamaInputer   = ucfirst(mysqli_fetch_assoc($queryFindNamaInputer)['username']);
    // echo $getDataNamaInputer;
    $simpanDataID = [];
    $inputData = 0;
    $sesi = 0;

    if (isset($_POST['simpan_data'])) {
        $sesi = 1;
        $inputData = 1;

        $data_id            = htmlspecialchars($_POST['id_siswa']);
        $data_nis           = htmlspecialchars($_POST['nis_siswa']);
        $data_tanggal_input = htmlspecialchars($_POST['tanggal_bukti_tf']);
        if ($_POST['isi_bulan'] != '') {
            # code...
            $data_bulan         = htmlspecialchars(strtoupper($_POST['isi_bulan']) . " " . $_POST['isi_tahun']);
        } else {
            $data_bulan = '';
        }
        $data_kelas         = htmlspecialchars($_POST['kelas_siswa']);
        $data_nama          = htmlspecialchars($_POST['nama_siswa']);
        $data_panggilan     = htmlspecialchars($_POST['panggilan_siswa']);
        $data_tx            = htmlspecialchars($_POST['isi_tx']);

        // Validasi jika data siswa tidak ada
        if ($data_id == '' || $data_nis == '' || $data_nama == '') {
            $_SESSION['err_warning'] = 'err_validation';
        } else {

            $data_uang_spp          = str_replace(["Rp. ", "."], "", $_POST['nominal_spp']);
            $data_ket_spp           = htmlspecialchars($_POST['ket_uang_spp']);
            if ($data_ket_spp == '') {
                $data_ket_spp = NULL;
            } else if ($data_ket_spp != '') {
                $data_ket_spp       = htmlspecialchars($_POST['ket_uang_spp']);
                // echo $data_ket_spp . " ";
            }

            $data_uang_pangkal      = str_replace(["Rp. ", "."], "", $_POST['nominal_pangkal']);
            $data_ket_pangkal       = htmlspecialchars($_POST['ket_uang_pangkal']);
            if ($data_ket_pangkal == '') {
                $data_ket_pangkal = null;
            } else if ($data_ket_pangkal != '') {
                $data_ket_pangkal       = htmlspecialchars($_POST['ket_uang_pangkal']);
                // echo $data_ket_pangkal . " ";
            }

            $data_uang_kegiatan     = str_replace(["Rp. ", "."], "", $_POST['nominal_kegiatan']);
            $data_ket_kegiatan      = htmlspecialchars($_POST['ket_uang_kegiatan']);
            if ($data_ket_kegiatan == '') {
                $data_ket_kegiatan = null;
            } else if ($data_ket_kegiatan != '') {
                $data_ket_kegiatan       = htmlspecialchars($_POST['ket_uang_kegiatan']);
                // echo $data_ket_kegiatan . " ";
            }

            $data_uang_buku         = str_replace(["Rp. ", "."], "", $_POST['nominal_buku']);
            $data_ket_buku          = htmlspecialchars($_POST['ket_uang_buku']);
            if ($data_ket_buku == '') {
                $data_ket_buku = null;
            } else if ($data_ket_buku != '') {
                $data_ket_buku       = htmlspecialchars($_POST['ket_uang_buku']);
                // echo $data_ket_buku . " ";
            }

            $data_uang_seragam      = str_replace(["Rp. ", "."], "", $_POST['nominal_seragam']);
            $data_ket_seragam       = htmlspecialchars($_POST['ket_uang_seragam']);
            if ($data_ket_seragam == '') {
                $data_ket_seragam = null;
            } else if ($data_ket_seragam != '') {
                $data_ket_seragam       = htmlspecialchars($_POST['ket_uang_seragam']);
                // echo $data_ket_seragam . " ";
            }

            $data_uang_registrasi   = str_replace(["Rp. ", "."], "", $_POST['nominal_regis']);
            $data_ket_registrasi    = htmlspecialchars($_POST['ket_uang_regis']);
            if ($data_ket_registrasi == '') {
                $data_ket_registrasi = null;
            } else if ($data_ket_registrasi != '') {
                $data_ket_registrasi       = htmlspecialchars($_POST['ket_uang_regis']);
                // echo $data_ket_registrasi . " ";
            }

            $data_uang_lain         = str_replace(["Rp. ", "."], "", $_POST['nominal_lain']);
            $data_ket_lain          = htmlspecialchars($_POST['ket_uang_lain2']);
            if ($data_ket_lain == '') {
                $data_ket_lain = null;
            } else if ($data_ket_lain != '') {
                $data_ket_lain       = htmlspecialchars($_POST['ket_uang_lain2']);
                // echo $data_ket_lain;
            }
            // $data_inputer           = ucfirst(str)

            $data_stamp         = $_POST['tanggal_bukti_tf'] . " " . date("H:i:s");

            // Insert Data 
            $queryInsert = "
            INSERT INTO `input_data_sd` (
                `ID`, `NIS`, `DATE`, `BULAN`, 
                `KELAS`, `NAMA_KELAS`, `NAMA`, `PANGGILAN`, 
                `TRANSAKSI`, `SPP_SET`, `PANGKAL_SET`, `SPP`, `SPP_txt`, 
                `PANGKAL`, `PANGKAL_txt`, `KEGIATAN`, `KEGIATAN_txt`, 
                `BUKU`, `BUKU_txt`, `SERAGAM`, `SERAGAM_txt`, 
                `REGISTRASI`, `REGISTRASI_txt`, `LAIN`, `LAIN_txt`, 
                `INPUTER`, `STAMP`) 
            VALUES (
                NULL, '$data_nis', '$tanggalInput', '$data_bulan', 
                '$data_kelas', NULL, '$data_nama', '$data_panggilan',
                 '$data_tx', NULL, NULL, '$data_uang_spp', '$data_ket_spp', 
                 '$data_uang_pangkal', '$data_ket_pangkal', '$data_uang_kegiatan', '$data_ket_kegiatan', 
                 '$data_uang_buku', '$data_ket_buku', '$data_uang_seragam', '$data_ket_seragam', 
                 '$data_uang_registrasi', '$data_ket_registrasi', '$data_uang_lain', '$data_ket_lain', 
                 '$getDataNamaInputer', '$data_stamp'
            )";

            mysqli_query($con, $queryInsert);
            $_SESSION['form_success'] = "insert";

            $dataIDInvoice = mysqli_query($con, "SELECT ID FROM input_data_sd WHERE NIS = '$data_nis' ");

            foreach ($dataIDInvoice as $idInvoice) {
                array_push($simpanDataID, $idInvoice['ID']);
            }

            // var_dump($simpanDataID);

        }

        // echo  $data_nis . " " . $data_bulan . " " . $data_kelas . " " . $data_nama . " " . $data_panggilan . " " . $data_tx . " " . str_replace(["Rp. ", "."], "", htmlspecialchars($_POST['ket_uang_spp']));exit;

        // exit;
    }

    // echo format_tanggal_indo(date("Y-m-d"));
    // echo end($simpanDataID);

?>

<style type="text/css">

    .flex_container {
      display: flex;
      gap: 10px;
      flex-wrap: nowrap;
      margin-left: -12px;
    }

    .flex_container > div {
      width: 100px;
      margin: 10px;
      text-align: center;
      line-height: 75px;
      font-size: 30px;
    }

    #check_pembayaran {
        margin-left: -2px;
    }

    #div_cetak_kuitansi {
        margin-left: 42px;
    }

    #div_slip_kuitansi {
        margin-left: 24px;
    }

    @media (max-width: 600px) {
        .flex_container {
            flex-direction: column;
            gap: 0px;
            flex-wrap: nowrap;
        }

        .flex_container > div {
            width: auto;
            margin: 10px;
            text-align: center;
            line-height: 75px;
            font-size: 30px;
        }

        #div_input_data {
            line-height: 30px;
            margin-left: 25px;
        }

        #div_input_data > #input_data {
            width: 100%;
        }

        #check_pembayaran {
            margin-left: -4px;
            line-height: 30px;
            width: 72.5%;
        }

        #check_pembayaran > #cek_pembayaran {
            width: 119%;
        }

        #div_cetak_kuitansi {
            margin-left: 23px;
            line-height: 30px;
            width: 88%;
        }

        #btn_cetak_kuitansi {
            width: 98%;
        }

        #div_slip_kuitansi {
            margin-left: 25px;
            line-height: 30px;
            width: 70%;
        }

        #slip_kuitansi {
            width: 123.5%;
        }

    }

</style>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

        <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'insert'){?>
          <div style="display: none;" class="alert alert-warning alert-dismissable">Data Berhasil Di Input
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_success']); ?>
          </div>
        <?php } ?>

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
            <?php 
                $sesi = 3;
                $inputData = 3;
                unset($_SESSION['err_warning']); 
            ?>
          </div>
        <?php } ?>

    </div>
</div>

<div class="box box-info">

    <div class="box-header with-border">
        <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Input Data Baru </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
       
    </div>

    <?php if ($sesi == 1): ?>
       
        <div class="box-body table-responsive">

            <div class="row">
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>ID SISWA</label>
                        <input type="text" name="" readonly="" class="form-control" id="id_siswa" value="<?= $data_id; ?>" />
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>NIS</label>
                        <input type="text" class="form-control" id="nis_siswa" value="<?= $data_nis; ?>" readonly="" />
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>NAMA</label>
                        <input type="text" class="form-control" id="nama_siswa" readonly="" value="<?= $data_nama; ?>" />
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>PANGGILAN</label>
                        <input type="text" class="form-control" id="panggilan_siswa" readonly="" value="<?= $data_panggilan; ?>" />
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" class="form-control" readonly="" id="kelas_siswa" value="<?= $data_kelas; ?>" />
                    </div>
                </div>
            </div> 

            <div class="row">

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>TANGGAL</label>
                        <input type="text" id='tanggal_bukti_tf' class="form-control" readonly value="<?= format_tanggal_indo($data_tanggal_input); ?>">
                    </div>
                </div>
                
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>BULAN</label>
                        <input type="text" readonly value="<?= $_POST['isi_bulan']; ?>" class="form-control">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>TAHUN</label>
                        <input type="text" id="isi_tahun" readonly value="<?= $_POST['isi_tahun']; ?>" class="form-control">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>TX</label>
                        <input type="text" class="form-control" readonly="" value="<?= $data_tx; ?>">
                    </div>
                </div>

            </div>

            <hr class="new1" />

            <div class="flex-containers">

                <!-- SPP -->
                <div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 215px;"> UANG SPP </label>
                            <input type="text" id="rupiah_spp" class="uang_spp" value="<?= rupiahFormat($data_uang_spp); ?>" readonly>
                            <input type="text" class="ket_uang_spp" id="ket_uang_spp" readonly value="<?= $data_ket_spp; ?>" placeholder="Keterangan">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 175px;"> UANG PANGKAL </label>
                            <input type="text" id="rupiah_pangkal" readonly class="uang_pangkal" value="<?= rupiahFormat($data_uang_pangkal); ?>">
                            <input type="text" class="ket_uang_pangkal" readonly value="<?= $data_ket_pangkal; ?>" placeholder="Keterangan">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 173px;"> UANG KEGIATAN </label>
                            <input type="text" id="rupiah_kegiatan" readonly="" class="uang_kegiatan" value="<?= rupiahFormat($data_uang_kegiatan); ?>">
                            <input type="text" class="ket_uang_kegiatan" readonly="" placeholder="Keterangan" value="<?= $data_ket_kegiatan; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 204px;"> UANG BUKU </label>
                            <input type="text" id="rupiah_buku" class="uang_buku" readonly="" value="<?= rupiahFormat($data_uang_buku); ?>">
                            <input type="text" class="ket_uang_buku" readonly="" placeholder="Keterangan" value="<?= $data_ket_buku; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 172px;"> UANG SERAGAM </label>
                            <input type="text" id="rupiah_seragam" readonly="" class="uang_seragam" value="<?= rupiahFormat($data_uang_seragam); ?>">
                            <input type="text" class="ket_uang_seragam" readonly="" placeholder="Keterangan" value="<?= $data_ket_seragam; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 71px;"> UANG REGISTRASI/Daftar Ulang </label>
                            <input type="text" id="rupiah_regis" readonly class="uang_regis" value="<?= rupiahFormat($data_uang_registrasi); ?>">
                            <input type="text" class="ket_uang_regis" readonly="" placeholder="Keterangan" value="<?= $data_ket_registrasi; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group" style="margin-left: 15px;">
                            <label style="margin-right: 26px;"> LAIN<sup style="font-size: 10px;">2</sup>/INFAQ/Sumbangan/Antar Jemput </label>
                            <input type="text" id="rupiah_lain" class="lain2" readonly="" value="<?= rupiahFormat($data_uang_lain); ?>">
                            <input type="text" class="ket_lain2" placeholder="Keterangan" readonly="" value="<?= $data_ket_lain; ?>">
                        </div>
                    </div>

                    <div class="flex_container">
                        <div id="div_input_data">
                            <a href="javascript:void(0);" id="input_data" class="btn btn-warning btn-circle"> <span class="glyphicon glyphicon-pencil"> </span> Input Data </a>
                            <!-- <button id="cek_pembayaran" class="btn btn-primary btn-circle"> Cek Pembayaran </button> -->
                        </div>

                        <div id="check_pembayaran">
                            <a href="javascript:void(0);" id="cek_pembayaran" class="btn btn-primary btn-circle"> <span class="glyphicon glyphicon-list"> </span> Cek Pembayaran </a>
                            <!-- <button id="cek_pembayaran" class="btn btn-primary btn-circle"> Cek Pembayaran </button> -->
                        </div>

                        <div id="div_cetak_kuitansi">
                            <!-- <a href="javascript:void(0);" id="cek_pembayaran" class="btn btn-success btn-circle"> Cetak Kuitansi <span class="glyphicon glyphicon-print"> </span> </a> -->
                            <form action="<?= $baseac; ?>Kuitansi.php" method="post" target="blank">
                                <input type="hidden" name="cetak_kuitansi_nis_siswa" value="<?= $data_nis; ?>">
                                <input type="hidden" name="cetak_kuitansi_nama_siswa" value="<?= $data_nama; ?>">
                                <input type="hidden" name="cetak_kuitansi_kelas_siswa" value="<?= $data_kelas; ?>">
                                <input type="hidden" name="cetak_kuitansi_id_invoice" value="<?= end($simpanDataID); ?>">
                                <input type="hidden" name="cetak_kuitansi_bukti_tf" value="<?= $data_tanggal_input; ?>">
                                <input type="hidden" name="cetak_kuitansi_bulan_pembayaran" value="<?= $data_bulan; ?>">

                                <input type="hidden" name="cetak_kuitansi_uang_spp" value="<?= $data_uang_spp; ?>">
                                <input type="hidden" name="cetak_kuitansi_uang_pangkal" value="<?= $data_uang_pangkal; ?>">
                                <input type="hidden" name="cetak_kuitansi_uang_kegiatan" value="<?= $data_uang_kegiatan; ?>">
                                <input type="hidden" name="cetak_kuitansi_uang_buku" value="<?= $data_uang_buku; ?>">
                                <input type="hidden" name="cetak_kuitansi_uang_seragam" value="<?= $data_uang_seragam; ?>">
                                <input type="hidden" name="cetak_kuitansi_uang_registrasi" value="<?= $data_uang_registrasi; ?>">
                                <input type="hidden" name="cetak_kuitansi_uang_lain" value="<?= $data_uang_lain; ?>">

                                <input type="hidden" name="cetak_kuitansi_ket_uang_spp" value="<?= $data_ket_spp; ?>">
                                <input type="hidden" name="cetak_kuitansi_ket_uang_pangkal" value="<?= $data_ket_pangkal; ?>">
                                <input type="hidden" name="cetak_kuitansi_ket_uang_kegiatan" value="<?= $data_ket_kegiatan; ?>">
                                <input type="hidden" name="cetak_kuitansi_ket_uang_buku" value="<?= $data_ket_buku; ?>">
                                <input type="hidden" name="cetak_kuitansi_ket_uang_seragam" value="<?= $data_ket_seragam; ?>">
                                <input type="hidden" name="cetak_kuitansi_ket_uang_registrasi" value="<?= $data_ket_registrasi; ?>">
                                <input type="hidden" name="cetak_kuitansi_ket_uang_lain" value="<?= $data_ket_lain; ?>">

                                <button type="submit" name="cetak_kuitansi" id="btn_cetak_kuitansi" class="btn btn-success btn-circle"> <span class="glyphicon glyphicon-print"> </span> Cetak Kuitansi </button>
                            </form>

                        </div>

                        <div id="div_slip_kuitansi">
                            <form action="<?= $baseac; ?>slipkuitansi.php" method="post" target="blank">
                                
                                <input type="hidden" name="cetak_kuitansi_nis_siswa" value="<?= $data_nis; ?>">
                                <input type="hidden" name="cetak_kuitansi_nama_siswa" value="<?= $data_nama; ?>">
                                <input type="hidden" name="cetak_kuitansi_kelas_siswa" value="<?= $data_kelas; ?>">
                                <input type="hidden" name="cetak_kuitansi_id_invoice" value="<?= end($simpanDataID); ?>">
                                <input type="hidden" name="cetak_kuitansi_bukti_tf" value="<?= $data_tanggal_input; ?>">
                                <input type="hidden" name="cetak_kuitansi_bulan_pembayaran" value="<?= $data_bulan; ?>">

                                <input type="hidden" name="cetak_kuitansi_uang_spp" value="<?= $data_uang_spp; ?>">
                                <input type="hidden" name="cetak_kuitansi_uang_pangkal" value="<?= $data_uang_pangkal; ?>">
                                <input type="hidden" name="cetak_kuitansi_uang_kegiatan" value="<?= $data_uang_kegiatan; ?>">
                                <input type="hidden" name="cetak_kuitansi_uang_buku" value="<?= $data_uang_buku; ?>">
                                <input type="hidden" name="cetak_kuitansi_uang_seragam" value="<?= $data_uang_seragam; ?>">
                                <input type="hidden" name="cetak_kuitansi_uang_registrasi" value="<?= $data_uang_registrasi; ?>">
                                <input type="hidden" name="cetak_kuitansi_uang_lain" value="<?= $data_uang_lain; ?>">

                                <input type="hidden" name="cetak_kuitansi_ket_uang_spp" value="<?= $data_ket_spp; ?>">
                                <input type="hidden" name="cetak_kuitansi_ket_uang_pangkal" value="<?= $data_ket_pangkal; ?>">
                                <input type="hidden" name="cetak_kuitansi_ket_uang_kegiatan" value="<?= $data_ket_kegiatan; ?>">
                                <input type="hidden" name="cetak_kuitansi_ket_uang_buku" value="<?= $data_ket_buku; ?>">
                                <input type="hidden" name="cetak_kuitansi_ket_uang_seragam" value="<?= $data_ket_seragam; ?>">
                                <input type="hidden" name="cetak_kuitansi_ket_uang_registrasi" value="<?= $data_ket_registrasi; ?>">
                                <input type="hidden" name="cetak_kuitansi_ket_uang_lain" value="<?= $data_ket_lain; ?>">

                                <input type="hidden" name="jenisPembayaranSPP" value="<?= $data_uang_spp; ?>">
                                <input type="hidden" name="jenisPembayaranPangkal" value="<?= $data_uang_pangkal; ?>">
                                <input type="hidden" name="jenisPembayaranKegiatan" value="<?= $data_uang_kegiatan; ?>">
                                <input type="hidden" name="jenisPembayaranBuku" value="<?= $data_uang_buku; ?>">
                                <input type="hidden" name="jenisPembayaranSeragam" value="<?= $data_uang_seragam; ?>">
                                <input type="hidden" name="jenisPembayaranRegistrasi" value="<?= $data_uang_registrasi; ?>">
                                <input type="hidden" name="jenisPembayaranLain" value="<?= $data_uang_lain; ?>">

                                <button type="submit" name="slip_kuitansi" id="slip_kuitansi" class="btn btn-success btn-circle"> <span class="glyphicon glyphicon-print"> </span> Slip Kuitansi </button>
                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    <?php elseif($sesi == 3): ?>

        <form action="<?= $baseac; ?>checkinputdata" method="post">
            <div class="box-body table-responsive">

                <div class="row">
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label>ID SISWA</label>
                            <input type="text" readonly="" class="form-control" id="id_siswa" name="id_siswa" />
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
                            <select class="form-control" name="isi_bulan">
                                <option value=""> -- PILIH -- </option>
                                <?php foreach ($dataBulan as $bln) : ?>
                                    <option value="<?= $bln; ?>"> <?= $bln; ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>TAHUN</label>
                            <input type="text" name="isi_tahun" id="isi_tahun" placeholder="2024" class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>TX</label>
                            <select class="form-control" name="isi_tx">
                                <option value=""> -- PILIH -- </option>
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
                                <label style="margin-right: 215px;"> UANG SPP </label>
                                <input type="text" id="rupiah_spp" class="uang_spp" value="0" name="nominal_spp" required="">
                                <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 175px;"> UANG PANGKAL </label>
                                <input type="text" id="rupiah_pangkal" class="uang_pangkal" value="0" name="nominal_pangkal">
                                <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 173px;"> UANG KEGIATAN </label>
                                <input type="text" id="rupiah_kegiatan" class="uang_kegiatan" value="0" name="nominal_kegiatan">
                                <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 204px;"> UANG BUKU </label>
                                <input type="text" id="rupiah_buku" class="uang_buku" value="0" name="nominal_buku">
                                <input type="text" class="ket_uang_buku" name="ket_uang_buku" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 172px;"> UANG SERAGAM </label>
                                <input type="text" id="rupiah_seragam" class="uang_seragam" value="0" name="nominal_seragam">
                                <input type="text" class="ket_uang_seragam" name="ket_uang_seragam" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 71px;"> UANG REGISTRASI/Daftar Ulang </label>
                                <input type="text" id="rupiah_regis" class="uang_regis" value="0" name="nominal_regis">
                                <input type="text" class="ket_uang_regis" name="ket_uang_regis" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 26px;"> LAIN<sup style="font-size: 10px;">2</sup>/INFAQ/Sumbangan/Antar Jemput </label>
                                <input type="text" id="rupiah_lain" class="lain2" value="0" name="nominal_lain">
                                <input type="text" class="ket_lain2" name="ket_uang_lain2" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="tombol">
                            <div class="form-group">
                                <button id="save_record" name="simpan_data" class="btn btn-warning btn-circle"> Save Record </button>
                            </div>

                        <div class="form-group">
                            <a href="javascript:void(0);" id="cek_pembayaran" class="btn btn-primary btn-circle"> Cek Pembayaran </a>
                            <!-- <button id="cek_pembayaran" class="btn btn-primary btn-circle"> Cek Pembayaran </button> -->
                        </div>

        </form>

    <?php else: ?>

        <form action="<?= $baseac; ?>checkinputdata" method="post">
            <div class="box-body table-responsive">

                <div class="row">
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label>ID SISWA</label>
                            <input type="text" readonly="" class="form-control" id="id_siswa" name="id_siswa" />
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
                            <select class="form-control" name="isi_bulan">
                                <option value=""> -- PILIH -- </option>
                                <?php foreach ($dataBulan as $bln) : ?>
                                    <option value="<?= $bln; ?>"> <?= $bln; ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>TAHUN</label>
                            <input type="text" name="isi_tahun" id="isi_tahun" placeholder="2024" class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>TX</label>
                            <select class="form-control" name="isi_tx">
                                <option value=""> -- PILIH -- </option>
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
                                <label style="margin-right: 215px;"> UANG SPP </label>
                                <input type="text" id="rupiah_spp" class="uang_spp" value="0" name="nominal_spp" required="">
                                <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 175px;"> UANG PANGKAL </label>
                                <input type="text" id="rupiah_pangkal" class="uang_pangkal" value="0" name="nominal_pangkal">
                                <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 173px;"> UANG KEGIATAN </label>
                                <input type="text" id="rupiah_kegiatan" class="uang_kegiatan" value="0" name="nominal_kegiatan">
                                <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 204px;"> UANG BUKU </label>
                                <input type="text" id="rupiah_buku" class="uang_buku" value="0" name="nominal_buku">
                                <input type="text" class="ket_uang_buku" name="ket_uang_buku" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 172px;"> UANG SERAGAM </label>
                                <input type="text" id="rupiah_seragam" class="uang_seragam" value="0" name="nominal_seragam">
                                <input type="text" class="ket_uang_seragam" name="ket_uang_seragam" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 71px;"> UANG REGISTRASI/Daftar Ulang </label>
                                <input type="text" id="rupiah_regis" class="uang_regis" value="0" name="nominal_regis">
                                <input type="text" class="ket_uang_regis" name="ket_uang_regis" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 26px;"> LAIN<sup style="font-size: 10px;">2</sup>/INFAQ/Sumbangan/Antar Jemput </label>
                                <input type="text" id="rupiah_lain" class="lain2" value="0" name="nominal_lain">
                                <input type="text" class="ket_lain2" name="ket_uang_lain2" placeholder="Keterangan">
                            </div>
                        </div>

                        <div class="tombol">
                            <div class="form-group">
                                <button id="save_record" name="simpan_data" class="btn btn-warning btn-circle"> Save Record </button>
                            </div>

                        <div class="form-group">
                            <a href="javascript:void(0);" id="cek_pembayaran" class="btn btn-primary btn-circle"> Cek Pembayaran </a>
                            <!-- <button id="cek_pembayaran" class="btn btn-primary btn-circle"> Cek Pembayaran </button> -->
                        </div>

        </form>

    <?php endif ?>
    
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

    $('#isi_tahun').keypress(function (e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
    });

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

    let hrefInputData = `<?= $inputData; ?>`;

    if (hrefInputData == 1) {

        let replaceInputData = document.getElementById('input_data');

        replaceInputData.addEventListener('click', function(e) {
            document.location.href = `<?= $baseac; ?>checkinputdata`
        })

    }

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
        $('#cetakKuitansi_kelas_siswa').val(kelas)
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




