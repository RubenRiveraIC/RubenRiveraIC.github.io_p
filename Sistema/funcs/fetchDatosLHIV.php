<?php
session_start();
$ckfile = $_SESSION['ck'];
$id_S = $_POST['id'];
date_default_timezone_set('America/Mexico_City');
$F_F= date('YmdHis', time()); 
$F_I= date("YmdHis",strtotime($F_F."- 1 hour"));

if(isset($_POST['id'])) {

	$url4 = "https://webservice.htech.mx/consultar.php?opcion=109&id_grupo=$id_S&fecha_inicial=$F_I&fecha_final=$F_F";
	$ch = curl_init ($url4);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$output2 = curl_exec ($ch);
	echo $output2;
}	

?>