
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <a class="navbar-brand" href="principal.php"><img src="assets/img/Logo_WebTelemetryW.png"  height="45" width="180"></a>
    <!-- Sistema Web HTECH -->
    <!-- <img src="assets/img/logo.png"  height="60" width="120"> -->
    <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo($DataU[0]->nombre)." ";?><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <?php  
                if ($DataU[0]->permisosapp==0) {
                    echo '<a class="dropdown-item" href="Cambia_Sys.php">Configuración</a>
                <div class="dropdown-divider"></div>';
                }                                                     
            ?>
                <a class="dropdown-item" href="logout.php">Salir</a>
			</div>
		</li>
	</ul>
</nav>