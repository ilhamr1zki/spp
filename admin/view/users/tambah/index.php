<?php 

	$timeOut        = $_SESSION['expire'];
    
    $timeRunningOut = time() + 5;

    $timeIsOut = 0;

    // echo "Waktu Habis : " . $timeOut . " Waktu Berjalan : " . $timeRunningOut;

    if ($timeRunningOut == $timeOut || $timeRunningOut > $timeOut) {

        $_SESSION['form_success'] = "session_time_out";
        $timeIsOut = 1;
        error_reporting(1);
        // exit;

    } 

?>

<script type="text/javascript">
	
	$(document).ready( function () {
	    $("#list_users").click();
	    $("#tambahuser").css({
	        "background-color" : "#ccc",
	        "color" : "black"
	    });
	  });

</script>