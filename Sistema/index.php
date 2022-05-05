<?php
	session_start();
	
	require 'funcs/funcs.php';
   
	$errors = array();

	if(!empty($_POST)){
		$usuario =$_POST['usuario'];
		$password =$_POST['password'];
		$captcha =$_POST['g-recaptcha-response'];
		$secret = '6LfyXHIeAAAAAMCfIoUWvQD1iRHAyFd4nDLYr6NR';

		if(!$captcha){
            $errors[]= "Por Favor Verifica El captcha";
        }

		if(isNullLogin($usuario, $password)){
			$errors[]= "Debe LLenar Todos Los Campos";
		}
		if (count($errors) == 0) {
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
            $arr = json_decode($response, TRUE);
            if ($arr['success']) {
                
                
            	$errors[]= loginWB($usuario, $password);//loginWB($usuario, $password);
            	
	        }else{
	                $errors[] = 'Error Al Comprobar Captcha';
	        }
	    }

		
	}

	
?>

<!DOCTYPE html>
<html lang="es">
    <head>
       <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <meta name="description" content="Bienvenid@s a #Web Telemetry, App de Telemetria, donde podras consultar los datos de Presion, Flujo y Nivel asi como los diferentes valores de las bombas mediante graficas segun sea tu sistema">

        <meta name="theme-color" content="#025C91">
        <meta name="MobileOptimized" content="width">
        <meta name="HandheldFriendly" content="true">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <link href="assets/img/cropped-icon-32x32.png" rel="shorcut icon" sizes="32x32"/>
        <link rel="apple-touch-icon" href="./assets/img/WebTelemetry_ICON_512.png">
        <link rel="apple-touch-startup-image" href="./WebTelemetry_ICON_512.png">
        
        <meta name="author" content="H-Tech Mexico" />
        <title>Web Telemetry H-Tech MX.</title>
        
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/sweetalert2.css"/>
        <script src="js/jquery-3.6.0.min.js"></script>
   		<script src="js/sweetalert2.js"></script>
        <script src='js/api.js'></script>
        <script type="text/javascript">
        	function mostrarPassword(){
				var cambio = document.getElementById("inputPassword");
				if(cambio.type == "password"){
					cambio.type = "text";
					$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
				}else{
					cambio.type = "password";
					$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
				}
			}
        </script>
	</head>
    <body style="background: #025C91;">
    	<?php echo resultBlock($errors); ?>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div>
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header text-center"><img src="assets/img/logo.png"  height="60" width="120"></div>
                                    <div class="card-body">
                                        <h3 class="text-center font-weight-light">Login</h3>
                                        <form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">

                                            <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Usuario</label><input class="form-control py-4" id="inputEmailAddress" name="usuario" type="text" placeholder="Ingresa tu correo" /></div>

                                            <div class="form-group">
                                            	<label class="small mb-1" for="inputPassword">Contraseña</label>
                                            	<div class="input-group">
                                            		<input class="form-control py-4" id="inputPassword" name="password" type="password" placeholder="Ingresa tu contraseña" />
	                                            	<div class="input-group-append">
										            	<button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()">
										            		<span class="fa fa-eye-slash icon"></span>
										            	</button>
										          	</div>
                                            	</div>
                                            </div>
                                           <!--  <div class="form-group">
                                                <div class="custom-control custom-checkbox"><input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" /><label class="custom-control-label" for="rememberPasswordCheck">Remember password</label></div>
											</div> -->
											<div class="form-group">
                                                <label for="captcha" class="col-sm-12 control-label "></label>
                                                <div class="g-recaptcha" data-sitekey="6LfyXHIeAAAAAF2t0k3GAjyEbcgj8bPsuHZb5SUX"></div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"><a class="small linkForm" href="password.php">¿Olvidaste tu contraseña?</a>
											<button type="submit" class="btn btn-primary">Login</button></div>
										</form>
										
									</div>
                                    <div class="card-footer form-group d-flex align-items-center justify-content-between small">
                                        Copyright &copy;  H-Tech México<br>S. de R. L. de C. V.
                                        <a class="linkForm" href="https://htech.mx/privacy-policy/">Politicas de Privacidad</a>
						                &middot;
						                <a class="linkForm" href="https://htech.mx/politica-de-privacidad-de-telemetry-h-tech-mx/">Terminos &amp; Condiciones</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</main>
			</div>
		</div>
        
        
       
	</body>
</html>
