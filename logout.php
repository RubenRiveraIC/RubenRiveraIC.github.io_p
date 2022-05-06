<?php
	
	session_start();
	$ckfile = $_SESSION['ck'];
	
	// $url = "https://webservice.htech.mx/logout.php";
 //    $content = file_get_contents($url);
    $url2 = "https://webservice.htech.mx/logout.php";
	/* STEP 3. visit cookiepage.php */
	$ch = curl_init ($url2);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$content = curl_exec ($ch);
	echo "<script>console.log('coderesponse: ".$content."' );</script>";
	unlink($ckfile);
	session_destroy();
	header("Location: index.php");
?>