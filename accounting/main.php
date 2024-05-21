<?php 
  
  date_default_timezone_set('Asia/Jakarta');$date=date('Y-m-d'); 
  
  require '../php/config.php'; 
  require '../php/function.php'; 
  // require 'view/spp/input_data/Model/Pagination.php';
  
  session_start(); 

  if(empty($_SESSION['c_accounting'])) {
    header('location:../login');
  } 

  $currTahun    = "";
  $currSemester = "";

  $check = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tahun_ajaran WHERE status = 'aktif' AND c_role = '$_SESSION[c_accounting]' "));

  if ($check != 0) {

    $currTahun = mysqli_query($con, "SELECT tahun FROM tahun_ajaran WHERE status = 'aktif' AND c_role = '$_SESSION[c_accounting]' ");
    $currTahun = mysqli_fetch_assoc($currTahun)['tahun'];
    // echo $currTahun;exit;
    $currSemester = mysqli_query($con, "SELECT semester FROM tahun_ajaran WHERE status = 'aktif' AND c_role = '$_SESSION[c_accounting]' ");
    $currSemester = mysqli_fetch_assoc($currSemester)['semester'];

  } else {

    $currTahun    = "";
    $currSemester = "";

  }

  $na = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM accounting where c_accounting = '$_SESSION[c_accounting]' ")); 
  //$setting=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM setting limit 1 "));*/ 
  if (isset($_GET['nextPage'])) {
    echo $_GET['nextPage'];exit;
  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Accouting AIIS-SPP</title>
  <link rel="icon" href="favicon.ico">
  
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?php echo $base; ?>imgstatis/favicon.jpg">

  <!-- Jquery -->
  <script type="text/javascript" src="<?php echo $base; ?>jquery.js"></script> 

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Theme -->
  <link href="<?php echo $base; ?>theme/js/summernote.min.css" rel="stylesheet"/>
 
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo $base; ?>theme/bootstrap/css/bootstrap.min.css">
  
  <!-- Font Awesome -->
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $base; ?>theme/plugins/datatables/dataTables.bootstrap.css">
  
  <!-- jvectormap -->

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $base; ?>theme/dist/css/AdminLTE.min.css">

  <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $base; ?>theme/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo $base; ?>theme/plugins/iCheck/square/blue.css">

  <link rel="stylesheet" type="text/css" href="view/spp/input_data/assets/css/pagination.css">
  <link rel="stylesheet" type="text/css" href="view/spp/input_data/assets/css/phppot-style.css">
  <script src="view/spp/input_data/vendor/jquery/jquery-3.3.1.js"></script>
  <script>
  function pageValidation()
  {
      var valid=true;
      var pageNo = $('#page-no').val();
      var totalPage = $('#total-page').val();
      if(pageNo == ""|| pageNo < 1 || !pageNo.match(/\d+/) || pageNo > parseInt(totalPage)){
          $("#page-no").css("border-color","#ee0000").show();
          valid=false;
      }
      return valid;
  }
  </script>

  <script type="text/javascript">
      $(document).ready(function() {
        $("#cari").keyup(function(){
        $("#fbody").find("tr").hide();
        var data = this.value.split("");
        var jo = $("#fbody").find("tr");
        $.each(data, function(i, v)
        {
              jo = jo.filter("*:contains('"+v+"')");
        });
          jo.fadeIn();

        })
  });

  </script>

  <!-- Pace style -->
  <link rel="stylesheet" href="<?php echo $base; ?>theme/plugins/pace/pace.min.css">

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  
  <!-- datetime -->
  <link href="<?php echo $base; ?>theme/datetime/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo $base; ?>theme/plugins/select2/select2.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $base; ?>theme/dist/css/AdminLTE.min.css">

  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $base; ?>theme/dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="<?php echo $base; ?>theme/dist/css/overridecss.css">
  
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
    
    body {
      font-family:arial;
    }

    hr.new1 {
      border-top: 1px solid black;
    }

    .treeview-menu li a:hover {
      background-color: #ccc;
      color: black !important;
    }

    .tombol {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }

    .form-isi {
      display: flex;
      flex-direction: column;
    }

    #spp1 {
      width: 20%;
      margin-right: 10px;
      text-align: end;
    }

    #tombol-cetak {
      display: flex; 
      gap: 5px; 
    }

    #tombol-cetak-pangkal {
      display: flex; 
      gap: 12px; 
      justify-content: center;
      margin-right: -4px;
    }

    #example1 {
      width: 200% !important;
      max-width: 200% !important;
    }

    #example_semua {
      width: 230% !important;
      max-width: 250% !important;
    }

    #example1_info {
      display: none;
    }

    #example1 th {
      background-color: lightblue;
      border: 2px solid black;
    }

    #example1 tbody tr:hover {
      background-color: aqua;
    }

    #example_semua th {
      background-color: lightblue;
      border: 2px solid black;
    }

    #example_semua tbody tr:hover {
      background-color: aqua;
    }

    #isi_tahun_ajaran {
      margin-left: -80px;
      top: -5px;
      z-index: 1;
    }

    #pilih_tahun_ajaran {
      width: 70%;
    }

    #isi_tahun_ajaran_2 {
      margin-left: -367px;
      top: -5px;
    }

    #div_slash {
      margin-left: -38px;
      top: -5px;
    }

    .uang_spp, 
    .uang_pangkal, 
    .uang_regis,
    .uang_seragam,
    .uang_buku,
    .uang_kegiatan,
    .lain2 {
      width: 20%;
      margin-right: 10px; 
      text-align: end;
    }

    .ket_uang_spp, 
    .ket_uang_pangkal, 
    .ket_uang_regis,
    .ket_uang_seragam,
    .ket_uang_buku,
    .ket_uang_kegiatan,
    .ket_lain2 {
      width: 25%;
    }

    #spp2 {
      width: 25%;
    }

    .judul {
      width: 100%; 
      background-color: #FFF; 
      padding: 10px;
      margin-bottom: 10px; 
    }

    .select2-container {
      width: 110% !important;
    }

    .keterangan_juz {
      width: 200%;
    }

    #seqketsurahedit {
      width: 60%;
    }

    .flex-container {
      display: flex;
      justify-content: center;
    }

    .flex-container > div {
      border: 1px solid black;
      margin: 10px;
      width: 50%;
      padding: 20px;
    }

    .flex-containers {
      display: flex;
      justify-content: center;
    }

    .flex-containers > div {
      border: 1px solid black;
      margin: 10px;
      width: 100%;
      padding: 20px;
    }

    #total {
      float: right;
    }

    #forLabel {
      margin-top: 2px;
    }
    
    #jun22 {
      margin-left: 180px;
    }

    #tombol {
      width: 30%;
      margin-left: -30px;
    }

    #tahun_ajaran {
      width: 70px;
      margin-left: 10px;
      text-align: center;
      padding: 1px;
    }

    #slashx {
      width: 10px;
      font-size: 17px;
    }

    #tahun_ajaran_2 {
      width: 70px;
      text-align: center;
      padding: 1px;
    }

    #semesterx {
      margin-left: 35px;
      width: 71px;
      height: 25px;
    }

    .tombols {
      display: flex;
      gap: 5px;
      flex-direction: row;
    }

    @media only screen and (max-width: 600px) {

      .cobasidebar {
        margin-top: 17%;
      }

      #cobacontent {
        min-height: 250px !important;
        margin-right: auto !important;
        margin-left: auto !important;
        padding-left: 15px !important;
        padding-right: 15px !important;
      }

      .tombols {
        display: flex;
        flex-direction: column;
        margin-left: 29px;
      }

    }

    @media only screen and (max-width: 768px) {

      .uang_spp, 
      .uang_pangkal, 
      .uang_regis,
      .uang_seragam,
      .uang_buku,
      .uang_kegiatan,
      .lain2 {
        width: 40%;
        margin-right: 10px; 
        text-align: end;
      }

      .tombols {
        display: flex;
        flex-direction: column;
        margin-left: -20px;
        width: 95%;
      }

      #tahun_ajaran {
        width: 50px;
        margin-left: 9px;
        text-align: center;
        padding: 1px;
      }

      #slashx {
        width: 20px;
        font-size: 17px;
      }

      #tahun_ajaran_2 {
        width: 50px;
        margin-left: -8px;
        text-align: center;
        padding: 1px;
      }

      #semesterx {
        margin-left: 30px;
        width: 41px;
      }

      #tombol-cetak {
        display: flex; 
        gap: 5px; 
        flex-direction: column;
      }

      #tombol-cetak-pangkal {
        display: flex; 
        gap: 5px; 
        justify-content: center;
        flex-direction: column;
      }

      #example1 {
        width: 167% !important;
        max-width: 200% !important;
      }

      .tombol {
        display: flex;
        flex-direction: column;
        margin-right: 50px;
        margin-top: 20px;
      }

      .ket_uang_spp, 
      .ket_uang_pangkal, 
      .ket_uang_regis,
      .ket_uang_seragam,
      .ket_uang_buku,
      .ket_uang_kegiatan,
      .ket_lain2 {
        width: 53%;
      }
      
      #tombol {
        width: 100%;
      }

      #save_record {
        width: 100%;
        margin-left: 29px;
      }

      #cek_pembayaran {
        width: 100%;
        margin-left: 29px;
      }

      #cetak_kuitansi_web {
        width: 100%;
        margin-left: 29px;
      }

      #cetak_slip_kuitansi {
        width: 100%;
        margin-left: 29px;
      }

      #jun22 {
        margin-left: 180px;
      }      

      #spp1 {
        width: 30%;
        margin-right: 10px;
        text-align: end;
      }

      #spp2 {
        width: 63%;
      }

      .flex-container {
        display: flex;
        justify-content: center;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: center;
      }

      .flex-container > div {
        background-color: #f1f1f1;
        border: 1px solid black;
        margin: 10px;
        width: 100%;
        padding: 20px;
      }

      .flex-containers {
        display: flex;
        justify-content: center;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: center;
      }

      .flex-containers > div {
        background-color: white;
        border: 1px solid black;
        margin: 10px;
        width: 100%;
        padding: 20px;
      }

      .select2-container {
        width: 100% !important;
      }

      .keteranganAyat {
        width: 100%
      }

      #seqketsurahedit {
        width: 16%;
      }

      #example1 th {
        background-color: lightblue;
        border: 2px solid black;
        width: 127%;
      }

    }

    /* The Modal (background) */
    .modal-error {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 9999; /* Sit on top */
      padding-top: 100px; /* Location of the box */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content-error {
      background-color: #fefefe;
      margin: auto;
      padding: 20px;
      border: 1px solid #888;
      width: 30%;
    }

    /* The Close Button */
    .close-popup-err {
      color: #aaaaaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close-popup-err:hover,
    .close-popup-err:focus {
      color: #000;
      text-decoration: none;
      cursor: pointer;
    }

  </style>
</head>
<body class="skin-blue hold-transition fixed" 
oncontextmenu="return false">
<!--modal ganti foto-->

<!-- Olahangka -->
<script src="<?php echo $base; ?>php/olahangka.js"></script>

<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>AKH</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"> <b> AIIS - SPP</b> </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
     <a href="#" class="glyphicon glyphicon-th" data-toggle="offcanvas" role="button" style="color: #fff;margin-top: 15px;margin-left: 15px;font-size: 15px;"> Menu
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="active">
            <!-- <a><i class="glyphicon glyphicon-stats"></i> <?php echo $ata['tahun']; ?> Semester <?php echo $ata['semester']; ?></a> -->
            <a><i class="glyphicon glyphicon-stats"></i> <?= $currTahun; ?> Semester <?= $currSemester; ?></a>
          </li>
        <?php /*if(empty($_GET['thisaction']) or $_GET['thisaction']!='grafik'){ ?>
          <li>
            <a href="<?php echo $basead; ?>a-control/<?php echo md5('testtoken').'/'.$t1=md5(date('H:i:s')); ?>"><i class="glyphicon glyphicon-stats"></i> Test Token</a>
          </li>
          <li>
            <a href="<?php echo $basecon; ?>grafik"><i class="glyphicon glyphicon-stats"></i> Grafik</a>
          </li>
        <?php } else{?>
          <li class="active">
            <a href="<?php echo $basecon; ?>grafik"><i class="glyphicon glyphicon-stats"></i> Grafik</a>
          </li>
        <?php }*/ ?>
          

          <li class="dropdown user user-menu">
            <?php if ($_SESSION['c_accounting'] == 'accounting1'): ?>

              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $base; ?>imgstatis/default.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo ucfirst($na['username']); ?></span>
              </a>

            <?php elseif($_SESSION['c_accounting'] == 'accounting2'): ?>

              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $base; ?>imgstatis/default.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo ucfirst($na['username']); ?></span>
              </a>

            <?php else: ?>

              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $base; ?>imgstatis/default.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo ucfirst($na['username']); ?></span>
              </a>

            <?php endif ?>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header" style="height: 185px;">
                <?php if ($_SESSION['c_accounting'] == 'accounting1'): ?>
                  <img src="<?php echo $base; ?>imgstatis/default.jpg" class="img-circle" alt="User Image">
                <?php elseif($_SESSION['c_accounting'] == 'accounting2'): ?>
                  <img src="<?php echo $base; ?>imgstatis/default.jpg" class="img-circle" alt="User Image">
                <?php else: ?>
                  <img src="<?php echo $base; ?>imgstatis/default.jpg" class="img-circle" alt="User Image">
                <?php endif ?>
                <p>
                  <?php echo ucfirst($na['username']); ?>
                  <small>(<?= ucfirst($na['nama']); ?>)</small>
                </p>
                <p style="font-size: 11px;"><?php echo $aplikasi['namasek']; ?></p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <button id="changePassword" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-wrench"></i> Ganti Password </button>
                  <a href="<?php echo $baseac; ?>a-control/<?php echo md5('logout'); ?>/access" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-off"></i> Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar cobasidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <?php if ($_SESSION['c_accounting'] == 'accounting1'): ?>
            <img src="<?php echo $base; ?>imgstatis/default.jpg" class="img-circle" alt="User Image">
          <?php elseif($_SESSION['c_accounting'] == 'accounting2'): ?>
            <img src="<?php echo $base; ?>imgstatis/default.jpg" class="img-circle" alt="User Image">
          <?php else: ?>
            <img src="<?php echo $base; ?>imgstatis/default.jpg" class="img-circle" alt="User Image">
          <?php endif ?>
        </div>
        <div class="pull-left info">
          <p><?php echo ucfirst($na['username']); ?> (<?= ucfirst($na['nama']); ?>) </p>
          <i class="glyphicon glyphicon-time"></i> <?php echo tgl(date('d-m-Y')); ?>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">

      </form>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>

        <!-- SPP -->
        <li>
          <a href="#" id="list_spp">
            <i class="glyphicon glyphicon-usd"></i> <span> SPP </span>
          </a>
          <ul class="treeview-menu">
            
            <li>
              <!-- <a href="#"><i class="glyphicon glyphicon-plus text-primary"></i> Input Data </a> -->
              <a href="<?php echo $baseac; ?>checkpembayaran" id="check_pembayaran"><i class="glyphicon glyphicon glyphicon-check"></i> <span style="margin-left: 5px;"> </span> Check Pembayaran</a>
              <a href="<?php echo $baseac; ?>inputdata" id="input_data"><i class="glyphicon glyphicon-plus text-primary"></i> <span style="margin-left: 5px;"> </span> Input Data </a>
              <a href="<?php echo $baseac; ?>editdata" id="edit_data"><i class="glyphicon glyphicon-pencil text-primary"></i> <span style="margin-left: 5px;"> </span> Edit Data </a>
              <!-- <ul class="treeview-menu">
                
                <li> <small> <a href="<?php echo $baseac; ?>checkpembayaran"><i class="glyphicon glyphicon glyphicon-check"></i> <span style="margin-left: 5px;"> </span> Check Pembayaran & Input Data </a> </small> </li>
                <li> <small> <a href=""><i class="glyphicon glyphicon glyphicon-zoom-in"></i> <span style="margin-left: 5px;"> </span> Check Input Data </a> </small> </li>

              </ul> -->
            </li>

            <!-- <li>
              <a href="<?php echo $basead; ?>setting"><i class="glyphicon glyphicon-bullhorn text-primary"></i> Laporan 2 </a>
              <ul class="treeview-menu">
                <li>
                  <small> 
                    <a href=""> <i class="glyphicon glyphicon-modal-window"></i> <span style="margin-left: 8px;"> </span> Kuitansi </a>
                  </small> 
                </li>
                <li>
                  <small>
                    <a href=""> <i class="glyphicon glyphicon-flag"></i> <span style="margin-left: 8px;"> </span> Check Pangkal </a>
                  </small>
                </li>
                <li>
                  <small>
                    <a href=""> <i class="glyphicon glyphicon-sd-video"></i> <span style="margin-left: 8px;"> </span> Check SPP </a>
                  </small>
                </li>
                <li>
                  <small>
                    <a href=""> <i class="glyphicon glyphicon-list-alt"></i> <span style="margin-left: 8px;"> </span> Check Daftar Ulang </a>
                  </small>
                </li>
              </ul>
            </li>

            <li>
              <a href="<?php echo $basead; ?>setting"><i class="glyphicon glyphicon-check text-primary"></i> Koreksi </a>
              <ul class="treeview-menu">
                <li> 
                  <small> 
                    <a href=""> <i class="glyphicon glyphicon-copy"></i> <span style="margin-left: 8px;"> </span> Koreksi Sequence ID </a>
                  </small>
                </li>
                <li> 
                  <small>
                    <a href=""> <i class="glyphicon glyphicon-ok-sign"></i> <span style="margin-left: 8px;"> </span> Koreksi Data Murid </a>
                  </small>
                </li>
                <li>
                  <small>
                    <a href=""> <i class="glyphicon glyphicon-floppy-saved"></i> <span style="margin-left: 8px;"> </span> Koreksi Input Data </a>
                  </small>
                </li>
              </ul>
            </li> -->

          </ul>
        </li>

        <!-- Try Layout -->
        <!-- <li>
          <a href="#">
            <i class="glyphicon glyphicon-usd"></i> <span> Try Layout </span>
          </a>
          <ul class="treeview-menu">
            
            <li>
              <a href="#"><i class="glyphicon glyphicon-plus text-primary"></i> Input Data </a>
              <ul class="treeview-menu">
                
                <li> <small> <a href="<?php echo $baseac; ?>trylayout"><i class="glyphicon glyphicon glyphicon-check"></i> <span style="margin-left: 5px;"> </span> Check Pembayaran & Input Data </a> </small> </li>
                <li> <small> <a href="<?php echo $baseac; ?>inputdata"><i class="glyphicon glyphicon glyphicon-zoom-in"></i> <span style="margin-left: 5px;"> </span> Check Input Data </a> </small> </li>

              </ul>
            </li>

            <li>
              <a href="<?= $baseac; ?>slipkuitansi"><i class="glyphicon glyphicon-plus text-primary"></i> Slip Kuitansi </a>
            </li>

          </ul>
        </li> -->
        
        <!-- Maintenance -->
        <li>
          <a href="#" id="list_maintenance">
            <i class="glyphicon glyphicon-cog"></i> <span> MAINTENANCE </span>
          </a>
          <ul class="treeview-menu">
            
            <li>
              <a href="<?= $baseac; ?>maintenance" id="form_data"><i class="glyphicon glyphicon-list-alt text-primary"></i> Form Data </a>
            </li>
            <li>
              <a href="<?= $baseac; ?>changepassword" id="ubah_password"><i class="glyphicon glyphicon-wrench text-primary"></i> Ubah Password </a>
            </li>

          </ul>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content" id="cobacontent">

<?php
  if(empty($_GET['on'])){require 'view/home.php';}
  else{
    $act=($_GET['on']);
    if($act=='kelas'){
      require 'view/a-kelas.php';
    }

    #region spp
    else if ($act == 'checkpembayaran') {
      require 'view/spp/input_data/check_pembayaran_dan_inputdata.php';
    } else if ($act == 'trylayout') {
      require 'view/spp/input_data/trylayout.php';
    } else if ($act == 'inputdata') {
      require 'view/spp/input_data/checkinputdata.php';
    } else if ($act == 'slipkuitansi') {
      require 'view/spp/input_data/slipkuitansi.php';
    } else if ($act == 'editdata') {
      require 'view/spp/input_data/editdata.php';
    }

    else if ($act == 'datacheckpayment') {
      require 'view/spp/input_data/datacheckpembayaran.php';
    }

    #region cetak data
    else if ($act == 'checkdata') {
      require 'view/spp/input_data/checkformdata.php';
    }    

    #region form maintenance
    elseif ($act == 'maintenance') {
      require 'view/spp/maitenance/maintenance.php';
    }

    #region change password
    else if ($act == 'changepassword') {
      require 'view/spp/maitenance/changepassword.php';
    }

    else{
      require 'view/404.php';
    }
  }
?>
    </section>
    <!-- /.content -->
  </div>
</div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.8
    </div>
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#"><?php echo $aplikasi['namasek']; ?></a></strong> by ATH
 
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
                    <table id="example1x" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                              <th style="text-align: center;" width="5%">NO</th>
                              <th style="text-align: center;">NIS</th>
                              <th style="text-align: center;">NAMA</th>
                              <th style="text-align: center;">GENDER</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td style="text-align: center;"> 1 </td>
                              <td style="text-align: center;"> 238711 </td>
                              <td style="text-align: center;"> GATHAN REVANZHA </td>
                              <td style="text-align: center;"> LAKI - LAKI </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>

<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo $base; ?>theme/plugins/jQuery/jquery-2.2.3.min.js"></script>

<script src="<?php echo $base; ?>theme/js/summernote.min.js" crossorigin="anonymous"></script>

<!-- Bootstrap 3.3.6 -->
<script src="<?php echo $base; ?>theme/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo $base; ?>theme/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $base; ?>theme/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo $base; ?>theme/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $base; ?>theme/plugins/fastclick/fastclick.js"></script>
<!-- Sparkline -->
<script src="<?php echo $base; ?>theme/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<!-- SlimScroll 1.3.0 -->
<script src="<?php echo $base; ?>theme/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<!-- AdminLTE App -->
<script src="<?php echo $base; ?>theme/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $base; ?>theme/dist/js/demo.js"></script>
<!-- <script src="<?php echo $base; ?>theme/plugins/select2/select2.full.min.js"></script> -->
<script>
  $(function () {
    $("#example1x").DataTable({
      "paging": true
    });
    $('#example2').DataTable({
      "paging": false,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": false
    });
    $('#example3').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": false
    });
    $('#tabelCariSiswaCheckPembayarans').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": false
    });
  });

