
<?php
    

    require 'funcs/funcs.php';
    
    $errors = array();
    
    if(!empty($_POST)){
        $nombre =($_POST['nombre']);
        $usuario =($_POST['usuario']);
        $password =($_POST['password']);
        $con_password =($_POST['con_password']);
        $email =($_POST['email']);

 
        $activo = 0;
        $tipo_usuario = 2;


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
            $arr = json_decode($response, TRUE);

            if ($arr['success']) {
                $pass_hash = hashPassword($password);
                $token = generateToken();
                //realaizar funcion actualiza usuario
                $registro =  registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario);
                
            }else{
              $errors[] = "Error Al Actualizar el Usuario";
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
   
    <link rel="stylesheet" href="css/sweetalert2.css"/>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="/js/sweetalert2.js"></script>
    <script src="/js/all.min.js"></script>
    
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
                                <div class="card-header"><h3 class="text-center font-weight-light my-2">Update Account</h3></div>
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
                                                  <select class="custom-select" name="Choose..." id="inputGroupSelect01">
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
                                                  <select class="custom-select" name="Choose..." id="inputGroupSelect02">
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
                                                  <select class="custom-select" name="Choose..." id="inputGroupSelect03">
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
                                                  <select class="custom-select" name="Choose..." id="inputGroupSelect04">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="sistema">Tipo Usuario</label>
                                                <div class="form-group py-1">
                                                  <select class="custom-select" name="Choose..." id="inputGroupSelect05">
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
                                                <label class="small mb-1" for="sistema">Genero</label>
                                                <div class="form-group py-1">
                                                  <select class="custom-select" name="Choose..." id="inputGroupSelect06">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                    <option value="4">Super administrador</option>
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="sistema">Permiso APP</label>
                                                <div class="form-group py-1">
                                                  <select class="custom-select" name="Choose..." id="inputGroupSelect07">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                  </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="form-group mt-4 mb-0">
                                        <button id="btn-signup" type="submit" class="btn btn-primary btn-block"><i class="icon-hand-right"></i>Create Account</button></div>
                                    </form>
                                     <?php echo resultBlock($errors); ?>
                                </div>
                                <!-- <div class="card-footer text-center">
                                    <div class="small"><a href="index.php">Have an account? Go to login</a></div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-3 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2019</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>


