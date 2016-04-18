<?php
/*
 *  Sintaxis recomendada para las plantillas PHP
 */
?>

<nav class="navbar" role="navigation">
	<div id="imagenfondo" class="navbar"></div>
	<!--navbar-fixed-top-->
	<div class="container">
		<!-- Image Background Page Header -->
		<!-- Note: The background image is set within the business-casual.css file. -->
		<header class="business-header">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<img src="<?php echo $this -> atributos['url_escudo']; ?>" alt="Perfil" class="hidden-xs hidden-sm img-responsive img-rounded escudo" />
					</div>
					<div class="col-xs-12 col-sm-10 col-lg-8">
						<h1 class="nameline"><?php echo $this -> atributos['nombre_usuario']; ?></h1>
						<h1 class="titleline"><?php echo $this -> atributos['profesion']; ?></h1>
						
						<ul id="nav">
							<li id="notification_li">
								<a id="notificationLink" href="#" title="Notificaciones">Notificaciones<b class="caret"></b> </a>
								<div id="notificationContainer">
									<div id="notificationTitle">Notificaciones del sistema</div>
									<div id="notificationsBody" class="notifications">
										<div id="contenido-notificacion">
											<?php if ($this->atributos ['notificaciones'] <= 0) :?>
												No hay ninguna notificación registrada para usted.
											<?php else: ?>
												<table class="table-notificacion">
													<?php for ($i = 0; $i < $this->atributos ['notificaciones']; $i++): ?>
													<?php if ($this->atributos ['estadoNotificacion'][$i] == 2): ?>
														<tr class="notificacion-tr ntf-vista">
													<?php endif;?>
													<?php if ($this->atributos ['estadoNotificacion'][$i] == 1):?>
														<tr class="notificacion-tr ntf-pen">
													<?php endif;?>
															<td id="td-izq-ntf">
																<img id="foto-notifi" alt="<?php echo $this -> atributos['imgaltNotificacion'][$i]; ?>" title="<?php echo $this -> atributos['imgaltNotificacion'][$i]; ?>" src="<?php echo $this -> atributos['imgsrcNotificacion'][$i]; ?>">
															</td>
															<td id="td-der-ntf">
																<p id="p-enlace-titulo">
																	<a id="enlacetitulonotifi" href="#" title="<?php echo $this -> atributos['tituloNotificacion'][$i]; ?>"><?php echo $this -> atributos['tituloNotificacion'][$i]; ?></a>
																</p>
																<p id='textonotifi'> <?php echo $this -> atributos['descripNotificacion'][$i]; ?> </p>
																<div>
																	<p id='fechanotifi'> 
																		<img class="img-clock" alt="clock" src="<?php echo $this -> atributos['url_clock'];?>">
																		<?php echo $this -> atributos['fechasNotificacion'][$i]; ?> 
																	</p>
																</div>
															</td>
														</tr>
													<?php endfor; ?>
												</table>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</li>
							<?php if ($this->atributos['cantNoti'] > 0): ?>
								<span id="notification_count"><?php echo $this -> atributos['cantNoti']; ?></span>
							<?php endif; ?>
						</ul>						
						<br>						
						<h1 class="closesession"><a href="<?php echo $this -> atributos['enlace_cerrar_sesion']; ?>">Cerrar Sesión</a></h1>
					</div>
					<div class="col-lg-2">
						<img src="<?php echo $this -> atributos['url_foto_perfil']; ?>" alt="Perfil" class="hidden-xs hidden-sm hidden-md img-responsive img-rounded profilepicture" />
					</div>
				</div>
			</div>
		</header>
		<!--http://jsfiddle.net/apougher/ydcMQ/-->
		<div class="navbar navbar-default navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Inicio</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<!--<li><a href="#">GLUD</a></li>-->
						<?php foreach($this -> atributos ['enlaces'] as $keyMenu => $menu): ?>
						<li class="dropdown menu-large">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this -> atributos['titulosMenu'][$keyMenu]; ?> <b class="caret"></b></a>
							<ul class="dropdown-menu megamenu row">
								<?php								
								$colXMenu = 4;//Número de columnas por menú
								//Para 4 columnas se pone la clase (col-sm-3)
								$numSubMenu = count($menu);
								$numGMenuXCol = $numSubMenu / $colXMenu;//Número de grupos menú por columna
								$parteEntera = intval($numGMenuXCol);
								$numGMenuIni = array();
								for ($i = 0; $i<$colXMenu; $i++){
									$numGMenuIni[$i] = $parteEntera;
								}
								if($numGMenuXCol != $parteEntera){
									$desbordeGMenu = ($numGMenuXCol * $colXMenu) - ($parteEntera * $colXMenu);
									//var_dump($numGMenuXCol, $parteEntera, $desbordeGMenu);
									$numGMenuXCol = $parteEntera;
									for ($i = 0; $i<$desbordeGMenu; $i++){
										$numGMenuIni[$i]++;
									}
								}
								//Arreglo que guarda los índices del foreach en que inicia el menú
								$inicioGMenu [0] = 1;
								$finalGMenu [0] = $inicioGMenu[0] + $numGMenuIni[0] - 1;
								$inicioGMenu [1] = $finalGMenu[0] + 1;
								$finalGMenu [1] = $inicioGMenu[1] + $numGMenuIni[1] - 1;
								$inicioGMenu [2] = $finalGMenu[1] + 1;
								$finalGMenu [2] = $inicioGMenu[2] + $numGMenuIni[2] - 1;
								$inicioGMenu [3] = $finalGMenu[2] + 1;
								$finalGMenu [3] = $inicioGMenu[3] + $numGMenuIni[3] - 1;
								//var_dump($numGMenuIni,$inicioGMenu,$finalGMenu);//die;
								//indice inicial del grupo menú
								$indexGrupoMenu = 1;
								?>
								<?php foreach($menu as $keyGrupoMenu => $grupoMenu):?>
									<?php if(in_array($indexGrupoMenu, $inicioGMenu)):?>
									<li class="col-sm-3">
									<ul>
									<?php else: ?>
									<li class="divider"></li>
									<?php endif; ?>
										<li class="dropdown-header">
											<?php echo $this -> atributos['titulosGrupoMenu'][$keyGrupoMenu]; ?>
										</li>
										<?php foreach($grupoMenu as $keyEnlace => $enlace): ?>
										<li>
											<a href="<?php echo $enlace['url']; ?>" target="<?php echo $this -> atributos['target']; ?>"><?php echo $enlace['etiqueta']; ?></a>
										</li>
										<?php endforeach; ?>
									<?php if(in_array($indexGrupoMenu, $finalGMenu)): ?>
									</ul>
									</li>
									<?php endif; ?>
									<?php
									$indexGrupoMenu++;
									?>
								<?php endforeach; ?>
							</ul>
						</li>
						<?php endforeach; ?>
					</ul>
					<!-- /.nav navbar-nav -->
				</div>
			</div>
		</div>
	</div>
	<!-- /.container -->
</nav>

