<?php
session_start();
$ckfile = $_SESSION['ck'];
$id_S = $_POST['nameID'];
$F_I = $_POST['fi'];
$F_F = $_POST['ff'];

if(isset($_POST['nameID'])) {
  
  	$url2 = "https://webservice.htech.mx/consultar.php?opcion=24&id_sensor=$id_S&fecha_inicial=$F_I&fecha_final=$F_F";

	$ch = curl_init ($url2);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$output3 = curl_exec ($ch);
	echo $output3;
}	





?>