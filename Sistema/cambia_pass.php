<?php
	
	
	require 'funcs/funcs.php';
	
	$token = null;
	
	if (empty($_GET['token'])) {
		header('Location: index.php');///mandar a la pagina de inicio de sesion 
	}

	$token = $_GET['token'];

	if (!verificaTokenPass($token)) {
		echo "
                <head>
                    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css'/>
                    <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
                    <script src='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js'></script></head>
                    <body style='background-color:#025C91;'>
                        <script https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js>swal('Warning','No se pudo verificar los Datos','warning',{ button: 'Iniciar Sesion'}).then(function(){window.location = 'index.php';});</script></body>";
		//echo "No se pudo verificar los Datos";
		exit;
	}
	
?>

<!doctype html>
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
        <link rel="manifest" href="./manifest.json">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="js/jquery-3.6.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link href="assets/img/cropped-icon-32x32.png" rel="shorcut icon" sizes="32x32"/>	
	</head>
	
	<body style="background: #025C91;">
		
		<div class="container">    
			<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
				<div class="panel panel-info" >
					<div class="panel-heading">
						<div class="panel-title">Cambiar Password</div>
						<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="index.php">Iniciar Sesi&oacute;n</a></div>
					</div>     
					
					<div style="padding-top:30px" class="panel-body" >
						
						<form id="loginform" class="form-horizontal" role="form" action="guarda_pass.php" method="POST" autocomplete="off">
							
							<input type="hidden" id="token" name="token" value ="<?php echo $token; ?>" />
							<div class="row">
								<div class="col-md-1"></div>
								<div class="form-group col-md-10" style="padding-left: 30px;padding-right: 30px;">
									<label for="password" class="control-label" style="color:black;">Nuevo Password</label>
									<div >
										<input id="contrasena" type="password" class="form-control" name="password" placeholder="Password" required>
									</div>
								</div>
								<div class="col-md-1"></div>
							</div>
							
							<div class="row">
								<div class="col-md-1"></div>
								<div class="form-group col-md-10" style="padding-left: 30px;padding-right: 30px;">
									<label for="con_password" class="control-label" style="color:black;">Confirmar Password</label>
									<div>
										<input id="contrasena2" type="password" class="form-control" name="con_password" placeholder="Confirmar Password" required>
									</div>
								</div>
								<div class="col-md-1"></div>
							</div>
							
							<div class="row">
								<div class="col-md-1"></div>
								<div class="col-md-6 form-group " style="padding-left: 30px;">
									<button id="btn-login" type="submit" class="btn btn-primary">Modificar</button>
							    </div>
							    <div class="col-md-5">
							    	<label for="password"></label>
							        <input  type="checkbox" id="mostrar_contrasena" title="clic para mostrar contraseña"/>
							        &nbsp;&nbsp;Mostrar Contraseña
							    </div>
							</div>
							   
						</form>
					</div>                     
				</div>  
			</div>
		</div>
		<script >
		    $('#mostrar_contrasena').click(function () {
			    if ($('#mostrar_contrasena').is(':checked')) {
			      $('#contrasena').attr('type', 'text');
			      $('#contrasena2').attr('type', 'text');
			    } else {
			      $('#contrasena').attr('type', 'password');
			      $('#contrasena2').attr('type', 'password');
			    }
		    });
		</script>
	</body>
</html>	