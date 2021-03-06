<?php
$rutaUrlBloque = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
?>

<header>
	<div id="tabudistrital">
		<a href="http://www.udistrital.edu.co">Udistrital</a>
	</div>
</header>
<div style="opacity: 1;" class="fade-in-forward" id="stage">
	<div class="sign-in">
		<div id="main-content" class="card">

			<div style="opacity: 1;" class="fade-in-forward" id="udistrital-logo"></div>

			<header>
				<h1 id="fxa-signin-header">
					<!-- L10N: For languages structured like English, the second phrase can read "to continue to %(serviceName)s" -->
					Sistema de Gesti�n Acad�mica
					<!--<span class="service">Identificarse-->
					</span>
				</h1>
			</header>

			<section>

				<div class="error"></div>
				<div class="success"></div>

        		<?php
				// ---------------- SECCION: Par�metros Generales del Formulario ----------------------------------
				// ---------------- SECCION: Par�metros Generales del Formulario ----------------------------------
				$esteCampo = $esteBloque ['nombre'];
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
				$atributos ['tipoFormulario'] = '';
				// Si no se coloca, entonces toma el valor predeterminado 'POST'
				$atributos ['metodo'] = 'POST';
				// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
				$atributos ['action'] = 'index.php';
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
				// Si no se coloca, entonces toma el valor predeterminado.
				$atributos ['estilo'] = '';
				$atributos ['marco'] = true;
				$tab = 1;
				// ---------------- FIN SECCION: de Par�metros Generales del Formulario ----------------------------
				// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
				$atributos ['tipoEtiqueta'] = 'inicio';
				echo $this->miFormulario->formulario ( $atributos );
				?>

				<div class="input-row">
						<?php
						$esteCampo = 'usuario';
						$atributos ['id'] = $esteCampo;
						$atributos ['nombre'] = $esteCampo;
						$atributos ['tipo'] = 'text';
						$atributos ['estilo'] = 'login jqueryui';
						$atributos ['marco'] = false;
						$atributos ['columnas'] = 1;
						$atributos ['dobleLinea'] = false;
						$atributos ['tabIndex'] = $tab;
						$atributos ['textoFondo'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['validar'] = 'required';
						if (isset ( $_REQUEST [$esteCampo] )) {
							$atributos ['valor'] = $_REQUEST [$esteCampo];
						} else {
							$atributos ['valor'] = '';
						}
						$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
						$atributos ['deshabilitado'] = false;
						$atributos ['tamanno'] = 20;
						$atributos ['maximoTamanno'] = '10';
						$tab ++;
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						?>
				</div>

				<div class="input-row password-row">
						<?php
						$esteCampo = 'clave';
						$atributos ['id'] = $esteCampo;
						$atributos ['nombre'] = $esteCampo;
						$atributos ['tipo'] = 'password';
						$atributos ['estilo'] = 'login jqueryui';
						$atributos ['marco'] = false;
						$atributos ['columnas'] = 1;
						$atributos ['dobleLinea'] = false;
						$atributos ['tabIndex'] = $tab;
						$atributos ['textoFondo'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['validar'] = 'required';
						if (isset ( $_REQUEST [$esteCampo] )) {
							$atributos ['valor'] = $_REQUEST [$esteCampo];
						} else {
							$atributos ['valor'] = '';
						}
						$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
						$atributos ['deshabilitado'] = false;
						$atributos ['tamanno'] = 20;
						$atributos ['maximoTamanno'] = '10';
						$tab ++;
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						?>
				</div>

				<div class="button-row">
					<button id="submit-btn" type="submit">Ingresar</button>
				</div>
				<?php
				// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
				// Paso 1: crear el listado de variables
				$valorCodificado = "action=" . $esteBloque ["nombre"];
				$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
				$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
				$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
				$valorCodificado .= "&opcion=login";
				/**
				 * SARA permite que los nombres de los campos sean din�micos.
				 * Para ello utiliza la hora en que es creado el formulario para
				 * codificar el nombre de cada campo.
				 */
				$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
				// Paso 2: codificar la cadena resultante
				$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
				$atributos ["id"] = "formSaraData"; // No cambiar este nombre
				$atributos ["tipo"] = "hidden";
				$atributos ['estilo'] = '';
				$atributos ["obligatorio"] = false;
				$atributos ['marco'] = true;
				$atributos ["etiqueta"] = "";
				$atributos ["valor"] = $valorCodificado;
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				// ----------------FIN SECCION: Paso de variables -------------------------------------------------
				// ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
				// ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
				// Se debe declarar el mismo atributo de marco con que se inici� el formulario.
				$atributos ['marco'] = true;
				$atributos ['tipoEtiqueta'] = 'fin';
				echo $this->miFormulario->formulario ( $atributos );
				$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
				$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
				$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
				$enlace = 'pagina=registroUsuario';
				$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
				?>

        <div class="links">
					<a href="/reset_password" class="/*left*/ reset-password">�Olvidaste
						la contrase�a?</a>

					<!--<a href="/oauth/signup" class="right sign-up">Crear una cuenta</a>-->
				</div>

				<div class="privacy-links">
					Al continuar, est�s de acuerdo con los <a id="fxa-tos"
						href="http://condor2.udistrital.edu.co/appserv/terminos_y_condiciones.pdf"
						target="_blank">T�rminos del servicio</a> del Sistema de Gesti�n
					Acad�mica.
				</div>

			</section>
		</div>
	</div>
	<aside>
		<div>
			<div class="lateral-icon news" data-open-id="noticias"></div>
			<div class="lateral-icon help" data-open-id="ayuda"></div>
			<div class="lateral-icon others" data-open-id="otros"></div>
		</div>
	</aside>
	<section id="noticias" class="panel-lateral" style="display: none;">
		<span class="callout section1"></span>
		<p>Noticias</p>
		<hr>
		<div class="noticia_index">
			<font color="RED">Modificaci�n Calendario Acad�mico 2016<br>
			</font> Consulte la <a href="/descargas/circular_001_2016.pdf"
				target="_blank" :="">Circular No. 001</a> de Vicerrector�a Acad�mica
			en la que se modifican fechas del Calendario Acad�mico.
		</div>
		<hr>
		<div class="noticia_index">
			<font color="RED"> <b> ALERTA, MENSAJE DE SEGURIDAD!!!</b>
			</font> <br>
		</div>
		<hr>
		<div class="noticia_index">
			<font color="RED"> <b>HORARIOS 2016-1</b> <br>
			</font> <a target="_blank"
				href="https://www.dropbox.com/sh/61jzu4e33xaqa18/AACQOWdyMIBmIuH7pAwOPPspa?dl=0">Descargar...</a>.
		</div>

		<hr>
		<div class="noticia_index">
			<b>Calendario Acad�mico 2016-1</b> <br>
		</div>
		<hr>
		<div class="noticia_index">
			<b>Franjas adiciones y cancelaciones 2016-1</b> <br>
		</div>
		<hr>
		<div class="noticia_index">
			<b>IMPORTANTE, CAMBIO DE CLAVES!</b> <br>
		</div>
		<hr>
	</section>
	<section id="ayuda" class="panel-lateral" style="display: none;">
		<span class="callout section2"></span>
		<p>Ayuda</p>
		<div>
			<br>
			<a
				href="https://oas.udistrital.edu.co/lamasu/index.php?data=fgFZPQk8Ylagtmuza7cDsoQGTiUhedXSALItf37BuI6t2MP1UJnYa3hxeSkOZwbSjWIm3RVxStePILtXqjPcOLovSBOnY9uYzQx5Y2uQHyTtqfKPb2DmYEtBI1AKkDLCYRvu8Pj_">Recuperaci�n
				contrase�a de Sistema de Gesti�n Acad�mica</a> <br> <br>
			<a
				href="https://docs.google.com/a/correo.udistrital.edu.co/file/d/0BzG7rdBcnWhoUWNsRzlTNmJoZVU/preview">Video
				recuperaci�n de clave</a> <br> <br>
			<a
				href="https://www.udistrital.edu.co/novedades/particularNews.php?idNovedad=3985&amp;Type=N">Recuperaci�n
				contrase�a del Correo Electr�nico</a> <br>
		</div>
	</section>
	<section id="otros" class="panel-lateral" style="display: none;">
		<span class="callout section3"></span>
		<p>Otros e informaci�n general</p>
		<div>
			<br>
			<a href="https://condor.udistrital.edu.co/moodle/index.php?">Moodle</a>
			<br> <br>
			<a href="https://portalws.udistrital.edu.co/soporte/">Manuales y
				Videotutoriales de Ayuda</a> <br> <br>
			<a href="https://sgral.udistrital.edu.co/sgral/index.php">Calendario
				Acad�mico</a> <br> <br>
			<a
				href="http://sgral.udistrital.edu.co/xdata/sgral/Derechos_Pecuniarios2015.pdf">Derechos
				Pecuniarios</a> <br>
		</div>
	</section>
</div>
<footer>
	<div class="define" id="pie">
		<p style="text-align: center;">
			<a href="http://autoevaluacion.udistrital.edu.co/version3/"> <img
				src="<?php echo $rutaUrlBloque.'img/acreditacion.png'?>" />
			</a> <a href="http://autoevaluacion.udistrital.edu.co/version3/"> <img
				src="<?php echo $rutaUrlBloque.'img/autoevaluacion.png'?>" />
			</a>
		</p>
		<p style="text-align: center;">
			<a href="https://www.udistrital.edu.co/">Universidad Distrital
				Francisco Jos� de Caldas</a> PBX: 3239300. Todos los derechos
			reservados &copy;. .:: <a
				href="http://condor2.udistrital.edu.co/appserv/terminos_y_condiciones.pdf">T�rminos,
				condiciones de uso y pol�tica de privacidad</a> ::..
		</p>
	</div>
</footer>