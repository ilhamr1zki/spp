<script language="javascript" type="text/javascript">
function OpenAddModal(){
        $('#_nmdok').val('');
        $('#_deskripsiadd').val('');

        $('#addpustaka').modal("show");
    }
    function OpenEdit(id, nmdok, deskdok) {
        _id = id;
        
        $('#_idedit').val(_id);
        $('#_nmdokeddit').val(nmdok);
        $('#_deskripsiedit').val(deskdok);

        $('#editpustaka').modal("show");
    }
    function OpenDeleteModal(id, filedokdel){
        _id = id;
        $('#_idhapus').val(id);
        $('#_filedokdel').val(filedokdel);

        $('#hapuspustaka').modal("show");
    }
    function ViewFilepustaka(nmfile)
    {
        var pdfFileName = nmfile ; 
        var iframe = document.getElementById('pdfFrame');
        iframe.src = 'view/qiroati/pdf-viewer.php?pdf=' + encodeURIComponent(pdfFileName);
        $('#pupviewfile').modal("show");
    }
</script>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='tambah'){?>
          <div style="display: none;" class="alert alert-warning alert-dismissable">Data Dokumen Berhasil Disimpan
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='edit'){?>
          <div style="display: none;" class="alert alert-info alert-dismissable">Data Dokumen Berhasil Diedit
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='hapus'){?>
          <div style="display: none;" class="alert alert-info alert-dismissable">Data Dokumen Berhasil Dihapus
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          </div>
        <?php } ?>
    </div>
</div>

<?php $_SESSION['pesan'] = '';?>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"> <i class="glyphicon glyphicon-book"></i> Data Dokumen</h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenAddModal()"><i class="glyphicon glyphicon-plus"></i> Tambah Pustaka</a></span>
    </div>


    <div class="box-body table-responsive">
    
            <table id="example1" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th width="5%">NO</th>
                <th>NAMA DOKUEMN</th>
                <th>DESKRIPSI</th>
                <th>FILE DOKUMEN</th>
                <th style="text-align:center;">OPSI</th>
            </tr>
            </thead>
            <tbody>
            <?php $smk=mysqli_query($con,"SELECT * FROM pustaka order by id desc ");
            $vr=1;
            while($akh=mysqli_fetch_array($smk)){?>
                <tr>
                  <td><?php echo $vr; ?></td>
                  <td><?php echo $akh['nama_dokumen']; ?></td>
                  <td><?php echo $akh['deskripsi']; ?></td>
                  <td>
                    <a style="cursor:pointer;" onclick="ViewFilepustaka('<?php echo $akh['file_dokumen'] ?>')"><i class="glyphicon glyphicon-open-file"></i> <?php echo $akh['file_dokumen']; ?></a>
                </td>
                  <td align="center">
                    <a class="btn btn-circle btn-primary btn-sm" onclick="OpenEdit('<?php echo $akh['id'] ?>', '<?php echo $akh['nama_dokumen'] ?>', '<?php echo $akh['deskripsi'] ?>' )" data-toggle="modal"> <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                    <a class="btn btn-circle btn-danger btn-sm"  onclick="OpenDeleteModal('<?php echo $akh['id']; ?>', '<?php echo $akh['file_dokumen'] ?>')" data-toggle="modal"><i class="glyphicon glyphicon-remove"></i>Delete</a>
                  </td>
                </tr>

                

            <?php $vr++;
            }?>
            </tbody>

        </table>
    </div>


</div>


<div id="addpustaka" class="modal"  data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-calendar"></i> Tambah Dokumen</h4>
            </div>
            
            <form action="<?php echo $basead; ?>a-control/<?php echo md5('addpustaka'); ?>/access" method="post" enctype="multipart/form-data">
            <div class="modal-body">  
            <input type="hidden" id="_userdok" name="_userdok" class="form-control" value="<?php echo $na['nama'] ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nama Dokumen</label>
                            <input type="text" id="_nmdok" name="_nmdok" class="form-control">
                        </div>
                    </div>  
                    
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input type="text" id="_deskripsiadd" name="_deskripsiadd" class="form-control">
                        </div>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>File Dokumen</label>
                            <input type="file" id="_filedok" name="_filedok" accept="application/pdf" class="form-control">
                        </div>
                    </div>  
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan</button> 
                <a class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Tutup</a>
            </div>
            </form>
        </div>
    </div>
</div>

<div id="editpustaka" class="modal"  data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-calendar"></i> Edit Dokumen</h4>
            </div>
            
            <form action="<?php echo $basead; ?>a-control/<?php echo md5('editpustaka'); ?>/access" method="post" enctype="multipart/form-data">
            <div class="modal-body">  
            <input type="hidden" id="_userdokedit" name="_userdokedit" class="form-control" value="<?php echo $na['nama'] ?>">
            <input type="hidden" id="_idedit" name="_idedit" class="form-control">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nama Dokumen</label>
                            <input type="text" id="_nmdokeddit" name="_nmdokeddit" class="form-control">
                        </div>
                    </div>  
                    
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input type="text" id="_deskripsiedit" name="_deskripsiedit" class="form-control">
                        </div>
                    </div>  
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan</button> 
                <a class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Tutup</a>
            </div>
            </form>
        </div>
    </div>
</div>

<div id="hapuspustaka" class="modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
    <form action="<?php echo $basead; ?>a-control/<?php echo md5('hapuspustaka').'/access' ?>" method="post">
        <div class="modal-content">
            <input type="hidden" id="_idhapus" name="_idhapus" class="form-control">
            <input type="hidden" id="_filedokdel" name="_filedokdel" class="form-control">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Konfirmasi hapus dokumen </h4>
            </div>
            <div class="modal-body">
            <p>Ingin menghapus data pustaka?</p>
            </div>
            <div class="modal-footer">
            <button class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-ok"></i> Lanjutkan</button> 
            <button class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Tutup</button>
            </div>
        </div>
        </form>
    </div>
</div>

<div id="pupviewfile" class="modal"  data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" style="width:1200px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-calendar"></i> VIEW DOKUMEN</h4>
            </div>
            <div class="modal-body">
            <iframe id="pdfFrame" width="100%" height="500px"></iframe>
        </div>
    </div>
</div>
