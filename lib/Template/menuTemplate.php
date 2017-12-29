<br>
<h1 style="margin-top: 10px;">Bienvenido</h1>
<?php
if(isset($_SESSION['usuario'])){
	$usuario = $_SESSION['usuario'];
?>
	<span><?php echo $usuario['nombre'];?></span>
	<p>
		<strong>Legajo:</strong> <?php echo $usuario['legajo'];?><br>
		<strong>DNI:</strong> <?php echo $usuario['dni'];?><br>
	</p>
	<hr>
	<ul>
	  <li><a href="index.php">Inicio</a></li>
	  <li><a href="verRecibos.php">Recibos</a></li>
	  <li><a href="cambiarPassword.php">Cambiar contraseña</a></li>
	  <li><a href="logout.php">Cerrar sesión</a></li>
	</ul>
<?php
}
else
{
?>
  <p>Inicia sesión para comenzar</p>
  <ul>
    <li><a href="login.php">Iniciar sesión</a></li>
  </ul>
<?php
}
?>