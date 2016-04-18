<?php
namespace gui\menuPrincipal\formulario;
$esteBloque = $this -> miConfigurador -> getVariableConfiguracion("esteBloque");
$rutaUrlBloque = $this -> miConfigurador -> getVariableConfiguracion("rutaUrlBloque");

$rutaBloque = $this -> miConfigurador -> getVariableConfiguracion("host");
$rutaBloque .= $this -> miConfigurador -> getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque['grupo'] . '/' . $esteBloque['nombre'];
?>

<<nav class="navbar" role="navigation">
    <div id="imagenfondo" class="navbar"></div>
    <!--navbar-fixed-top-->
    <div class="container">
      <!-- Image Background Page Header -->
      <!-- Note: The background image is set within the business-casual.css file. -->
      <header class="business-header">
        <div class="container">
          <div class="row">
            <div class="col-sm-2">
              <img src="<?php echo $rutaUrlBloque.'images/escudo.png'?>" alt="Perfil" class="hidden-xs hidden-sm img-responsive img-rounded escudo" />
            </div>
            <div class="col-xs-12 col-sm-10 col-lg-8">
              <h1 class="nameline">JORGE ULISES USECHE CUELLAR</h1>
              <h1 class="titleline">Msc. Teleinformática</h1>
              <h1 class="closesession"><a href="#">Cerrar Sesión</a></h1>
            </div>
            <div class="col-lg-2">
              <img src="<?php echo $rutaUrlBloque.'images/profile.png'?>" alt="Perfil" class="hidden-xs hidden-sm hidden-md img-responsive img-rounded profilepicture" />
            </div>
          </div>
        </div>
      </header>
      <!--http://jsfiddle.net/apougher/ydcMQ/-->
      <div class="navbar navbar-default navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Inicio</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <!--<li><a href="#">Otro Enlace</a></li>-->
              <li class="dropdown menu-large">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categories <b class="caret"></b></a>
                <ul class="dropdown-menu megamenu row">
                  <li class="col-sm-3">
                    <ul>
                      <li class="dropdown-header">Glyphicons</li>
                      <li><a href="#">Available glyphs</a></li>
                      <li class="disabled"><a href="#">How to use</a></li>
                      <li><a href="#">Examples</a></li>
                      <li class="divider"></li>
                      <li class="dropdown-header">Dropdowns</li>
                      <li><a href="#">Example</a></li>
                      <li><a href="#">Aligninment options</a></li>
                      <li><a href="#">Headers</a></li>
                      <li><a href="#">Disabled menu items</a></li>
                    </ul>
                  </li>
                  <li class="col-sm-3">
                    <ul>
                      <li class="dropdown-header">Button groups</li>
                      <li><a href="#">Basic example</a></li>
                      <li><a href="#">Button toolbar</a></li>
                      <li><a href="#">Sizing</a></li>
                      <li><a href="#">Nesting</a></li>
                      <li><a href="#">Vertical variation</a></li>
                      <li class="divider"></li>
                      <li class="dropdown-header">Button dropdowns</li>
                      <li><a href="#">Single button dropdowns</a></li>
                    </ul>
                  </li>
                  <li class="col-sm-3">
                    <ul>
                      <li class="dropdown-header">Input groups</li>
                      <li><a href="#">Basic example</a></li>
                      <li><a href="#">Sizing</a></li>
                      <li><a href="#">Checkboxes and radio addons</a></li>
                      <li class="divider"></li>
                      <li class="dropdown-header">Navs</li>
                      <li><a href="#">Tabs</a></li>
                      <li><a href="#">Pills</a></li>
                      <li><a href="#">Justified</a></li>
                    </ul>
                  </li>
                  <li class="col-sm-3">
                    <ul>
                      <li class="dropdown-header">Navbar</li>
                      <li><a href="#">Default navbar</a></li>
                      <li><a href="#">Buttons</a></li>
                      <li><a href="#">Text</a></li>
                      <li><a href="#">Non-nav links</a></li>
                      <li><a href="#">Component alignment</a></li>
                      <li><a href="#">Fixed to top</a></li>
                      <li><a href="#">Fixed to bottom</a></li>
                      <li><a href="#">Static top</a></li>
                      <li><a href="#">Inverted navbar</a></li>
                    </ul>
                  </li>
                </ul>

              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container -->
  </nav>