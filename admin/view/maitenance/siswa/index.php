<?php 

  $jenis_kelamin      = ["L", "P"];
  $jenjang_pendidikan = mysqli_query($con, "SELECT * FROM kelas ORDER BY kelas ASC");

  $pendidikan         = ["SD", "SMP", "SMA", "SMK", "D1", "D2", "D3", "D4", "S1", "S2", "S3"];
  $pekerjaan          = ["WIRASWASTA", "KS", "PNS", "TNI", "POLRI", "PENSIUNAN", "LAINNYA"];
  $pekerjaanIbu       = ["WIRASWASTA", "KS", "PNS", "TNI", "POLRI", "PENSIUNAN", "IRT", "LAINNYA"];

  if (isset($_POST['tambah_siswa'])) {

    $nis    = $_POST['nis_siswa'];
    // $nisn   = $_POST['nisn_siswa'];
    $nama   = mysqli_real_escape_string($con , htmlspecialchars($_POST['nama_siswa']));
    // $nama   = htmlspecialchars($_POST['nama_siswa']);
    $alamat = mysqli_real_escape_string($con, htmlspecialchars($_POST['alamat_siswa']));
    $tl     = date('Y-m-d',strtotime($_POST['tl_siswa']));
    $jns_kl = htmlspecialchars($_POST['jns_kl']);
    $klp    = htmlspecialchars($_POST['_klpselect']);
    $thnJ   = htmlspecialchars($_POST['_thnjoin']);
    $pggl   = mysqli_real_escape_string($con, htmlspecialchars($_POST['_nmpanggilan']));
    $brtB   = htmlspecialchars($_POST['_beratbadan']);
    $tggB   = htmlspecialchars($_POST['_tinggibadan']);
    $ukr    = htmlspecialchars($_POST['_ukuranbaju']);
    $almtRm = mysqli_real_escape_string($con, htmlspecialchars($_POST['_alamatrumah']));
    $noTelp = $_POST['_telp'];
    $noHp   = $_POST['_hp'];
    $email  = htmlspecialchars($_POST['_email']);

    // ortu
    $namaAyah  = mysqli_real_escape_string($con, htmlspecialchars($_POST['_nmayah']));
    $pddknAyah = mysqli_real_escape_string($con, htmlspecialchars($_POST['_pendayah'] . " - " . $_POST['ketPendA']));

    $pkrjnAyah = htmlspecialchars($_POST['_pekerjaanayah']);
    if ($pkrjnAyah == 'KS') {
      $pkrjnAyah = "KARYAWAN SWASTA";
    } elseif ($pkrjnAyah == 'LAINNYA') {
      $pkrjnAyah = $_POST['kerjaLain1'];
    }

    $tmptTglAyah  = mysqli_real_escape_string($con, htmlspecialchars($_POST['_temptglayah'] . ", " . $_POST['tl_ayah']));

    $namaIbu      = mysqli_real_escape_string($con, htmlspecialchars($_POST['_nmibu']));
    $pddknIbu     = mysqli_real_escape_string($con,htmlspecialchars($_POST['_pendibu'] . " - " . $_POST['ketPendI']));
    // echo "Data Ayah : " . $pddknAyah . "<br>" . "Data Ibu : " . $pddknIbu;exit;

    $pkrjnIbu     = htmlspecialchars($_POST['_pekerjaanibu']);
    if ($pkrjnIbu == 'KS') {
      $pkrjnIbu = "KARYAWAN SWASTA";
    } elseif ($pkrjnIbu == 'LAINNYA') {
      $pkrjnIbu = $_POST['kerjaLain2'];
    }

    $tmptTglIbu   = mysqli_real_escape_string($con, htmlspecialchars($_POST['_temptglibu'] . ", " . $_POST['tl_ibu']));

    if ($klp == 'KB' || $klp == 'TKA' || $klp == 'TKB') {
      $kodeJenjang = "PTK";
    } else {
      $kodeJenjang  = str_replace(["1", "2", "3", "4", "5", "6"], "", $klp);
    }

    $c_jenjang = str_replace(['PTK'], "TK", $kodeJenjang);

    // // echo $kodseq;exit;

    // //$c_siswa
    // $insertDB = mysqli_query($con,"
    //   INSERT INTO siswa 
    //   set 
    //   c_siswa     = '$kodseq',
    //   c_kelas     = '$klp',
    //   nisn        = '$nisn',
    //   nama        = '$nama',
    //   jk          = '$jns_kl',
    //   temlahir    = '$alamat',
    //   tanglahir   ='$tl', 
    //   thn_join    = '$thnJ', 
    //   panggilan   = '$pggl', 
    //   c_klp       = NULL, 
    //   bbadan      = NULL,
    //   tbadan      = NULL, 
    //   ukuran_baju = NULL, 
    //   alamat      = '$almtRm', 
    //   telp        = '$noTelp', 
    //   hp          = '$noHp',
    //   email       = '$email', 
    //   nama_ayah   = '$namaAyah', 
    //   pendidikan_a = '$pddknAyah', 
    //   pekerjaan_a = '$pkrjnAyah',
    //   ttl_a = '$tmptTglAyah', 
    //   nama_ibu = '$namaIbu', 
    //   pendidikan_i = '$pddknIbu', 
    //   pekerjaan_i = '$pkrjnIbu',
    //   ttl_i = '$tmptTglIbu', 
    //   nis = '$nis' ");

    // $penomoran=mysqli_query($con,"UPDATE penomoranmas set no`urut='$nomorurut' where kode ='$kodeJenjang' ");
    if ($nis == "" || $nama == "" || $pggl == "" ) {
      $_SESSION['pesan'] = "data_empty";
    } elseif($klp == "kosong") {
      $_SESSION['pesan'] = "jenjang_pendidikan_empty";
    } else {

      if ($c_jenjang != "TK") {

        $kelas  = str_replace(["1SD", "2SD", "3SD", "4SD", "5SD", "6SD"], ["1 SD", "2 SD", "3 SD", "4 SD", "5 SD", "6 SD"], $klp);
        // echo $kelas;exit;

        $insertDB1 = mysqli_query($con,"
          INSERT INTO data_murid_sd 
          set
          Nama          = '$nama',
          KELAS         = '$kelas',
          jk            = '$jns_kl',
          temlahir      = '$alamat',
          tanglahir     = '$tl', 
          thn_join      = '$thnJ', 
          Panggilan     = '$pggl', 
          KLP           = NULL, 
          berat_badan   = NULL,
          tinggi_badan  = NULL, 
          ukuran_baju   = NULL, 
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
        ");

      } elseif ($c_jenjang == 'TK') {

        $kelas  = $klp;
        // echo $nama;exit;

        $insertDB2 = mysqli_query($con,"
          INSERT INTO data_murid_tk
          set
          Nama          = '$nama',
          KELAS         = '$kelas',
          jk            = '$jns_kl',
          temlahir      = '$alamat',
          tanglahir     = '$tl', 
          thn_join      = '$thnJ', 
          Panggilan     = '$pggl', 
          KLP           = NULL, 
          berat_badan   = NULL,
          tinggi_badan  = NULL, 
          ukuran_baju   = NULL, 
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
        ");

      }

      $_SESSION['pesan'] = 'tambah';
      
    }

  }

?>
  <div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

      <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='edit'){?>
        <div style="display: none;" class="alert alert-info alert-dismissable">Kelas Berhasil Diedit
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <?php unset($_SESSION['pesan']); ?>
        </div>
      <?php } ?>

      <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='tambah'){?>
        <div style="display: none;" class="alert alert-warning alert-dismissable">Data Siswa Baru Berhasil Disimpan
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <?php unset($_SESSION['pesan']); ?>
        </div>
      <?php } ?>

      <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='data_empty'){?>
        <div style="display: none;" class="alert alert-danger alert-dismissable">Data NIS, NAMA LENGKAP, NAMA PANGGILAN TIDAK BOLEH KOSONG
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <?php unset($_SESSION['pesan']); ?>
        </div>
      <?php } ?> 

      <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='jenjang_pendidikan_empty'){?>
        <div style="display: none;" class="alert alert-danger alert-dismissable"> Harap Isi Jenjang Pendidikan Terlebih Dahulu
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <?php unset($_SESSION['pesan']); ?>
        </div>
      <?php } ?> 
      
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Tambah Data Siswa</h3>
        </div>
        <!-- /.box-header -->
        
        <form role="form" method="post" action="tambahdatasiswa">
          <input type="hidden" name="c_kelas" value="">
            <div class="box-body">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>NIS<sup style="color: red; font-size: 10px;">*</sup></label>
                    <input type="text" required name="nis_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>NAMA LENGKAP<sup style="color: red; font-size: 10px;">*</sup></label>
                    <input type="text" required name="nama_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENIS KELAMIN</label>
                    <select class="form-control form-select" name="jns_kl">
                      <option value="kosong"> -- PILIH -- </option>
                      <?php foreach ($jenis_kelamin as $jk): ?>
                        <?php if ($jk == "L"): ?>
                          <option value="<?= $jk; ?>"> Laki - Laki </option>
                        <?php elseif($jk == "P"): ?>
                          <option value="<?= $jk; ?>"> Perempuan </option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                    
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>JENJANG PENDIDIKAN<sup style="color: red; font-size: 10px;">*</sup></label>
                    <select class="form-control form-select" id="_klpselect" name="_klpselect" onchange="SelesaiChanged()">
                      <option value="kosong"> -- PILIH -- </option>
                      <?php foreach ($jenjang_pendidikan as $data): ?>
                        <option value="<?= $data['c_kelas']; ?>"> <?= $data['kelas']; ?> </option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>ALAMAT LAHIR</label>
                    <input type="text" required name="alamat_siswa" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>TANGGAL LAHIR</label>
                    <div class="controls input-append date form_date" data-date-format="dd MM yyyy">
                        <input class="form-control" required type="text" name="tl_siswa" value="" >
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tahun Join</label>
                        <input min=2000 type="number" class="form-control" id="_thnjoin" name="_thnjoin" >
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nama Panggilan<sup style="color: red; font-size: 10px;">*</sup></label>
                        <input type="text" required class="form-control" id="_nmpanggilan" name="_nmpanggilan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Berat Badan</label>
                        <input type="text" class="form-control" id="_beratbadan" name="_beratbadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Tinggi Badan</label>
                        <input type="text" class="form-control" id="_tinggibadan" name="_tinggibadan">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Ukuran Baju</label>
                        <input type="text" class="form-control" id="_ukuranbaju" name="_ukuranbaju">
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" id="_alamatrumah" name="_alamatrumah">
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>Telp.</label>
                        <input type="text" class="form-control" id="_telp" name="_telp">
                    </div>
                </div>
                <div class="col-sm-2">
                      <div class="form-group">
                        <label>HP</label>
                        <input type="text" class="form-control" id="_hp" name="_hp">
                    </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="_email" name="_email" >
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
                                <input type="text" class="form-control" id="_nmayah" name="_nmayah" >
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                                <label>Tempat Lahir. Ayah</label>
                                <input type="text" class="form-control" id="_temptglayah" name="_temptglayah">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label>TGL LAHIR AYAH</label>
                              <div class="controls input-append date form_date2" data-date-format="dd MM yyyy">
                                  <input class="form-control" required type="text" name="tl_ayah" value="" >
                                  <span class="add-on"><i class="icon-th"></i></span>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                                <label>Pend. Ayah</label>
                                <select id="_pendayah" name="_pendayah"  class="form-control form-select" onchange="fatherAcademy()">
                                    <option value="kosong">-- PILIH --</option>
                                    <?php foreach ($pendidikan as $dataPendidikan): ?>
                                      <option value="<?= $dataPendidikan; ?>"> <?= $dataPendidikan; ?> </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                          </div>
                          <div class="col-sm-3" id="ketPendidikan1">
                            <div class="form-group">
                                <label>Jurusan</label>
                                <input type="text" class="form-control" id="ketPendidikanA" name="ketPendA">
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          <div class="form-group">
                              <label>Pekerjaan Ayah</label>
                              <select id="_pekerjaanayah" name="_pekerjaanayah" class="form-control form-select" onchange="fatherJob()">
                                  <option value="">-- PILIH --</option>
                                  <?php foreach ($pekerjaan as $jenisPekerjaan): ?>
                                    <?php if ($jenisPekerjaan != 'KS' && $jenisPekerjaan != 'LAINNYA'): ?>
                                      <option value="<?= $jenisPekerjaan; ?>"> <?= $jenisPekerjaan; ?> </option>
                                    <?php elseif($jenisPekerjaan == 'KS'): ?>
                                      <option value="<?= $jenisPekerjaan; ?>"> KARYAWAN SWASTA </option>
                                    <?php elseif($jenisPekerjaan == 'LAINNYA'): ?>
                                      <option value="<?= $jenisPekerjaan; ?>"> LAIN - LAIN </option>
                                    <?php endif ?>
                                  <?php endforeach ?>
                              </select>
                          </div>
                        </div>
                        <div class="col-sm-4" id="anotherJob1">
                          <div class="form-group">
                              <label>Pekerjaan</label>
                              <input type="text" class="form-control" id="kerjaLain" name="kerjaLain1" >
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
                              <input type="text" class="form-control" id="_nmibu" name="_nmibu" >
                          </div>
                        </div>

                        <div class="col-sm-2">
                          <div class="form-group">
                              <label>Tempat Lahir. Ibu</label>
                              <input type="text" class="form-control" id="_temptglibu" name="_temptglibu">
                          </div>
                        </div>

                        <div class="col-sm-2">
                          <div class="form-group">
                            <label>TGL LAHIR IBU</label>
                            <div class="controls input-append date form_date3" data-date-format="dd MM yyyy">
                                <input class="form-control" required type="text" name="tl_ibu" value="" >
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-2">
                          <div class="form-group">
                              <label>Pend. Ibu</label>
                              <select id="_pendibu" name="_pendibu"  class="form-control form-select" onchange="motherAcademy()">
                                <option value="kosong1">-- PILIH --</option>
                                  <?php foreach ($pendidikan as $dataPendidikan): ?>
                                    <option value="<?= $dataPendidikan; ?>"> <?= $dataPendidikan; ?> </option>
                                  <?php endforeach ?>
                              </select>
                          </div>
                        </div>

                        <div class="col-sm-3" id="ketPendidikan2">
                          <div class="form-group">
                              <label>Jurusan</label>
                              <input type="text" class="form-control" id="ketPendidikanI" name="ketPendI">
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-sm-3">
                          <div class="form-group">
                            <label>Pekerjaan Ibu</label>
                            <select id="_pekerjaanibu" name="_pekerjaanibu" class="form-control form-select" onchange="motherJob()">
                              <option value="">-- PILIH --</option>
                                <?php foreach ($pekerjaanIbu as $jenisPekerjaan): ?>
                                  <?php if ($jenisPekerjaan != 'KS'): ?>
                                    <option value="<?= $jenisPekerjaan; ?>"> <?= $jenisPekerjaan; ?> </option>
                                  <?php elseif($jenisPekerjaan == 'KS'): ?>
                                    <option value="<?= $jenisPekerjaan; ?>"> KARYAWAN SWASTA </option>
                                  <?php elseif($jenisPekerjaan == 'LAINNYA'): ?>
                                    <option value="<?= $jenisPekerjaan; ?>"> LAIN - LAIN </option>
                                  <?php endif ?>
                                <?php endforeach ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-sm-4" id="anotherJob2">
                          <div class="form-group">
                              <label>Pekerjaan</label>
                              <input type="text" class="form-control" id="kerjaLain" name="kerjaLain2" >
                          </div>
                        </div>

                      </div>
                    </div>  
                  </div>
                </div>
              </div>
              
            </div>

            <div class="box-footer">
              <button type="submit" name="tambah_siswa" id="btnSimpan" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan Siswa</button>
            </div>

        </form>  

      </div>

    </div>

  </div>

<script type="text/javascript" src="<?php echo $base; ?>theme/datetime/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript">
  $(document).ready( function () {
    $("#ketPendidikan1").hide();
    $("#ketPendidikan2").hide();
    $("#anotherJob1").hide();
    $("#anotherJob2").hide();
    $("#list_maintenance").click();
    $("#tambahdatasiswa").css({
        "background-color" : "#ccc",
        "color" : "black"
    });
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
    $("input[name='nisn_siswa']").on('input', function (e) {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
  });

  $(function () {
    $("input[name='_telp']").on('input', function (e) {
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