<?php
session_start();
$ckfile = $_SESSION['ck'];
$id = $_POST['id'];

if(isset($_POST['id'])) {
  
  $url1 = "https://webservice.htech.mx/consultar.php?opcion=16&id_grupo=$id";
	
	$ch = curl_init ($url1);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$output_consulta = curl_exec ($ch);

	echo $output_consulta;
	// $Jout = json_decode($output_consulta); 

	// print_r($Jout);	
}





?>