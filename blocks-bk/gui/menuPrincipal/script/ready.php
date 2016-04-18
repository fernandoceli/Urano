<?php
$rutaUrlBloque = $this->miConfigurador->getVariableConfiguracion ( "host" ).$this->miConfigurador->getVariableConfiguracion ( "site" ).'/blocks/gui/menuPrincipal/';
?>
var i = 0;

  function cambiarImagen() {
    var imagenes = [
      "<?php echo $rutaUrlBloque.'images/header.png'?>",
      "<?php echo $rutaUrlBloque.'images/header2.png'?>",
      "<?php echo $rutaUrlBloque.'images/header3.png'?>"
    ];
    if (i < imagenes.length - 1) {
      i++;
    } else {
      i = 0;
    }
    $('#imagenfondo').fadeOut('slow', function() {

      $('#imagenfondo').css({
        'background-image': 'url("' + imagenes[i] + '")'
      });

      $('#imagenfondo').fadeIn('slow');
    });
  }
  setInterval(cambiarImagen, 30000);