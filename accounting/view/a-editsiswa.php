<?php $aksis=mysqli_query($con,"SELECT s.*, sj.nmjilid, sj.nmbagian, kls.kelas FROM siswa s left join sisjilid_h sj on s.c_siswa = sj.c_siswa left join kelas kls on s.c_kelas = kls.c_kelas where s.c_siswa='$_GET[q]' ");$hasis=mysqli_fetch_array($aksis); $sqlKlp=mysqli_query($con,"SELECT * FROM m_klp"); $sqlKls=mysqli_query($con,"SELECT * FROM kelas order by kelas");?>
<div class="row">
        <!-- left column -->
        <div class="col-md-12">
        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='edit'){?>
          <div style="display: none;" class="alert alert-success alert-dismissable">Siswa Berhasil Diedit
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          </div>
        <?php } $_SESSION['pesan'] = '';?>
          <!-- general form elements -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"> <i class="glyphicon glyphicon-user"></i> Edit Siswa</h3><span style="float:right;"><a href="<?php echo $basead.'siswa'; ?>" class="btn btn-circle btn-primary"><i class="glyphicon glyphicon-th-list"></i> Lihat Siswa</a></span>
            </div>
            <!-- form start -->
            <form role="form" method="post" enctype="multipart/form-data" action="<?php echo $basead; ?>a-control/<?php echo md5('editsiswa'); ?>/access">
            <input type="hidden" name="c_siswa" value="<?php echo $_GET['q']; ?>">
              <div class="box-body">
                <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label>NIS</label>
                      <input type="text" name="_nis" class="form-control" value="<?php echo $hasis['nis']; ?>">
                    </div>
                  </div>
                  <div class="col-sm-2">
                      <div class="form-group">
                      <label>NISN</label>
                      <input type="text" name="nisn" class="form-control" value="<?php echo $hasis['nisn']; ?>">
                    </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                      <label>NAMA LENGKAP</label>
                      <input type="text" required="" name="nama" class="form-control" value="<?php echo $hasis['nama']; ?>">
                    </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                      <label>NAMA JILID</label>
                      <input type="text" name="namajilid" class="form-control" value="<?php echo $hasis['nmjilid']; ?>" disabled>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>ALAMAT LAHIR</label>
                      <input type="text" required="" name="alamat" class="form-control" value="<?php echo $hasis['temlahir']; ?>">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>TANGGAL LAHIR</label>
                      <div class="controls input-append date form_date" data-date="1998-10-14" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                          <input class="form-control" type="text" name="tl" value="<?php echo $hasis['tanglahir']; ?>" required="">
                          <span class="add-on"><i class="icon-th"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                      <label>NAMA BAGIAN</label>
                      <input type="text" name="namabagian" class="form-control" value="<?php echo $hasis['nmbagian']; ?>" disabled>
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>JENIS KELAMIN</label>&nbsp;&nbsp;&nbsp;
                        <label><input <?php if($hasis['jk']=='L'){echo 'checked';} ?> type="radio" name="jk" value="L"> Laki-Laki</label>&nbsp;&nbsp;
                        <label><input <?php if($hasis['jk']=='P'){echo 'checked';} ?> type="radio" name="jk" value="P"> Perempuan</label>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>KELAS</label>
                        <select class="form-control form-select" id="_kelasselect" name="_kelasselect" value="<?php echo $hasis['c_kelas']; ?>" required="">
                        <option value="<?php  echo $hasis['c_kelas']; ?>"> <?php echo $hasis['kelas']; ?></option>
                        <?php 
                        while($resKls=mysqli_fetch_array($sqlKls))
                        {?>
                            <option value="<?php  echo $resKls['c_kelas']; ?>"> <?php echo $resKls['kelas']; ?></option>
                        <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>KELOMPOK</label>
                        <select class="form-control form-select" id="_klpselect" name="_klpselect" value="<?php echo $hasis['c_klp']; ?>" onchange="SelesaiChanged()" required="">
                        <option value="<?php  echo $hasis['c_klp']; ?>"> <?php echo $hasis['c_klp']; ?></option>
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
                          <input min=2000 type="number" class="form-control" id="_thnjoin" name="_thnjoin" value="<?php echo $hasis['thn_join']; ?>" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                          <label>Nama Panggilan</label>
                          <input type="text" class="form-control" id="_nmpanggilan" name="_nmpanggilan" value="<?php echo $hasis['panggilan']; ?>">
                      </div>
                  </div>
                  <div class="col-sm-2">
                      <div class="form-group">
                          <label>Berat Badan</label>
                          <input type="text" class="form-control" id="_beratbadan" name="_beratbadan" value="<?php echo $hasis['bbadan']; ?>">
                      </div>
                  </div>
                  <div class="col-sm-2">
                      <div class="form-group">
                          <label>Tinggi Badan</label>
                          <input type="text" class="form-control" id="_tinggibadan" name="_tinggibadan" value="<?php echo $hasis['tbadan']; ?>">
                      </div>
                  </div>
                  <div class="col-sm-2">
                      <div class="form-group">
                          <label>Ukuran Baju</label>
                          <input type="text" class="form-control" id="_ukuranbaju" name="_ukuranbaju" value="<?php echo $hasis['ukuran_baju']; ?>">
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4">
                        <div class="form-group">
                          <label>Alamat</label>
                          <input type="text" class="form-control" id="_alamatrumah" name="_alamatrumah" value="<?php echo $hasis['alamat']; ?>">
                      </div>
                  </div>
                  <div class="col-sm-2">
                        <div class="form-group">
                          <label>Telp.</label>
                          <input type="text" class="form-control" id="_telp" name="_telp" value="<?php echo $hasis['telp']; ?>">
                      </div>
                  </div>
                  <div class="col-sm-2">
                        <div class="form-group">
                          <label>HP</label>
                          <input type="text" class="form-control" id="_hp" name="_hp" value="<?php echo $hasis['hp']; ?>">
                      </div>
                  </div>
                  <div class="col-sm-4">
                        <div class="form-group">
                          <label>Email</label>
                          <input type="text" class="form-control" id="_email" name="_email" value="<?php echo $hasis['email']; ?>">
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
                                      <input type="text" class="form-control" id="_nmayah" name="_nmayah" value="<?php echo $hasis['nama_ayah']; ?>" required="">
                                  </div>
                                </div>
                                <div class="col-sm-2">
                                  <div class="form-group">
                                      <label>Pendidikan Ayah</label>
                                      <select id="_pendayah" name="_pendayah"  class="form-control form-select" value="<?php echo $hasis['pendidikan_a']; ?>">
                                          <option value="<?php echo $hasis['pendidikan_a']; ?>"><?php echo $hasis['pendidikan_a']; ?></option>
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
                                      <select id="_pekerjaanayah" name="_pekerjaanayah" class="form-control form-select" value="<?php echo $hasis['pekerjaan_a']; ?>">
                                          <option value="<?php echo $hasis['pekerjaan_a']; ?>"><?php echo $hasis['pekerjaan_a']; ?></option>
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
                                      <input type="text" class="form-control" id="_temptglayah" name="_temptglayah" value="<?php echo $hasis['ttl_a']; ?>">
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
                                      <input type="text" class="form-control" id="_nmibu" name="_nmibu" value="<?php echo $hasis['nama_ibu']; ?>" required="">
                                  </div>
                                </div>
                                <div class="col-sm-2">
                                  <div class="form-group">
                                      <label>Pendidikan Ibu</label>
                                      <select id="_pendibu" name="_pendibu"  class="form-control form-select" value="<?php echo $hasis['pendidikan_i']; ?>">
                                          <option value="<?php echo $hasis['pendidikan_i']; ?>"><?php echo $hasis['pendidikan_i']; ?></option>
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
                                      <select id="_pekerjaanibu" name="_pekerjaanibu" class="form-control form-select" value="<?php echo $hasis['pekerjaan_i']; ?>">
                                          <option value="<?php echo $hasis['pekerjaan_i']; ?>"><?php echo $hasis['pekerjaan_i']; ?></option>
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
                                      <input type="text" class="form-control" id="_temptglibu" name="_temptglibu" value="<?php echo $hasis['ttl_i']; ?>">
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
                <button type="submit" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan</button>
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
function SelesaiChanged(selesaival) {
    //alert( $('#_klpselect').val());
}
</script>