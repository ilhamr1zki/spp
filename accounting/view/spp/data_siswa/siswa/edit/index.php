<?php 

  $jenis_kelamin      = ["L", "P"];
  $jenjang_pendidikan = mysqli_query($con, "SELECT * FROM kelas ORDER BY kelas ASC");

  $tampungData = [];
  $jenjangOpt  = [];

  foreach ($jenjang_pendidikan as $dt) {
    $tampungData[] = $dt['kelas'];
  }

  // var_dump($tampungData);

  $pendidikan         = ["SD", "SMP", "SMA", "SMK", "D1", "D2", "D3", "D4", "S1", "S2", "S3"];
  $pekerjaan          = ["WIRASWASTA", "KS", "PNS", "TNI", "POLRI", "PENSIUNAN", "LAINNYA"];
  $pekerjaanIbu       = ["WIRASWASTA", "KS", "PNS", "TNI", "POLRI", "PENSIUNAN", "IRT", "LAINNYA"];

  if ($_SESSION['c_accounting'] == 'accounting1') {

    $dataSiswa          = mysqli_query($con, "
      SELECT 
      *
      FROM data_murid_sd
    ");

    for ($i = 0; $i < 6; $i++) { 
      $jenjangOpt[] = $tampungData[$i];
    }

  } else if ($_SESSION['c_accounting'] == 'accounting2') {

    $dataSiswa          = mysqli_query($con, "
      SELECT
      *
      FROM data_murid_tk
    ");

    $jenjangOpt = array_slice($tampungData, 6,3);

  }

  // var_dump($jenjangOpt);

  $timeOut        = $_SESSION['expire'];
    
  $timeRunningOut = time() + 5;

  $timeIsOut = 0;

  $sesiForm = 0;

  // echo "Waktu Habis : " . $timeOut . " Waktu Berjalan : " . $timeRunningOut;

  if ($timeRunningOut == $timeOut || $timeRunningOut > $timeOut) {

      $_SESSION['form_success'] = "session_time_out";
      $timeIsOut = 1;
      error_reporting(1);
      // exit;

  } elseif (isset($_POST['update_siswa'])) {

    $nis      = $_POST['nis_siswa'];
    // $nisn   = $_POST['nisn_siswa'];
    $nama     = mysqli_real_escape_string($con , htmlspecialchars($_POST['nama_siswa']));
    // $nama   = htmlspecialchars($_POST['nama_siswa']);
    $alamat   = mysqli_real_escape_string($con, htmlspecialchars($_POST['alamat_siswa']));
    $tl       = date('Y-m-d',strtotime($_POST['tl_siswa']));
    $jns_kl   = htmlspecialchars($_POST['jns_kl']);
    $klsSiswa = htmlspecialchars($_POST['kelas']);
    $dtKlp    = mysqli_real_escape_string($con, htmlspecialchars($_POST['isi_klp']));
    $thnJ     = htmlspecialchars($_POST['_thnjoin']);
    $pggl     = mysqli_real_escape_string($con, htmlspecialchars($_POST['_nmpanggilan']));
    $brtB     = mysqli_real_escape_string($con, htmlspecialchars($_POST['_beratbadan']));
    $tggB     = mysqli_real_escape_string($con, htmlspecialchars($_POST['_tinggibadan']));
    $ukr      = mysqli_real_escape_string($con, htmlspecialchars($_POST['_ukuranbaju']));
    $almtRm   = mysqli_real_escape_string($con, htmlspecialchars($_POST['_alamatrumah']));
    $noTelp   = $_POST['telp_rumah'];
    $noHp     = $_POST['_hp'];
    $email    = mysqli_real_escape_string($con, htmlspecialchars($_POST['_email']));

    // ortu
    $namaAyah  = mysqli_real_escape_string($con, htmlspecialchars($_POST['_nmayah']));
    $pddknAyah = mysqli_real_escape_string($con, htmlspecialchars($_POST['_pendayah']));

    $pkrjnAyah = mysqli_real_escape_string($con, htmlspecialchars($_POST['_pekerjaanayah']));
    if ($pkrjnAyah == 'KS') {
      $pkrjnAyah = "KARYAWAN SWASTA";
    } elseif ($pkrjnAyah == 'LAINNYA') {
      $pkrjnAyah = mysqli_real_escape_string($con, htmlspecialchars($_POST['kerjaLain1']));
    }

    $tmptTglAyah  = mysqli_real_escape_string($con, htmlspecialchars($_POST['_temptglayah']));

    $namaIbu      = mysqli_real_escape_string($con, htmlspecialchars($_POST['_nmibu']));
    $pddknIbu     = mysqli_real_escape_string($con,htmlspecialchars($_POST['_pendibu']));
    // echo "Data Ayah : " . $pddknAyah . "<br>" . "Data Ibu : " . $pddknIbu;exit;

    $pkrjnIbu     = mysqli_real_escape_string($con, htmlspecialchars($_POST['_pekerjaanibu']));
    if ($pkrjnIbu == 'KS') {
      $pkrjnIbu = "KARYAWAN SWASTA";
    } elseif ($pkrjnIbu == 'LAINNYA') {
      $pkrjnIbu = mysqli_real_escape_string($con, htmlspecialchars($_POST['kerjaLain2']));
    }

    $tmptTglIbu   = mysqli_real_escape_string($con, htmlspecialchars($_POST['_temptglibu']));

    if ($klsSiswa == 'KB' || $klsSiswa == 'TKA' || $klsSiswa == 'TKB') {
      $kodeJenjang = "PTK";
    } else {
      $kodeJenjang  = str_replace(["1", "2", "3", "4", "5", "6"], "", $klsSiswa);
    }

    $c_jenjang = str_replace(['PTK'], "TK", $kodeJenjang);

    if ($nis == "" || $nama == "" || $pggl == "" ) {
      $_SESSION['pesan'] = "data_empty";
    } elseif($klsSiswa == "kosong") {
      $_SESSION['pesan'] = "jenjang_pendidikan_empty";
    } else {

      if ($_SESSION['c_accounting'] == 'accounting1') {

        if ($c_jenjang != "TK") {

          $kelas  = str_replace(["1SD", "2SD", "3SD", "4SD", "5SD", "6SD"], ["1 SD", "2 SD", "3 SD", "4 SD", "5 SD", "6 SD"], $klsSiswa);
          // echo $kelas;exit;

          $insertDB1 = mysqli_query($con,"
            UPDATE data_murid_sd 
            set
            Nama                  = '$nama',
            KELAS                 = '$kelas',
            jk                    = '$jns_kl',
            tempat_lahir          = '$alamat',
            tanggal_lahir         = '$tl', 
            tahun_join            = '$thnJ', 
            Panggilan             = '$pggl', 
            KLP                   = '$dtKlp', 
            berat_badan           = '$brtB',
            tinggi_badan          = '$tggB', 
            ukuran_baju           = '$ukr', 
            Alamat                = '$almtRm', 
            telp_rumah            = '$noTelp', 
            HP                    = '$noHp',
            alamat_email          = '$email', 
            nama_ayah             = '$namaAyah', 
            Pendidikan            = '$pddknAyah', 
            Pekerjaan             = '$pkrjnAyah',
            tempat_tanggal_lahir  = '$tmptTglAyah', 
            nama_ibu              = '$namaIbu', 
            Pendidikan1           = '$pddknIbu', 
            Pekerjaan1            = '$pkrjnIbu',
            tempat_tanggal_lahir1 = '$tmptTglIbu', 
            NIS                   = '$nis' 
            WHERE NIS = '$nis'
          ");

          if ($insertDB1) {
            $_SESSION['pesan'] = 'update';
            $sesiForm = 0;
            $dataSiswa          = mysqli_query($con, "
              SELECT 
              *
              FROM data_murid_sd
            ");
          } else {
            echo "gagal";
          }

        }

      } else if ($_SESSION['c_accounting'] == 'accounting2') {

        $kelas  = $klsSiswa;
        // echo $nama;exit;

        $insertDB2 = mysqli_query($con,"
          UPDATE data_murid_tk
          set
          Nama          = '$nama',
          KELAS         = '$kelas',
          jk            = '$jns_kl',
          temlahir      = '$alamat',
          tanglahir     = '$tl', 
          thn_join      = '$thnJ', 
          Panggilan     = '$pggl', 
          KLP           = '$dtKlp', 
          berat_badan   = '$brtB',
          tinggi_badan  = '$tggB', 
          ukuran_baju   = '$ukr', 
          alamat        = '$almtRm', 
          telp_rumah    = '$noTelp', 
          HP            = '$noHp',
          email         = '$email', 
          nama_ayah     = '$namaAyah', 
          pendidikan_a  = '$pddknAyah', 
          pekerjaan_a   = '$pkrjnAyah',
          ttl_a         = '$tmptTglAyah', 
          nama_ibu      = '$namaIbu', 
          pendidikan_i  = '$pddknIbu', 
          pekerjaan_i   = '$pkrjnIbu',
          ttl_i         = '$tmptTglIbu', 
          NIS           = '$nis' 
          WHERE NIS = '$nis'
        ");

        if ($insertDB2) {
          $_SESSION['pesan'] = 'update';
          $sesiForm = 0;
          $dataSiswa          = mysqli_query($con, "
            SELECT
            *
            FROM data_murid_tk
          ");
        } else {
          echo "gagal";
        }

      }
      
    }

  } else if (isset($_POST['editData_Siswa']) ) {

    $sesiForm = 1;

    $nisSiswa     = $_POST['nis_siswa'];
    $namaSiswa    = htmlspecialchars($_POST['nama_siswa']);
    $jkSiswa      = $_POST['jk_siswa'];
    $jenjangSiswa = str_replace([" "],"",$_POST['jenjang_siswa']);
    $klp          = $_POST['klp'];
    $tempLahir    = $_POST['temp_lahir'];
    $tangLahir    = str_replace([" 00:00:00"],"",$_POST['tang_lahir']);
    $thnJoin      = $_POST['taJoin'];
    $nmPnggilan   = $_POST['nama_panggilan'];
    $beratBadan   = $_POST['berat_badan'];
    $tggBadan     = $_POST['tinggi_badan'];
    $ukrBaju      = $_POST['ukuran_baju'];
    $almtRmh      = $_POST['alamat_rmh'];
    $telpRmh      = $_POST['telp_rumah'];
    $no_hp        = str_replace(["'"],"",$_POST['no_hp']);
    $almtEmail    = $_POST['alamat_email'];

    $namaAyah    = $_POST['nama_ayah'];
    $tempLhrAyah = $_POST['ttl_ayah'];
    $pendAyah    = $_POST['pendAyah'];
    $pekAyah     = $_POST['pekerAyah'];

    $namaIbu     = $_POST['nama_ibu'];
    $tempLhrIbu  = $_POST['ttl_ibu'];
    $pendIbu     = $_POST['pendIbu'];
    $pekIbu      = $_POST['pekerIbu'];

  } elseif (isset($_GET['back'])) {

    $sesiForm = 0;

  } elseif (isset($_POST['dataNis'])) {
    echo $_POST['dataNis'];
  }

?>

  <div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

        <?php if(isset($_SESSION['form_kosong']) && $_SESSION['form_kosong'] == 'filter_kosong'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Tidak Ada Filter yang di pilih
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_kosong']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_kosong']) && $_SESSION['form_kosong'] == 'tanggal_awal_lebih_besar'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Tanggal Awal harus lebih dulu dari pada tanggal Akhir
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_kosong']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'session_time_out'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Waktu Sesi Telah Habis
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <?php 
                  unset($_SESSION['form_success']); 
              ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan'] == 'update'){?>
          <div style="display: none;" class="alert alert-warning alert-dismissable"> Data Siswa Berhasil Di Update
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <?php 
                  unset($_SESSION['pesan']); 
              ?>
          </div>
        <?php } ?>

    </div>
  </div>

  <?php  

    $vr=1;

  ?>

  <div class="box box-info">

    <?php if ($sesiForm == 0): ?>

      <div class="box-header with-border">
        <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Edit Data Siswa </h3>
      </div>
      
      <div class="box-body table-responsive">
        <table id="form_edit_siswa" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th style="text-align: center;" width="5%">NO</th>
              <th style="text-align: center;">NIS</th>
              <th style="text-align: center;">NAMA</th>
              <th style="text-align: center;">KELAS</th>
              <th style="text-align: center;">GENDER</th>
              <th style="text-align: center;">TEMPAT/TANGGAL LAHIR</th>
              <th style="text-align: center;" width="25%">ACTION</th>
            </tr>
          </thead>
          <tbody>

            <?php foreach ($dataSiswa as $data): ?>
              <?php if ($_SESSION['c_accounting'] == 'accounting1'): ?>

                <tr>
                  <td style="text-align: center;"> <?= $vr++; ?> </td>
                  <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                  <td style="text-align: center;"> <?= $data['Nama']; ?> </td>
                  <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>
                  <td style="text-align: center;"> <?= ($data['jk'] == 'L') ? "Laki - Laki" : "Perempuan"; ?> </td>
                  <?php if ($data['tanggal_lahir'] == NULL): ?>
                    <td style="text-align: center;"> <strong> - </strong> </td>
                  <?php elseif($data['tempat_lahir'] == NULL && $data['tanggal_lahir'] != NULL): ?>
                    <td style="text-align: center;"> <?= tgl($data['tanggal_lahir']); ?> </td>
                  <?php else: ?>
                    <td style="text-align: center;"> <?= $data['tempat_lahir']; ?>, <?= tgl($data['tanggal_lahir']); ?> </td>
                  <?php endif ?>

                  <td id="button_act">
                    <form action="<?= $baseac; ?>editdatasiswa" method="post">

                      <input type="hidden" name="nis_siswa" value="<?= $data['NIS']; ?>">
                      <input type="hidden" name="nama_siswa" value="<?= $data['Nama']; ?>">
                      <input type="hidden" name="jk_siswa" value="<?= $data['jk']; ?>">
                      <input type="hidden" name="jenjang_siswa" value="<?= $data['KELAS']; ?>">
                      <input type="hidden" name="klp" value="<?= $data['KLP']; ?>">
                      <input type="hidden" name="temp_lahir" value="<?= $data['tempat_lahir']; ?>">
                      <input type="hidden" name="tang_lahir" value="<?= $data['tanggal_lahir']; ?>">
                      <input type="hidden" name="taJoin" value="<?= $data['tahun_join']; ?>">
                      <input type="hidden" name="nama_panggilan" value="<?= $data['Panggilan']; ?>">
                      <input type="hidden" name="berat_badan" value="<?= $data['berat_badan']; ?>">
                      <input type="hidden" name="tinggi_badan" value="<?= $data['tinggi_badan']; ?>">
                      <input type="hidden" name="ukuran_baju" value="<?= $data['ukuran_baju']; ?>">
                      <input type="hidden" name="alamat_rmh" value="<?= $data['Alamat']; ?>">
                      <input type="hidden" name="telp_rumah" value="<?= $data['telp_rumah']; ?>">
                      <input type="hidden" name="no_hp" value="<?= $data['HP']; ?>">
                      <input type="hidden" name="alamat_email" value="<?= $data['alamat_email']; ?>">

                      <input type="hidden" name="nama_ayah" value="<?= $data['nama_ayah']; ?>">
                      <input type="hidden" name="ttl_ayah" value="<?= $data['tempat_tanggal_lahir']; ?>">
                      <input type="hidden" name="pendAyah" value="<?= $data['Pendidikan']; ?>">
                      <input type="hidden" name="pekerAyah" value="<?= $data['Pekerjaan']; ?>">

                      <input type="hidden" name="nama_ibu" value="<?= $data['nama_ibu']; ?>">
                      <input type="hidden" name="ttl_ibu" value="<?= $data['tempat_tanggal_lahir1']; ?>">
                      <input type="hidden" name="pendIbu" value="<?= $data['Pendidikan1']; ?>">
                      <input type="hidden" name="pekerIbu" value="<?= $data['Pekerjaan1']; ?>">

                      <button class="btn btn-sm btn-primary" name="editData_Siswa"> Edit </button>
                    </form>
                    
                  </td>
                </tr>

              <?php elseif($_SESSION['c_accounting'] == 'accounting2'): ?>

                <tr>
                  <td style="text-align: center;"> <?= $vr++; ?> </td>
                  <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                  <td style="text-align: center;"> <?= $data['Nama']; ?> </td>
                  <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>
                  <td style="text-align: center;"> <?= ($data['jk'] == 'L') ? "Laki - Laki" : "Perempuan"; ?> </td>
                  <?php if ($data['tanglahir'] == NULL): ?>
                    <td style="text-align: center;"> <strong> - </strong> </td>
                  <?php elseif($data['temlahir'] == NULL && $data['tanglahir'] != NULL): ?>
                    <td style="text-align: center;"> <?= tgl($data['tanglahir']); ?> </td>
                  <?php else: ?>
                    <td style="text-align: center;"> <?= $data['temlahir']; ?>, <?= tgl($data['tanglahir']); ?> </td>
                  <?php endif ?>

                  <td id="button_act">
                    <form action="<?= $baseac; ?>editdatasiswa" method="post">

                      <input type="hidden" name="nis_siswa" value="<?= $data['NIS']; ?>">
                      <input type="hidden" name="nama_siswa" value="<?= $data['Nama']; ?>">
                      <input type="hidden" name="jk_siswa" value="<?= $data['jk']; ?>">
                      <input type="hidden" name="jenjang_siswa" value="<?= $data['KELAS']; ?>">
                      <input type="hidden" name="klp" value="<?= $data['KLP']; ?>">
                      <input type="hidden" name="temp_lahir" value="<?= $data['temlahir']; ?>">
                      <input type="hidden" name="tang_lahir" value="<?= $data['tanglahir']; ?>">
                      <input type="hidden" name="taJoin" value="<?= $data['thn_join']; ?>">
                      <input type="hidden" name="nama_panggilan" value="<?= $data['Panggilan']; ?>">
                      <input type="hidden" name="berat_badan" value="<?= $data['berat_badan']; ?>">
                      <input type="hidden" name="tinggi_badan" value="<?= $data['tinggi_badan']; ?>">
                      <input type="hidden" name="ukuran_baju" value="<?= $data['ukuran_baju']; ?>">
                      <input type="hidden" name="alamat_rmh" value="<?= $data['Alamat']; ?>">
                      <input type="hidden" name="telp_rumah" value="<?= $data['telp_rumah']; ?>">
                      <input type="hidden" name="no_hp" value="<?= $data['HP']; ?>">
                      <input type="hidden" name="alamat_email" value="<?= $data['email']; ?>">

                      <input type="hidden" name="nama_ayah" value="<?= $data['nama_ayah']; ?>">
                      <input type="hidden" name="ttl_ayah" value="<?= $data['ttl_a']; ?>">
                      <input type="hidden" name="pendAyah" value="<?= $data['pendidikan_a']; ?>">
                      <input type="hidden" name="pekerAyah" value="<?= $data['pekerjaan_a']; ?>">

                      <input type="hidden" name="nama_ibu" value="<?= $data['nama_ibu']; ?>">
                      <input type="hidden" name="ttl_ibu" value="<?= $data['ttl_i']; ?>">
                      <input type="hidden" name="pendIbu" value="<?= $data['pendidikan_i']; ?>">
                      <input type="hidden" name="pekerIbu" value="<?= $data['pekerjaan_i']; ?>">

                      <button class="btn btn-sm btn-primary" name="editData_Siswa"> Edit </button>
                    </form>

                  </td>
                </tr>

              <?php endif; ?>

            <?php endforeach; ?>

          </tbody>
        </table>
      </div>

    <?php elseif($sesiForm == 1): ?>
        
      <?php if($jenjangSiswa == 'KB'): ?>

        <div class="box-header with-border">
          <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Edit Data Siswa <?= $namaSiswa; ?> </h3>
        </div>
        
        <form role="form" method="post" action="editdatasiswa">
          <input type="hidden" name="c_kelas" value="">
            <div class="box-body">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>NIS<sup style="color: red; font-size: 10px;">*</sup></label>
                    <input type="text" readonly value="<?= $nisSiswa; ?>" name="nis_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>NAMA LENGKAP</label>
                    <input type="text" value="<?= $namaSiswa; ?>" name="nama_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENIS KELAMIN</label>
                    <select class="form-control form-select" name="jns_kl">
                      <option value="kosong"> -- PILIH -- </option>
                      <?php foreach ($jenis_kelamin as $jk): ?>
                        <?php if ($jk == "L"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Laki - Laki </option>
                        <?php elseif($jk == "P"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Perempuan </option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                    
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENJANG PENDIDIKAN</label>
                    <select class="form-control form-select" id="kelas" name="kelas">

                      <?php if ($jenjangSiswa != 'LULUS'): ?>

                        <option value="kosong"> -- PILIH -- </option>

                        <?php foreach ($jenjangOpt as $data): ?>
                          <option value="<?= str_replace([" "],"",$data); ?>" <?= (str_replace([" "],"",$data) == $jenjangSiswa) ? 'selected="selected"' : '' ; ?> > <?= $data; ?> </option>
                        <?php endforeach ?>

                      <?php elseif($jenjangSiswa == 'LULUS'): ?>
                        <option value="" > LULUS </option>
                      <?php endif ?>
                      
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>KELOMPOK</label>
                    <input type="text" value="<?= $klp; ?>" name="isi_klp" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>ALAMAT LAHIR</label>
                    <input type="text" name="alamat_siswa" value="<?= $tempLahir; ?>" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>TANGGAL LAHIR</label>
                    <div class="controls input-append date form_date" data-date-format="dd MM yyyy">
                        <input class="form-control" type="text" name="tl_siswa" value="<?= $tangLahir; ?>">
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tahun Join</label>
                        <input type="text" value="<?= $thnJoin; ?>" class="form-control" id="_thnjoin" name="_thnjoin" >
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" class="form-control" value="<?= $nmPnggilan; ?>" id="_nmpanggilan" name="_nmpanggilan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Berat Badan</label>
                        <input type="text" class="form-control" value="<?= $beratBadan; ?>" id="_beratbadan" name="_beratbadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tinggi Badan</label>
                        <input type="text" class="form-control" value="<?= $tggBadan; ?>" id="_tinggibadan" name="_tinggibadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Ukuran Baju</label>
                        <input type="text" class="form-control" value="<?= $ukrBaju; ?>" id="_ukuranbaju" name="_ukuranbaju">
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="_alamatrumah" id="_alamatrumah">
                          <?= $almtRmh; ?>
                        </textarea>
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>Telp.</label>
                        <input type="text" class="form-control" value="<?= $telpRmh; ?>" id="_telp" name="telp_rumah">
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>HP</label>
                        <input type="text" class="form-control" value="<?= $no_hp; ?>" id="_hp" name="_hp">
                    </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="<?= $almtEmail; ?>" id="_email" name="_email" >
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">

                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ayah</h3>
                    </div>

                    <div class="box-body">
                      <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                                <label>Nama Ayah</label>
                                <input type="text" class="form-control" value="<?= $namaAyah; ?>" id="_nmayah" name="_nmayah" >
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tempat Tgl Lahir. Ayah</label>
                                <input type="text" class="form-control" value="<?= $tempLhrAyah; ?>" id="_temptglayah" name="_temptglayah">
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <label>Pend. Ayah</label>
                                <input type="text" name="_pendayah" class="form-control" value="<?= $pendAyah; ?>">
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Pekerjaan Ayah</label>
                              <input type="text" class="form-control" name="_pekerjaanayah" value="<?= $pekAyah; ?>">
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ibu</h3>
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="col-sm-3">
                          <div class="form-group">
                              <label>Nama Ibu</label>
                              <input type="text" class="form-control" id="_nmibu" name="_nmibu" value="<?= $namaIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Tempat Tgl Lahir. Ibu</label>
                              <input type="text" class="form-control" id="_temptglibu" name="_temptglibu" value="<?= $tempLhrIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-5">
                          <div class="form-group">
                              <label>Pend. Ibu</label>
                              <input type="text" name="_pendibu" class="form-control" value="<?= $pendIbu; ?>">
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-sm-4">
                          <div class="form-group">
                            <label>Pekerjaan Ibu</label>
                            <input type="text" name="_pekerjaanibu" class="form-control" value="<?= $pekIbu; ?>">
                          </div>
                        </div>

                      </div>
                    </div>  
                  </div>
                </div>
              </div>
              
            </div>

            <div class="box-footer" id="button_form_edit">
              <button type="submit" name="update_siswa" id="btnSimpan" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan Siswa </button>

        </form>  

        <form action="editdatasiswa" method="POST">
          <button type="submit" name="back" id="btnSimpan" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-log-out" id="cancel"></i> Kembali </button>
        </form>

      <?php elseif($jenjangSiswa == 'TKA'): ?>

        <div class="box-header with-border">
          <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Edit Data Siswa <?= $namaSiswa; ?> </h3>
        </div>
        
        <form role="form" method="post" action="editdatasiswa">
          <input type="hidden" name="c_kelas" value="">
            <div class="box-body">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>NIS<sup style="color: red; font-size: 10px;">*</sup></label>
                    <input type="text" readonly value="<?= $nisSiswa; ?>" name="nis_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>NAMA LENGKAP</label>
                    <input type="text" value="<?= $namaSiswa; ?>" name="nama_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENIS KELAMIN</label>
                    <select class="form-control form-select" name="jns_kl">
                      <option value="kosong"> -- PILIH -- </option>
                      <?php foreach ($jenis_kelamin as $jk): ?>
                        <?php if ($jk == "L"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Laki - Laki </option>
                        <?php elseif($jk == "P"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Perempuan </option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                    
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENJANG PENDIDIKAN</label>
                    <select class="form-control form-select" id="kelas" name="kelas">

                      <?php if ($jenjangSiswa != 'LULUS'): ?>

                        <option value="kosong"> -- PILIH -- </option>

                        <?php foreach ($jenjangOpt as $data): ?>
                          <option value="<?= str_replace([" "],"",$data); ?>" <?= (str_replace([" "],"",$data) == $jenjangSiswa) ? 'selected="selected"' : '' ; ?> > <?= $data; ?> </option>
                        <?php endforeach ?>

                      <?php elseif($jenjangSiswa == 'LULUS'): ?>
                        <option value="" > LULUS </option>
                      <?php endif ?>
                      
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>KELOMPOK</label>
                    <input type="text" value="<?= $klp; ?>" name="isi_klp" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>ALAMAT LAHIR</label>
                    <input type="text" name="alamat_siswa" value="<?= $tempLahir; ?>" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>TANGGAL LAHIR</label>
                    <div class="controls input-append date form_date" data-date-format="dd MM yyyy">
                        <input class="form-control" type="text" name="tl_siswa" value="<?= $tangLahir; ?>">
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tahun Join</label>
                        <input type="text" value="<?= $thnJoin; ?>" class="form-control" id="_thnjoin" name="_thnjoin" >
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" class="form-control" value="<?= $nmPnggilan; ?>" id="_nmpanggilan" name="_nmpanggilan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Berat Badan</label>
                        <input type="text" class="form-control" value="<?= $beratBadan; ?>" id="_beratbadan" name="_beratbadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tinggi Badan</label>
                        <input type="text" class="form-control" value="<?= $tggBadan; ?>" id="_tinggibadan" name="_tinggibadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Ukuran Baju</label>
                        <input type="text" class="form-control" value="<?= $ukrBaju; ?>" id="_ukuranbaju" name="_ukuranbaju">
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="_alamatrumah" id="_alamatrumah">
                          <?= $almtRmh; ?>
                        </textarea>
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>Telp.</label>
                        <input type="text" class="form-control" value="<?= $telpRmh; ?>" id="_telp" name="telp_rumah">
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>HP</label>
                        <input type="text" class="form-control" value="<?= $no_hp; ?>" id="_hp" name="_hp">
                    </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="<?= $almtEmail; ?>" id="_email" name="_email" >
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">

                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ayah</h3>
                    </div>

                    <div class="box-body">
                      <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                                <label>Nama Ayah</label>
                                <input type="text" class="form-control" value="<?= $namaAyah; ?>" id="_nmayah" name="_nmayah" >
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tempat Tgl Lahir. Ayah</label>
                                <input type="text" class="form-control" value="<?= $tempLhrAyah; ?>" id="_temptglayah" name="_temptglayah">
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <label>Pend. Ayah</label>
                                <input type="text" name="_pendayah" class="form-control" value="<?= $pendAyah; ?>">
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Pekerjaan Ayah</label>
                              <input type="text" class="form-control" name="_pekerjaanayah" value="<?= $pekAyah; ?>">
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ibu</h3>
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="col-sm-3">
                          <div class="form-group">
                              <label>Nama Ibu</label>
                              <input type="text" class="form-control" id="_nmibu" name="_nmibu" value="<?= $namaIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Tempat Tgl Lahir. Ibu</label>
                              <input type="text" class="form-control" id="_temptglibu" name="_temptglibu" value="<?= $tempLhrIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-5">
                          <div class="form-group">
                              <label>Pend. Ibu</label>
                              <input type="text" name="_pendibu" class="form-control" value="<?= $pendIbu; ?>">
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-sm-4">
                          <div class="form-group">
                            <label>Pekerjaan Ibu</label>
                            <input type="text" name="_pekerjaanibu" class="form-control" value="<?= $pekIbu; ?>">
                          </div>
                        </div>

                      </div>
                    </div>  
                  </div>
                </div>
              </div>
              
            </div>

            <div class="box-footer" id="button_form_edit">
              <button type="submit" name="update_siswa" id="btnSimpan" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan Siswa </button>

        </form>  

        <form action="editdatasiswa" method="POST">
          <button type="submit" name="back" id="btnSimpan" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-log-out" id="cancel"></i> Kembali </button>
        </form>

      <?php elseif($jenjangSiswa == 'TKB'): ?>

        <div class="box-header with-border">
          <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Edit Data Siswa <?= $namaSiswa; ?> </h3>
        </div>
        
        <form role="form" method="post" action="editdatasiswa">
          <input type="hidden" name="c_kelas" value="">
            <div class="box-body">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>NIS<sup style="color: red; font-size: 10px;">*</sup></label>
                    <input type="text" readonly value="<?= $nisSiswa; ?>" name="nis_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>NAMA LENGKAP</label>
                    <input type="text" value="<?= $namaSiswa; ?>" name="nama_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENIS KELAMIN</label>
                    <select class="form-control form-select" name="jns_kl">
                      <option value="kosong"> -- PILIH -- </option>
                      <?php foreach ($jenis_kelamin as $jk): ?>
                        <?php if ($jk == "L"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Laki - Laki </option>
                        <?php elseif($jk == "P"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Perempuan </option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                    
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENJANG PENDIDIKAN</label>
                    <select class="form-control form-select" id="kelas" name="kelas">

                      <?php if ($jenjangSiswa != 'LULUS'): ?>

                        <option value="kosong"> -- PILIH -- </option>

                        <?php foreach ($jenjangOpt as $data): ?>
                          <option value="<?= str_replace([" "],"",$data); ?>" <?= (str_replace([" "],"",$data) == $jenjangSiswa) ? 'selected="selected"' : '' ; ?> > <?= $data; ?> </option>
                        <?php endforeach ?>

                      <?php elseif($jenjangSiswa == 'LULUS'): ?>
                        <option value="" > LULUS </option>
                      <?php endif ?>
                      
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>KELOMPOK</label>
                    <input type="text" value="<?= $klp; ?>" name="isi_klp" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>ALAMAT LAHIR</label>
                    <input type="text" name="alamat_siswa" value="<?= $tempLahir; ?>" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>TANGGAL LAHIR</label>
                    <div class="controls input-append date form_date" data-date-format="dd MM yyyy">
                        <input class="form-control" type="text" name="tl_siswa" value="<?= $tangLahir; ?>">
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tahun Join</label>
                        <input type="text" value="<?= $thnJoin; ?>" class="form-control" id="_thnjoin" name="_thnjoin" >
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" class="form-control" value="<?= $nmPnggilan; ?>" id="_nmpanggilan" name="_nmpanggilan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Berat Badan</label>
                        <input type="text" class="form-control" value="<?= $beratBadan; ?>" id="_beratbadan" name="_beratbadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tinggi Badan</label>
                        <input type="text" class="form-control" value="<?= $tggBadan; ?>" id="_tinggibadan" name="_tinggibadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Ukuran Baju</label>
                        <input type="text" class="form-control" value="<?= $ukrBaju; ?>" id="_ukuranbaju" name="_ukuranbaju">
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="_alamatrumah" id="_alamatrumah">
                          <?= $almtRmh; ?>
                        </textarea>
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>Telp.</label>
                        <input type="text" class="form-control" value="<?= $telpRmh; ?>" id="_telp" name="telp_rumah">
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>HP</label>
                        <input type="text" class="form-control" value="<?= $no_hp; ?>" id="_hp" name="_hp">
                    </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="<?= $almtEmail; ?>" id="_email" name="_email" >
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">

                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ayah</h3>
                    </div>

                    <div class="box-body">
                      <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                                <label>Nama Ayah</label>
                                <input type="text" class="form-control" value="<?= $namaAyah; ?>" id="_nmayah" name="_nmayah" >
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tempat Tgl Lahir. Ayah</label>
                                <input type="text" class="form-control" value="<?= $tempLhrAyah; ?>" id="_temptglayah" name="_temptglayah">
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <label>Pend. Ayah</label>
                                <input type="text" name="_pendayah" class="form-control" value="<?= $pendAyah; ?>">
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Pekerjaan Ayah</label>
                              <input type="text" class="form-control" name="_pekerjaanayah" value="<?= $pekAyah; ?>">
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ibu</h3>
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="col-sm-3">
                          <div class="form-group">
                              <label>Nama Ibu</label>
                              <input type="text" class="form-control" id="_nmibu" name="_nmibu" value="<?= $namaIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Tempat Tgl Lahir. Ibu</label>
                              <input type="text" class="form-control" id="_temptglibu" name="_temptglibu" value="<?= $tempLhrIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-5">
                          <div class="form-group">
                              <label>Pend. Ibu</label>
                              <input type="text" name="_pendibu" class="form-control" value="<?= $pendIbu; ?>">
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-sm-4">
                          <div class="form-group">
                            <label>Pekerjaan Ibu</label>
                            <input type="text" name="_pekerjaanibu" class="form-control" value="<?= $pekIbu; ?>">
                          </div>
                        </div>

                      </div>
                    </div>  
                  </div>
                </div>
              </div>
              
            </div>

            <div class="box-footer" id="button_form_edit">
              <button type="submit" name="update_siswa" id="btnSimpan" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan Siswa </button>

        </form>  

        <form action="editdatasiswa" method="POST">
          <button type="submit" name="back" id="btnSimpan" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-log-out" id="cancel"></i> Kembali </button>
        </form>

      <?php elseif($jenjangSiswa == '1SD'): ?>

        <div class="box-header with-border">
          <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Edit Data Siswa <?= $namaSiswa; ?> </h3>
        </div>
        
        <form role="form" method="post" action="editdatasiswa">
          <input type="hidden" name="c_kelas" value="">
            <div class="box-body">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>NIS<sup style="color: red; font-size: 10px;">*</sup></label>
                    <input type="text" readonly value="<?= $nisSiswa; ?>" name="nis_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>NAMA LENGKAP</label>
                    <input type="text" value="<?= $namaSiswa; ?>" name="nama_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENIS KELAMIN</label>
                    <select class="form-control form-select" name="jns_kl">
                      <option value="kosong"> -- PILIH -- </option>
                      <?php foreach ($jenis_kelamin as $jk): ?>
                        <?php if ($jk == "L"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Laki - Laki </option>
                        <?php elseif($jk == "P"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Perempuan </option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                    
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENJANG PENDIDIKAN</label>
                    <select class="form-control form-select" id="kelas" name="kelas">

                      <?php if ($jenjangSiswa != 'LULUS'): ?>

                        <option value="kosong"> -- PILIH -- </option>

                        <?php foreach ($jenjangOpt as $data): ?>
                          <option value="<?= str_replace([" "],"",$data); ?>" <?= (str_replace([" "],"",$data) == $jenjangSiswa) ? 'selected="selected"' : '' ; ?> > <?= $data; ?> </option>
                        <?php endforeach ?>

                      <?php elseif($jenjangSiswa == 'LULUS'): ?>
                        <option value="" > LULUS </option>
                      <?php endif ?>
                      
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>KELOMPOK</label>
                    <input type="text" value="<?= $klp; ?>" name="isi_klp" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>ALAMAT LAHIR</label>
                    <input type="text" name="alamat_siswa" value="<?= $tempLahir; ?>" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>TANGGAL LAHIR</label>
                    <div class="controls input-append date form_date" data-date-format="dd MM yyyy">
                        <input class="form-control" type="text" name="tl_siswa" value="<?= $tangLahir; ?>">
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tahun Join</label>
                        <input type="text" value="<?= $thnJoin; ?>" class="form-control" id="_thnjoin" name="_thnjoin" >
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" class="form-control" value="<?= $nmPnggilan; ?>" id="_nmpanggilan" name="_nmpanggilan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Berat Badan</label>
                        <input type="text" class="form-control" value="<?= $beratBadan; ?>" id="_beratbadan" name="_beratbadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tinggi Badan</label>
                        <input type="text" class="form-control" value="<?= $tggBadan; ?>" id="_tinggibadan" name="_tinggibadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Ukuran Baju</label>
                        <input type="text" class="form-control" value="<?= $ukrBaju; ?>" id="_ukuranbaju" name="_ukuranbaju">
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="_alamatrumah" id="_alamatrumah">
                          <?= $almtRmh; ?>
                        </textarea>
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>Telp.</label>
                        <input type="text" class="form-control" value="<?= $telpRmh; ?>" id="_telp" name="telp_rumah">
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>HP</label>
                        <input type="text" class="form-control" value="<?= $no_hp; ?>" id="_hp" name="_hp">
                    </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="<?= $almtEmail; ?>" id="_email" name="_email" >
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">

                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ayah</h3>
                    </div>

                    <div class="box-body">
                      <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                                <label>Nama Ayah</label>
                                <input type="text" class="form-control" value="<?= $namaAyah; ?>" id="_nmayah" name="_nmayah" >
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tempat Tgl Lahir. Ayah</label>
                                <input type="text" class="form-control" value="<?= $tempLhrAyah; ?>" id="_temptglayah" name="_temptglayah">
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <label>Pend. Ayah</label>
                                <input type="text" name="_pendayah" class="form-control" value="<?= $pendAyah; ?>">
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Pekerjaan Ayah</label>
                              <input type="text" class="form-control" name="_pekerjaanayah" value="<?= $pekAyah; ?>">
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ibu</h3>
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="col-sm-3">
                          <div class="form-group">
                              <label>Nama Ibu</label>
                              <input type="text" class="form-control" id="_nmibu" name="_nmibu" value="<?= $namaIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Tempat Tgl Lahir. Ibu</label>
                              <input type="text" class="form-control" id="_temptglibu" name="_temptglibu" value="<?= $tempLhrIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-5">
                          <div class="form-group">
                              <label>Pend. Ibu</label>
                              <input type="text" name="_pendibu" class="form-control" value="<?= $pendIbu; ?>">
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-sm-4">
                          <div class="form-group">
                            <label>Pekerjaan Ibu</label>
                            <input type="text" name="_pekerjaanibu" class="form-control" value="<?= $pekIbu; ?>">
                          </div>
                        </div>

                      </div>
                    </div>  
                  </div>
                </div>
              </div>
              
            </div>

            <div class="box-footer" id="button_form_edit">
              <button type="submit" name="update_siswa" id="btnSimpan" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan Siswa </button>

        </form>  

        <form action="editdatasiswa" method="POST">
          <button type="submit" name="back" id="btnSimpan" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-log-out" id="cancel"></i> Kembali </button>
        </form>

      <?php elseif($jenjangSiswa == '2SD'): ?>
        
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Edit Data Siswa <?= $namaSiswa; ?> </h3>
        </div>
        
        <form role="form" method="post" action="editdatasiswa">
          <input type="hidden" name="c_kelas" value="">
            <div class="box-body">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>NIS<sup style="color: red; font-size: 10px;">*</sup></label>
                    <input type="text" readonly value="<?= $nisSiswa; ?>" name="nis_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>NAMA LENGKAP</label>
                    <input type="text" value="<?= $namaSiswa; ?>" name="nama_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENIS KELAMIN</label>
                    <select class="form-control form-select" name="jns_kl">
                      <option value="kosong"> -- PILIH -- </option>
                      <?php foreach ($jenis_kelamin as $jk): ?>
                        <?php if ($jk == "L"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Laki - Laki </option>
                        <?php elseif($jk == "P"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Perempuan </option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                    
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENJANG PENDIDIKAN</label>
                    <select class="form-control form-select" id="kelas" name="kelas">

                      <?php if ($jenjangSiswa != 'LULUS'): ?>

                        <option value="kosong"> -- PILIH -- </option>

                        <?php foreach ($jenjangOpt as $data): ?>
                          <option value="<?= str_replace([" "],"",$data); ?>" <?= (str_replace([" "],"",$data) == $jenjangSiswa) ? 'selected="selected"' : '' ; ?> > <?= $data; ?> </option>
                        <?php endforeach ?>

                      <?php elseif($jenjangSiswa == 'LULUS'): ?>
                        <option value="" > LULUS </option>
                      <?php endif ?>
                      
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>KELOMPOK</label>
                    <input type="text" value="<?= $klp; ?>" name="isi_klp" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>ALAMAT LAHIR</label>
                    <input type="text" name="alamat_siswa" value="<?= $tempLahir; ?>" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>TANGGAL LAHIR</label>
                    <div class="controls input-append date form_date" data-date-format="dd MM yyyy">
                        <input class="form-control" type="text" name="tl_siswa" value="<?= $tangLahir; ?>">
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tahun Join</label>
                        <input type="text" value="<?= $thnJoin; ?>" class="form-control" id="_thnjoin" name="_thnjoin" >
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" class="form-control" value="<?= $nmPnggilan; ?>" id="_nmpanggilan" name="_nmpanggilan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Berat Badan</label>
                        <input type="text" class="form-control" value="<?= $beratBadan; ?>" id="_beratbadan" name="_beratbadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tinggi Badan</label>
                        <input type="text" class="form-control" value="<?= $tggBadan; ?>" id="_tinggibadan" name="_tinggibadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Ukuran Baju</label>
                        <input type="text" class="form-control" value="<?= $ukrBaju; ?>" id="_ukuranbaju" name="_ukuranbaju">
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="_alamatrumah" id="_alamatrumah">
                          <?= $almtRmh; ?>
                        </textarea>
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>Telp.</label>
                        <input type="text" class="form-control" value="<?= $telpRmh; ?>" id="_telp" name="telp_rumah">
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>HP</label>
                        <input type="text" class="form-control" value="<?= $no_hp; ?>" id="_hp" name="_hp">
                    </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="<?= $almtEmail; ?>" id="_email" name="_email" >
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">

                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ayah</h3>
                    </div>

                    <div class="box-body">
                      <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                                <label>Nama Ayah</label>
                                <input type="text" class="form-control" value="<?= $namaAyah; ?>" id="_nmayah" name="_nmayah" >
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tempat Tgl Lahir. Ayah</label>
                                <input type="text" class="form-control" value="<?= $tempLhrAyah; ?>" id="_temptglayah" name="_temptglayah">
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <label>Pend. Ayah</label>
                                <input type="text" name="_pendayah" class="form-control" value="<?= $pendAyah; ?>">
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Pekerjaan Ayah</label>
                              <input type="text" class="form-control" name="_pekerjaanayah" value="<?= $pekAyah; ?>">
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ibu</h3>
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="col-sm-3">
                          <div class="form-group">
                              <label>Nama Ibu</label>
                              <input type="text" class="form-control" id="_nmibu" name="_nmibu" value="<?= $namaIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Tempat Tgl Lahir. Ibu</label>
                              <input type="text" class="form-control" id="_temptglibu" name="_temptglibu" value="<?= $tempLhrIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-5">
                          <div class="form-group">
                              <label>Pend. Ibu</label>
                              <input type="text" name="_pendibu" class="form-control" value="<?= $pendIbu; ?>">
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-sm-4">
                          <div class="form-group">
                            <label>Pekerjaan Ibu</label>
                            <input type="text" name="_pekerjaanibu" class="form-control" value="<?= $pekIbu; ?>">
                          </div>
                        </div>

                      </div>
                    </div>  
                  </div>
                </div>
              </div>
              
            </div>

            <div class="box-footer" id="button_form_edit">
              <button type="submit" name="update_siswa" id="btnSimpan" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan Siswa </button>

        </form>  

        <form action="editdatasiswa" method="POST">
          <button type="submit" name="back" id="btnSimpan" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-log-out" id="cancel"></i> Kembali </button>
        </form>

      <?php elseif($jenjangSiswa == '3SD'): ?>
        
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Edit Data Siswa <?= $namaSiswa; ?> </h3>
        </div>
        
        <form role="form" method="post" action="editdatasiswa">
          <input type="hidden" name="c_kelas" value="">
            <div class="box-body">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>NIS<sup style="color: red; font-size: 10px;">*</sup></label>
                    <input type="text" readonly value="<?= $nisSiswa; ?>" name="nis_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>NAMA LENGKAP</label>
                    <input type="text" value="<?= $namaSiswa; ?>" name="nama_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENIS KELAMIN</label>
                    <select class="form-control form-select" name="jns_kl">
                      <option value="kosong"> -- PILIH -- </option>
                      <?php foreach ($jenis_kelamin as $jk): ?>
                        <?php if ($jk == "L"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Laki - Laki </option>
                        <?php elseif($jk == "P"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Perempuan </option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                    
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENJANG PENDIDIKAN</label>
                    <select class="form-control form-select" id="kelas" name="kelas">

                      <?php if ($jenjangSiswa != 'LULUS'): ?>

                        <option value="kosong"> -- PILIH -- </option>

                        <?php foreach ($jenjangOpt as $data): ?>
                          <option value="<?= str_replace([" "],"",$data); ?>" <?= (str_replace([" "],"",$data) == $jenjangSiswa) ? 'selected="selected"' : '' ; ?> > <?= $data; ?> </option>
                        <?php endforeach ?>

                      <?php elseif($jenjangSiswa == 'LULUS'): ?>
                        <option value="" > LULUS </option>
                      <?php endif ?>
                      
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>KELOMPOK</label>
                    <input type="text" value="<?= $klp; ?>" name="isi_klp" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>ALAMAT LAHIR</label>
                    <input type="text" name="alamat_siswa" value="<?= $tempLahir; ?>" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>TANGGAL LAHIR</label>
                    <div class="controls input-append date form_date" data-date-format="dd MM yyyy">
                        <input class="form-control" type="text" name="tl_siswa" value="<?= $tangLahir; ?>">
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tahun Join</label>
                        <input type="text" value="<?= $thnJoin; ?>" class="form-control" id="_thnjoin" name="_thnjoin" >
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" class="form-control" value="<?= $nmPnggilan; ?>" id="_nmpanggilan" name="_nmpanggilan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Berat Badan</label>
                        <input type="text" class="form-control" value="<?= $beratBadan; ?>" id="_beratbadan" name="_beratbadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tinggi Badan</label>
                        <input type="text" class="form-control" value="<?= $tggBadan; ?>" id="_tinggibadan" name="_tinggibadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Ukuran Baju</label>
                        <input type="text" class="form-control" value="<?= $ukrBaju; ?>" id="_ukuranbaju" name="_ukuranbaju">
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="_alamatrumah" id="_alamatrumah">
                          <?= $almtRmh; ?>
                        </textarea>
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>Telp.</label>
                        <input type="text" class="form-control" value="<?= $telpRmh; ?>" id="_telp" name="telp_rumah">
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>HP</label>
                        <input type="text" class="form-control" value="<?= $no_hp; ?>" id="_hp" name="_hp">
                    </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="<?= $almtEmail; ?>" id="_email" name="_email" >
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">

                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ayah</h3>
                    </div>

                    <div class="box-body">
                      <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                                <label>Nama Ayah</label>
                                <input type="text" class="form-control" value="<?= $namaAyah; ?>" id="_nmayah" name="_nmayah" >
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tempat Tgl Lahir. Ayah</label>
                                <input type="text" class="form-control" value="<?= $tempLhrAyah; ?>" id="_temptglayah" name="_temptglayah">
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <label>Pend. Ayah</label>
                                <input type="text" name="_pendayah" class="form-control" value="<?= $pendAyah; ?>">
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Pekerjaan Ayah</label>
                              <input type="text" class="form-control" name="_pekerjaanayah" value="<?= $pekAyah; ?>">
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ibu</h3>
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="col-sm-3">
                          <div class="form-group">
                              <label>Nama Ibu</label>
                              <input type="text" class="form-control" id="_nmibu" name="_nmibu" value="<?= $namaIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Tempat Tgl Lahir. Ibu</label>
                              <input type="text" class="form-control" id="_temptglibu" name="_temptglibu" value="<?= $tempLhrIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-5">
                          <div class="form-group">
                              <label>Pend. Ibu</label>
                              <input type="text" name="_pendibu" class="form-control" value="<?= $pendIbu; ?>">
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-sm-4">
                          <div class="form-group">
                            <label>Pekerjaan Ibu</label>
                            <input type="text" name="_pekerjaanibu" class="form-control" value="<?= $pekIbu; ?>">
                          </div>
                        </div>

                      </div>
                    </div>  
                  </div>
                </div>
              </div>
              
            </div>

            <div class="box-footer" id="button_form_edit">
              <button type="submit" name="update_siswa" id="btnSimpan" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan Siswa </button>

        </form>  

        <form action="editdatasiswa" method="POST">
          <button type="submit" name="back" id="btnSimpan" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-log-out" id="cancel"></i> Kembali </button>
        </form>

      <?php elseif($jenjangSiswa == '4SD'): ?>
        
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Edit Data Siswa <?= $namaSiswa; ?> </h3>
        </div>
        
        <form role="form" method="post" action="editdatasiswa">
          <input type="hidden" name="c_kelas" value="">
            <div class="box-body">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>NIS<sup style="color: red; font-size: 10px;">*</sup></label>
                    <input type="text" readonly value="<?= $nisSiswa; ?>" name="nis_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>NAMA LENGKAP</label>
                    <input type="text" value="<?= $namaSiswa; ?>" name="nama_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENIS KELAMIN</label>
                    <select class="form-control form-select" name="jns_kl">
                      <option value="kosong"> -- PILIH -- </option>
                      <?php foreach ($jenis_kelamin as $jk): ?>
                        <?php if ($jk == "L"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Laki - Laki </option>
                        <?php elseif($jk == "P"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Perempuan </option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                    
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENJANG PENDIDIKAN</label>
                    <select class="form-control form-select" id="kelas" name="kelas">

                      <?php if ($jenjangSiswa != 'LULUS'): ?>

                        <option value="kosong"> -- PILIH -- </option>

                        <?php foreach ($jenjangOpt as $data): ?>
                          <option value="<?= str_replace([" "],"",$data); ?>" <?= (str_replace([" "],"",$data) == $jenjangSiswa) ? 'selected="selected"' : '' ; ?> > <?= $data; ?> </option>
                        <?php endforeach ?>

                      <?php elseif($jenjangSiswa == 'LULUS'): ?>
                        <option value="" > LULUS </option>
                      <?php endif ?>
                      
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>KELOMPOK</label>
                    <input type="text" value="<?= $klp; ?>" name="isi_klp" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>ALAMAT LAHIR</label>
                    <input type="text" name="alamat_siswa" value="<?= $tempLahir; ?>" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>TANGGAL LAHIR</label>
                    <div class="controls input-append date form_date" data-date-format="dd MM yyyy">
                        <input class="form-control" type="text" name="tl_siswa" value="<?= $tangLahir; ?>">
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tahun Join</label>
                        <input type="text" value="<?= $thnJoin; ?>" class="form-control" id="_thnjoin" name="_thnjoin" >
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" class="form-control" value="<?= $nmPnggilan; ?>" id="_nmpanggilan" name="_nmpanggilan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Berat Badan</label>
                        <input type="text" class="form-control" value="<?= $beratBadan; ?>" id="_beratbadan" name="_beratbadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tinggi Badan</label>
                        <input type="text" class="form-control" value="<?= $tggBadan; ?>" id="_tinggibadan" name="_tinggibadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Ukuran Baju</label>
                        <input type="text" class="form-control" value="<?= $ukrBaju; ?>" id="_ukuranbaju" name="_ukuranbaju">
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="_alamatrumah" id="_alamatrumah">
                          <?= $almtRmh; ?>
                        </textarea>
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>Telp.</label>
                        <input type="text" class="form-control" value="<?= $telpRmh; ?>" id="_telp" name="telp_rumah">
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>HP</label>
                        <input type="text" class="form-control" value="<?= $no_hp; ?>" id="_hp" name="_hp">
                    </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="<?= $almtEmail; ?>" id="_email" name="_email" >
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">

                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ayah</h3>
                    </div>

                    <div class="box-body">
                      <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                                <label>Nama Ayah</label>
                                <input type="text" class="form-control" value="<?= $namaAyah; ?>" id="_nmayah" name="_nmayah" >
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tempat Tgl Lahir. Ayah</label>
                                <input type="text" class="form-control" value="<?= $tempLhrAyah; ?>" id="_temptglayah" name="_temptglayah">
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <label>Pend. Ayah</label>
                                <input type="text" name="_pendayah" class="form-control" value="<?= $pendAyah; ?>">
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Pekerjaan Ayah</label>
                              <input type="text" class="form-control" name="_pekerjaanayah" value="<?= $pekAyah; ?>">
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ibu</h3>
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="col-sm-3">
                          <div class="form-group">
                              <label>Nama Ibu</label>
                              <input type="text" class="form-control" id="_nmibu" name="_nmibu" value="<?= $namaIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Tempat Tgl Lahir. Ibu</label>
                              <input type="text" class="form-control" id="_temptglibu" name="_temptglibu" value="<?= $tempLhrIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-5">
                          <div class="form-group">
                              <label>Pend. Ibu</label>
                              <input type="text" name="_pendibu" class="form-control" value="<?= $pendIbu; ?>">
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-sm-4">
                          <div class="form-group">
                            <label>Pekerjaan Ibu</label>
                            <input type="text" name="_pekerjaanibu" class="form-control" value="<?= $pekIbu; ?>">
                          </div>
                        </div>

                      </div>
                    </div>  
                  </div>
                </div>
              </div>
              
            </div>

            <div class="box-footer" id="button_form_edit">
              <button type="submit" name="update_siswa" id="btnSimpan" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan Siswa </button>

        </form>  

        <form action="editdatasiswa" method="POST">
          <button type="submit" name="back" id="btnSimpan" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-log-out" id="cancel"></i> Kembali </button>
        </form>

      <?php elseif($jenjangSiswa == '5SD'): ?>
        
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Edit Data Siswa <?= $namaSiswa; ?> </h3>
        </div>
        
        <form role="form" method="post" action="editdatasiswa">
          <input type="hidden" name="c_kelas" value="">
            <div class="box-body">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>NIS<sup style="color: red; font-size: 10px;">*</sup></label>
                    <input type="text" readonly value="<?= $nisSiswa; ?>" name="nis_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>NAMA LENGKAP</label>
                    <input type="text" value="<?= $namaSiswa; ?>" name="nama_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENIS KELAMIN</label>
                    <select class="form-control form-select" name="jns_kl">
                      <option value="kosong"> -- PILIH -- </option>
                      <?php foreach ($jenis_kelamin as $jk): ?>
                        <?php if ($jk == "L"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Laki - Laki </option>
                        <?php elseif($jk == "P"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Perempuan </option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                    
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENJANG PENDIDIKAN</label>
                    <select class="form-control form-select" id="kelas" name="kelas">

                      <?php if ($jenjangSiswa != 'LULUS'): ?>

                        <option value="kosong"> -- PILIH -- </option>

                        <?php foreach ($jenjangOpt as $data): ?>
                          <option value="<?= str_replace([" "],"",$data); ?>" <?= (str_replace([" "],"",$data) == $jenjangSiswa) ? 'selected="selected"' : '' ; ?> > <?= $data; ?> </option>
                        <?php endforeach ?>

                      <?php elseif($jenjangSiswa == 'LULUS'): ?>
                        <option value="" > LULUS </option>
                      <?php endif ?>
                      
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>KELOMPOK</label>
                    <input type="text" value="<?= $klp; ?>" name="isi_klp" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>ALAMAT LAHIR</label>
                    <input type="text" name="alamat_siswa" value="<?= $tempLahir; ?>" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>TANGGAL LAHIR</label>
                    <div class="controls input-append date form_date" data-date-format="dd MM yyyy">
                        <input class="form-control" type="text" name="tl_siswa" value="<?= $tangLahir; ?>">
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tahun Join</label>
                        <input type="text" value="<?= $thnJoin; ?>" class="form-control" id="_thnjoin" name="_thnjoin" >
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" class="form-control" value="<?= $nmPnggilan; ?>" id="_nmpanggilan" name="_nmpanggilan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Berat Badan</label>
                        <input type="text" class="form-control" value="<?= $beratBadan; ?>" id="_beratbadan" name="_beratbadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tinggi Badan</label>
                        <input type="text" class="form-control" value="<?= $tggBadan; ?>" id="_tinggibadan" name="_tinggibadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Ukuran Baju</label>
                        <input type="text" class="form-control" value="<?= $ukrBaju; ?>" id="_ukuranbaju" name="_ukuranbaju">
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="_alamatrumah" id="_alamatrumah">
                          <?= $almtRmh; ?>
                        </textarea>
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>Telp.</label>
                        <input type="text" class="form-control" value="<?= $telpRmh; ?>" id="_telp" name="telp_rumah">
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>HP</label>
                        <input type="text" class="form-control" value="<?= $no_hp; ?>" id="_hp" name="_hp">
                    </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="<?= $almtEmail; ?>" id="_email" name="_email" >
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">

                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ayah</h3>
                    </div>

                    <div class="box-body">
                      <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                                <label>Nama Ayah</label>
                                <input type="text" class="form-control" value="<?= $namaAyah; ?>" id="_nmayah" name="_nmayah" >
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tempat Tgl Lahir. Ayah</label>
                                <input type="text" class="form-control" value="<?= $tempLhrAyah; ?>" id="_temptglayah" name="_temptglayah">
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <label>Pend. Ayah</label>
                                <input type="text" name="_pendayah" class="form-control" value="<?= $pendAyah; ?>">
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Pekerjaan Ayah</label>
                              <input type="text" class="form-control" name="_pekerjaanayah" value="<?= $pekAyah; ?>">
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ibu</h3>
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="col-sm-3">
                          <div class="form-group">
                              <label>Nama Ibu</label>
                              <input type="text" class="form-control" id="_nmibu" name="_nmibu" value="<?= $namaIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Tempat Tgl Lahir. Ibu</label>
                              <input type="text" class="form-control" id="_temptglibu" name="_temptglibu" value="<?= $tempLhrIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-5">
                          <div class="form-group">
                              <label>Pend. Ibu</label>
                              <input type="text" name="_pendibu" class="form-control" value="<?= $pendIbu; ?>">
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-sm-4">
                          <div class="form-group">
                            <label>Pekerjaan Ibu</label>
                            <input type="text" name="_pekerjaanibu" class="form-control" value="<?= $pekIbu; ?>">
                          </div>
                        </div>

                      </div>
                    </div>  
                  </div>
                </div>
              </div>
              
            </div>

            <div class="box-footer" id="button_form_edit">
              <button type="submit" name="update_siswa" id="btnSimpan" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan Siswa </button>

        </form>  

        <form action="editdatasiswa" method="POST">
          <button type="submit" name="back" id="btnSimpan" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-log-out" id="cancel"></i> Kembali </button>
        </form>

      <?php elseif($jenjangSiswa == '6SD'): ?>

        <div class="box-header with-border">
          <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Edit Data Siswa <?= $namaSiswa; ?> </h3>
        </div>
        
        <form role="form" method="post" action="editdatasiswa">
          <input type="hidden" name="c_kelas" value="">
            <div class="box-body">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>NIS<sup style="color: red; font-size: 10px;">*</sup></label>
                    <input type="text" readonly value="<?= $nisSiswa; ?>" name="nis_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>NAMA LENGKAP</label>
                    <input type="text" value="<?= $namaSiswa; ?>" name="nama_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENIS KELAMIN</label>
                    <select class="form-control form-select" name="jns_kl">
                      <option value="kosong"> -- PILIH -- </option>
                      <?php foreach ($jenis_kelamin as $jk): ?>
                        <?php if ($jk == "L"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Laki - Laki </option>
                        <?php elseif($jk == "P"): ?>
                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Perempuan </option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                    
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENJANG PENDIDIKAN</label>
                    <select class="form-control form-select" id="kelas" name="kelas">

                      <?php if ($jenjangSiswa != 'LULUS'): ?>

                        <option value="kosong"> -- PILIH -- </option>

                        <?php foreach ($jenjangOpt as $data): ?>
                          <option value="<?= str_replace([" "],"",$data); ?>" <?= (str_replace([" "],"",$data) == $jenjangSiswa) ? 'selected="selected"' : '' ; ?> > <?= $data; ?> </option>
                        <?php endforeach ?>

                      <?php elseif($jenjangSiswa == 'LULUS'): ?>
                        <option value="" > LULUS </option>
                      <?php endif ?>
                      
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>KELOMPOK</label>
                    <input type="text" value="<?= $klp; ?>" name="isi_klp" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>ALAMAT LAHIR</label>
                    <input type="text" name="alamat_siswa" value="<?= $tempLahir; ?>" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>TANGGAL LAHIR</label>
                    <div class="controls input-append date form_date" data-date-format="dd MM yyyy">
                        <input class="form-control" type="text" name="tl_siswa" value="<?= $tangLahir; ?>">
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tahun Join</label>
                        <input type="text" value="<?= $thnJoin; ?>" class="form-control" id="_thnjoin" name="_thnjoin" >
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" class="form-control" value="<?= $nmPnggilan; ?>" id="_nmpanggilan" name="_nmpanggilan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Berat Badan</label>
                        <input type="text" class="form-control" value="<?= $beratBadan; ?>" id="_beratbadan" name="_beratbadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tinggi Badan</label>
                        <input type="text" class="form-control" value="<?= $tggBadan; ?>" id="_tinggibadan" name="_tinggibadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Ukuran Baju</label>
                        <input type="text" class="form-control" value="<?= $ukrBaju; ?>" id="_ukuranbaju" name="_ukuranbaju">
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="_alamatrumah" id="_alamatrumah">
                          <?= $almtRmh; ?>
                        </textarea>
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>Telp.</label>
                        <input type="text" class="form-control" value="<?= $telpRmh; ?>" id="_telp" name="telp_rumah">
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>HP</label>
                        <input type="text" class="form-control" value="<?= $no_hp; ?>" id="_hp" name="_hp">
                    </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="<?= $almtEmail; ?>" id="_email" name="_email" >
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">

                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ayah</h3>
                    </div>

                    <div class="box-body">
                      <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                                <label>Nama Ayah</label>
                                <input type="text" class="form-control" value="<?= $namaAyah; ?>" id="_nmayah" name="_nmayah" >
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tempat Tgl Lahir. Ayah</label>
                                <input type="text" class="form-control" value="<?= $tempLhrAyah; ?>" id="_temptglayah" name="_temptglayah">
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <label>Pend. Ayah</label>
                                <input type="text" name="_pendayah" class="form-control" value="<?= $pendAyah; ?>">
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Pekerjaan Ayah</label>
                              <input type="text" class="form-control" name="_pekerjaanayah" value="<?= $pekAyah; ?>">
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ibu</h3>
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="col-sm-3">
                          <div class="form-group">
                              <label>Nama Ibu</label>
                              <input type="text" class="form-control" id="_nmibu" name="_nmibu" value="<?= $namaIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Tempat Tgl Lahir. Ibu</label>
                              <input type="text" class="form-control" id="_temptglibu" name="_temptglibu" value="<?= $tempLhrIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-5">
                          <div class="form-group">
                              <label>Pend. Ibu</label>
                              <input type="text" name="_pendibu" class="form-control" value="<?= $pendIbu; ?>">
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-sm-4">
                          <div class="form-group">
                            <label>Pekerjaan Ibu</label>
                            <input type="text" name="_pekerjaanibu" class="form-control" value="<?= $pekIbu; ?>">
                          </div>
                        </div>

                      </div>
                    </div>  
                  </div>
                </div>
              </div>
              
            </div>

            <div class="box-footer" id="button_form_edit">
              <button type="submit" name="update_siswa" id="btnSimpan" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan Siswa </button>

        </form>  

        <form action="editdatasiswa" method="POST">
          <button type="submit" name="back" id="btnSimpan" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-log-out" id="cancel"></i> Kembali </button>
        </form>

      <?php else: ?>

        <div class="box-header with-border">
          <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Edit Data Siswa <?= str_replace(["#"],"",$namaSiswa); ?> </h3>
        </div>
        
        <form role="form" method="post" action="editdatasiswa">
          <input type="hidden" name="c_kelas" value="">
            <div class="box-body">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>NIS<sup style="color: red; font-size: 10px;">*</sup></label>
                    <input type="text" readonly value="<?= $nisSiswa; ?>" name="nis_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>NAMA LENGKAP</label>
                    <input type="text" readonly value="<?= $namaSiswa; ?>" name="nama_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENIS KELAMIN</label>
                    <input type="text" class="form-control" readonly value="<?= ($jkSiswa == 'L') ? "Laki - Laki" : "Perempuan"; ?>">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENJANG PENDIDIKAN</label>
                    <select class="form-control form-select" id="kelas" name="kelas">
                      <option value="" > <?= $jenjangSiswa; ?> </option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>KELOMPOK</label>
                    <input type="text" readonly value="<?= $klp; ?>" name="isi_klp" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>ALAMAT LAHIR</label>
                    <input type="text" readonly name="alamat_siswa" value="<?= $tempLahir; ?>" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>TANGGAL LAHIR</label>
                    <div class="controls input-append date form_date" data-date-format="dd MM yyyy">
                        <input class="form-control" readonly type="text" name="tl_siswa" value="<?= $tangLahir; ?>">
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tahun Join</label>
                        <input type="text" value="<?= $thnJoin; ?>" readonly class="form-control" id="_thnjoin" name="_thnjoin" >
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" class="form-control" readonly value="<?= $nmPnggilan; ?>" id="_nmpanggilan" name="_nmpanggilan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Berat Badan</label>
                        <input type="text" class="form-control" readonly value="<?= $beratBadan; ?>" id="_beratbadan" name="_beratbadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tinggi Badan</label>
                        <input type="text" class="form-control" readonly value="<?= $tggBadan; ?>" id="_tinggibadan" name="_tinggibadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Ukuran Baju</label>
                        <input type="text" class="form-control" readonly value="<?= $ukrBaju; ?>" id="_ukuranbaju" name="_ukuranbaju">
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" readonly name="_alamatrumah" id="_alamatrumah">
                          <?= $almtRmh; ?>
                        </textarea>
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>Telp.</label>
                        <input type="text" class="form-control" readonly value="<?= $telpRmh; ?>" id="_telp" name="telp_rumah">
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>HP</label>
                        <input type="text" class="form-control" readonly value="<?= $no_hp; ?>" id="_hp" name="_hp">
                    </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" readonly value="<?= $almtEmail; ?>" id="_email" name="_email" >
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">

                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ayah</h3>
                    </div>

                    <div class="box-body">
                      <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                                <label>Nama Ayah</label>
                                <input type="text" class="form-control" readonly value="<?= $namaAyah; ?>" id="_nmayah" name="_nmayah" >
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tempat Tgl Lahir. Ayah</label>
                                <input type="text" class="form-control" readonly value="<?= $tempLhrAyah; ?>" id="_temptglayah" name="_temptglayah">
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <label>Pend. Ayah</label>
                                <input type="text" name="_pendayah" readonly class="form-control" value="<?= $pendAyah; ?>">
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Pekerjaan Ayah</label>
                              <input type="text" class="form-control" readonly name="_pekerjaanayah" value="<?= $pekAyah; ?>">
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Data Ibu</h3>
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="col-sm-3">
                          <div class="form-group">
                              <label>Nama Ibu</label>
                              <input type="text" class="form-control" readonly id="_nmibu" name="_nmibu" value="<?= $namaIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Tempat Tgl Lahir. Ibu</label>
                              <input type="text" class="form-control" readonly id="_temptglibu" name="_temptglibu" value="<?= $tempLhrIbu; ?>">
                          </div>
                        </div>

                        <div class="col-sm-5">
                          <div class="form-group">
                              <label>Pend. Ibu</label>
                              <input type="text" name="_pendibu" readonly class="form-control" value="<?= $pendIbu; ?>">
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-sm-4">
                          <div class="form-group">
                            <label>Pekerjaan Ibu</label>
                            <input type="text" name="_pekerjaanibu" readonly class="form-control" value="<?= $pekIbu; ?>">
                          </div>
                        </div>

                      </div>
                    </div>  
                  </div>
                </div>
              </div>
              
            </div>

            <div class="box-footer" id="button_form_edit">
              <button type="submit" name="back" id="btnSimpan" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-log-out" id="cancel"></i> Kembali </button>

        </form>

      <?php endif ?>

    <?php endif ?>

  </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="<?php echo $base; ?>theme/datetime/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript">
  $(document).ready( function () {
    $("#ketPendidikan1").hide();
    $("#ketPendidikan2").hide();
    $("#anotherJob1").hide();
    $("#anotherJob2").hide();
    $("#list_data_siswa").click();
    $("#editdatasiswa").css({
        "background-color" : "#ccc",
        "color" : "black"
    });
  });

  function deleteData(nis, nm) {

    Swal.fire({
      title: "Are you sure ? ",
      text: `Are you sure want to delete data ${nm} !`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#008d4c",
      cancelButtonColor: "#3c8dbc",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {

        $.ajax({
          url : `<?= $baseac; ?>apidatasiswa.php`,
          type : "POST",
          data : {
            dataNis : nis
          },
          success:function(data){
            if (data == 'sukses') {
              setTimeout(refreshPage, 1000);
              Swal.fire({
                title: "Deleted!",
                text: "Data successfully deleted",
                icon: "success"
              });
            } else if (data == 'gagal') {
              Swal.fire({
                title: "Fail!",
                text: "Deleted Unsuccessfully",
                icon: "error"
              });
            }

            function refreshPage() {
              location.replace(`<?= $baseac; ?>editdatasiswa`)
            }

          }
        })
      }
    });

  }

  $('.form_date').datetimepicker({
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
  });

  $('.form_date2').datetimepicker({
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
  });

  $('.form_date3').datetimepicker({
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
  });

  $(function () {
    $("input[name='nis_siswa']").on('input', function (e) {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
  });

  $(function () {
    $("input[name='_thnjoin']").on('input', function (e) {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
  });

  $(function () {
    $("input[name='telp_rumah']").on('input', function (e) {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
  });

  $(function () {
    $("input[name='_hp']").on('input', function (e) {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
  });

  function fatherJob() {
    let dataAyah = document.getElementById("_pekerjaanayah").value;
    if (dataAyah == 'LAINNYA') {
      $("#anotherJob1").show();
    } else {
      $("#anotherJob1").hide();
    }
  }

  function OpenCarisiswaModal(){
    $('#modalEditData').modal("show");
  }

  function OnSiswaSelectedModal(id, nis, nmsiswa, kelas, panggilan){



    $('#modalEditData').modal("hide");
  }

  function fatherAcademy() {
    let dataPendAyah = document.getElementById("_pendayah").value;
    if (dataPendAyah == 'SD') {
      $("#ketPendidikan1").hide();
    } else if(dataPendAyah == 'SMP') {
      $("#ketPendidikan1").hide();
    } else if(dataPendAyah == 'kosong') {
      $("#ketPendidikan1").hide();
    } else {
      $("#ketPendidikan1").show();
    }
  }

  function motherJob() {
    let dataIbu = document.getElementById("_pekerjaanibu").value;
    if (dataIbu == 'LAINNYA') {
      $("#anotherJob2").show();
    } else {
      $("#anotherJob2").hide();
    }
  }

  function motherAcademy() {
    let dataPendIbu = document.getElementById("_pendibu").value;
    if (dataPendIbu == 'SD') {
      $("#ketPendidikan2").hide();
    } else if(dataPendIbu == 'SMP') {
      $("#ketPendidikan2").hide();
    } else if(dataPendIbu == 'kosong1') {
      $("#ketPendidikan2").hide();
    } else {
      $("#ketPendidikan2").show();
    }
  }

</script>