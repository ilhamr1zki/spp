<?php 
if(isset($_GET['q'])){
  $poskelas=mysqli_query($con,"SELECT * FROM kelas where c_kelas='$_GET[q]' ");$dkelas=mysqli_fetch_array($poskelas); 
}
$sqlKlp=mysqli_query($con,"SELECT * FROM m_klp");
?>
<div class="row">
        <!-- left column -->
        <div class="col-md-12">
        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='tambah'){?>
          <div style="display: none;" class="alert alert-success alert-dismissable">Siswa Berhasil Ditambahkan
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          </div>
        <?php } $_SESSION['pesan'] = '';?>
          <!-- general form elements -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Tambah Siswa Kelas <?php echo $dkelas['kelas']; ?></h3><span style="float:right;"><a href="<?php echo $basead.'siswa/'.$_GET['q']; ?>" class="btn btn-circle btn-primary"><i class="glyphicon glyphicon-th-list"></i> Lihat Siswa</a></span>
            </div>
            <!-- form start -->
            <form role="form" method="post" enctype="multipart/form-data" action="<?php echo $basead; ?>a-control/<?php echo md5('addsiswa'); ?>/access">
            <input type="hidden" name="c_kelas" value="<?php echo $_GET['q']; ?>">
              <div class="box-body">
                <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label>NIS</label>
                      <input type="text" name="_nis" class="form-control">
                    </div>
                  </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                          <label>NISN</label>
                          <input type="text"  name="nisn" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                          <label>NAMA LENGKAP</label>
                          <input type="text" required="" name="nama" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>ALAMAT LAHIR</label>
                      <input type="text" required="" name="alamat" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>TANGGAL LAHIR</label>
                      <div class="controls input-append date form_date" data-date="1998-10-14" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                          <input class="form-control" type="text" name="tl" value="" required="">
                          <span class="add-on"><i class="icon-th"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                          <label>JENIS KELAMIN</label>&nbsp;&nbsp;&nbsp;
                          <label><input type="radio" name="jk" value="L"> Laki-Laki</label>&nbsp;&nbsp;
                          <label><input type="radio" name="jk" value="P"> Perempuan</label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>KELOMPOK</label>
                        <select class="form-control form-select" id="_klpselect" required="" name="_klpselect" onchange="SelesaiChanged()">
                        <option value="">--Pilih--</option>
                        <?php 
                        while($resKlp=mysqli_fetch_array($sqlKlp))
                        {?>
                            <option value="<?php  echo $resKlp['nm_klp']; ?>"> <?php echo $resKlp['nm_klp']; ?></option>
                        <?php } ?>
                        </select>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                      <div class="form-group">
                          <label>Tahun Join</label>
                          <input min=2000 type="number" class="form-control" id="_thnjoin" name="_thnjoin" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                          <label>Nama Panggilan</label>
                          <input type="text" class="form-control" id="_nmpanggilan" name="_nmpanggilan">
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
                          <input type="text" class="form-control" id="_email" name="_email" >
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
                                <div class="col-sm-4">
                                  <div class="form-group">
                                      <label>Nama Ayah</label>
                                      <input type="text" class="form-control" id="_nmayah" name="_nmayah" required="">
                                  </div>
                                </div>
                                <div class="col-sm-2">
                                  <div class="form-group">
                                      <label>Pendidikan Ayah</label>
                                      <select id="_pendayah" name="_pendayah"  class="form-control form-select">
                                          <option value="">--Pilih--</option>
                                          <?php 
                                              foreach($pendidikans as $item){
                                                echo "<option value='$item'>$item</option>";
                                            }
                                          ?>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-sm-3">
                                  <div class="form-group">
                                      <label>Pekerjaan Ayah</label>
                                      <select id="_pekerjaanayah" name="_pekerjaanayah" class="form-control form-select">
                                          <option value="">--Pilih--</option>
                                          <?php 
                                              foreach($pekerjaans as $item){
                                                echo "<option value='$item'>$item</option>";
                                            }
                                          ?>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-sm-3">
                                  <div class="form-group">
                                      <label>Tempat Tgl. Ayah</label>
                                      <input type="text" class="form-control" id="_temptglayah" name="_temptglayah">
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
                                <div class="col-sm-4">
                                  <div class="form-group">
                                      <label>Nama Ibu</label>
                                      <input type="text" class="form-control" id="_nmibu" name="_nmibu" required="">
                                  </div>
                                </div>
                                <div class="col-sm-2">
                                  <div class="form-group">
                                      <label>Pendidikan Ibu</label>
                                      <select id="_pendibu" name="_pendibu"  class="form-control form-select">
                                          <option value="">--Pilih--</option>
                                          <?php 
                                              foreach($pendidikans as $item){
                                                echo "<option value='$item'>$item</option>";
                                            }
                                          ?>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-sm-3">
                                  <div class="form-group">
                                      <label>Pekerjaan Ibu</label>
                                      <select id="_pekerjaanibu" name="_pekerjaanibu" class="form-control form-select">
                                          <option value="">--Pilih--</option>
                                          <?php 
                                              foreach($pekerjaans as $item){
                                                echo "<option value='$item'>$item</option>";
                                            }
                                          ?>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-sm-3">
                                  <div class="form-group">
                                      <label>Tempat Tgl. Ibu</label>
                                      <input type="text" class="form-control" id="_temptglibu" name="_temptglibu">
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
              </div>

                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" id="btnSimpan" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan Siswa</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
</div>
<!-- jQuery 2.2.3 -->
<script src="<?php echo $base; ?>theme/plugins/jQuery/jquery-2.2.3.min.js"></script>
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

<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('#nisn').val();


});

// $('#btnSimpan').click(function () {
//             if ($('#nisn').val() == "" || $('#nisn').val() == null) {
//                 alert('NISN belum diisi');
//                 return false;
//             }

//           ]);


function SelesaiChanged(selesaival) {
    //alert( $('#_klpselect').val());
}
</script>
