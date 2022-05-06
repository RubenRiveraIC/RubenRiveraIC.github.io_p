
<?php
    
    // require 'funcs/conexion.php';
    require 'funcs/funcs.php';
    
    $errors = array();
    

    if(!empty($_POST)){
        // $nombre =$mysqli->real_escape_string($_POST['nombre']);
        // $usuario =$mysqli->real_escape_string($_POST['usuario']);
        // $password =$mysqli->real_escape_string($_POST['password']);
        // $con_password =$mysqli->real_escape_string($_POST['con_password']);
        // $email =$mysqli->real_escape_string($_POST['email']);
        // $tipo_usuario =$mysqli->real_escape_string($_POST['inputSelectTUsuario']);
        // $captcha =$mysqli->real_escape_string($_POST['g-recaptcha-response']);

 
        $activo = 0;
        $secret = '6LfyXHIeAAAAAMCfIoUWvQD1iRHAyFd4nDLYr6NR';


        if(!$captcha){
            $errors[]= "Por Favor Verifica El captcha";
        }

        if (isNull($nombre, $usuario, $password, $con_password, $email)) {
            $errors[] = "Debe LLenar Todos Los Campos";
        }

        if (!isEmail($email)) {
            $errors[] = "Dirección de Correo Invalida";
        }

        if (!validaPassword($password, $con_password)) {
            $errors[] = "Las Contraseñas No Coinciden!";
        }

        if (usuarioExiste($usuario)) {
            $errors[] = "El Nombre De Usuario $usuario ya existe";
        }

        if (emailExiste($email)) {
            $errors[] = "El Correo Electronico $email ya existe";
        }

        if (count($errors) == 0) {
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
            $arr = json_decode($response, TRUE);

            if ($arr['success']) {
                $pass_hash = hashPassword($password);
                $token = generateToken();

                $registro =  registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario);
                
                if($registro > 0){

                    $url = 'http://'.$_SERVER["SERVER_NAME"].
                    '/sistema/activar.php?id='.$registro.'&val='.$token;

                    $asunto = 'Activar Cuenta - Sistema de Usuarios HTECH';
                    $cuerpo = "Estimado $nombre <br /><br />Para continuar con el proceso de registro, es indispensable de click en la siguiente liga <a href='$url'> Activar Cuenta </a>";

                    if(enviarEmail($email, $nombre, $asunto, $cuerpo)){

                        

                        echo "
                                <head>
                                    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css'/>
                                    <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
                                    <script src='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js'></script></head>
                                    <body style='background-color:#007bff;'>
                                        <script https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js>swal('Good job','Para terminar el proceso de registro siga las instrucciones que le hemos enviado a la direccion de correo electronico $email', 'success',{button: 'Iniciar Sesion'}).then(function(){window.location = 'index.php';});</script></body>";
                        exit; 

                    } else{
                        $errors[] = "Error al enviar Email";
                    }



                }else{
                    $errors[] = "Error Al Registrar";
                }


            }else{
                $errors[] = 'Error Al Comprobar Captcha';
            }
        }




    }
    
?>
<!DOCTYPE html>
<html lang="en">
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
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css"/>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<body style="background: #025C91;">
    
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            <div class="card shadow-lg border-0 rounded-lg mt-3">
                                <div class="card-header"><h3 class="text-center font-weight-light">Create Account</h3></div>
                                <div class="card-body">
                                    <form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                                        <div id="signupalert" style="display:none" class="alert alert-danger">
                                            <p>Error:</p>
                                            <span></span>
                                         </div>
                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <div class="form-group"><label class="small mb-1" for="usuario">Usuario</label><input class="form-control py-4" name="usuario" type="text" placeholder="Enter User" value="<?php if(isset($usuario)) echo $usuario; ?>" required/></div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"><label class="small mb-1" for="nombre">Nombre</label><input class="form-control py-4" name="nombre" type="text" placeholder="Enter Name" value="<?php if(isset($nombre)) echo $nombre; ?>" required /></div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="small mb-1" for="sistema">Sistema</label>
                                                <div class="form-group py-1">
                                                  <select class="custom-select" name="Choose..." id="inputSelectSistema required">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                  </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-8">
                                                <div class="form-group"><label class="small mb-1" for="email">Email</label><input class="form-control py-4" name="email" type="email" aria-describedby="emailHelp" placeholder="Enter email address" value="<?php if(isset($email)) echo $email; ?>" required/></div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="small mb-1" for="sistema">Sub-Sistema</label>
                                                <div class="form-group py-1">
                                                  <select class="custom-select" name="Choose..." id="inputSelectSubSistema">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                  </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <div class="form-group"><label class="small mb-1" for="password">Password</label><input class="form-control py-4" name="password" type="password" placeholder="Enter password" required /></div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"><label class="small mb-1" for="con_password">Confirm Password</label><input class="form-control py-4"  name="con_password" type="password" placeholder="Confirm password" required/></div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="small mb-1" for="sistema">Tipo Sub-Sistema</label>
                                                <div class="form-group py-1">
                                                  <select class="custom-select" name="Choose..." id="inputSelectTSubSistema">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                  </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="sistema">Permiso QGIS</label>
                                                <div class="form-group py-1">
                                                  <select class="custom-select" name="Choose..." id="inputSelectPermisoQGIS">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Super administrador</option>
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="sistema">Permiso APP</label>
                                                <div class="form-group py-1">
                                                  <select class="custom-select" name="Choose..." id="inputSelectPermisoAPP">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Super administrador</option>
                                                  </select>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="captcha" class="col-md-1 control-label"></label>
                                                    <div class="g-recaptcha" data-sitekey="6LfyXHIeAAAAAF2t0k3GAjyEbcgj8bPsuHZb5SUX"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="small mb-1" for="sistema">Genero</label>
                                                <div class="form-group py-1">
                                                  <select class="custom-select" name="Choose..." id="inputSelectGenero">
                                                    <option selected>Choose...</option>
                                                    <option value="1">Sin especificar</option>
                                                    <option value="2">Otro</option>
                                                    <option value="3">Mujer</option>
                                                    <option value="4">Hombre</option>
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="small mb-1" for="sistema">Tipo Usuario</label>
                                                <div class="form-group py-1">
                                                  <select class="custom-select" name="inputSelectTUsuario" id="inputSelectTUsuario">
                                                    <option selected>Choose...</option>
                                                  </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="form-group mt-4 mb-0">
                                        <button id="btn-signup" type="submit" class="btn btn-primary btn-block"><i class="icon-hand-right"></i>Create Account</button></div>
                                    </form>
                                     <?php echo resultBlock($errors); ?>
                                </div>
                                <div class="card-footer form-group d-flex align-items-center small">
                                    Copyright &copy; H-Tech México S. de R. L. de C. V. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="linkForm" href="https://htech.mx/privacy-policy/">Privacy Policy</a>
                                    &middot;
                                    <a class="linkForm" href="https://htech.mx/politica-de-privacidad-de-telemetry-h-tech-mx/">Terms &amp; Conditions</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>


