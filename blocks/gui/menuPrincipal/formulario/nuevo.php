<?php

namespace gui\menuPrincipal;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Formulario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSesion;
	function __construct($lenguaje, $formulario, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		$this->miSql = $sql;
		
		$this->miSesion = \Sesion::singleton ();
	}
	function formulario() {
		
		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
		/**
		 * Atributos que deben ser aplicados a todos los controles de este formulario.
		 * Se utiliza un arreglo
		 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		 *
		 * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
		 * $atributos= array_merge($atributos,$atributosGlobales);
		 */
		$atributosGlobales ['campoSeguro'] = 'true';
		$_REQUEST ['tiempo'] = time ();
		
		$conexion = 'estructura';
		$esteRecurso = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$usuario = $this->miSesion->getSesionUsuarioId ();
		
		// -------------------------------------------------------------------------------------------------
		// var_dump($_REQUEST);
		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
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
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );
		
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		$rutaUrlBloque = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
		
		$_REQUEST ['usuario'] = '6666';
		
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
						<img src="<?php echo $rutaUrlBloque.'images/escudo.png'?>"
							alt="Perfil"
							class="hidden-xs hidden-sm img-responsive img-rounded escudo" />
					</div>
					<div class="col-xs-12 col-sm-10 col-lg-8">
						<h1 class="nameline">JORGE ULISES USECHE CUELLAR</h1>
						<h1 class="titleline">Msc. Teleinformática</h1>

						<!--  -->
						<?php
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNotificaciones", $_REQUEST ['usuario'] );
		$matrizNotificaciones = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$cantidadNoti = 0;
		
		if ($matrizNotificaciones) {
			foreach ( $matrizNotificaciones as $notificacion ) {
				if ($notificacion ['estado'] == 1) {
					$cantidadNoti ++;
				}
			}
		}
		
		?>
						<ul id="nav">
							<li id="notification_li">
							<?php
		
		$atributos ['id'] = 'notificationLink';
		$atributos ['enlace'] = "#";
		$atributos ['enlaceTitulo'] = "Notificaciones";
		$atributos ['enlaceTexto'] = "Notificaciones";
		echo $this->miFormulario->enlace ( $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "notificationContainer";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "notificationTitle";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		echo "Notificaciones del sistema";
		
		echo $this->miFormulario->division ( "fin" );
		
		$atributos ['id'] = "notificationsBody";
		$atributos ['estilo'] = "notifications";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		if (! $matrizNotificaciones) {
			echo "No hay ninguna notificación registrada para usted.";
		} else {
			echo "<table>";
			foreach ( $matrizNotificaciones as $notificacion ) {
				echo "<tr>";
				echo "<td>";
				
				$pordefecto = $rutaUrlBloque . "images/silueta.gif";
				
				$imagen = "<img id='foto-notifi' ";
				
				if ($notificacion ['imagen']) {
					$imagen .= "src=" . $rutaUrlBloque . "images/" . trim ( $notificacion ['imagen'] ) . "";
				} else {
					$imagen .= "src=" . $pordefecto;
				}
				
				$imagen .= " alt='" . trim($notificacion ['emisor']) . "' title='" . trim($notificacion ['emisor']) . "'>";
				
				echo $imagen;
				
				echo "</td>";
				echo "<td>";
				
				$atributos ['id'] = 'enlacetitulonotifi';
				$atributos ['enlace'] = "#";
				$atributos ['enlaceTitulo'] = "Prueba";
				$atributos ['enlaceTexto'] = trim($notificacion ['titulo']);
				echo $this->miFormulario->enlace ( $atributos );
				
				echo "<p id='textonotifi'>";
				
				$descrip = trim ( $notificacion ['contenido'] );
				
				if ($notificacion ['enlace']) {
					$descrip = str_replace ( "[", "<a id='enlaceinternonotifi' href='" . trim ( $notificacion ['enlace'] ) . "'>", $descrip );
				} else {
					$descrip = str_replace ( "[", "<a id='enlaceinternonotifi' href=''>", $descrip );
				}
				$descrip = str_replace ( "]", "</a>", $descrip );
				
				echo $descrip;
				
				echo "</p>";
				
				echo "<p id='fechanotifi'>";
				
				$auxfecha = trim ( $notificacion ['fecha'] );
				
				$auxfecha = explode ( " ", $auxfecha );
				
				$auxfecha2 = $auxfecha [0];
				
				$auxfecha2 = explode ( "-", $auxfecha2 );
				
				$f ['anio'] = $auxfecha2 [0];
				$f ['mes'] = $auxfecha2 [1];
				$f ['dia'] = $auxfecha2 [2];
				$f ['hora'] = $auxfecha [1];
				
				echo fecha_es ( $f );
				
				echo "</p>";
				
				echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
		}
		
		echo $this->miFormulario->division ( "fin" );
		
		echo $this->miFormulario->division ( "fin" );
		?>
							</li>
							<?php
		
		if ($cantidadNoti > 0) {
			$span = '<span id="notification_count">';
			$span .= $cantidadNoti;
			$span .= '</span>';
			
			echo $span;
		}
		
		?>
						</ul>

						<br>
						<!--  -->

						<h1 class="closesession">
							<a href="#">Cerrar Sesión</a>
						</h1>
					</div>
					<div class="col-lg-2">
						<img src="<?php echo $rutaUrlBloque.'images/profile.png'?>"
							alt="Perfil"
							class="hidden-xs hidden-sm hidden-md img-responsive img-rounded profilepicture" />
					</div>
				</div>
			</div>
		</header>
		<!--http://jsfiddle.net/apougher/ydcMQ/-->
		<div id="menu" class="navbar navbar-default navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse"
						data-target=".navbar-collapse">
						<span class="icon-bar"></span> <span class="icon-bar"></span> <span
							class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Inicio</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<!--<li><a href="#">Otro Enlace</a></li>-->
						<li class="dropdown menu-large"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown">Categories <b
								class="caret"></b></a>
							<ul class="dropdown-menu megamenu row">
								<li class="col-sm-3">
									<ul>
										<li class="dropdown-header">Glyphicons</li>
										<li><a href="#">Available glyphs</a></li>
										<li class="disabled"><a href="#">How to use</a></li>
										<li><a href="#">Examples</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Dropdowns</li>
										<li><a href="#">Example</a></li>
										<li><a href="#">Aligninment options</a></li>
										<li><a href="#">Headers</a></li>
										<li><a href="#">Disabled menu items</a></li>
									</ul>
								</li>
								<li class="col-sm-3">
									<ul>
										<li class="dropdown-header">Button groups</li>
										<li><a href="#">Basic example</a></li>
										<li><a href="#">Button toolbar</a></li>
										<li><a href="#">Sizing</a></li>
										<li><a href="#">Nesting</a></li>
										<li><a href="#">Vertical variation</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Button dropdowns</li>
										<li><a href="#">Single button dropdowns</a></li>
									</ul>
								</li>
								<li class="col-sm-3">
									<ul>
										<li class="dropdown-header">Input groups</li>
										<li><a href="#">Basic example</a></li>
										<li><a href="#">Sizing</a></li>
										<li><a href="#">Checkboxes and radio addons</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Navs</li>
										<li><a href="#">Tabs</a></li>
										<li><a href="#">Pills</a></li>
										<li><a href="#">Justified</a></li>
									</ul>
								</li>
								<li class="col-sm-3">
									<ul>
										<li class="dropdown-header">Navbar</li>
										<li><a href="#">Default navbar</a></li>
										<li><a href="#">Buttons</a></li>
										<li><a href="#">Text</a></li>
										<li><a href="#">Non-nav links</a></li>
										<li><a href="#">Component alignment</a></li>
										<li><a href="#">Fixed to top</a></li>
										<li><a href="#">Fixed to bottom</a></li>
										<li><a href="#">Static top</a></li>
										<li><a href="#">Inverted navbar</a></li>
									</ul>
								</li>
							</ul></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- /.container -->
</nav>


<?php
		// ------------------- SECCION: Paso de variables ------------------------------------------------
		
		/**
		 * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
		 * SARA permite realizar esto a través de tres
		 * mecanismos:
		 * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
		 * la base de datos.
		 * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
		 * formsara, cuyo valor será una cadena codificada que contiene las variables.
		 * (c) a través de campos ocultos en los formularios. (deprecated)
		 */
		
		// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
		
		// Paso 1: crear el listado de variables
		
		$valorCodificado = "action=" . $esteBloque ["nombre"];
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$valorCodificado .= "&usuario=" . $usuario;
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&opcion=ver";
		/**
		 * SARA permite que los nombres de los campos sean dinámicos.
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
		// Se debe declarar el mismo atributo de marco con que se inició el formulario.
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );
		
		return true;
	}
	function mensaje() {
		
		// Si existe algun tipo de error en el login aparece el siguiente mensaje
		$mensaje = $this->miConfigurador->getVariableConfiguracion ( 'mostrarMensaje' );
		$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', null );
		
		if ($mensaje) {
			
			$tipoMensaje = $this->miConfigurador->getVariableConfiguracion ( 'tipoMensaje' );
			
			if ($tipoMensaje == 'json') {
				
				$atributos ['mensaje'] = $mensaje;
				$atributos ['json'] = true;
			} else {
				$atributos ['mensaje'] = $this->lenguaje->getCadena ( $mensaje );
			}
			// -------------Control texto-----------------------
			$esteCampo = 'divMensaje';
			$atributos ['id'] = $esteCampo;
			$atributos ["tamanno"] = '';
			$atributos ["estilo"] = 'information';
			$atributos ["etiqueta"] = '';
			$atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
			echo $this->miFormulario->campoMensaje ( $atributos );
			unset ( $atributos );
		}
		
		return true;
	}
}
$miFormulario = new Formulario ( $this->lenguaje, $this->miFormulario, $this->sql );
$miFormulario->formulario ();
$miFormulario->mensaje ();
function fecha_es($fecha) {
	$meses = array (
			'01' => 'Enero',
			'02' => 'Febrero',
			'03' => 'Marzo',
			'04' => 'Abril',
			'05' => 'Mayo',
			'06' => 'Junio',
			'07' => 'Julio',
			'08' => 'Agosto',
			'09' => 'Septiembre',
			'10' => 'Octubre',
			'11' => 'Noviembre',
			'12' => 'Diciembre' 
	);
	return $meses [$fecha ['mes']] . " " . $fecha ['dia'] . ", " . $fecha ['anio'] . " - " . $fecha ['hora'];
}

?>