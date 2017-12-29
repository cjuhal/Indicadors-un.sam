<?php
use \lib\Template\Template;
use \lib\Template\TemplateController;
// require_once("C:/www/unsam2015/Templates/TemplateController.php");
// require_once("C:/www/unsam2015/Templates/Template.php");

/*
variables privilegiadas que no se pueden usar.
$html
*/

class Main extends TemplateController {
	public $contenidoHTML = "";
	public $template;

	public function __construct(){
		$this->template = new Template('sistemas.twig', __DIR__.'/../lib/Template/');
	}

	public function iniciarHTML(){
		ob_start();
	}

	public function cerrarHTML(){
		$this->contenidoHTML = ob_get_contents();
		ob_end_clean();
	}

	public function render($html){
		global $nombre,$apellido, $uid, $tituloSistema;
		$this->template->render(
			array(
				// 'menuIzquierda'=>"menu_principal.php",
				'imagen_guarda'=>"css/indicadores/indicadores.jpg",
				'tituloSistema'=>$tituloSistema,
				'nombre'=>isset($nombre)?$nombre:"",
				'apellido'=>isset($apellido)?$apellido:"",
				'uid'=>isset($uid)?$uid:"",
				'contenidoHTML'=>$html,
				'menuTemplate' => __DIR__."/../lib/Template/menuTemplate.php"
				)
			);
	}

}
?>
