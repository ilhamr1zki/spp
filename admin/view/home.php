<?php
$jsi=mysqli_query($con,"SELECT * FROM siswa ");$hsi=mysqli_num_rows($jsi);
$jgu=mysqli_query($con,"SELECT * FROM guru ");$hgu=mysqli_num_rows($jgu);
$jwam=mysqli_query($con,"SELECT * FROM walimurid ");$hwam=mysqli_num_rows($jwam);
$jmapel=mysqli_query($con,"SELECT * FROM mapel ");$hmapel=mysqli_num_rows($jmapel);
$dnil=mysqli_query($con,"SELECT * FROM nilai ");$jdnil=mysqli_num_rows($dnil);
$kelkel=mysqli_query($con,"SELECT * FROM kelas ");$jkelkel=mysqli_num_rows($kelkel);


// $generatePw = password_hash($passAdm, PASSWORD_DEFAULT);
// echo $generatePw;

?>

<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <a href="<?php echo $basead; ?>siswa"><div class="info-box bg-blue">
      <span class="info-box-icon"><i class="glyphicon glyphicon-education"></i></span>
        <div class="info-box-content">
          <span class="info-box-text"> siswa SD </span>
          <span class="info-box-number"><?php echo $hsi; ?></span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <span class="progress-description">
            AIIS-APPS
          </span>
        </div>
    </div></a>
  </div>
  <div class="col-xs-12 col-md-9 col-lg-9">
    <div class="box">
      <div class="box-header with-border bg-maroon">
        <h3 class="box-title"> Daftar Nama Siswa SD </h3>
      </div>
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





