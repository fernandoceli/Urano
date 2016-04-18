<?php

namespace gui\noticias\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Formulario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	function __construct($lenguaje, $formulario) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
	}
	function formulario() {
		
		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
		/**
		 * Atributos que deben ser aplicados a todos los controles de este formulario.
		 * Se utiliza un arreglo
		 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		 *
		 * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
		 * $atributos= array_merge($atributos,$atributosGlobales);
		 */
		$atributosGlobales ['campoSeguro'] = 'true';
		$_REQUEST ['tiempo'] = time ();
		
		// -------------------------------------------------------------------------------------------------
		
		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = '';
		
		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';
		
		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );
		
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		?>
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="glyphicon glyphicon-list-alt"></span><b>Noticias</b>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12">
							<ul class="demo1">
								<li class="news-item">
									<table cellpadding="4">
										<tr>
											<td><img src="images/1.png" width="60" class="img-circle" /></td>
											<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
												Nullam in venenatis enim... <a href="#">Read more...</a>
											</td>
										</tr>
									</table>
								</li>
								<li class="news-item">
									<table cellpadding="4">
										<tr>
											<td><img src="images/2.png" width="60" class="img-circle" /></td>
											<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
												Nullam in venenatis enim... <a href="#">Read more...</a>
											</td>
										</tr>
									</table>
								</li>
								<li class="news-item">
									<table cellpadding="4">
										<tr>
											<td><img src="images/3.png" width="60" class="img-circle" /></td>
											<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
												Nullam in venenatis enim... <a href="#">Read more...</a>
											</td>
										</tr>
									</table>
								</li>
								<li class="news-item">
									<table cellpadding="4">
										<tr>
											<td><img src="images/4.png" width="60" class="img-circle" /></td>
											<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
												Nullam in venenatis enim... <a href="#">Read more...</a>
											</td>
										</tr>
									</table>
								</li>
								<li class="news-item">
									<table cellpadding="4">
										<tr>
											<td><img src="images/5.png" width="60" class="img-circle" /></td>
											<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
												Nullam in venenatis enim... <a href="#">Read more...</a>
											</td>
										</tr>
									</table>
								</li>
								<li class="news-item">
									<table cellpadding="4">
										<tr>
											<td><img src="images/6.png" width="60" class="img-circle" /></td>
											<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
												Nullam in venenatis enim... <a href="#">Read more...</a>
											</td>
										</tr>
									</table>
								</li>
								<li class="news-item">
									<table cellpadding="4">
										<tr>
											<td><img src="images/7.png" width="60" class="img-circle" /></td>
											<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
												Nullam in venenatis enim... <a href="#">Read more...</a>
											</td>
										</tr>
									</table>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="panel-footer"></div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="glyphicon glyphicon-list-alt"></span><b>News</b>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12">
							<ul class="demo2">
								<li class="news-item">Lorem ipsum dolor sit amet, consectetur
									adipiscing elit. Nullam in venenatis enim... <a href="#">Read
										more...</a>
								</li>
								<li class="news-item">Lorem ipsum dolor sit amet, consectetur
									adipiscing elit. Nullam in venenatis enim... <a href="#">Read
										more...</a>
								</li>
								<li class="news-item">Lorem ipsum dolor sit amet, consectetur
									adipiscing elit. Nullam in venenatis enim... <a href="#">Read
										more...</a>
								</li>
								<li class="news-item">Lorem ipsum dolor sit amet, consectetur
									adipiscing elit. Nullam in venenatis enim... <a href="#">Read
										more...</a>
								</li>
								<li class="news-item">Lorem ipsum dolor sit amet, consectetur
									adipiscing elit. Nullam in venenatis enim... <a href="#">Read
										more...</a>
								</li>
								<li class="news-item">Lorem ipsum dolor sit amet, consectetur
									adipiscing elit. Nullam in venenatis enim... <a href="#">Read
										more...</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="glyphicon glyphicon-list-alt"></span><b>Noticias</b>
				</div>
				<div class="panel-footer"></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12">
							<ul id="demo3">
								<li class="news-item">Curabitur porttitor ante eget hendrerit
									adipiscing. Maecenas at magna accumsan, rhoncus neque id,
									fringilla dolor. <a href="#">Read more...</a>
								</li>
								<li class="news-item">Curabitur porttitor ante eget hendrerit
									adipiscing. Maecenas at magna accumsan, rhoncus neque id,
									fringilla dolor. <a href="#">Read more...</a>
								</li>
								<li class="news-item">Praesent ornare nisl lorem, ut condimentum
									lectus gravida ut. Ut velit nunc, vehicula volutpat laoreet
									vel, consequat eu mauris. <a href="#">Read more...</a>
								</li>
								<li class="news-item">Nunc ultrices tortor eu massa placerat
									posuere. Vivamus viverra sagittis nunc. Nunc et imperdiet
									magna. Mauris sed eros nulla. <a href="#">Read more...</a>
								</li>
								<li class="news-item">Morbi sodales tellus sit amet leo congue
									bibendum. Ut non mauris eu neque fermentum pharetra. <a
									href="#">Read more...</a>
								</li>
								<li class="news-item">In pharetra suscipit orci sed viverra.
									Praesent at sollicitudin tortor, id sagittis magna. Fusce massa
									sem, bibendum id. <a href="#">Read more...</a>
								</li>
								<li class="news-item">Maecenas nec ligula sed est suscipit
									aliquet sed eget ipsum. Suspendisse id auctor nibh. Ut
									porttitor volutpat augue, non sodales odio dignissi id. <a
									href="#">Read more...</a>
								</li>
								<li class="news-item">Onec bibendum consectetur diam, nec
									euismod urna venenatis eget. Cras consequat convallis leo. <a
									href="#">Read more...</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
		
		// ------------------- SECCION: Paso de variables ------------------------------------------------
		
		/**
		 * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
		 * SARA permite realizar esto a través de tres
		 * mecanismos:
		 * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
		 * la base de datos.
		 * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
		 * formsara, cuyo valor será una cadena codificada que contiene las variables.
		 * (c) a través de campos ocultos en los formularios. (deprecated)
		 */
		
		// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
		
		// Paso 1: crear el listado de variables
		
		$valorCodificado = "action=" . $esteBloque ["nombre"];
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&opcion=registrarBloque";
		/**
		 * SARA permite que los nombres de los campos sean dinámicos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo.
		 */
		$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
		// Paso 2: codificar la cadena resultante
		$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
		
		$atributos ["id"] = "formSaraData"; // No cambiar este nombre
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ["obligatorio"] = false;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		$atributos ["valor"] = $valorCodificado;
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ----------------FIN SECCION: Paso de variables -------------------------------------------------
		
		// ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
		
		// ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
		// Se debe declarar el mismo atributo de marco con que se inició el formulario.
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );
		
		return true;
	}
	function mensaje() {
		
		// Si existe algun tipo de error en el login aparece el siguiente mensaje
		$mensaje = $this->miConfigurador->getVariableConfiguracion ( 'mostrarMensaje' );
		$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', null );
		
		if ($mensaje) {
			
			$tipoMensaje = $this->miConfigurador->getVariableConfiguracion ( 'tipoMensaje' );
			
			if ($tipoMensaje == 'json') {
				
				$atributos ['mensaje'] = $mensaje;
				$atributos ['json'] = true;
			} else {
				$atributos ['mensaje'] = $this->lenguaje->getCadena ( $mensaje );
			}
			// -------------Control texto-----------------------
			$esteCampo = 'divMensaje';
			$atributos ['id'] = $esteCampo;
			$atributos ["tamanno"] = '';
			$atributos ["estilo"] = 'information';
			$atributos ["etiqueta"] = '';
			$atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
			echo $this->miFormulario->campoMensaje ( $atributos );
            unset ( $atributos );

             
        }

        return true;

    }

}

$miFormulario = new Formulario ( $this->lenguaje, $this->miFormulario );


$miFormulario->formulario ();
$miFormulario->mensaje ();

?>