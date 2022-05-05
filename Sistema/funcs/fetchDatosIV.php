<?php
session_start();
$ckfile = $_SESSION['ck'];
$id_S = $_POST['id'];
$F_I = $_POST['fi'];
$F_F = $_POST['ff'];

if(isset($_POST['id'])) {
  
  	$url4 = "https://webservice.htech.mx/consultar.php?opcion=109&id_grupo=$id_S&fecha_inicial=$F_I&fecha_final=$F_F";

	$ch = curl_init ($url4);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$output3 = curl_exec ($ch);
	echo $output3;
}	





?>