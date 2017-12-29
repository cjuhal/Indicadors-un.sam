<?php
session_start();
if(count($_SESSION['usuario']) > 0)
{
	$usuario = $_SESSION['usuario'];
}
else
{
	var_dump($_SESSION['usuario']);
	header("Location: login.php");
	
}
?>