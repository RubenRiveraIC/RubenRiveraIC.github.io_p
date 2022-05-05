<?php
session_start();
$ckfile = $_SESSION['ck'];
$id = $_POST['id'];

if(isset($_POST['id'])) {
  
  $url = "https://webservice.htech.mx/consultar.php?opcion=105&id_grupo=$id";
	
	$ch = curl_init ($url);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$output_consulta = curl_exec ($ch);

	echo $output_consulta;
	
}





?>