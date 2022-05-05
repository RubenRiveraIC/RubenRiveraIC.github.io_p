<?php
	
	function isNull($nombre, $user, $pass, $pass_con, $email){
		if(strlen(trim($nombre)) < 1 || strlen(trim($user)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($pass_con)) < 1 || strlen(trim($email)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}
	
	function isEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
			} else {
			return false;
		}
	}
	
	function validaPassword($var1, $var2)
	{
		if (strcmp($var1, $var2) !== 0){
			return false;
			} else {
			return true;
		}
	}
	
	
	
	function resultBlock($errors){
		if(count($errors) > 0)
		{
			echo "<script> swal({title: '¡ERROR!', html: '<ul style=\"list-style: none;\">' +";
			foreach($errors as $error)
			{
				echo "'<li>".$error."</li>' +";
			}
			echo "'</ul>',type: 'error',timer: 5000});</script>";
			
		}
	}
	

	function enviarEmail($email, $nombre, $asunto, $cuerpo){
		
		require_once 'PHPMailer/PHPMailerAutoload.php';
		
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPAuth = true; 
		$mail->SMTPSecure = 'starttls'; //Modificar
		$mail->Host = 'h-tech.htech.mx'; //Modificar
		$mail->Port = 587; //Modificar
		
		$mail->Username = 'ruben.rivera@htech.mx'; //Modificar
		$mail->Password = 'HZSVDB07971217*'; //Modificar
		
		$mail->setFrom('ruben.rivera@htech.mx', 'Sistema de Usuarios HTECH'); //Modificar
		$mail->addAddress($email, $nombre);
		
		$mail->Subject = $asunto;
		$mail->Body    = $cuerpo;
		$mail->IsHTML(true);
		
		if($mail->send())
		return true;
		else
		return false;
	}
	
	
	function isNullLogin($usuario, $password){
		if(strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	
	

	//este bloque se usa para hacer el login con el URL
	function loginWB($usuario, $password)
	{
		
		
		
		//oscar.telles@htech.mx
		//V4LP4R4ISO12*
		//

		//para el token hay que recuperar la mac del dispositovo y concatenarle una "d" en minusculass
		//PHP code to get the MAC address of Client
		$MAC = exec('getmac');
		$MAC = strtok($MAC, ' ');
		$token = $MAC.'d';
		
		// echo $token;
		
		//Ejemplo Login => $url = 'https://webservice.htech.mx/login.php?usuario=oscar.telles@htech.mx&password=V4LP4R4ISO12*&token=00-FF-5E-B8-4A-B6d';
		$url = "https://webservice.htech.mx/login.php?usuario=$usuario&password=$password&token=$token";
		// Ejemplo Consulta => $url2 = "https://webservice.htech.mx/consultar.php?opcion=24&id_sensor=34&fecha_inicial=20220314000000&fecha_final=20220314115900";
		// /* STEP 1. let’s create a cookie file */
		$ckfile = @tempnam ("/tmp", "CURLCOOKIE");
		/* STEP 2. visit the homepage to set the cookie properly */
		$ch = curl_init ($url);
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$output_login = curl_exec ($ch);
		$_SESSION['usuario'] = $usuario;
		$_SESSION['ck'] = $ckfile;
		switch ($output_login) {
			case '0':
				$errors = "La sesión ya está abierta.";
				header("location: principal.php");
				break;
			case '1':
				$errors = " La sesión se ha abierto gracias a la cookie indicada";
				header("location: principal.php");
				break;
			case '2':
				$errors = "Sesión iniciada correctamente.";
				header("location: principal.php");
				break;
			case '3':
				$errors = "El nombre de usuario no existe.";
				break;
			case '4':
				$errors = "La contraseña es incorrecta.";
				break;
			case '5':
				$errors = "No se ingresaron nombre de usuario y/o contraseña.";
				break;
			case '6':
				$errors = "La cuenta no ha sido activada.";
				break;
			case '7':
				$errors = "Sesión iniciada correctamente..";
				header("location: principal.php");
				break;	
			default:
			$errors = "No se pudo hacer contacto con el servidor.";
				break;
		}
		//echo "<script>console.log('coderesponse: ".$content."' );</script>";
		
		return $errors;
	}

	function menubar_tiposub($T_sub,$ckfile){

		
			$url2 = "https://webservice.htech.mx/consultar.php?opcion=19&tipo_subsistema=$T_sub";
			/* STEP 3. visit cookiepage.php */
			$ch = curl_init ($url2);
			curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile); 
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
			$output_consulta = curl_exec ($ch);
			$Jout = json_decode($output_consulta);
			
			return $Jout;
	
	}

	function menubar_idsub($id_sub,$ckfile){

		$url2 = "https://webservice.htech.mx/consultar.php?opcion=21&id_subsistema=$id_sub";
		/* STEP 3. visit cookiepage.php */
		$ch = curl_init ($url2);
		curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$output_consulta = curl_exec ($ch);
		$Jout = json_decode($output_consulta); 

		return $Jout;

	
	}

	function CUsuario($ckfile){
		$url2 = "https://webservice.htech.mx/consultar.php?opcion=18";
		/* STEP 3. visit cookiepage.php */
		$ch = curl_init ($url2);
		curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$output_consulta = curl_exec ($ch);
		$Jout = json_decode($output_consulta); 

		return $Jout;
	}

	function emailExiste($email){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://webservice.htech.mx/recover.php");
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "usuario=$email&aplicacion=1");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec ($ch);
		curl_close ($ch);
        return ($output==1 || $output==0) ? true : false;
        
	}

	function verificaTokenPass($token){
		// abrimos la sesión cURL
		$ch = curl_init();

		// definimos la URL a la que hacemos la petición
		curl_setopt($ch, CURLOPT_URL,"https://webservice.htech.mx/cambiarpassword.php");
		// indicamos el tipo de petición: POST
		curl_setopt($ch, CURLOPT_POST, TRUE);
		// definimos cada uno de los parámetros
		curl_setopt($ch, CURLOPT_POSTFIELDS, "codigo=$token");

		// recibimos la respuesta y la guardamos en una variable
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$remote_server_output = curl_exec ($ch);

		// cerramos la sesión cURL
		curl_close ($ch);

       return ($remote_server_output==1) ? true : false;
       
	}

	function cambiaPassword($password, $token){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://webservice.htech.mx/cambiarpassword.php");
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "codigo=$token&password=$password");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$remote_server_output = curl_exec ($ch);
		curl_close ($ch);

       return ($remote_server_output==0) ? true : false;
	}