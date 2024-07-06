<?php

  $timeOut        = $_SESSION['expire'];
    
  $timeRunningOut = time() + 5;
  $timeIsOut      = 0;

  $getDataACC     = mysqli_query($con, "SELECT nama FROM accounting WHERE c_accounting = '$_SESSION[c_accounting]' ");
  $getDataACC     = mysqli_fetch_array($getDataACC);
  $checkSession   = str_replace(["Accounting_"], "", $getDataACC['nama']);
  // echo $checkSession;exit;

  if ($timeRunningOut == $timeOut || $timeRunningOut > $timeOut) {

    if ($_SESSION['c_accounting'] == 'accounting1' || $checkSession == 'sd') {
      $jsi=mysqli_query($con,"SELECT * FROM data_murid_sd WHERE KELAS LIKE '%SD%' ");
      $hsi=mysqli_num_rows($jsi);
    } else if ($_SESSION['c_accounting'] == 'accounting2' || $checkSession == 'tk') {
      $jsi=mysqli_query($con,"SELECT * FROM data_murid_tk WHERE KELAS LIKE '%KB%' OR KELAS LIKE '%TKA%' OR KELAS LIKE '%TKB%' ");
      $hsi=mysqli_num_rows($jsi);
    }

    $_SESSION['form_success'] = "session_time_out";
    $timeIsOut = 1;
    // exit;

  } else {

    if ($_SESSION['c_accounting'] == 'accounting1' || $checkSession == 'sd') {
      $jsi=mysqli_query($con,"SELECT * FROM data_murid_sd WHERE KELAS LIKE '%SD%' ");
      $hsi=mysqli_num_rows($jsi);
    } else if ($_SESSION['c_accounting'] == 'accounting2' || $checkSession == 'tk') {
      $jsi=mysqli_query($con,"SELECT * FROM data_murid_tk WHERE KELAS LIKE '%KB%' OR KELAS LIKE '%TKA%' OR KELAS LIKE '%TKB%' ");
      $hsi=mysqli_num_rows($jsi);
    }

  }

  // echo "Waktu Habis : " . $timeOut . " Waktu Berjalan : " . $timeRunningOut

?>

<div class="row">
  <div class="col-xs-12 col-md-12 col-lg-12">
    <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'session_time_out'){?>
      <div style="display: none;" class="alert alert-danger alert-dismissable"> Waktu Sesi Telah Habis
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <?php 
              unset($_SESSION['form_success']); 
          ?>
      </div>
    <?php } ?>
  </div>
</div>

<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <a href="<?php echo $basead; ?>siswa"><div class="info-box bg-blue">
      <span class="info-box-icon"><i class="glyphicon glyphicon-education"></i></span>
        <div class="info-box-content">
          <?php if ($_SESSION['c_accounting'] == 'accounting1' || $checkSession == 'sd'): ?>
            <span class="info-box-text"> siswa SD </span>
          <?php elseif($_SESSION['c_accounting'] == 'accounting2' || $checkSession == 'tk'): ?>
            <span class="info-box-text"> siswa KB TKA TKB </span>
          <?php endif ?>
          <span class="info-box-number"><?php echo $hsi; ?></span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <span class="progress-description">
            AIIS-SPP
          </span>
        </div>
    </div></a>
  </div>
  <!-- <div class="col-xs-12 col-md-9 col-lg-9">
    <div class="box">
      <?php if ($_SESSION['c_accounting'] == 'accounting1'): ?>
        <div class="box-header with-border bg-maroon">
          <h3 class="box-title"> Daftar Nama Siswa SD </h3>
        </div>
      <?php else: ?>
        <div class="box-header with-border bg-maroon">
          <h3 class="box-title"> Daftar Nama Siswa KB TKA TKB </h3>
        </div>
      <?php endif; ?>
      <div class="box-body table-responsive">
        <table id="" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th width="5%">NO</th>
              <th>KELAS</th>
              <th>NAMA</th>
              <th>GENDER</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td> 1 </td>
              <td> 3 SD </td>
              <td> ABDURRAHMAN AKHYAR ALFATIH </td>
              <td> LAKI - LAKI </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    </div>
  </div> -->
</div>





