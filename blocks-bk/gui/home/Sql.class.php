<?php

namespace gui\home;

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
			
			case 'buscarNoticias' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "noti_nombre, ";
				$cadenaSql .= "noti_descripcion, ";
				$cadenaSql .= "noti_enlace, ";
				$cadenaSql .= "noti_tipo, ";
				$cadenaSql .= "noti_anio, ";
				$cadenaSql .= "noti_periodo, ";
				$cadenaSql .= "noti_fradicacion, ";
				$cadenaSql .= "noti_usr_remi, ";
				$cadenaSql .= "noti_img_usr_enlace ";
				$cadenaSql .= "FROM general.noticia ";
				$cadenaSql .= "WHERE noti_estado=1 ";
				$cadenaSql .= "OR now()::date BETWEEN noti_finicio AND noti_ffin ";
				$cadenaSql .= "ORDER BY noti_fradicacion DESC";
				// echo $cadenaSql;
				break;
			
			case 'buscarHorario' :
				
				$cadenaSql = 'SELECT ';
				
				$cadenaSql .= 'ANIO, ';
				$cadenaSql .= 'PERIODO, ';
				$cadenaSql .= 'COD_FACULTAD, ';
				$cadenaSql .= 'FACULTAD, ';
				$cadenaSql .= 'COD_PROYECTO, ';
				$cadenaSql .= 'PROYECTO, ';
				$cadenaSql .= 'DOCENTE, ';
				$cadenaSql .= 'NOMBRE_DOCENTE, ';
				$cadenaSql .= 'COD_ESPACIO, ';
				$cadenaSql .= 'ESPACIO, ';
				$cadenaSql .= 'COD_GRUPO, ';
				$cadenaSql .= 'GRUPO, ';
				
				$cadenaSql .= 'HOR_ID, ';
				$cadenaSql .= 'DIA_NRO, ';
				$cadenaSql .= 'DIA_ABREV, ';
				$cadenaSql .= 'DIA, ';
				$cadenaSql .= 'HORA, ';
				$cadenaSql .= 'HORA_LARGA, ';
				$cadenaSql .= 'EDIFICIO, ';
				$cadenaSql .= 'SEDE, ';
				$cadenaSql .= 'SALON, ';
				$cadenaSql .= 'ESTADO ';
				
				$cadenaSql .= 'FROM (';
				
				$cadenaSql .= 'SELECT DISTINCT cur_ape_ano AS ANIO,';
				$cadenaSql .= 'cur_ape_per AS PERIODO,';
				$cadenaSql .= 'cra_dep_cod 				AS COD_FACULTAD,';
				$cadenaSql .= 'dep_nombre 				AS FACULTAD,';
				$cadenaSql .= 'cur_cra_cod				AS COD_PROYECTO,';
				
				$cadenaSql .= 'A.cra_nombre 				AS PROYECTO,';
				$cadenaSql .= 'car_doc_nro				AS DOCENTE,';
				$cadenaSql .= "doc_nombre||' '||doc_apellido 		AS NOMBRE_DOCENTE,";
				$cadenaSql .= 'cur_asi_cod				AS COD_ESPACIO,';
				$cadenaSql .= 'asi_nombre 				AS ESPACIO,';
				$cadenaSql .= 'cur_grupo 				AS COD_GRUPO,';
				$cadenaSql .= "(Lpad(Cur_Cra_Cod,3,0)||'-'||Cur_Grupo)||' ('||cur_id||')' AS GRUPO,";
				$cadenaSql .= 'H.hor_id				AS HOR_ID,';
				$cadenaSql .= 'H.hor_dia_nro				AS DIA_NRO,';
				$cadenaSql .= 'dia_abrev				AS DIA_ABREV,';
				$cadenaSql .= 'dia_nombre				AS DIA,';
				$cadenaSql .= 'H.hor_hora				AS HORA,';
				$cadenaSql .= 'GH.hor_larga				AS HORA_LARGA,';
				$cadenaSql .= "(SED_ID||' - '||edi_nombre) 		AS EDIFICIO,";
				$cadenaSql .= "TO_CHAR(sed_nombre||' - '||edi_nombre)	AS SEDE,";
				$cadenaSql .= "(sal_id_espacio||' - '||sal_nombre) 	AS SALON,";
				$cadenaSql .= 'cur_estado				AS ESTADO ';
				
				$cadenaSql .= 'FROM accursos ';
				$cadenaSql .= "inner join acasperi on ape_ano=cur_ape_ano and ape_per=cur_ape_per and ape_estado='A' ";
				$cadenaSql .= "left outer join achorarios H ON hor_id_curso=cur_id AND H.hor_estado='A' ";
				$cadenaSql .= "left outer join accargas on car_hor_id=hor_id AND car_estado='A' ";
				$cadenaSql .= "left outer join accra A ON A.cra_cod=cur_cra_cod ";
				$cadenaSql .= "left outer join gedep A ON A.cra_dep_cod=dep_cod ";
				$cadenaSql .= "left outer join acasi ON asi_cod=cur_asi_cod ";
				$cadenaSql .= "left outer join acdocente ON doc_nro_iden=car_doc_nro ";
				$cadenaSql .= "left outer join gehora GH on H.hor_hora=GH.hor_cod ";
				$cadenaSql .= "left outer join gedia on hor_dia_nro=dia_cod ";
				$cadenaSql .= "left outer join actipvin ON tvi_cod=car_tip_vin ";
				$cadenaSql .= "left outer Join Gesalones On Hor_Sal_Id_Espacio=Sal_Id_Espacio ";
				$cadenaSql .= "left outer Join Gesede On Sal_Sed_Id=Sed_Id ";
				$cadenaSql .= "left outer join geedificio on sal_edificio=edi_cod ";
				
				$cadenaSql .= 'UNION ';
				
				$cadenaSql .= 'SELECT DPT_APE_ANO				AS ANIO, ';
				$cadenaSql .= 'DPT_APE_PER				AS PERIODO, ';
				$cadenaSql .= 'null 					AS COD_FACULTAD, ';
				$cadenaSql .= "'N/A' 					AS FACULTAD, ";
				$cadenaSql .= "null 					AS COD_PROYECTO, ";
				$cadenaSql .= "'N/A' 					AS PROYECTO, ";
				$cadenaSql .= "DPT_DOC_NRO_IDEN			AS DOC_DOCENTE, ";
				$cadenaSql .= "(DOC_APELLIDO||' '||DOC_NOMBRE)		AS NOMBRE_DOCENTE, ";
				$cadenaSql .= "DAC_COD					AS COD_ACTIVIDAD, ";
				$cadenaSql .= "DAC_NOMBRE				AS ACTIVIDAD, ";
				$cadenaSql .= "null 					AS COD_GRUPO, ";
				$cadenaSql .= "'N/A' 					AS GRUPO, ";
				$cadenaSql .= "null 					AS HORARIO, ";
				$cadenaSql .= "DIA_COD					AS DIA_NRO, ";
				$cadenaSql .= "dia_abrev				AS DIA_ABREV, ";
				$cadenaSql .= "dia_nombre				AS DIA, ";
				$cadenaSql .= "HOR_COD					AS HORA, ";
				$cadenaSql .= "HOR_LARGA				AS HORA_LARGA, ";
				$cadenaSql .= "(SED_ID||' - '||edi_nombre) 		AS EDIFICIO, ";
				$cadenaSql .= "TO_CHAR(sed_nombre||' - '||edi_nombre)	AS SEDE, ";
				$cadenaSql .= "(sal_id_espacio||' - '||sal_nombre) 	AS SALON, ";
				$cadenaSql .= "DPT_ESTADO 				AS ESTADO ";
				
				$cadenaSql .= 'FROM acdocplantrabajo ';
				$cadenaSql .= 'INNER JOIN acdocente ON DPT_DOC_NRO_IDEN = DOC_NRO_IDEN ';
				$cadenaSql .= "INNER JOIN acdocactividad ON DAC_COD = DPT_DAC_COD AND  DAC_ESTADO = 'A' AND DAC_COD=5 ";
				$cadenaSql .= "INNER JOIN gedia ON dia_cod= dpt_dia_nro AND DIA_ESTADO = 'A' ";
				$cadenaSql .= "INNER JOIN gehora ON hor_cod= dpt_hora AND HOR_ESTADO = 'A' ";
				$cadenaSql .= "LEFT OUTER JOIN gesede ON SED_COD = DPT_SED_COD AND SED_ESTADO = 'A' ";
				$cadenaSql .= "LEFT OUTER JOIN gesalones ON SAL_ID_ESPACIO = DPT_SAL_COD AND SAL_ESTADO = 'A' ";
				$cadenaSql .= "LEFT OUTER JOIN geedificio ON sal_edificio= edi_cod ";
				$cadenaSql .= "INNER JOIN actipvin ON tvi_cod=dpt_tvi_cod ";
				$cadenaSql .= "INNER JOIN acasperi ON ape_ano=DPT_APE_ANO AND ape_per=DPT_APE_PER AND ape_estado='A' ";
				$cadenaSql .= ") PLANT ";
				
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= "PLANT.ESTADO='A' ";
				$cadenaSql .= "AND PLANT.DOCENTE = '79708124' ";
				$cadenaSql .= 'ORDER BY PLANT.DOCENTE,PLANT.DIA_NRO, PLANT.HORA';
				// echo $cadenaSql;
				break;
			
			case 'buscarPrev' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "onmouseout AS sale, ";
				$cadenaSql .= "onmouseover AS entra, ";
				$cadenaSql .= "onmousemove AS mueve ";
				$cadenaSql .= "FROM general.previsualizacion ";
				$cadenaSql .= "WHERE id_prev=" . $variable . "; ";
				break;
		}
		
		if (! isset ( $cadenaSql )) {
			echo "No se encontro la sentencia: '" . $tipo . "'";
		}
		
		return $cadenaSql;
	}
}
?>
