<?php

$indice=0;
$funcion = array();
// $funcion[$indice++]="clicder.js";
// $funcion[$indice++]="md5.js";
// $funcion[$indice++]="MuestraLayer.js";
// $funcion[$indice++]="BorraLink.js";
// $funcion[$indice++]="ventana.js";
// $funcion[$indice++]="modificado.js";

// $funcion[$indice++]="overlib.js";

// $funcion[$indice++]="overlibmws.js";
// $funcion[$indice++]="overlibmws_filter.js";
// $funcion[$indice++]="overlibmws_print.js";
// $funcion[$indice++]="overlibmws_shadow.js";
// $funcion[$indice++]="300lo.js";
// $funcion[$indice++]="boost.js";
// $funcion[$indice++]="bootstrap.js";
// $funcion[$indice++]="analytics.js";
// $funcion[$indice++]="jquery_002.js";
// $funcion[$indice++]="easy-ticker.js";
// $funcion[$indice++]="jquery.min.js";
$funcion[$indice++]="jquery.easy-ticker.js";
// $funcion[$indice++]="jquery.easy-ticker.min.js";
$funtion[$indice++]="jquery.easing.min.js";


$rutaBloque=$this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");

if($esteBloque["grupo"]==""){
	$rutaBloque.="/blocks/".$esteBloque["nombre"];
}else{
	$rutaBloque.="/blocks/".$esteBloque["grupo"]."/".$esteBloque["nombre"];
}


$_REQUEST ['tiempo'] = time ();

if(isset($funcion[0])){
foreach ($funcion as $clave=>$nombre){
	if(!isset($embebido[$clave])){
		echo "\n<script type='text/javascript' src='".$rutaBloque."/script/".$nombre."'>\n</script>\n";
	}else{
		echo "\n<script type='text/javascript'>";
		include($nombre);
		echo "\n</script>\n";
	}
}
}

?>
