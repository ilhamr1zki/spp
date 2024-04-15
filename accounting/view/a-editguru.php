<?php $eg=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM guru where c_guru='$_GET[q]' ")); ?>
<div class="row">
        <!-- left column -->
        <div class="col-md-12">
        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='edit'){?>
          <div style="display: none;" class="alert alert-success alert-dismissable">Guru Berhasil Diedit
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          </div>
        <?php } $_SESSION['pesan'] = '';?>
          <!-- general form elements -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"> <i class="glyphicon glyphicon-edit"></i> Edit Data Guru</h3><span style="float:right;"><a href="<?php echo $basead.'guru'; ?>" class="btn btn-circle btn-primary"><i class="glyphicon glyphicon-th-list"></i> Lihat Guru</a></span>
            </div>
            <!-- form start -->
            <form role="form" method="post" enctype="multipart/form-data" action="<?php echo $basead; ?>a-control/<?php echo md5('editguru'); ?>/access">
             <input type="hidden" name="c_guru" class="form-control" value="<?php echo $eg['c_guru']; ?>">
              <div class="box-body">
                <div class="row">
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" value="<?php echo $eg['nip']; ?>" required="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>NAMA</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo $eg['nama']; ?>" required="">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>TANGGAL LAHIR</label>
                        <div class="controls input-append date form_date" data-date="1998-10-14" data-date-format="dd-mm-yyyy" data-link-field="dtp_input1">
                            <input class="form-control" type="text" name="tl" value="<?php echo $eg['tanglahir']; ?>" required="">
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                      </div>
                    </div>
                </div>
                
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>ALAMAT LAHIR</label>
                      <input type="text" required="" name="alamat" class="form-control" value="<?php echo $eg['temlahir']; ?>">
                    </div>
                  </div>
                  <div class="col-sm-6">
                      <div class="form-group">
                        <label>JENIS KELAMIN</label>&nbsp;&nbsp;&nbsp;
                        <label><input <?php if($eg['jkel']=='L'){echo 'checked';} ?> type="radio" name="jk" value="L"> Laki-Laki</label>&nbsp;&nbsp;
                        <label><input <?php if($eg['jkel']=='P'){echo 'checked';} ?> type="radio" name="jk" value="P"> Perempuan</label>
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                        <div class="form-group">
                          <label>ALAMAT</label>
                          <input type="text" class="form-control" id="_alamatrumah" name="_alamatrumah" value="<?php echo $eg['alamat']; ?>">
                      </div>
                  </div>
                  <div class="col-sm-2">
                      <div class="form-group">
                          <label>PENDIDIKAN</label>
                          <select id="_pendidikan" name="_pendidikan"  class="form-control form-select" value="<?php echo $eg['pendidikan']; ?>">
                              <option value="<?php echo $eg['pendidikan']; ?>"><?php echo $eg['pendidikan']; ?></option>
                              <?php 
                                  foreach($pendidikans as $item){
                                    echo "<option value='$item'>$item</option>";
                                }
                              ?>
                          </select>
                      </div>
                  </div>
                  <div class="col-sm-4">
                        <div class="form-group">
                          <label>JURUSAN</label>
                          <input type="text" class="form-control" id="_jurusan" name="_jurusan" value="<?php echo $eg['jurusan']; ?>">
                      </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>TANGGAL JOIN</label>
                        <div class="controls input-append date form_date" data-date="14-10-1998" data-date-format="dd-mm-yyyy" data-link-field="dtp_input1">
                            <input class="form-control" type="text" name="tgljoin" value="<?php echo $eg['tgl_join']; ?>" required="">
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>JABATAN</label>
                        <input type="text" name="jabatan" class="form-control" value="<?php echo $eg['c_jabatan']; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>EMAIL</label>
                        <input type="text"  name="_email" class="form-control" value="<?php echo $eg['email']; ?>">
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>USERNAME</label>
                      <input type="text" required="" name="username" class="form-control" value="<?php echo $eg['username']; ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>PASSWORD</label>
                      <input type="text" required="" name="password" class="form-control" value="<?php echo $eg['password']; ?>">
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