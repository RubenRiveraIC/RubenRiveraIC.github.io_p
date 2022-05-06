<?php

session_start();
require 'funcs/funcs.php';
$errors = array();

if(!empty($_POST)){

    $email =$_POST['email'];
    if(!isEmail($email)){
        $errors[] = "Debe de Ingresar un Correo Electronico Valido";
    }else if (emailExiste($email)) {
        echo "
            <head>
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css'/>
                <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
                <script src='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js'></script></head>
                <body style='background-color:#025C91;'>
                    <script https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js>swal('Buen Trabajo!','Hemos enviado un correo electronico a la direccion $email para restablecer tu Password','success',{button: 'Iniciar Sesion'}).then(function(){window.location = 'index.php';});</script></body>";
                    exit;
    } else {
        $errors[] = "No Existe el Correo Electronico";

    }
    
}

  include "components/headdoc.php";  
?>
    <link rel="stylesheet" href="css/sweetalert2.css"/>
        <script src="js/sweetalert2.js"></script>
    <body style="background: #025C91;">
        
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Recuperación de contraseña</h3></div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">Ingresa tu email y se te enviara un link para cambiar tu contraseña.</div>
                                        <form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                                            <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input  id="email"  type="email" class="form-control py-4" name="email" aria-describedby="emailHelp" placeholder="Enter email address" required />
                                                
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small linkForm" href="index.php">Regresar al login</a>
                                                <button id="btn-login" type="submit" class="btn btn-primary">Enviar</button>
                                            </div>
                                        </form>
                                        <?php echo resultBlock($errors); ?>
                                    </div>
                                    
                                    <div class="card-footer form-group d-flex align-items-center justify-content-between small">
                                        Copyright &copy; H-Tech México<br>S. de R. L. de C. V.
                                        <a class="linkForm" href="https://htech.mx/privacy-policy/">Privacy Policy</a>
                                        &middot;
                                        <a class="linkForm" href="https://htech.mx/politica-de-privacidad-de-telemetry-h-tech-mx/">Terms &amp; Conditions</a>
                                    </div>
                                        <!-- <div class="small"><a href="register.php">Need an account? Sign up!</a></div> -->
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            
        </div>

        <script src="js/jquery-3.6.0.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
