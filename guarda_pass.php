<?php
	
	
	require 'funcs/funcs.php';
	
	
	$token = $_POST['token'];
	$password = $_POST['password'];
	$con_password = $_POST['con_password'];

	$url = 'http://'.$_SERVER["SERVER_NAME"].
                '/sistema/cambia_pass.php?token='.$token;

	if (validaPassword($password, $con_password)) {
		if (cambiaPassword($password, $token)){

			echo "
                <head>
                    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css'/>
                    <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
                    <script src='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js'></script></head>
                    <body style='background-color:#025C91;'>
                        <script https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js>swal('Buen Trabajo!','Password Modificado Con Exito!', 'success',{button: 'Iniciar Sesion'}).then(function(){window.location = 'index.php';});</script></body>";

		}else{
			//echo"Error Al Modificar El Password";

			echo "
                <head>
                    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css'/>
                    <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
                    <script src='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js'></script></head>
                    <body style='background-color:#025C91;'>
                        <script https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js>swal('Error!','Error Al Modificar El Password','error',{button: 'Iniciar Sesion'}).then(function(){window.location = '$url';});</script></body>";
		 }
	}else{
		//echo"Las Contraseñas No Coinciden";
		echo "
                <head>
                    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css'/>
                    <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
                    <script src='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js'></script></head>
                    <body style='background-color:#025C91;'>
                        <script https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js>swal('Warning!','Las Contraseñas No Coinciden','warning',{ button: 'Iniciar Sesion'}).then(function(){window.location = '$url';});</script></body>";
	 }


?>	