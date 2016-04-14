<?php 

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

if (isset($_REQUEST ['funcion'])) {
	
	switch ($_REQUEST ['funcion']) {
		case 'actualizarNotificaciones':
			$cadenaSql = $this->sql->getCadenaSql ( 'actualizarNotificaciones', $_REQUEST['usuario']);
			break;
	}
// 	var_dump($cadenaSql);
	$actualizacion = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizacion" );
// 	var_dump($actualizacion);

}

?>