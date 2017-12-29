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
          <div class="right"><a class="btn btn-primary" href="index.php">Volver</a></div>
          <h1>Tablero de Control</h1>
          <div class="intro">
            <div class="padd4_12">
              <h2 class="h2">DETALLES</h2>
            </div>
          </div>

          <!-- Seccion con los 5 informes a traer en iframe -->
          <div class="row">
            <div class="col-sm-6">
              Contenido 1
              <!-- <div class="espacio" style="display: none">
                <iframe width="100%" scrolling="no" src="" frameborder="0"></iframe>
              </div> -->
            </div>
            <div class="col-sm-6">
              Contenido 2
              <!-- <div class="espacio" style="display: none">
                <iframe width="100%" scrolling="no" src="" frameborder="0"></iframe>
              </div> -->
            </div>
            <div class="col-sm-6">Contenido 3
              <!-- <div class="espacio" style="display: none">
                <iframe width="100%" scrolling="no" src="" frameborder="0"></iframe>
              </div> -->
            </div>
            <div class="col-sm-6">
              Contenido 4
              <!-- <div class="espacio" style="display: none">
                <iframe width="100%" scrolling="no" src="" frameborder="0"></iframe>
              </div> -->
            </div>
            <div class="col-sm-6 col-sm-offset-3">
              Contenido 5
              <!-- <div class="espacio" style="display: none">
                <iframe width="100%" scrolling="no" src="" frameborder="0"></iframe>
              </div> -->
            </div>
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
