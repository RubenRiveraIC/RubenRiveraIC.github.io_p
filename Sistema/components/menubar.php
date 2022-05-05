<nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <a class="nav-link dash" href="principal.php"
			><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Inicio</a>
			
			
				
				<div class="sb-sidenav-menu-heading">Interface</div>


				<!-- Fuentes -->
				<a class="nav-link collapsed Fuentes" href="#" data-toggle="collapse" data-target="#collapsePages01" aria-expanded="false" aria-controls="collapsePages01">
					<div class="sb-nav-link-icon">
						<!-- <i class="fas fa-cloud-rain"></i> -->
						<i ><img src="assets/img/icon_well_96.png" height="32" width="32"></i>
					</div>
					Fuentes de Agua
					<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
				</a>
			
					<div class="collapse" id="collapsePages01" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
						<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
							<?php
							$tiposubFA = menubar_tiposub(0,$ckfile);

							if ($DataU[0]->permisosapp!=0) {
								foreach(array_column($tiposubFA, 'nombre') as $key => $value ){
								    if(preg_match('/([\s\S]+)?(Prueba|prueba)([\s\S]+\w)?/', $value)){
								    	unset($tiposubFA[$key]);
								    }
								}
							}
							$FA = 0;
							foreach ($tiposubFA as $key => $tiposubFA[$FA]) {
								$id_sub = $tiposubFA[$FA]->idSubsistema;
							?>
							<!-- Fuentes/benito -->
							<a class="nav-link collapsed FR_G" href="#" data-toggle="collapse" data-target="#<?php echo 'Expanded'.$id_sub?>" aria-expanded="false" aria-controls="<?php echo 'Expanded'.$id_sub?>">
							<?php echo ($tiposubFA[$FA]->nombre);?>
							<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
							</a>
							<!-- ! -->
								<!-- Fuentes/benito/pozo -->
								<div class="collapse" id="<?php echo 'Expanded'.$id_sub?>" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">

									<nav class="sb-sidenav-menu-nested nav">  

										<?php 
										$idsub = menubar_idsub($id_sub,$ckfile);
										foreach ($idsub as $key => $idsub[$FA]) {
											
											echo '<a class="nav-link FRGrupo" href="#" id="'.$idsub[$FA]->idGrupo.'">'.$idsub[$FA]->nombre.'</a>';

									    }
										?> 
									</nav>

								</div>
								<!-- ! -->
							<?php $FA++;} ?>
						</nav>
					</div>
					
					
				<!-- -------------------------------------------------------------------- -->
				<!-- Redes -->
				<a class="nav-link collapsed Redes" href="#" data-toggle="collapse" data-target="#collapsePages02" aria-expanded="false" aria-controls="collapsePages02">
					<div class="sb-nav-link-icon">
						<i ><img src="assets/img/icon_piping_64.png" height="32" width="32"></i>
					</div>
					Redes de Agua
					<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
				</a>
				<!-- ! -->
					
					<!-- ----------------------------------------- -->
					<div class="collapse" id="collapsePages02" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
						<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
							<?php

							$tiposubRA = menubar_tiposub(1,$ckfile);
							if ($DataU[0]->permisosapp!=0) {
								foreach(array_column($tiposubRA, 'nombre') as $key => $value ){
								    if(preg_match('/([\s\S]+)?(Prueba|prueba)([\s\S]+\w)?/', $value)){
								    	unset($tiposubRA[$key]);
								    }
								}
							}
							$RA = 0;
							foreach ($tiposubRA as $key => $tiposubRA[$RA]) {
								$id_sub = $tiposubRA[$RA]->idSubsistema;
							?>
							<!-- Redes/Sector -->
							<a class="nav-link collapsed FR_G" href="#" data-toggle="collapse" data-target="#<?php echo 'Expanded'.$id_sub?>" aria-expanded="false" aria-controls="<?php echo 'Expanded'.$id_sub?>">
							<?php echo ($tiposubRA[$RA]->nombre);?>
							<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
							</a>
							<!-- ! -->
								<!-- Redes/Sector/bernardez -->
								<div class="collapse" id="<?php echo 'Expanded'.$id_sub?>" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">

									<nav class="sb-sidenav-menu-nested nav">  

										<?php 
										$idsub = menubar_idsub($id_sub,$ckfile);
										foreach ($idsub as $key => $idsub[$RA]) {
											echo '<a class="nav-link FRGrupo" href="#" id="'.$idsub[$RA]->idGrupo.'">'.$idsub[$RA]->nombre.'</a>';
									    }
										?> 
									</nav>

								</div>
								<!-- ! -->
							<?php $RA++;} ?>
						</nav>
					</div>
					
					
				<!-- -------------------------------------------------------------------- -->

			
			<!-- <div class="sb-sidenav-menu-heading">Addons</div>
			<a class="nav-link" href="charts.html"
			><div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
				Charts</a
				><a class="nav-link" href="tabla.php"
				><div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
					Tables</a
				> -->
			</div>
	</div>
	<div>
		<img src="" alt="logo" id="imgsis" class="imgsis" style="margin-left: 15px;margin-right: 15px;margin-bottom: 15px;margin-top: 15px;">
	</div>
	
    <div class="sb-sidenav-footer" style="background: #025C91;">
        <div class="small">Sistema:</div>
        <span id="namesis"></span>
	</div>
</nav>