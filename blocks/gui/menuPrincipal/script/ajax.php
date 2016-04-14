<?php

// URL base
$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$url .= "/index.php?";
// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=actualizarNotificaciones";
$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
$cadenaACodificar .= "&usuario=" . $_REQUEST ['usuario'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );

// URL definitiva
$urlFinal = $url . $cadena;

?>

<script type='text/javascript'>

$(document).ready(function() {
	var cantidad;

	$("#notificationLink").click(function() {
		$("#notificationContainer").fadeToggle(300);
		$("#notification_count").fadeOut("slow");
		cantidad = $("#notification_count").text();
		return false;
	});

	// Document Click
	$(document).click(function() {
		if (cantidad != '') {
			$.ajax({
	            url: "<?php echo $urlFinal; ?>",
	            success: function(data){
	        		$("#notificationContainer").hide();
	        		$("#notification_count").text('');
	            }
	   		});
		}
	});
	
	// Popup Click
	$("#notificationContainer").click(function() {
		return false
	});
});

</script>