</script>
<script src="<?php echo $base; ?>theme/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<script src="<?php echo $base; ?>theme/plugins/pace/pace.min.js"></script>
<script type="text/javascript">
  // To make Pace works on Ajax calls
  $(document).ajaxStart(function() { Pace.restart(); });
    $('.ajax').click(function(){
        $.ajax({url: '#', success: function(result){
            $('.ajax-content').html('<hr>Ajax Request Completed !');
        }});
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Select2 -->
<script src="<?php echo $base; ?>theme/plugins/select2/select2.full.min.js"></script>
<script>
  $(function () {
    $("#changePassword").click(function() {
      document.location.href = `<?= $baseac; ?>changepassword`
    })
    //Initialize Select2 Elements
    $("#select2").select2();
  });
  $(function () {
    //Initialize Select2 Elements
    $("#select3").select2();
  });
  $(function () {
    //Initialize Select2 Elements
    $("#select4").select2();
  });
</script>
<script>
//angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
$(document).ready(function(){
  alert(`Welcome <?= ucfirst($_SESSION['start_name']); unset($_SESSION['start_name']); ?>`)
  setTimeout(function(){
    $(".alert").fadeIn('fast');}, 100);
  });
//angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
setTimeout(function(){$(".alert").fadeOut('fast');}, 3000);
</script>
</body>
</html>
