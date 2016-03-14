<?php

namespace gui\accesoIncorrecto;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class Sql extends \Sql {
	var $miConfigurador;
	function getCadenaSql($tipo, $variable = '') {
		
		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		
		switch ($tipo) {
			
			/**
			 * Clausulas específicas
			 */
			case 'insertarPagina' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= $prefijo . 'pagina ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'nombre,';
				$cadenaSql .= 'descripcion,';
				$cadenaSql .= 'modulo,';
				$cadenaSql .= 'nivel,';
				$cadenaSql .= 'parametro';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= '\'' . $_REQUEST ['nombrePagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['descripcionPagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['moduloPagina'] . '\', ';
				$cadenaSql .= $_REQUEST ['nivelPagina'] . ', ';
				$cadenaSql .= '\'' . $_REQUEST ['parametroPagina'] . '\'';
				$cadenaSql .= ') ';
				break;
			
			case 'buscarPagina' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_pagina as PAGINA, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'descripcion as DESCRIPCION,';
				$cadenaSql .= 'modulo as MODULO,';
				$cadenaSql .= 'nivel as NIVEL,';
				$cadenaSql .= 'parametro as PARAMETRO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= $prefijo . 'pagina ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'nombre=\'' . $_REQUEST ['nombrePagina'] . '\' ';
				break;
			
			case 'insertarBloque' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= $prefijo . 'bloque ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'nombre,';
				$cadenaSql .= 'descripcion,';
				$cadenaSql .= 'grupo';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= '\'' . $_REQUEST ['nombreBloque'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['descripcionBloque'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['grupoBloque'] . '\' ';
				$cadenaSql .= ') ';
				break;
			
			case 'buscarBloque' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_bloque as BLOQUE, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'descripcion as DESCRIPCION,';
				$cadenaSql .= 'grupo as GRUPO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= $prefijo . 'bloque ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'nombre=\'' . $_REQUEST ['nombreBloque'] . '\' ';
				break;
			
			case 'buscarBloques' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_bloque as BLOQUE, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'descripcion as DESCRIPCION,';
				$cadenaSql .= 'grupo as GRUPO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= $prefijo . 'bloque ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id_bloque>0';
				break;
				
			case 'buscarNoticias':
				$cadenaSql = "SELECT ";
				$cadenaSql .= "nombre, ";
				$cadenaSql .= "descripcion, ";
				$cadenaSql .= "enlace, ";
				$cadenaSql .= "tipo, ";
				$cadenaSql .= "anio, ";
				$cadenaSql .= "periodo, ";
				$cadenaSql .= "fercha_radicacion, ";
				$cadenaSql .= "nombre_usr_remi, ";
				$cadenaSql .= "img_usr_enlace ";
				$cadenaSql .= "FROM general.noticia ";
				$cadenaSql .= "WHERE estado=1 ";
				$cadenaSql .= "OR now()::date BETWEEN fecha_inicio AND fecha_fin ";
				$cadenaSql .= "ORDER BY fercha_radicacion DESC";
// 				echo $cadenaSql;
				break;

			case 'buscarPrev':
				$cadenaSql = "SELECT ";
				$cadenaSql .= "onmouseout AS sale, ";
				$cadenaSql .= "onmouseover AS entra, ";
				$cadenaSql .= "onmousemove AS mueve ";
				$cadenaSql .= "FROM general.previsualizacion ";
				$cadenaSql .= "WHERE id_prev=" . $variable . "; ";
				break;
		}
		
		if (!isset($cadenaSql)) {
			echo "No se encontro la sentencia: '" . $tipo . "'";
		}
		
		return $cadenaSql;
	}
}
?>
