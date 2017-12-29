<?php
namespace lib\Template;

class TemplateController {
	public $html = "";
	public $template;

	public function __construct($template){
		$this->template = $template;
	}

	public function iniciarHTML(){
		ob_start();
	}

	public function cerrarHTML(){
		$this->html = ob_end_flush();
	}
	
	public function render($html){
		$this->template->render(
			array(
				'variable'=>"Hello world!",
				)
			);
	}

}
?>