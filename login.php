<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require "autoload.php";

$templateCtrl = new Main();

$templateCtrl->iniciarHTML();
/* COMIENZA EL HTML INTERNO */
?>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<div class="tit_section">
  Login
</div>
<h4>Bienvenidos al sistema UMapuche.<br>
Por favor, para ingresar al sistema ingrese los siguientes datos.</h4>
<br>
<?php 
if(isset($_POST['btnSubmit']))
{
	include "checkLogIn.php";
}
?>
<br>
<div class="col-md-3">
</div>
<div class="col-md-6">
  <div class="card">
    <div class="card-block">
      <form action="?" method="post" onsubmit="return checkForm(this)">
        <div class="md-form">
            <i class="fa fa-user prefix"></i>
            <input type="text" id="user" name="user" data-name="Cuenta" data-nameIngles="Account" class="form-control">
            <label for="cuenta">Usuario</label>
        </div>

        <div class="md-form">
            <i class="fa fa-lock prefix"></i>
            <input type="password" id="pass" name="pass" data-name="Contraseña" data-nameIngles="Password" class="form-control">
            <label for="pass">Contraseña</label>
        </div>




      	<div id="html_element"></div>
        <div class="clear15"></div>
      	<input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary waves-effect waves-light"><br>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">

  var onloadCallback = function() {
    grecaptcha.render('html_element', {
      'sitekey' : '6LdalTUUAAAAAC7jdFPGOMMZiwvibYN2dFsuW6QV'
    });
  };


function checkForm(form)
{
  responseReCaptcha = grecaptcha.getResponse();
  // Si la respuesta es vacía entonces no pasó la prueba del reCaptcha
  if(!responseReCaptcha || 0 === responseReCaptcha.length)
  {
      msgToast ('Por favor, validar el captcha para continuar.','', false);
      return false;
  }else
  {
      return true;
  }
}
</script>
<?php
$templateCtrl->cerrarHTML();

$html = $templateCtrl->contenidoHTML;
$templateCtrl->render($html);
?>
