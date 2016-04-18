<?php

namespace gui\home;

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
		
		$conexionOracle = "academica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexionOracle );
		
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
		
		$_REQUEST ['usuario'] = '6666';
		
		$rutaUrlBloque = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
		
		?>

<!-- Page Content -->
<div class="container">

	<!-- row -->
	<div class="row">
		<div class="col-sm-6">
			<h1>Horario de Clase</h1>
			<?php
		include 'horario.php';
		?>

		</div>

		<div id="col-noti" class="col-sm-6">
			<h1>Noticias</h1>
			
	<?php
	
		$atributos['estilo'] = 'btn-group';
		$atributos['id'] = 'botones-noticias';
		echo $this->miFormulario->division("inicio", $atributos);
		unset($atributos);
		
		// -----------------INICIO CONTROL: Bot�n ------------------------------------------
		$esteCampo = 'botonSubir';
		$atributos ['id'] = $esteCampo;
		$atributos ['tabIndex'] = $tab;
		$atributos ['tipo'] = 'boton';
		$atributos ['estiloBoton'] = 'btnUp btn btn-default';
		$atributos ["cancelar"] = true;
		$atributos ['onClick'] = '';
		$atributos ['sinDivision'] = true;
		$atributos ['valor'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
		$tab++;
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoBoton ( $atributos );
		unset ( $atributos );
		// -----------------FIN CONTROL: Bot�n ---------------------------------------
		
		// -----------------INICIO CONTROL: Bot�n ------------------------------------------
		$esteCampo = 'botonBajar';
		$atributos ['id'] = $esteCampo;
		$atributos ['tabIndex'] = $tab;
		$atributos ['tipo'] = 'boton';
		$atributos ['estiloBoton'] = 'btnDown btn btn-info';
		$atributos ["cancelar"] = true;
		$atributos ['onClick'] = '';
		$atributos ['sinDivision'] = true;
		$atributos ['valor'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
		$tab++;
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoBoton ( $atributos );
		unset ( $atributos );
		// -----------------FIN CONTROL: Bot�n ---------------------------------------
		
		// -----------------INICIO CONTROL: Bot�n ------------------------------------------
		$esteCampo = 'botonToggle';
		$atributos ['id'] = $esteCampo;
		$atributos ['tabIndex'] = $tab;
		$atributos ['tipo'] = 'boton';
		$atributos ['estiloBoton'] = 'btnToggle btn btn-success';
		$atributos ["cancelar"] = true;
		$atributos ['onClick'] = '';
		$atributos ['sinDivision'] = true;
		$atributos ['valor'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
		$tab++;
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoBoton ( $atributos );
		unset ( $atributos );
		// -----------------FIN CONTROL: Bot�n ---------------------------------------
		
		// -----------------INICIO CONTROL: Bot�n ------------------------------------------
		$esteCampo = 'botonVerMas';
		$atributos ['id'] = $esteCampo;
		$atributos ['tabIndex'] = $tab;
		$atributos ['tipo'] = 'boton';
		$atributos ['estiloBoton'] = 'btnVerMas btn btn-warning';
		$atributos ["cancelar"] = true;
		$atributos ['onClick'] = '';
		$atributos ['sinDivision'] = true;
		$atributos ['valor'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
		$tab++;
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoBoton ( $atributos );
		unset ( $atributos );
		// -----------------FIN CONTROL: Bot�n ---------------------------------------
		
		// -----------------INICIO CONTROL: Bot�n ------------------------------------------
		$esteCampo = 'botonVerMenos';
		$atributos ['id'] = $esteCampo;
		$atributos ['tabIndex'] = $tab;
		$atributos ['tipo'] = 'boton';
		$atributos ['estiloBoton'] = 'btnVerMenos btn btn-primary';
		$atributos ["cancelar"] = true;
		$atributos ['onClick'] = '';
		$atributos ['sinDivision'] = true;
		$atributos ['valor'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
		$tab++;
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoBoton ( $atributos );
		unset ( $atributos );
		// -----------------FIN CONTROL: Bot�n ---------------------------------------
		
		echo $this->miFormulario->division("fin");
		
		include 'noticias.php';
		?>
		</div>
	</div>
	<!-- /.row -->

	<!-- row -->
	<div class="row">
		<div class="col-sm-12">
			<h1>Servicios más usados</h1>
			<div class="row text-center">
				<div class="col-xs-4 col-md-2">
					<img src="<?php echo $rutaUrlBloque.'images/mi_plan_trabajo.png'?>"
						alt="Perfil" class="img-responsive" style="width: 100%;" />
					<h3 class="hidden-xs hidden-sm">Mi plan de Trabajo</h3>
					<h5 class="hidden-md hidden-lg">Mi plan de Trabajo</h5>
					<hr></hr>
				</div>
				<div class="col-xs-4 col-md-2">
					<img src="<?php echo $rutaUrlBloque.'images/asignaturas.png'?>"
						alt="Perfil" class="img-responsive" style="width: 100%;" />
					<h3 class="hidden-xs hidden-sm">Asignaturas</h3>
					<h5 class="hidden-md hidden-lg">Asignaturas</h5>
					<hr></hr>
				</div>
				<div class="col-xs-4 col-md-2">
					<img
						src="<?php echo $rutaUrlBloque.'images/resultados_evaluacion.png'?>"
						alt="Perfil" class="img-responsive" style="width: 100%;" />
					<h3 class="hidden-xs hidden-sm">Resultados Evaluación</h3>
					<h5 class="hidden-md hidden-lg">Resultados Evaluación</h5>
					<hr></hr>
				</div>
				<div class="col-xs-4 col-md-2">
					<img
						src="<?php echo $rutaUrlBloque.'images/produccion_academica.png'?>"
						alt="Perfil" class="img-responsive" style="width: 100%;" />
					<h3 class="hidden-xs hidden-sm">Producción Académica</h3>
					<h5 class="hidden-md hidden-lg">Producción Académica</h5>
					<hr></hr>
				</div>
				<div class="col-xs-4 col-md-2">
					<img src="<?php echo $rutaUrlBloque.'images/autoevaluacion.png'?>"
						alt="Perfil" class="img-responsive" style="width: 100%;" />
					<h3 class="hidden-xs hidden-sm">Autoevaluación</h3>
					<h5 class="hidden-md hidden-lg">Autoevaluación</h5>
					<hr></hr>
				</div>
				<div class="col-xs-4 col-md-2">
					<img src="<?php echo $rutaUrlBloque.'images/lista_clase.png'?>"
						alt="Perfil" class="img-responsive" style="width: 100%;" />
					<h3 class="hidden-xs hidden-sm">Lista de Clase</h3>
					<h5 class="hidden-md hidden-lg">Lista de Clase</h5>
					<hr></hr>
				</div>

			</div>
		</div>

	</div>
	<!-- fin row -->

</div>

</div>
<!-- /.container -->

<hr>

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

?>