<?php

    $jsiSD=mysqli_query($con,"SELECT * FROM siswa WHERE c_kelas LIKE '%SD%' ");
    $hsiSD=mysqli_num_rows($jsiSD);

    $jsiTK=mysqli_query($con,"SELECT * FROM siswa WHERE c_kelas LIKE '%KB%' OR c_kelas LIKE '%TKA%' OR c_kelas LIKE '%TKB%' ");
    $hsiTK=mysqli_num_rows($jsiTK);

?>

<div class="row">

  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <a href="<?php echo $basead; ?>siswa"><div class="info-box bg-blue">
      <span class="info-box-icon"><i class="glyphicon glyphicon-education"></i></span>
        <div class="info-box-content">
            <span class="info-box-text"> siswa SD </span>
          <span class="info-box-number"><?php echo $hsiSD; ?></span>
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


