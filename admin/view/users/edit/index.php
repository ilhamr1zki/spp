<?php 

	$timeOut        = $_SESSION['expire'];
    
    $timeRunningOut = time() + 5;

    $timeIsOut = 0;

    $level  = ['Administrator', 'Accounting'];
    $divisi = ['sd', 'tk'];

    $sesiErr = 0;

    $sesiPage = 0;
    $role = 0;

    $getDataUsers = mysqli_query($con, "
    	SELECT admin.c_admin id_users, admin.username username, admin.nama level 
    	FROM admin 
       	UNION 
       	SELECT accounting.c_accounting id_users, accounting.username username, accounting.nama level FROM 
       	accounting
    ");

    // echo "Waktu Habis : " . $timeOut . " Waktu Berjalan : " . $timeRunningOut;

    if ($timeRunningOut == $timeOut || $timeRunningOut > $timeOut) {

        $_SESSION['form_success'] = "session_time_out";
        $timeIsOut = 1;
        error_reporting(1);
        // exit;

    } else {

    	if (isset($_POST['editData_users'])) {

    		$sesiPage = 1;

    		$idUsers 			= htmlspecialchars($_POST['id_users']);
    		$nameOrUsername 	= htmlspecialchars(strtolower($_POST['username_users']));
    		$levelUsersX		= htmlspecialchars($_POST['lvl_users']);
    		$levelUsers         = str_replace(["_sd", "_tk"], "", $levelUsersX);
    		$divisiUsers		= str_replace(["Accounting_"], "", $levelUsersX);

    		if ($divisiUsers == 'sd') {
    			$role = 1;
    		} elseif ($divisiUsers == 'tk') {
    			$role = 1;
    		} else {
    			if ($idUsers == 'accounting1') {
    				$role = 1;
    			} elseif ($idUsers == 'accounting2') {
    				$role = 1;
    			} else {
    				$role = 0;
    			}
    		}

    	} elseif (isset($_POST['changePass_users'])) {

    		$sesiPage 			= 2;
    		$idUsers 			= htmlspecialchars($_POST['id_users']);

    	}

    }

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

        <?php if(isset($_SESSION['form_error']) && $_SESSION['form_error'] == 'data_duplicate'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Nama / Username Telah Terdaftar
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_error']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_error']) && $_SESSION['form_error'] == 'name_too_short'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Nama / Username Terlalu Pendek
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_error']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_error']) && $_SESSION['form_error'] == 'empty_level'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Tidak Ada Level User Yang Di Pilih
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_error']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_error']) && $_SESSION['form_error'] == 'change_password_too_short'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Password terlalu pendek!
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php 
             	unset($_SESSION['form_error']); 
             	$sesiErr = 1;
             	$nameOrUsername = $nameOrUsername;
             	$isLevel = $isLevel;
             ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_error']) && $_SESSION['form_error'] == 'divisi_empty'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Harap Pilih Divisi Pendidikan Terlebih Dahulu!
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php 
             	unset($_SESSION['form_error']); 
             	$sesiErr 						= 2;
             	$nameOrUsername 				= $nameOrUsername;
             	$dataInputPasswordBaru 			= $dataInputPasswordBaru;
                $dataInputKonfirmasiPassword 	= $dataInputKonfirmasiPassword;
             	$isLevel 						= $isLevel;
             ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_error']) && $_SESSION['form_error'] == 'new_password_error'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Password dan Konfirmasi Password Tidak Sesuai!
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php 
             	unset($_SESSION['form_error']); 
             	$sesiErr = 1;
             	$nameOrUsername = $nameOrUsername;
             	$isLevel = $isLevel;
             ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['error_mysql']) && $_SESSION['error_mysql'] == 'gagal'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Gagal Menambahkan User Baru!
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php 
             	unset($_SESSION['error_mysql']);
             ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'change_password_success'){?>
          <div style="display: none;" class="alert alert-warning alert-dismissable"> User Baru Berhasil Di Tambahkan!
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php 
             	unset($_SESSION['form_success']);
             ?>
          </div>
        <?php } ?>

    </div>
</div>

