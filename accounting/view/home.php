<?php

  if ($_SESSION['c_accounting'] == 'accounting1') {
    $jsi=mysqli_query($con,"SELECT * FROM siswa WHERE c_kelas LIKE '%SD%' ");$hsi=mysqli_num_rows($jsi);
  } else if ($_SESSION['c_accounting'] == 'accounting2') {
    $jsi=mysqli_query($con,"SELECT * FROM siswa WHERE c_kelas LIKE '%KB%' OR c_kelas LIKE '%TKA%' OR c_kelas LIKE '%TKB%' ");$hsi=mysqli_num_rows($jsi);
  }


?>

<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <a href="<?php echo $basead; ?>siswa"><div class="info-box bg-blue">
      <span class="info-box-icon"><i class="glyphicon glyphicon-education"></i></span>
        <div class="info-box-content">
          <?php if ($_SESSION['c_accounting'] == 'accounting1'): ?>
            <span class="info-box-text"> siswa SD </span>
          <?php elseif($_SESSION['c_accounting'] == 'accounting2'): ?>
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
  <div class="col-xs-12 col-md-9 col-lg-9">
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
  </div>
</div>





