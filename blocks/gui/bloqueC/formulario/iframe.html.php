<?php
$directorio = $this -> miConfigurador -> getVariableConfiguracion("host");
$directorio .= $this -> miConfigurador -> getVariableConfiguracion("site") . "/index.php?";
$directorio .= $this -> miConfigurador -> getVariableConfiguracion("enlace");

$enlaceHome = 'pagina=home';
$enlaceHome = $this -> miConfigurador -> fabricaConexiones -> crypto -> codificar_url($enlaceHome, $directorio);

?>
<script type="text/javascript">
	function calcHeight() {
		//find the height of the internal page
		document.getElementById('bloqueC').height = 1;
		var alturaIframe = document.getElementById('bloqueC').contentWindow.document.body.scrollHeight;
		//alert(alturaIframe);
		//change the height of the iframe
		var alturaMinima = 720;
		if (alturaIframe <= alturaMinima) {
			alturaIframe = alturaMinima;
		}
		document.getElementById('bloqueC').height = alturaIframe;
	}
	window.addEventListener("resize", calcHeight);
</script>

<iframe src="<?php echo $enlaceHome; ?>" id="bloqueC" name="principal" onLoad="calcHeight();" height="1px" frameborder="0"  scrolling="no" >
	GLUD
</iframe>
