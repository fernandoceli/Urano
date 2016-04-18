<?php

namespace gui\menuPrincipal\formulario;

include_once ($this->ruta . '/funcion/encriptar.class.php');
use gui\menuPrincipal\funcion\encriptar;
// include_once ($this->ruta . "/builder/DibujarMenu.class.php");
// use gui\menuPrincipal\builder\Dibujar;
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class FormularioMenu {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $miEncriptador;
	
	function __construct($lenguaje, $formulario, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		$this->miSql = $sql;
		// Se crea una instancia del objeto encriptador.
		$this->miEncriptador = new encriptar ( $this->miSql );
		
		$this->configuracion_appserv = $this->miEncriptador->getConfiguracion();
	}
	function formulario() {
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		
		$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
		
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
		$rutaBloque .= $esteBloque ['grupo'] . '/' . $esteBloque ['nombre'];
		$rutaUrlBloque = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
		
		
		
		/**
		 * Comienza sección de variables necesarias para los enlaces
		 */
		// codigo del usuario
		$usuario = $_REQUEST ['usuario'];
		// $usuario = 79708124;
		// $usuario = $_SESSION ['usuario_login'];
		$tokenSaraAcademica = $this->miEncriptador->codificar_sara ( 'condorSara2013!' );
		$tokenSaraAdministrativa = $this->miEncriptador->codificar_sara ( 's4r44dm1n1str4t1v4C0nd0r2014!' );
		$tokenSaraDocencia = $this->miEncriptador->codificar_sara ( 'condorSara2013' );
		$tiempo = time ();
		/**
		 * Termina sección de variables necesarias para los enlaces
		 */
		 
		// consultar los roles que están asignados al usuario
		// $conexion = 'academica_ac';
		// $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		// $cadenaSql = $this->miSql->getCadenaSql ( 'perfilesUsuario', $usuario );
		// $datosPerfiles = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		// $esteRecursoDB->desconectar_db();
		// $perfiles = array_column ( $datosPerfiles, 'TIP_US' );
		
		//Inicio: Se busca en la base de datos los datos de la conexión de logueo
        $conexion = 'appserv';
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        
        $cadenaSql = $this->miSql->getCadenaSql ( 'buscarRol', 'logueo' );       
        $resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' )[0];		
		//Fin: Se busca en la base de datos los datos de la conexión de logueo
		
		//Se necesita una conexión al recurso de base de datos resultado de la consulta
		
		//Inicio: Crear conexión logueo
		//Se crea la conexión a base de datos recursivamente
		$semilla = 'condor';
		$conexionDB = array(
			//'inicio' => true,
			'dbsys' => $resultado['dbms'],
			'dbdns' => $resultado['servidor'],
			'dbpuerto' => $resultado['puerto'],
			'dbnombre' => $resultado['db'],
			'dbusuario' => trim($this->decodificar_variable($resultado['usuario'],$semilla)),			
			'dbclave' =>  trim($this->decodificar_variable($resultado['password'],$semilla))
		);
		//Se realiza una conexión con $conexionDB y se le llama logueo
		$conexion = 'logueo';	
		$this->miConfigurador->fabricaConexiones->setRecursoDB($conexion, 'registro', $conexionDB);
		
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
		//Fin: Crear conexión logueo
		
		$parametros = array(
        	'usuario' => $usuario,
        	'sql_tabla1' => $this->configuracion_appserv['sql_tabla1']
		);
        $cadenaSql = $this->miSql->getCadenaSql ( 'buscarPerfilesUsuario' , $parametros);
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		
		$perfiles = array();
		foreach ($resultado as $key => $value) {
			$perfiles[] = $value['TIP_US'];
		}
		
		//$perfiles = array(4, 16, 20, 24, 28, 30, 31, 32, 33, 34, 51, 52, 61, 68, 72, 75, 80, 83, 84, 87, 88, 104, 105, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125);
		
		$conexion = 'lamasu';
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		$cadenaSql = $this->miSql->getCadenaSql ( 'datosFuncionario', $usuario );
		$datosPerfiles = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		
		if ($datosPerfiles) {
			$atributos ['nombre_usuario'] = $datosPerfiles [0] [2];
		} else {
			$atributos ['nombre_usuario'] = 'INVITADO';
		}
		
		$conexion = 'estructura';
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'datosMenu', $perfiles );
		$datosMenu = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		
		// Se genera un arreglo con todos los enlaces, además su título y los títulos del menú y los grupos menú
		if ($datosMenu) {
			$enlaces = array ();
			$titulosMenu = array ();
			$titulosGrupoMenu = array ();
			foreach ( $datosMenu as $menu => $item ) {
				$titulosMenu [$item ['id_menu']] = $item ['etiqueta_menu'];
				$titulosGrupoMenu [$item ['id_grupo_menu']] = $item ['etiqueta_grupo_menu'];
				$enlace = "#";
				// Se establece un enlace nulo de manera predeterminada
				if ($item ['url_host_enlace'] != '') { // Enlace completo especificado, no se arma el enlace y no se codifica nada.
					$enlace = $item ['url_host_enlace'];
				} elseif ($item ['codificado'] == 't') { // Es un enlace codificado
					if ($item ['pagina_enlace'] != '') { // Si existe el parámetro página
						$enlace = 'pagina=' . $item ['pagina_enlace'] . '&' . $item ['parametros'];
					} else { // Si no existe el parámetro página
						$enlace = $item ['parametros'];
					}
					eval ( "\$enlace = \"$enlace\";" );
					// Se evaluan las variables de los parámetros
					$enlace = $this->miEncriptador->{$item ['funcion_codificador']} ( $enlace );
					$enlace = $item ['host'] . $item ['ruta'] . '?' . $item ['indice_codificador'] . '=' . $enlace;
				} else { // No es un enlace codificado
					if ($item ['pagina_enlace'] != '') { // Si existe el parámetro página
						$enlace = 'pagina=' . $item ['pagina_enlace'] . '&' . $item ['parametros'];
					} else { // Si no existe el parámetro página
						$enlace = $item ['parametros'];
					}
					$enlace = $item ['host'] . $item ['ruta'] . '?' . $item ['indice_codificador'] . '=' . $enlace;
				}
				$enlacesJavascript [] = array (
						'etiqueta' => $item ['etiqueta_menu'] . ' - ' . $item ['etiqueta_grupo_menu'] . ' - ' . $item ['etiqueta_enlace'],
						'url' => $enlace 
				);
				$enlaces [$item ['id_menu']] [$item ['id_grupo_menu']] [$item ['id_enlace']] = array (
						'etiqueta' => $item ['etiqueta_enlace'],
						'url' => $enlace 
				);
			}
			// var_dump($enlaces,$titulosMenu,$titulosGrupoMenu);
		} else {
			die ( 'Sin servicios registrados para el usuario.' );
		}
		echo '<script>var enlacesRol=' . json_encode ( $enlacesJavascript ) . ';</script>';
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'buscarNotificaciones', $usuario );
		$matrizNotificaciones = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$matrizNotificaciones = ($matrizNotificaciones) ? $matrizNotificaciones : array ();
		
		$cantidadNoti = 0;
		// Son la cantidad de notificaciones pendientes
		
		$imgsrcNotificacion = array ();
		$imgaltNotificacion = array ();
		$tituloNotificacion = array ();
		$descripcionNotificacion = array ();
		$fechaNotificacion = array ();
		$estadoNotificacion = array();
		
		if ($matrizNotificaciones) {
			foreach ( $matrizNotificaciones as $notificacion ) {
				
				if ($notificacion ['estado'] == 1) {
					$cantidadNoti ++;
				}
				
				array_push( $estadoNotificacion, trim($notificacion ['estado']) );
				
				$pordefecto = $rutaUrlBloque . 'images/silueta.gif';
				
				if ($notificacion ['imagen']) {
					$imagen = $rutaUrlBloque . 'images/' . trim ( $notificacion ['imagen'] );
				} else {
					$imagen = $pordefecto;
				}
				
				array_push ( $imgsrcNotificacion, $this->imagenBase64($imagen) );
				
				array_push ( $imgaltNotificacion, trim ( $notificacion ['emisor'] ) );
				
				array_push ( $tituloNotificacion, trim ( $notificacion ['titulo'] ) );
				
				$descrip = trim ( $notificacion ['contenido'] );
				
				if ($notificacion ['enlace']) {
					$descrip = str_replace ( '[', '<a id="enlaceinternonotifi" href="' . trim ( $notificacion ['enlace'] ) . '">', $descrip );
				} else {
					$descrip = str_replace ( '[', '<a id="enlaceinternonotifi" href="">', $descrip );
				}
				$descrip = str_replace ( ']', '</a>', $descrip );
				
				array_push ( $descripcionNotificacion, $descrip );
				
				$auxfecha = trim ( $notificacion ['fecha'] );
				
				$auxfecha = explode ( ' ', $auxfecha );
				
				$auxfecha2 = $auxfecha [0];
				
				$auxfecha2 = explode ( '-', $auxfecha2 );
				
				$f ['anio'] = $auxfecha2 [0];
				$f ['mes'] = $auxfecha2 [1];
				$f ['dia'] = $auxfecha2 [2];
				$f ['hora'] = $auxfecha [1];
				
				array_push ( $fechaNotificacion, $this->fecha_es ( $f ) );
			}
		}
		
		$atributos ['id'] = 'megaMenu';
		$atributos ['target'] = 'principal';
		$atributos ['url_escudo'] = $this->imagenBase64($rutaUrlBloque . 'images/escudo_ud_blanco2.png');
		$atributos ['url_foto_perfil'] = $this->imagenBase64($rutaUrlBloque . 'images/profile.png');
		$atributos ['enlace_cerrar_sesion'] = "/appserv/conexion/salir.php?urano=true";
		// $atributos ['nombre_usuario'] = 'JORGE ULISES USECHE CUELLAR';
		$atributos ['profesion'] = 'Msc. Teleinformática';
		$atributos ['enlaces'] = $enlaces;
		$atributos ['titulosMenu'] = $titulosMenu;
		$atributos ['titulosGrupoMenu'] = $titulosGrupoMenu;
		
		$atributos ['cantNoti'] = $cantidadNoti;
		$atributos ['notificaciones'] = count ( $matrizNotificaciones );
		// El número total de notificaciones
		
		$atributos ['imgsrcNotificacion'] = $imgsrcNotificacion;
		$atributos ['imgaltNotificacion'] = $imgaltNotificacion;
		$atributos ['tituloNotificacion'] = $tituloNotificacion;
		$atributos ['descripNotificacion'] = $descripcionNotificacion;
		$atributos ['fechasNotificacion'] = $fechaNotificacion;
		$atributos ['estadoNotificacion'] = $estadoNotificacion;
		$atributos ['url_clock'] = $this->imagenBase64($rutaUrlBloque . 'images/mini-clock.png');
		
		echo $this->miFormulario->megaMenu ( $atributos );
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
			$atributos ['efecto'] = 'desvanecer';
			$atributos ["etiqueta"] = '';
			$atributos ["columnas"] = '';
			// El control ocupa 47% del tamaño del formulario
			echo $this->miFormulario->campoMensaje ( $atributos );
			unset ( $atributos );
		}
		
		return true;
	}
	
	private function fecha_es($fecha) {
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
		return $meses [$fecha ['mes']] . ' ' . $fecha ['dia'] . ', ' . $fecha ['anio'] . ' - ' . $fecha ['hora'];
	}
	
	private function imagenBase64($rutaImagen) {
		$imagen = file_get_contents ( $rutaImagen );
		$imagenEncriptada = base64_encode ( $imagen );
		$url = "data:image/png;base64," . $imagenEncriptada;
		return $url;
	}
	
	private function decodificar_variable($cadena,$semilla) {
		$cifrado = MCRYPT_RIJNDAEL_256;
		$modo = MCRYPT_MODE_ECB;
		$cadena=base64_decode(str_pad(strtr($cadena, '-_', '+/'), strlen($cadena) % 4, '=', STR_PAD_RIGHT)); 
        $cadena=mcrypt_decrypt(
        	$cifrado,
        	$semilla,
        	$cadena,
        	$modo,
        	mcrypt_create_iv(
        		mcrypt_get_iv_size(
        			$cifrado,
        			$modo
				),
				MCRYPT_RAND
			)
		);
        return $cadena;
	}
}

$miFormulario = new FormularioMenu ( $this->lenguaje, $this->miFormulario, $this->sql );

$miFormulario->formulario ();
$miFormulario->mensaje ();
?>
