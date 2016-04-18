<?php

namespace gui\home\funcion;
use \DateTime;
use \DateInterval;

$conexionOracle = "academica";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexionOracle );
$rutaUrlBloque = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );


if ($_REQUEST ['funcion'] == 'buscarHorario') {
	//$cadenaSql = $this->sql->getCadenaSql ( 'buscarHorario', $_REQUEST['valor']);
	$cadenaSql = $this->sql->getCadenaSql ( 'buscarHorario');
	$matrizHorario = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
}

$hoy = getdate();

$diaActual=$hoy['wday'];
$diaActual=3;

$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$arrayDias = array( 'Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y');

function diaHora($dia, $hora){
	if($dia=='LUNES' ) $i=1;
	if($dia=='MARTES' ) $i=2;
	if($dia=='MIERCOLES' ) $i=3;
	if($dia=='JUEVES' ) $i=4;
	if($dia=='VIERNES' ) $i=5;
	if($dia=='SABADO' ) $i=6;
	if($dia=='DOMINGO' ) $i=0;

	if($hora==6) ${"tede".$i} = 'ma0070'.$i;
	else if($hora==7) ${"tede".$i} = 'ma0080'.$i;
	else if($hora==8) ${"tede".$i} = 'ma0090'.$i;
	else if($hora==9) ${"tede".$i} = 'ma0001'.$i;
	else if($hora==10) ${"tede".$i} = 'ma0011'.$i;
	else if($hora==11) ${"tede".$i} = 'mp0021'.$i;
	else if($hora==12) ${"tede".$i} = 'mp0010'.$i;
	else if($hora==13) ${"tede".$i} = 'mp0020'.$i;
	else if($hora==14) ${"tede".$i} = 'mp0030'.$i;
	else if($hora==15) ${"tede".$i} = 'mp0040'.$i;
	else if($hora==16) ${"tede".$i} = 'mp0050'.$i;
	else if($hora==17) ${"tede".$i} = 'mp0060'.$i;

	return ${"tede".$i};
}

function numDia($dia){
	if($dia=='LUNES' ) $i=1;
	if($dia=='MARTES' ) $i=2;
	if($dia=='MIERCOLES' ) $i=3;
	if($dia=='JUEVES' ) $i=4;
	if($dia=='VIERNES' ) $i=5;
	if($dia=='SABADO' ) $i=6;
	if($dia=='DOMINGO' ) $i=0;
	return $i;
}

function formatoHora($in){
	$hora= date($in.':00');
	$time = new DateTime($hora);
	$time->add(new DateInterval('PT' . '00' . 'M'));
	$stamp = $time->format('h:i a');
	return $stamp;
}

function sumtime($in, $fin,$minutos, $dia){
	$hoy = getdate();
	$parse1 = new DateTime($in);
	$parse2 = new DateTime($fin);
	if ($parse2 <= $parse1){
		return;
	}else{
		
		$time = new DateTime($in);
		$time->add(new DateInterval('PT' . $minutos . 'M'));
		$stamp = $time->format('h:i a');
		$format24 = $time ->format('G:i');

		$uniq = str_replace(' ', '', str_replace(':', '', $stamp));
		$reverse = strrev($uniq);
		$rest = substr($uniq, -6, 4);
		$rest2=strrev($rest);
		
		if($in==$hoy['hours']){
			$ahora = "<div style='margin-top: 8%'><span class='label' id='label_ahora'>Ahora >></span></div>";
		}else{
			$ahora='';
		}
		
		echo '<tr id="'.$rest2.$dia.'"><td class="td-time" id="'.$rest.$dia."t".'">'.date('h:i a', strtotime($in)). ' - ' .$stamp.$ahora.'</td>';
		
		for ($i=1; $i <= 1; $i++) {
			
			echo'
             <td class="td-line">
               <div class="col-sm-12 nopadding">
                  <label class="label-desc" id="'.$reverse.$dia.'" style="margin: 0 0 0 0;"></label>
               </div>
     
            </td>';
		}
		echo'</tr>';

		resum($format24,$fin,$minutos, $dia);
	}
}

