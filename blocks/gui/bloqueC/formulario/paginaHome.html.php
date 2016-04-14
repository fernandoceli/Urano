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
		var alturaIframe = document.getElementById('bloqueC').contentWindow.document.body.scrollHeight;
		//change the height of the iframe
		if (alturaIframe <= 1024) {
			alturaIframe = 1024;
		}
		document.getElementById('bloqueC').height = alturaIframe;
	}
</script>

<iframe src="<?php echo $enlaceHome; ?>" id="bloqueC" name="principal" onLoad="calcHeight();" height="1px" frameborder="0"  scrolling="no" >
	GLUD
</iframe>
