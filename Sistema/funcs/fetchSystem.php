<?php
session_start();
$ckfile = $_SESSION['ck'];

  	$url2 = "https://webservice.htech.mx/consultar.php?opcion=17";

	$ch = curl_init ($url2);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$output3 = curl_exec ($ch);
	echo $output3;





?>