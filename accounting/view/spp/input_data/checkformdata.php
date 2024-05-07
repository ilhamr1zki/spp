<?php 

	$cek = 0;
	$spp = "";
	$nominal_spp;
	$arrKsg = [];

	function RemoveSpecialChar($str) {
 
      // Using str_replace() function 
      // to replace the word 
     	$res = str_replace( 
     		array( 
     			'\'', 
     			'"',
      			',' , 
      			';', 
      			'<', 
      			'>',
      			'.'
      		), 
      		' ',
      		$str
     	);
 
      // Returning the result 
      	return $res;
  	}

	if (isset($_POST['cetak_kuitansi'])) {

		$nominal_spp = str_replace(["Rp. ", ".", '"'],"",$_POST['nominal_spp']);

	} else {

		$nominal_spp;

	}

?>

<script type="text/javascript">
	
	let nominal_spp = `<?= $nominal_spp; ?>`

	$(document).ready(function() {

		$.ajax({
			url : `<?= $baseac; ?>senddataapi.php`,
			method : "POST",
			data : {
				spp : nominal_spp
			},
			success:function(data){

				if(data != 0) {

					$.ajax({
						url : `<?= $baseac; ?>kuitansi.php`,
						method : "POST",
						data : {
							nominal : data
						},
						success:function(data){
							console.log(data)
							setInterval({
								
							},1000)
						}
					})

				}

				// window.open(`<?= $baseac; ?>kuitansi.php`);
			}
		})

	})

</script>