function resum($in,$fin,$minutos, $dia){
	$hoy = getdate();
	$time = new DateTime($in);
	$time->add(new DateInterval('PT' . $minutos . 'M'));
	$stamp = $time->format('h:i a');
	$format24 = $time ->format('G:i');

	$uniq = str_replace(' ', '', str_replace(':', '', $stamp));
	$reverse = strrev($uniq);
	$rest = substr($uniq, -6, 4);
	$rest2=strrev($rest);
	
	if($in==$hoy['hours']){
		$ahora = "<div style='margin-top: 8%'><span class='label' id='label_ahora'>Ahora >></span></div>";
	}else{
		$ahora='';
	}

	echo '<tr id="'.$rest2.$dia.'"><td class="td-time">'.date('h:i a', strtotime($in)). ' - ' .$stamp.$ahora.'</td>';

	for ($i=1; $i <= 1; $i++) {

		echo'
             <td class="td-line">
               <div class="col-sm-12 nopadding">
                  <label class="label-desc" id="'.$reverse.$dia.'" style="margin: 0 0 0 0;"></label>
               </div>

            </td>
        ';
	}

	echo '</tr>';
	sumtime($format24,$fin,$minutos, $dia);
}
?>

<!-- container -->
<div class="container2">

<?php 
    $colores=array('green-label', 'blue-label', 'red-label', 'purple-label', 'pink-label');
    $materias=array();
    $franjas=array();
   
    $id=0;

    for($i=0; $i<count($matrizHorario); $i++){
      if(!in_array($matrizHorario[$i]['ESPACIO'], $materias)){
        $franjaP = array($matrizHorario[$i]['ESPACIO'], $colores[$id] );
        array_push($materias, $matrizHorario[$i]['ESPACIO']);
          array_push($franjas, $franjaP);
          $id++;
      }
    }
    
    
    //crear arreglo para guardar todas las posibles posiciones
    $losqhay = array('ma00701', 'ma00801', 'ma00901', 'ma00011', 'ma00111', 'mp00211', 'mp00101', 'mp00201', 'mp00301', 'mp00401', 'mp00501', 'mp00601',
    		'ma00702', 'ma00802', 'ma00902', 'ma00012', 'ma00112', 'mp00212', 'mp00102', 'mp00202', 'mp00302', 'mp00402', 'mp00502', 'mp00602',
    		'ma00703', 'ma00803', 'ma00903', 'ma00013', 'ma00113', 'mp00213', 'mp00103', 'mp00203', 'mp00303', 'mp00403', 'mp00503', 'mp00603',
    		'ma00704', 'ma00804', 'ma00904', 'ma00014', 'ma00114', 'mp00214', 'mp00104', 'mp00204', 'mp00304', 'mp00404', 'mp00504', 'mp00604',
    		'ma00705', 'ma00805', 'ma00905', 'ma00015', 'ma00115', 'mp00215', 'mp00105', 'mp00205', 'mp00305', 'mp00405', 'mp00505', 'mp00605',
    		'ma00706', 'ma00806', 'ma00906', 'ma00016', 'ma00116', 'mp00216', 'mp00106', 'mp00206', 'mp00306', 'mp00406', 'mp00506', 'mp00606',
    		'ma00700', 'ma00800', 'ma00900', 'ma00010', 'ma00110', 'mp00210', 'mp00100', 'mp00200', 'mp00300', 'mp00400', 'mp00500', 'mp00600'
    );
    $tam=count($losqhay);
    
    //crear arreglo para guardar los tede
    $mostrados = array();

    $ahora='';
    $hora= date('6:00');
    $hora2= date('18:00');
    $min=60;
    
    //var_dump($matrizHorario);
    for ($i=0; $i<count($matrizHorario); $i++){
    	${"espacio".$i} = $matrizHorario[$i]['ESPACIO'];
    	${"sede".$i} = $matrizHorario[$i]['SEDE'];
    	${"salon".$i} = substr($matrizHorario[$i]['SALON'], 13);
    	${"tede".$i}=diaHora($matrizHorario[$i]['DIA'], $matrizHorario[$i]['HORA']);
   
    	//si se repite
    	if($i>0){
    		$l=$i-1;
    		if((${"espacio".$i}==${"espacio".$l}) &&($matrizHorario[$i]['DIA']==$matrizHorario[$l]['DIA'])){
    			${"tede".$i}=${"tede".$l};
    			//hora inicial
    			$horaAnterior=$matrizHorario[$l]['HORA'];
    			//hora final
    			$horaActual=$matrizHorario[$i]['HORA']+1;
    			$horaMedia=$matrizHorario[$i]['HORA'];
    			
    			$numeroDia=numDia($matrizHorario[$i]['DIA']);
    			
    			$formatoHI=formatoHora($horaAnterior);
    			$formatoHF=formatoHora($horaActual);
    			$formatoHM=formatoHora($horaMedia);
    			
    			$uniq = str_replace(' ', '', str_replace(':', '', $formatoHM));
    			$rest = substr($uniq, -6, 4);
    			
    			?>
				<script type="text/javascript">
					$("<?php echo "#".$rest.$numeroDia."t";?>").text("<?php echo $formatoHI.' - '.$formatoHF; ?>");
    			   
    			        	
    			</script>
    			    <?php 
    			
    		}
    	}
    	
    }
    
   
    for($i=0; $i<count($matrizHorario); $i++){
    	for ($k=0; $k<count($franjas); $k++){
    		if($franjas[$k][0]==${"espacio".$i} ){
    			${"color".$i} = $franjas[$k][1];
    		}
    	}
    	
    	if($matrizHorario[$i]['DIA']=='LUNES' ) $dia=1;
    	if($matrizHorario[$i]['DIA']=='MARTES' ) $dia=2;
    	if($matrizHorario[$i]['DIA']=='MIERCOLES' ) $dia=3;
    	if($matrizHorario[$i]['DIA']=='JUEVES' ) $dia=4;
    	if($matrizHorario[$i]['DIA']=='VIERNES' ) $dia=5;
    	if($matrizHorario[$i]['DIA']=='SABADO' ) $dia=6;
    	if($matrizHorario[$i]['DIA']=='DOMINGO' ) $dia=0;
    	
    	if(isset(${"tede".$i} ) ){
    		array_push($mostrados, ${"tede".$i});
    		
    		?>
            <script>
            
              $(<?php  echo '"#'.${"tede".$i}.'"'; ?>).
              html(<?php  echo '"'.${"espacio".$i}.
              "<br>".
              ${"sede".$i}."<br>".${"salon".$i}.'"'; ?>)
              .addClass(<?php  echo "'". ${"color".$i}."'"; ?>).show();
            </script>
            <?php 
            
          }
        }
    
        //quitar los mostrados a los q hay
        for($i=0; $i<count($mostrados); $i++){
          if(in_array($mostrados[$i], $losqhay)){
            $quitar=array_search($mostrados[$i], $losqhay);
            unset($losqhay[$quitar]);
          }
        }
    
        //eliminar del horario
        for($i=0; $i<$tam; $i++){
          if(isset($losqhay[$i])){
            $m = substr($losqhay[$i], 2);
          ?>
            <script>
              //eliminar fila vacÌa
              $(<?php  echo '"#'.$m.'"'; ?>).remove();
            </script>
            <?php
          }
        }   
        
        //ver si existen materias para el dÌa
        $materiasDia=false;
        for($i=0; $i<count($mostrados); $i++){
        	$m = substr($mostrados[$i], 6);
        	if($m==$diaActual){
        		$materiasDia=true;
        	}
        }
    
        //var_dump($mostrados);
        

if($diaActual==1 && $materiasDia){ 
	echo'<table id="tablaLunes" class="table table-bordered">';
    // Acomodar Dias
    echo'<thead>
    <th><i class="fa fa-clock-o"></i> Horario</th>';
    echo '<th><i class="fa fa-angle-right"></i> Lunes</th>';
    echo '</thead>
    <tbody>';

    sumtime($hora,$hora2,$min, $diaActual);
    echo '</tbody>';  
	echo '</table>'; 
}

else if($diaActual==2 && $materiasDia){ 
	echo '<table id="tablaMartes" class="table table-bordered">';
 
  	echo'<thead>
    <th><i class="fa fa-clock-o"></i> Horario</th>';
    echo '<th><i class="fa fa-angle-right"></i> Martes</th>';
    echo '</thead>
    <tbody>';
    
    sumtime($hora,$hora2,$min, $diaActual);
    
    echo '</tbody>';
	echo '</table>';
}

else if($diaActual==3 && $materiasDia){ 
  	echo'<table id="tablaMiercoles" class="table table-bordered">';
 	$dia=3;
  	echo'<thead>
    <th><i class="fa fa-clock-o"></i> Horario</th>';
    echo '<th><i class="fa fa-angle-right"></i> Miercoles</th>';
    echo '</thead>
    <tbody>';

    sumtime($hora,$hora2,$min, $diaActual);
    
    echo '</tbody>';
	echo '</table>';
} 

else if($diaActual==4 && $materiasDia){ 

	echo '<table id="tablaJueves" class="table table-bordered">';

 	echo'<thead>
    <th><i class="fa fa-clock-o"></i> Horario</th>';
 
    echo '<th><i class="fa fa-angle-right"></i> Jueves</th>';
    echo '</thead>
    <tbody>';

    sumtime($hora,$hora2,$min, $diaActual);
    
    echo '</tbody>';
	echo '</table>';

} 

else if($diaActual==5 && $materiasDia){ 

	echo '<table id="tablaViernes" class="table table-bordered">';
  	echo'
    <thead>
    <th><i class="fa fa-clock-o"></i> Horario</th>';
    echo '<th><i class="fa fa-angle-right"></i> Viernes</th>';
    echo '</thead>
    <tbody>';

    sumtime($hora,$hora2,$min, $diaActual);
    
    echo '</tbody>';
	echo '</table>';

} 

else if($diaActual==6 && $materiasDia){ 

 	echo '<table id="tablaSabado" class="table table-bordered">';
  	echo'<thead>
    <th><i class="fa fa-clock-o"></i> Horario</th>';
    
    echo '<th><i class="fa fa-angle-right"></i> Sabado</th>';
    echo '</thead>
    <tbody>';

    sumtime($hora,$hora2,$min, $diaActual);
    
    echo '</tbody>';
	echo '</table>';
}

else if($diaActual==0 && $materiasDia){

	echo '<table id="tablaDomingo" class="table table-bordered">';
	echo'<thead>
    <th><i class="fa fa-clock-o"></i> Horario</th>';

	echo '<th><i class="fa fa-angle-right"></i> Domingo</th>';
	echo '</thead>
    <tbody>';

	sumtime($hora,$hora2,$min, $diaActual);

	echo '</tbody>';
	echo '</table>';
}
else{
	
	?>
	<div style="margin-top: 25%; width: 100%; height: 100%;">

		<img src="<?php echo $rutaUrlBloque.'images/no_hay_horario.png'?>" class="img-responsive" style="width: 100%;" />
		<br>
		<p style='text-align: center; font-size: 16px;'>No hay espacios acad√©micos asignados para el d√≠a.</p>
	</div>
	<?php 
	
}

?>

</div>