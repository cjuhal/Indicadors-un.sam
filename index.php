<?php

require "autoload.php";
/*
Habilitar el login en la página de inicio descomentando la siguiente línea.
Debe haber una variable $_SESSION['usuario'] no vacía con más de un ítem en la matriz.
*/
// require "bloqSeguro.php";

$templateCtrl = new Main();

$templateCtrl->iniciarHTML();
/* COMIENZA EL HTML INTERNO */
?>

  <link rel="stylesheet" type="text/css" href="css/indicadores/swiper.min.css" />
  <link rel="stylesheet" type="text/css" href="css/indicadores/categorias-slider.css" />
  <script src="js/indicadores/swiper.jquery.min.js"></script>
  <script src="js/indicadores/swiper.min.js"></script>

  <script>
    var es_ie = navigator.userAgent.indexOf('MSIE') > -1;

    function getInternetExplorerVersion() {
      var rv = -1;
      if (navigator.appName == 'Microsoft Internet Explorer') {
        var ua = navigator.userAgent;
        var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
          rv = parseFloat(RegExp.$1);
      } else if (navigator.appName == 'Netscape') {
        var ua = navigator.userAgent;
        var re = new RegExp("Trident/.*rv:([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
          rv = parseFloat(RegExp.$1);
      }
      return rv;
    }

    function mostrarIndicador(id, url) {
      //var elemento = document.getElementById(id+"_link"); es_ie
      var version = getInternetExplorerVersion();


      if ((navigator.appName == 'Microsoft Internet Explorer' || navigator.appName == 'Explorer') || (es_ie || version > -1)) {
        document.getElementById(id + "_link").target = "_blank";
        document.getElementById(id + "_link").href = url;

      } else {
        $("#indicadores").show();
        window.location.hash = '#' + id + '_link';
        document.getElementById(id + "_link").target = "frameIndicador";
        document.getElementById("frameIndicador").src = url;
      }
    }

  </script>

  <form id="main" runat="server">
    <div id="header" style="display: none"></div>
    <div id="bodyApp">
      <div id="container">
        <div id="myApp">
          <div class="right"><a class="btn btn-primary" href="tablero.php">Tablero de control</a></div>
          <h1>INDICADORES UNSAM </h1>
          <div class="intro">
            <div class="padd4_12">
              <h2 class="h2">Portal de Indicadores UNSAM</h2>
              <p>Bienvenido al Portal de Indicadores UNSAM. Este sistema sirve para ver información estadistica de diferentes secretarias.</p>
              <p>Acceda a las distintas áreas temáticas incluidas en la barra de navegación más abajo para conocer y acceder a los distintos tableros de información.</p>
            </div>
          </div>


          <div class="categorias-slider">
            <div class="sm-row">
              <div class="columns">
                <div class="slider-wrapper">
                  <div class="swiper-container swiper-container-horizontal" id="swiper" style="cursor: -webkit-grab;">
                    <div class="swiper-wrapper">

                      <div class="swiper-slide categoria swiper-slide-active" style="width: 170.667px;">
                        <a class="" onclick="javascript:getCategoria(this);" title="Académica" id="slider_1">
                                              <span class="ico">
                                                  <img style="max-height: 80px; max-width: 80px;" src="css/iconos/educacion.png"></span>
                                              <div class="" style="">Académica</div>
                                          </a>
                      </div>

                      <div class="swiper-slide categoria swiper-slide-next" style="width: 170.667px;">
                        <a class="" onclick="javascript:getCategoria(this);" title="Personal" id="slider_2">
                                              <span class="ico">
                                                  <img style="max-height: 80px; max-width: 80px;" src="css/iconos/expedientes.png"></span>
                                              <div class="" style="">Personal</div>
                                          </a>
                      </div>

                      <div class="swiper-slide categoria" style="width: 170.667px;">
                        <a class="" onclick="javascript:getCategoria(this);" title="Presupuesto" id="slider_3">
                                              <span class="ico">
                                                  <img style="max-height: 80px; max-width: 80px;" src="css/iconos/presupuesto.png" ></span>
                                              <div class="" style="">Presupuesto</div>
                                          </a>
                      </div>

                    </div>
                  </div>

                  <a class="arrow-left" id="swiperLeft"></a>
                  <a class="arrow-right" id="swiperRight"></a>

                </div>
              </div>
            </div>
          </div>

          <div class="barraGuiaSlider" id="barraSlider" style="display:none;"></div>
          <div class="intro" id="espacio" style="height:200px;"></div>


          <div class="panel primary-color" id="categoria" style="display:none;">
              <div class="panel-body white-text bold" id="categoria_menu">CATEGORÍAS <i class="fa fa-angle-down" aria-hidden="true"></i></div>
              <div class="card-body">
          </div>
        </div>

          <div class="panel">
            <div class="list-group" style="display:none;" id="categoria1">
                <a class="list-group-item list-group-item-action" id="cat1op1_link" onclick="mostrarIndicador('cat1op1', 'http://10.1.75.138/pentaho/api/repos/%3Ahome%3ASIU-Wichi%3APortal%20Gerencial%3A3%20-%20Academica%20-%20Araucano%3A3.2%20-%20Alumnos%3A3.2.3%20-%20De%20Grado%20y%20Pregrado%20segun%20rango%20edad.wcdf/generatedContent?customParamu=serid=pvillanueva&password=pvilla');">Alumnos de Grado y Pregrado según rango edad</a>
                <a class="list-group-item list-group-item-action" id="cat1op2_link" onclick="mostrarIndicador('cat1op2', 'http://10.1.75.138/pentaho/api/repos/%3Ahome%3ASIU-Wichi%3APortal%20Gerencial%3A3%20-%20Academica%20-%20Araucano%3A3.6%20-%20Evolucion%3A3.6.4%20-%20Egresados.wcdf/generatedContent?customParamu=serid=pvillanueva&password=pvilla');">Egresados – Evolución</a>
                <a class="list-group-item list-group-item-action" id="cat1op3_link" onclick="mostrarIndicador('cat1op3', 'http://10.1.75.138/pentaho/api/repos/%3Ahome%3ASIU-Wichi%3APortal%20Gerencial%3A4%20-%20Academica%20-%20Guarani%202%3AReinscriptos%20por%20UA%2C%20carrera%20y%20cohorte.wcdf/generatedContent?customParamu=serid=pvillanueva&password=pvilla');">Reinscriptos por UA, carrera y cohorte</a>
                <a class="list-group-item list-group-item-action" id="cat1op4_link" onclick="mostrarIndicador('cat1op4', 'http://10.1.75.138/pentaho/api/repos/%3Ahome%3ASIU-Wichi%3APortal%20Gerencial%3A4%20-%20Academica%20-%20Guarani%202%3AIngresantes%20por%20carrera%20-%20ultimos%205%20anios.wcdf/generatedContent?customParamu=serid=pvillanueva&password=pvilla');">Ingresantes por carrera - últimos 5 años</a>
            </div>

              <div class="list-group" style="display:none;"  id="categoria2">
                <a class="list-group-item list-group-item-action" id="cat2op1_link" onclick="mostrarIndicador('cat2op1', 'http://10.1.75.138/pentaho/api/repos/%3Ahome%3ASIU-Wichi%3APortal%20Gerencial%3A2%20-%20Personal%3A2.2%20-%20Evolucion%3A2.2.3%20-%20Evolucion%20Mensual%20del%20Pagado%20por%20Escalafon.wcdf/generatedContent?customParamu=serid=pvillanueva&password=pvilla');"> Evolución Mensual del Pagado por Escalafón</a>
                <a class="list-group-item list-group-item-action" id="cat2op2_link" onclick="mostrarIndicador('cat2op2', 'http://10.1.75.138/pentaho/api/repos/%3Ahome%3ASIU-Wichi%3APortal%20Gerencial%3A2%20-%20Personal%3A2.1%20-%20Informacion%20sobre%20Personal%3A2.1.1%20-%20Expresada%20en%20Pesos%3A2.1.1.2%20-%20Planta%20de%20Personal%20en%20Pesos.wcdf/generatedContent?customParamu=serid=pvillanueva&password=pvilla');"> Planta de personal en pesos</a>
                <a class="list-group-item list-group-item-action" id="cat2op3_link" onclick="mostrarIndicador('cat2op3', 'http://10.1.75.138/pentaho/api/repos/%3Ahome%3ASIU-Wichi%3APortal%20Gerencial%3A2%20-%20Personal%3A2.2%20-%20Evolucion%3A2.2.1%20-%20Evolucion%20de%20Planta%20de%20Personal%20por%20Escalafon%20en%20Cargos.wcdf/generatedContent?customParamu=serid=pvillanueva&password=pvilla');"> Evolución de Planta de Personal por Escalafón en Cargos</a>
              </div>

              <div class="list-group" style="display:none;"  id="categoria3">
                <a class="list-group-item list-group-item-action" id="cat3op1_link" onclick="mostrarIndicador('cat3op1', 'http://10.1.75.138/pentaho/api/repos/%3Ahome%3ASIU-Wichi%3APortal%20Gerencial%3A1%20-%20Presupuestaria%3A1.1%20-%20Ingreso%20de%20Recursos%3A1.1.2%20-%20Por%20Concepto%20y%20Fuente.wcdf/generatedContent?customParamu=serid=pvillanueva&password=pvilla');">Ingresos por concepto y fuente</a>
                <a class="list-group-item list-group-item-action" id="cat3op2_link" onclick="mostrarIndicador('cat3op2', 'http://10.1.75.138/pentaho/api/repos/%3Ahome%3ASIU-Wichi%3APortal%20Gerencial%3A1%20-%20Presupuestaria%3A1.3%20-%20Ejecucion%20Presupuestaria%3A1.3.7%20-%20Totales%20por%20Inciso%20y%20Fuente%3A1.3.7.1%20-%20Ejecucion%20por%20Inciso.wcdf/generatedContent?customParamu=serid=pvillanueva&password=pvilla');">Ejecución por inciso</a>
                <a class="list-group-item list-group-item-action" id="cat3op3_link" onclick="mostrarIndicador('cat3op3', 'http://10.1.75.138/pentaho/api/repos/%3Ahome%3ASIU-Wichi%3APortal%20Gerencial%3A1%20-%20Presupuestaria%3A1.3%20-%20Ejecucion%20Presupuestaria%3A1.3.8%20-%20Evolucion%20Anual%20por%20Fuente%3A1.3.8.4%20-%20Pagado.wcdf/generatedContent?customParamu=serid=pvillanueva&password=pvilla');">Evolución pagado por fuente</a>
                <a class="list-group-item list-group-item-action" id="cat3op4_link" onclick="mostrarIndicador('cat3op4', 'http://10.1.75.138/pentaho/api/repos/%3Ahome%3ASIU-Wichi%3APortal%20Gerencial%3A1%20-%20Presupuestaria%3A1.2%20-%20Credito%20Presupuestario%3A1.2.2%20-%20Saldos%20Presupuestarios%20y%20Disponibles.wcdf/generatedContent?customParamu=serid=pvillanueva&password=pvilla');">Saldos Presupuestarios y Disponibles</a>
                <a class="list-group-item list-group-item-action" id="cat3op5_link" onclick="mostrarIndicador('cat3op5', 'http://10.1.75.138/pentaho/api/repos/%3Ahome%3ASIU-Wichi%3APortal%20Gerencial%3A1%20-%20Presupuestaria%3A1.2%20-%20Credito%20Presupuestario%3A1.2.3%20-%20Total%20Credito%20Presupuestario%20por%20Unidad%20Presupuestaria.wcdf/generatedContent?customParamu=serid=pvillanueva&password=pvilla');">Total Crédito Presupuestario por Unidad Presupuestaria</a>
              </div>

          </div>

        </div>
    </div>


          <div id="indicadores" class="espacio" style="display: none">
            <iframe name="frameIndicador" id="frameIndicador" width="100%" style="min-height:1800px; max-heigh:2800px;" scrolling="yes" frameborder="0"></iframe>
          </div>

        </div>
      </div>
    </div>
    <div id="footer" style="display: none"></div>
  </form>

  <script>
    //GENERO EL SLIDER
    mySwiper = new Swiper('.swiper-container', {
      slidesPerView: 3,
      spaceBetween: 50,
      //slidesPerGroup: 3,
      loop: false,
      loopFillGroupWithBlank: false,
      breakpoints: {
        1024: {
          slidesPerView: 3,
          spaceBetween: 30,
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 40,
        },
        528: {
          slidesPerView: 3,
          spaceBetween: 50,
        }
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.arrow-right',
        prevEl: '.arrow-left',
      },
    });

    function getIndex(tag) {
      var _id = tag.id;
      var pos = _id.indexOf("_");
      var index = _id.substring(pos + 1);
      return index;
    }

    function getCategoria(tag) {

      var index = getIndex(tag);

      index_categoria = index;

      $('#espacio').hide();
      $('#categoria').hide();
      $('.tramitesBackground').hide();
      $('#indicadores').hide();

      for (var i = 1; i < 13; i++) {
        $('#categoria' + i).hide();
        $('#slider_' + i).removeClass('sliderSelected');
      }
      $('#slider_' + index).addClass('sliderSelected');
      $('#barraSlider').show();
      $('#categoria').show();
      $('#categoria' + index).toggle();
    }

    function getOptions(tag) {
      var index = getIndex(tag);
      $('#categoria' + index).toggle();
      $('#categoria').show();
    }

    // BOTONES DE SLIDER
    $('.arrow-right').click(function() {
      mySwiper.slideNext();
    });
    $('.arrow-left').click(function() {
      mySwiper.slidePrev();
    });

    //MUESTA U OCULTA LISTA DE CATEGORIAS Y OCULTA BOTONES DE SUB CAT
    $('#categoria_menu').click(function() {
      $('#categoria' + index_categoria).toggle();
      $('.tramitesBackground').hide();
      $('#indicadores').hide();
    });


    function mostrarCategoria(cat, box, hash) {
      $("#indicadores").hide();
      $("#categoria1").hide();
      $("#categoria2").hide();
      $("#categoria3").hide();
      $("#" + cat).show();
      window.location.hash = '#' + hash;
      $('#cat1').removeClass('activar');
      $('#cat2').removeClass('activar');
      $('#cat3').removeClass('activar');
      $('#' + box).addClass('activar');
    }

  </script>


<?php
$templateCtrl->cerrarHTML();

$html = $templateCtrl->contenidoHTML;
$templateCtrl->render($html);
?>
