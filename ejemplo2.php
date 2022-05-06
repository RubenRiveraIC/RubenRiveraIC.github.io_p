<?php
require 'funcs/funcs.php';

session_start();


// $ckfile = $_SESSION['ck'];
// echo $ckfile;
// $DataU = CUsuario($ckfile);
date_default_timezone_set('America/Mexico_City');
$F_F= date('Ymdhis', time()); 
$F_I= date("Ymdhis",strtotime($F_F."- 1 hour"));
// echo $F_F;
// echo "<br>";
// echo $F_I;

// $prueba = menubar_tiposub(1,$ckfile);
// echo "<pre>";
// print_r($prueba);
// echo "</pre>";
// //para el token hay que recuperar la mac del dispositovo y concatenarle una "d" en minusculass
// //PHP code to get the MAC address of Client
// $MAC = exec('getmac');
// $MAC = strtok($MAC, ' ');
// $token = $MAC.'d';

// // echo $token;

 // $url = 'https://webservice.htech.mx/login.php?usuario=oscar.telles@htech.mx&password=V4LP4R4ISO12*&token=00-FF-5E-B8-4A-B6d';
// $url = "https://webservice.htech.mx/consultar.php?opcion=18";
// $url = "https://webservice.htech.mx/consultar.php?opcion=5";
// $url = "https://webservice.htech.mx/consultar.php?opcion=105&id_grupo=7";
// $url = "https://webservice.htech.mx/consultar.php?opcion=19&tipo_subsistema=1";
// $url = "https://webservice.htech.mx/consultar.php?opcion=20&id_subsistema=1";
// $url = "https://webservice.htech.mx/consultar.php?opcion=109&id_grupo=1&fecha_inicial=20220329013657&fecha_final=20220329123657";
// $url = "https://webservice.htech.mx/consultar.php?opcion=24&id_sensor=1&fecha_inicial=$F_I&fecha_final=$F_F";
// $url = "https://webservice.htech.mx/consultar.php?opcion=24&id_sensor=78&fecha_inicial=20220418000000&fecha_final=20220418235959";
 // $url = "https://webservice.htech.mx/consultar.php?opcion=109&id_grupo=1&fecha_inicial=$F_I&fecha_final=$F_F";
// $url = "https://webservice.htech.mx/consultar.php?opcion=8&id_sensor=2";
// $url = "https://webservice.htech.mx/consultar.php?opcion=16&id_grupo=1";
 // $url = "https://webservice.htech.mx/consultar.php?opcion=29&id_sensor=49";

// /* STEP 1. let’s create a cookie file */
//  $ckfile = @tempnam ("/tmp", "CURLCOOKIE");
// /* STEP 2. visit the homepage to set the cookie properly */
// $ch = curl_init ($url);
// curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile); 
// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
// $output = curl_exec ($ch);
// //$_SESSION['file'] = $ckfile;
// echo "Login : ".$output;
// echo "<br>";

/* STEP 3. visit cookiepage.php */
// $ch = curl_init ($url);
// curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile); 
// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
// $output2 = curl_exec ($ch);
// $Jout = json_decode($output2); 

// $ch = curl_init ($url5);
// curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile); 
// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
// $output2 = curl_exec ($ch);
// $Jout2 = json_decode($output2); 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://webservice.htech.mx/recover.php");
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "usuario=ruben.rno18@gmail.com&aplicacion=1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec ($ch);
        curl_close ($ch);

        echo $remote_server_output;

echo "<pre>";
// echo $output2;
// if ($output2 == "[]") {
//     echo "simon es null";
// } else{
//     echo "nomames no es null";
// }

// print_r($data);
// echo "</pre>";
// // echo $Jout[0]->permisosapp;


// // $tiposubFA = menubar_tiposub(0,$ckfile);
// // $tiposubRA = menubar_tiposub(1,$ckfile);
// // echo "<pre>";
// // print_r($tiposubFA);
// // print_r($tiposubRA);
// echo "</pre>";


// //$_SESSION = json_decode($output2);
// echo "<pre>";
// echo "Datos Usuario : <br>";

// print_r($Jout2);
// echo "<br>";
// echo "</pre>";
// $i = 0;
// echo "[";
// foreach ($Jout2 as $key => $Jout[$i]) {
//     echo ("'".$Jout2[$i]->dato."'".",");
//     $i++;
// }
// echo "]";
// echo "<br>";echo "<br>";echo "<br>";


// $i = 0;
// foreach ($Jout as $key => $Jout[$i]) {
//     echo ($Jout[$i]->nombre."<br>");

//     foreach ($Jout2 as $key => $Jout2[$i]) {
//         // echo ($Jout2[$i]->nombre."<br>");
//         echo '<a class="nav-link bg-success rounded" href="Grafico1.php">'.$Jout2[$i]->grupoTexto.'</a>';

//     }
//     $i++;
// }

// date_default_timezone_set('America/Mexico_City');
// $DateAndTime = date('Y/m/d h:i:s', time());  
// echo "The current date and time are $DateAndTime <br>";
// echo date("Ymdhis",strtotime($DateAndTime."- 1 hour")); 
// echo "<br>";
// $F_F= date('Ymdhis', time()); 
// $F_I= date("Ymdhis",strtotime($F_F."- 1 hour")); 
//     echo "Inicio => $F_I  Final => $F_F <br>";



// $url2 = "https://webservice.htech.mx/consultar.php?opcion=24&id_sensor=$id_S&fecha_inicial=$F_I&fecha_final=$F_F";
//         $ch = curl_init ($url2);
//         curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile); 
//         curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
//         $output3 = curl_exec ($ch);
//         //$CDate = json_decode($output3);


?>
