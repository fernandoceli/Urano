<?php
namespace gui\inicio\funcion;
include_once 'sesion.class.php';
include_once 'accesos.class.php';
include_once 'expirar_sesiones.class.php';
use gui\inicio\funcion\sesiones as sesiones;
use gui\inicio\funcion\accesos as accesos;
use gui\inicio\funcion\expirar_sesiones as expirar_sesiones;
//include_once ('verifica.class.php');
//use gui\inicio\funcion\verifica as verifica;

class Login {
	var $miConfigurador;
	var $miAutenticador;
	var $miSql;
	var $configuracion_appserv;
	var $nueva_sesion;
	var $reg_acceso;
	var $expira;
	
	function __construct($sql) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->miAutenticador = \Autenticador::singleton ();
		$this->miSql = $sql;
		$this->configuracion_appserv = $this->getConfiguration();
		$this->nueva_sesion = new sesiones($this->configuracion_appserv);
        $this->reg_acceso = new acceso($this->configuracion_appserv);
        $this->expira = new expira_sesion();
		/*variables para controlar las sesiones*/
        $this->CarpetaSesion = $this->configuracion_appserv['raiz_sesiones'] . "/sesiones/";
        $this->NumSesionEst  = 'sesionesEstudiante.txt';
        $this->NumSesionEst2 = 'sesionesEstudiante2.txt';
        $this->NumSesionEst3 = 'sesionesEstudiante3.txt';
        $this->NumSesionFun  = 'sesionesFuncionario.txt';
        $this->TimeSesionEst = 'tiempoSesionesEstudiante.txt';
        $this->TimeSesionFun = 'tiempoSesionesFuncionario.txt';
        $this->ingresosEst   = 'ingresosEstudiante.txt';
        $this->histSemilla   = 'historialSemillas.txt';
        $this->redirLogueo   = $this->configuracion_appserv['host_logueo'] . $this->configuracion_appserv['site'] . '/index.php';
	}
	function procesarFormulario() {
		
		$this->expirar_sesiones();
		//var_dump($this->miAutenticador);
		// $resultado = $this->miAutenticador->iniciarAutenticacion();
        // $verifica = new verifica();var_dump($verifica);die;
        // $user=$verifica->action();
        $user = $_REQUEST['usuario'];
		
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
		$this->miConfigurador->fabricaConexiones->setConfiguracion($conexionDB);		
		$this->miConfigurador->fabricaConexiones->setRecursoDB($conexion,'instalacion');
		
		$acceso_MY = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
		//Fin: Crear conexión logueo
		
		//Inicio: Trae la clave del usuario de la conexión anterior
        $parametros = array(
        	'usuario' => $user,
        	'sql_tabla1' => $this->configuracion_appserv['sql_tabla1']
		);
        $cadenaSql = $this->miSql->getCadenaSql ( 'buscarClaveUsuario' , $parametros);
		$resultado = $acceso_MY->ejecutarAcceso ( $cadenaSql, 'busqueda' )[0];
		//Fin: Trae la clave del usuario de la conexión anterior
		
		
		
		session_cache_limiter('nocache,private');
        session_name($this->configuracion_appserv['usuarios_sesion']);
        session_start();
        /*registra el inicio de la sesion en el sistema*/
        $_SESSION["usuario_login"]    = $resultado['COD'];
        $_SESSION['usuario_password'] = $resultado['PWD'];
        $_SESSION["usuario_nivel"]    = $resultado['TIP_US'];
        $tipoUser = $resultado['TIP_US'];

		//$this->printRows($resultado);die;

		//Si la autenticación fue exitosa va a la página bienvenido
		if($resultado){
			$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
			$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
			$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
            $valorCodificado = "pagina=bienvenido";
			$valorCodificado.= "&usuario=".$user;
			//$valorCodificado .= "&autenticado=true";
			$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
			$enlace = $directorio.'='.$valorCodificado;
			
			header('Location: '.$enlace);
		}
		return $resultado;
	}

	function printRows($rows){
	    echo "<h3>Filas SQL:</h3>\n<table border='1'>";
	    foreach ($rows as $row)
	    {
	        echo "<tr>";    
	        // $row is array... foreach( .. ) puts every element
	        // of $row to $cell variable
	        foreach($row as $cellName => $cell){
	        	$entero = (int)$cellName;
				$texto = (string)$entero;
	        	if (!$cellName==$texto){		        		
		        	//echo var_dump($cellName);
					echo "<td>$cellName: $cell</td>";
	        	}
	        }	            
	        echo "</tr>\n";
	    }
	    echo "</table>";
	}
	private function getConfiguration(){		
		//Inicio: Trae la configuración de appserv de una base de datos
		$conexion = 'appserv';
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        
        $cadenaSql = $this->miSql->getCadenaSql ( 'buscarConfiguracionDBMS' );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		
		$configuracion = array();
        foreach($resultado as $row){
            $configuracion[$row[0]] = $row[1];
        }
		return $configuracion;
		//Fin: Trae la configuración de appserv de una base de datos
	}
	function decodificar_variable($cadena,$semilla) {
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
	function expirar_sesiones()
    //VERIFICA Y REALIZA LA EXPIRACION DE SESIONES DE ESTUDIANTES
    {
        $tiempoEst     = $this->leer_archivo($this->TimeSesionEst);
        $expiraEst_ini = $tiempoEst + $this->configuracion_appserv['tiempo_revisar_sesiones_estudiante'];
        $expiraEst_fin = time();
        //$this->expira->verificarExpiracion();
        if ($expiraEst_ini < $expiraEst_fin) {
            $this->expira->verificarExpiracion('estudiante');
            $fsesEst = fopen($this->CarpetaSesion . $this->TimeSesionEst, "w");
            fwrite($fsesEst, $expiraEst_fin);
            fclose($fsesEst);
        }
        //VERIFICA Y REALIZA LA EXPIRACION DE SESIONES DE FUNACIONARIOS
        $tiempoFun     = $this->leer_archivo($this->NumSesionFun);
        $expiraFun_ini = $tiempoFun + $this->configuracion_appserv['tiempo_revisar_sesiones_funcionario'];
        $expiraFun_fin = time();
        //$this->expira->verificarExpiracion();
        if ($expiraFun_ini < $expiraFun_fin) {
            $this->expira->verificarExpiracion('funcionario');
            $fsesFun = fopen($this->CarpetaSesion . $this->TimeSesionFun, "w");
            fwrite($fsesFun, $expiraFun_fin);
            fclose($fsesFun);
        }
        /*espera 3 segundos mientras borra los registros*/
        //set_time_limit(10); 
    }
	function leer_archivo($doc)
    {
        if (!file_exists($this->CarpetaSesion . $doc)) {
            $dato = 0;
        } else {
            $dato = file_get_contents($this->CarpetaSesion . $doc);
        }
        //echo "<br>dato ".$dato;
        return ($dato);
        exit;
    } //fin funcion leer_archivo
    
}

$miProcesador = new Login ($this->sql);
$miProcesador->procesarFormulario();
?>