<div class="box box-info">
	
	<div class="box-header with-border">
    	<h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Edit USER </h3>
    </div>

    <?php if ($sesiPage == 0): ?>
    	
    	<div class="box-body table-responsive">
	        <table id="table_users" class="table table-bordered table-hover">
	          	<thead>
		            <tr>
		              <th style="text-align: center;" width="5%"> NO </th>
		              <th style="text-align: center;"> ID </th>
		              <th style="text-align: center;"> NAMA / USERNAME </th>
		              <th style="text-align: center;"> LEVEL </th>
		              <th style="text-align: center;" width="25%"> ACTION </th>
		            </tr>
		        </thead>
		        <tbody>

	          		<?php $no = 1; ?>
	          		<?php foreach ($getDataUsers as $users): ?>
	          			<tr>
			                <td style="text-align: center;"> <?= $no++; ?> </td>
			                <td style="text-align: center;"> <?= $users['id_users']; ?> </td>
			                <td style="text-align: center;"> <?= $users['username']; ?> </td>
			                <td style="text-align: center;"> <?= str_replace(["_SD", "_TK"],"",strtoupper($users['level'])); ?> </td>
			                <td id="button_act">
			                	<form action="edituser" method="post">
			                		<input type="hidden" name="id_users" value="<?= $users['id_users']; ?>">
			                		<input type="hidden" name="username_users" value="<?= $users['username']; ?>">
			                		<input type="hidden" name="lvl_users" value="<?= $users['level']; ?>">

			                    	<button class="btn btn-sm btn-primary" type="submit" name="editData_users"> <i class="glyphicon glyphicon-pencil"></i> Edit </button>
			                	</form>
			                	<form action="edituser" method="post">
			                		<input type="hidden" name="id_users" value="<?= $users['id_users']; ?>">
			                  		<button class="btn btn-sm btn-success" name="changePass_users"> <i class="glyphicon glyphicon-cog"></i> Change Password </button>
			                	</form>
			                  	<button class="btn btn-sm btn-danger" name="deleteData_Siswa"> <i class="glyphicon glyphicon-trash"></i> Delete </button>
			                </td>
			            </tr>
	          		<?php endforeach ?>

	          	</tbody>
	        </table>
	    </div>

	<?php elseif($sesiPage == 1): ?>
	        
        <form role="form" method="post" action="editdatasiswa">

            <div class="box-body">

	            <div class="row">
	                <div class="col-sm-12">
	                	<div class="box">

		                	<div class="box-body">

		                    	<div class="col-sm-2">
			                        <div class="form-group">
					                    <label>ID<sup style="color: red; font-size: 10px;">*</sup></label>
					                    <input type="text" readonly value="<?= $idUsers; ?>" name="idUsers" class="form-control">
					                </div>
			                    </div>

			                    <div class="col-sm-2">
			                        <div class="form-group">
					                    <label>NAMA / USERNAME</label>
					                    <input type="text" value="<?= $nameOrUsername; ?>" name="nm_username" class="form-control">
					                </div>
			                    </div>

			                    <div class="col-sm-2">
			                        <div class="form-group">
					                    <label>LEVEL</label>
					                    <select class="form-control form-select" name="curr_lvl" id="curr_lvl" onchange="selectDivisi()">
					                      <option value="kosong"> -- PILIH -- </option>
					                      <?php foreach ($level as $lvl): ?>
					                      	<option value="<?= $lvl; ?>" <?=($lvl == $levelUsers )?'selected="selected"':''?> > <?= ($lvl == 'Administrator') ? "ADMINISTRATOR" : "ACCOUNTING" ; ?> </option>
					                      <?php endforeach ?>

					                      <!-- <?php foreach ($jenis_kelamin as $jk): ?>
					                        <?php if ($jk == "L"): ?>
					                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Laki - Laki </option>
					                        <?php elseif($jk == "P"): ?>
					                          <option value="<?= $jk; ?>" <?=($jk == $jkSiswa )?'selected="selected"':''?> > Perempuan </option>
					                        <?php endif ?>
					                      <?php endforeach ?> -->
					                    </select>
				                    
				                  	</div>
			                    </div>

			                    <div class="col-sm-2" id="dvs_pend">
			                        <div class="form-group">
					                    <label>Divisi Pendidikan</label>
					                    <select class="form-control">
					                    	<option value="kosong"> -- PILIH -- </option>
					                    	
					                    	<?php if ($idUsers == 'accounting1'): ?>

					                    		<?php foreach ($divisi as $dvs): ?>
					                    			<option value="<?= $dvs; ?>" <?=($dvs == 'sd' )?'selected="selected"':''; ?> > 
						                    			<?= ($dvs == 'tk') ? "TK" : "SD" ; ?> 
						                    		</option>
				                    			<?php endforeach ?>

				                    		<?php elseif($idUsers == 'accounting2'): ?>
					                    		
					                    		<?php foreach ($divisi as $dvs): ?>
					                    			<option value="<?= $dvs; ?>" <?=($dvs == 'tk' )?'selected="selected"':''; ?> > 
					                    				<?= ($dvs == 'tk') ? "TK" : "SD" ; ?> 
					                    			</option>
				                    			<?php endforeach ?>
				                    		
				                    		<?php else: ?>

				                    			<?php foreach ($divisi as $dvs): ?>
						                    		<option value="<?= $dvs; ?>" <?= ($dvs == $divisiUsers ) ? 'selected="selected"' : ''; ?> > 
						                    			<?= ($dvs == 'tk') ? "TK" : "SD" ; ?>
						                    		</option>
						                    	<?php endforeach ?>

					                    	<?php endif ?>

					                    </select>
					                </div>
			                    </div>

			                    <?php if ($levelUsers == 'Accounting'): ?>
			                    	
			                    	<div class="col-sm-2" id="dvs_pend2">
				                        <div class="form-group">
						                    <label>Divisi Pendidikan</label>
						                    <select class="form-control">
						                    	<option value="kosong"> -- PILIH -- </option>
						                    	
						                    	<?php if ($idUsers == 'accounting1'): ?>

						                    		<?php foreach ($divisi as $dvs): ?>
						                    			<option value="<?= $dvs; ?>" <?=($dvs == 'sd' )?'selected="selected"':''; ?> > 
							                    			<?= ($dvs == 'tk') ? "TK" : "SD" ; ?> 
							                    		</option>
					                    			<?php endforeach ?>

					                    		<?php elseif($idUsers == 'accounting2'): ?>
						                    		
						                    		<?php foreach ($divisi as $dvs): ?>
						                    			<option value="<?= $dvs; ?>" <?=($dvs == 'tk' )?'selected="selected"':''; ?> > 
						                    				<?= ($dvs == 'tk') ? "TK" : "SD" ; ?> 
						                    			</option>
					                    			<?php endforeach ?>
					                    		
					                    		<?php else: ?>

					                    			<?php foreach ($divisi as $dvs): ?>
							                    		<option value="<?= $dvs; ?>" <?= ($dvs == $divisiUsers ) ? 'selected="selected"' : ''; ?> > 
							                    			<?= ($dvs == 'tk') ? "TK" : "SD" ; ?>
							                    		</option>
							                    	<?php endforeach ?>

						                    	<?php endif ?>

						                    </select>
						                </div>
				                    </div>

			                    <?php endif ?>

	                    	</div>

	                  	</div>
	                </div>
	            </div>
			
			</div>

            <div class="box-footer" id="button_form_edit">
              <button type="submit" name="update_siswa" id="btnSimpan" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-floppy-disk"></i> Update Users </button>

        </form>  

	    <form action="edituser" method="POST">
	        <button type="submit" name="back" id="btnSimpan" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-log-out" id="cancel"></i> Kembali </button>
	    </form>

          	</div>

    <?php elseif($sesiPage == 2): ?>

    	<form role="form" method="post" action="editdatasiswa">

            <div class="box-body">

	            <div class="row">
	                <div class="col-sm-12">
	                	<div class="box">

		                	<div class="box-body">

		                		<div class="col-sm-2">
			                        <div class="form-group">
					                    <label>ID</label>
					                    <input type="text" value="<?= $idUsers; ?>" name="idUsers" readonly class="form-control">
					                </div>
			                    </div>

			                    <div class="col-sm-2">
			                        <div class="form-group">
					                    <label>PASSWORD SEKARANG</label>
					                    <input type="password" name="curr_pass" placeholder="password sekarang" class="form-control">
					                </div>
			                    </div>

			                    <div class="col-sm-3">
			                        <div class="form-group">
					                    <label>PASSWORD BARU</label>
					                    <input type="password" name="new_pass" placeholder="password baru" class="form-control">
					                </div>
			                    </div>

			                    <div class="col-sm-3">
			                        <div class="form-group">
					                    <label>KONFIRMASI PASSWORD BARU</label>
					                    <input type="password" name="conf_new_pass" placeholder="konfirmasi password baru" class="form-control">
					                </div>
			                    </div>

	                    	</div>

	                  	</div>
	                </div>
	            </div>
			
			</div>

            <div class="box-footer" id="button_form_edit">
              <button type="submit" name="update_siswa" id="btnSimpan" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-floppy-disk"></i> Update Users </button>

        </form>  

	    <form action="edituser" method="POST">
	        <button type="submit" name="back" id="btnSimpan" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-log-out" id="cancel"></i> Kembali </button>
	    </form>

          	</div>

    <?php endif ?>

</div>

<script type="text/javascript">

	let roles  = `<?= $role; ?>`
	
	$("#dvs_pend").hide();
	$(document).ready( function () {
	    $("#list_users").click();
	    $("#edituser").css({
	        "background-color" : "#ccc",
	        "color" : "black"
	    });
	});

	function selectDivisi() {
		let dataLevelUser = document.getElementById("curr_lvl").value;
		if (roles == 0) {
		    if (dataLevelUser == 'Administrator') {
		      $("#dvs_pend").hide();
		    } else if (dataLevelUser == 'Accounting') {
		      $("#dvs_pend").show();
		    } else {
		      $("#dvs_pend").hide();
		    }
		} else if (roles == 1) {
			$("#dvs_pend").hide();
			if (dataLevelUser == 'Administrator') {
		      $("#dvs_pend2").hide();
		    } else if (dataLevelUser == 'Accounting') {
		      $("#dvs_pend2").show();
		    } else {
		      $("#dvs_pend2").hide();
		    }
		}
	}

</script>