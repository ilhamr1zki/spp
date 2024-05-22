<?php  

	// Jika filter by Pangkal sedangkan filter tanggal dari dan tanggal sampai tidak di isi 
    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
    	echo "Tidak tanggal Pangkal";
    } else {
    	echo "Ada tanggal pangkal";
    }

?>