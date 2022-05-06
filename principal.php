<?php
	
	session_start();
	
	require 'funcs/funcs.php';
	if(!isset($_SESSION['ck'])){
		header("Location: index.php");
		exit(0);
	}	
	$ckfile = $_SESSION['ck'];
	$DataU = CUsuario($ckfile);
	include "components/headdoc.php";
?>

    <body class="sb-nav-fixed">
    	<?php include "components/navbar.php";?>
      <div id="layoutSidenav">
      	<div id="layoutSidenav_nav">
      		<?php include "components/menubar.php";?>
      	</div>
	      <div id="layoutSidenav_content">
	        <main>
	          <div class="container-fluid">
	          	<!-- Breadcrumbs -->
              <h1 style="margin: 10;"></h1>
              <ol class="breadcrumb mb-4 blanco" id="breadC" style="display: none;">
                  <li class="breadcrumb-item active">Inicio</li>
              </ol>
              <!-- ------------------------------------------------------------ -->
              <!-- Iframe -->
		        	<div class="embed-responsive embed-responsive-4by3" id="BRW" >
							  <iframe class="embed-responsive-item" src="https://htech.mx/"></iframe>
							</div>
							<!-- ----------------------------------------------------------------------------- -->
						
						<!-- -------------------------------------INICIA GRAFICA----------------------------------------- -->
							<div class="card mb-4" id="Grafica">
                <div class="card-header" style="background: #025C91;">
                  <div class="form-row">
                    <div class="col-md-6 col-sm-12 blanco"><i class="fas fa-chart-area mr-1" style="background: #025C91; color: #FFFFFF;"></i><a target="_blank" rel="noopener noreferrer" id="nombrechart" style="color: #FFC71A;"></a>
                    </div>
                    <div class="col-md-6 col-sm-12 blanco" id="conteiner" >
	                    <ul class="nav nav-tabs card-header-tabs justify-content-end" id="Sensores">			      
											</ul>
										</div> 
                  </div>    
                </div>
                <div class="card-body"><canvas id="myChart" width="100%" height="30%"></canvas></div>
                  <div class="card-footer" style="background: #025C91;" >
                    <div class="form-row" >
                      <div class="col-md-6 col-sm-12 d-flex INRB resultado" style="color: #025C91;">
                        <div class="form-check form-check-inline color blanco ">
                          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                          <label class="form-check-label" for="inlineRadio1">Última Hora</label>
                        </div>
                        <div class="form-check form-check-inline color blanco ">
                          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                          <label class="form-check-label" for="inlineRadio3">Hoy</label>
                        </div>
                        <div class="form-check form-check-inline color blanco ">
                          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="option4">
                          <label class="form-check-label" for="inlineRadio4">Ayer</label>
                        </div>
                        <div class="form-check form-check-inline color blanco ">
                          <input class="form-check-input radios" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                          <label class="form-check-label radios" for="inlineRadio2">Personalizado</label>
                        </div>
                      </div>
                      <div class=" col-md-6 col-sm-12 small text-muted d-flex justify-content-end" id="reportrange" style="padding-top: 5px;padding-bottom: 5px;padding-right: 5px;">
                        <span class="input-group-text" style="padding-top: 1px; padding-bottom: 1px; padding-right: 1px; padding-left: 5px; DISPLAY: none; background: #025C91;" id="spanDate">
                        	<i class="fa fa-calendar" style="color: white;"></i>&nbsp;
                        	<input type="text" style="border: none; background: none; background: #025C91; color: white;" id="daterange"/>
                        </span>
                      </div>
                    </div>
                  </div>
              </div>
              <!-- --------------------------TERMINA GRAFICA----------------------------------- -->
              <!-- Pantalla de Carga -->
							<div class="loading" id="LD">
								<div class="loading-text">
									<span class="loading-text-words">L</span>
									<span class="loading-text-words">O</span>
									<span class="loading-text-words">A</span>
									<span class="loading-text-words">D</span>
									<span class="loading-text-words">I</span>
									<span class="loading-text-words">N</span>
									<span class="loading-text-words">G</span>
								</div>
							</div>
							<!-- --------------------------------------------- -->
						</div>
					</main>
	            <?php include "components/footer.php";?>
				</div>
			</div>

			<script src="js/all.min.js"></script>
	    <script src="js/jquery-3.6.0.min.js"></script>
	    <script src="js/chart.js"></script>
	    <script src="js/hammer.min.js"></script>
	    <script src="js/chartjs-plugin-zoom.min.js"></script>
			<script src="js/moment-with-locales.min.js"></script>
			<script src="js/daterangepicker.min.js"></script>
			<link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
			<script src="js/jmespath/jmespath.js"></script>
			<script src="js/mqtt.min.js"></script>
			<script src="js/apps.js"></script>
			<script src="js/bootstrap.bundle.min.js"></script>
			<script src="js/scripts.js"></script>
		<!-- <link href="css/style.scss"/> -->
		</body>
</html>
