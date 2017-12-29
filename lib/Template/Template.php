<?php
namespace lib\Template;

use Exception;
/**
 * Sistema de Templates que enlaza PHP con las plantillas (MVC)
 *
 * Clase encargada de tomar los datos enviados desde
 * PHP en forma de array y distribuirlos sobre un archivo- Template
 * El sistema captura dentro del template las palabras entre {}
 * y las reemplaza por el valor con la llave respectiva de un array asociativo
 *
 * @category MVC
 * @subpackage Library Classes
 * @copyright Copyright (c) 2010, Hidek1 [rhyudek1@gmail.com]
 * @license http://creativecommons.org/licenses/by-sa/2.0/cl/
 * Atribución-Licenciar Igual 2.0 Chile.
 * @since 0.1a
 */
class Template
{
    private $_filename;

    public $plantillaPadre;

    private $_extends;

    public $variables = array();

    /**
     * Obtiene la ruta al template
     * este debe tener permisos de lectura
     * retorna una Exception en caso de que 
     * el archivo especificado no se encuentre.
     *
     * @param string $filename
     */
    public function __construct($filename, $pathDirTemplates)
    {
        $this->dirTemplateParent = $pathDirTemplates;

        if (file_exists($this->dirTemplateParent.$filename)) {
            $this->_filename = $filename;
        } else {
            throw new Exception("Template no encontrado.");
        }
        

    }
    

    /**
     * Devuelve el template procesado con sus variables correspondientes
     * captura dentro de este las palabras entre {} y las modifica por su 
     * valor correspondiente en el array
     * 
     * $valores = array('foo' => 'bar');
     * La palabra de prueba {{foo}}
     * 
     * @param array $matriz
     * @param bool $print //OBSOLETO
     * @return string
     */
    public function render(array $matriz = array())
    {
        $this->_extends = $this->obtenerUrlExtends($this->_filename);

        $data = $this->reemplazoBlocks();
        $html = $this->recorrerPHP($data);
        $this->recorrerHTML($matriz, $html);
    }

    /**
     * Si no tiene plantilla padre, cargar el html de él mismo 
     * Si tiene plantilla padre abre la plantilla hijo
     * Obtiene los blocks del hijo
     * Sustituye los blocks del padre con los del hijo
     *
     * @return string
     */
    public function recorrerHTML($matriz, $html){
        // Definir variables globales de los colores
        $this->colores_UA();
        global $color_UA, $color_UA_Hex, $color_UA_a;

        // Si tiene variables pasadas por $matriz
        if (!empty($matriz)) {
           // Convertir todas las keys de la matriz en variables con sus nombres: $matriz['titulo'] --> $titulo = $value;
            foreach ($matriz as $key => $value) {
                $$key = $value;
                $this->variables[$key] = $value;
            }
        }
        
        //Recorrer linea por linea
        $lines =  explode('\n',$html);
        $lines =  explode(PHP_EOL,$html);
        foreach($lines as $line) {

            if (preg_match("/(\{[^\}]+\}\})/i", $line, $areaComandoLlaves) > 0){
                
                // es una variable para sustituir
                if(count(preg_grep("/{{([a-z]\w+?)}}/", explode("\n", $line))) > 0){

                    $line = preg_replace('/{{([a-z]\w+?)}}/', "'.$$1.'", $line);
                    eval("\$line = '$line';");
                    echo $line;

                }else{
                    $command = new Command($areaComandoLlaves, $line, $this->variables, $this->dirTemplateParent);
                }

            }else{
                echo $line.'
                ';
            }
        }
        
    }

    /**
     * Ejecuta todo c'ogido php y devuelve un html con tags {{}} 
     *
     * @return string
     */
    public function recorrerPHP($php){
        // Definir variables globales de los colores
        $this->colores_UA();
        global $color_UA, $color_UA_Hex, $color_UA_a;
        
        $html = "";
        ob_start();
            eval(" ?>".$php."<?php ");
        $html .= ob_get_clean();
        return $html;
        
    }


    /**
     * Si no tiene plantilla padre, cargar el html de él mismo 
     * Si tiene plantilla padre abre la plantilla hijo
     * Obtiene los blocks del hijo
     * Sustituye los blocks del padre con los del hijo
     *
     * @return string
     */
    public function reemplazoBlocks(){
        try{
            if (empty($this->_extends)){
                $data = $this->abrirPlantilla($this->_filename);
            }else{
                $html = $this->abrirPlantilla($this->_filename);
                $blocksHijo = $this->buscarBlocks($html);

                $data = $this->convertirBlocks($blocksHijo);
            }
            return $data;
        }catch(Exception $e){
            $templateExc = new TemplateException($e);
            echo $templateExc;
        }
        
    }

    /**
     * 
     */
    public function obtenerUrlExtends($filename){
        $html = $this->abrirPlantilla($filename);
        if (preg_match("/{% extends (.*?) %}/i", $html, $salida)){
            $url = $salida[1];
            $url = str_replace("'", "", $url);
            $url = str_replace('"', "", $url);
            return $url;
        }
        // $url = $this->obtenerUrlExtends($html);
    }

    /**
     * Busca bloques de la plantilla y devuelve su string nuevo.
     * 
     * $valores = array('foo' => 'bar');
     * La palabra de prueba {{foo}}
     * 
     * @param array $matriz
     * @param bool $print //OBSOLETO
     * @return string
     */
    public function buscarBlocks($html){
        preg_match_all("/{% block (\w+) %}((.|\n)*?){% endblock %}/i", $html, $matcheos, PREG_OFFSET_CAPTURE);

        $salida = array();

        $bloqueCompleto = $matcheos[0];
        $nombres = $matcheos[1];
        $htmls = $matcheos[2];

        // Devolver un array con solo lo que necesito: [1] y [2].
        for ($i=0; $i < count($matcheos[0]); $i++) {             
            $nombre = $nombres[$i][0];
            $elem = array('block'=>$bloqueCompleto[$i][0],'contenido'=>$htmls[$i][0], 'startPos'=>$bloqueCompleto[$i][1]);

            $salida[$nombre] = $elem;
        }
        
        return $salida;
    }


    /**
     * Reemplaza por los bloques de la plantilla hijo.
     * 
     * $valores = array('foo' => 'bar');
     * La palabra de prueba {{foo}}
     * 
     * @param array $matriz
     * @param bool $print //OBSOLETO
     * @return string
     */
    public function convertirBlocks($blocksHijo){
        $this->plantillaPadre = $this->abrirPlantilla($this->_extends);
        $blocksPadre = $this->buscarBlocks($this->plantillaPadre);

        try{
            $subject = $this->plantillaPadre;
            foreach ($blocksPadre as $key => $value) {

                if(array_key_exists($key, $blocksPadre)){
                    $blockPadre = $blocksPadre[$key]; //$blocksPadre['contenido']
                }else{
                    throw new Exception("El block de nombre: ". $key . " no existe en la plantilla padre.", 1);
                }

                if(array_key_exists($key, $blocksHijo)){
                    $blockHijo = $blocksHijo[$key]; //$blocksHijo['contenido']
                }else{
                    throw new Exception("El block de nombre: ". $key . " no existe en la plantilla hijo.", 1);
                }
                
                if( isset($blockPadre) && isset($blocksHijo) ){
                    $search = $blockPadre['block'];
                    $replace = $blockHijo['contenido'];
                }
    
                $subject = str_replace ( $search , $replace , $subject);
            }
            
            return $subject;
        }catch(Exception $e){
            $templateExc = new TemplateException($e);
            echo $templateExc;
        }
    }

    // EL TEMPLATE PADRE DEBE SABER DONDE COMIENZA SU BLOQUE Y CUAL ES.

    public function abrirPlantilla($filename){
        $filename = $this->dirTemplateParent.$filename;
        $template = file_get_contents($filename);

        $file = fopen($filename, 'r');
        $data = fread($file, filesize($filename));
        fclose($file);

        return $data;
    }



    /**
     */
    public function colores_UA() {
        // global $color_UA, $color_UA_HEX, $color_UA_a;
        $v_dir = $_SERVER['REQUEST_URI'];

        if (strpos($v_dir, "/escuelas/ciencia") !== false){
            $GLOBALS['color_UA'] = "color_cyt";
            $GLOBALS['color_UA_Hex'] = "#4F9F66";
            $GLOBALS['color_UA_a'] = "cyt";
        }
        elseif (strpos($v_dir, "/escuelas/politica") !== false){
            $GLOBALS['color_UA'] = "color_pyg";
            $GLOBALS['color_UA_Hex'] = "#9C2227";
            $GLOBALS['color_UA_a'] = "pyg";
        } 
        elseif (strpos($v_dir, "/escuelas/economia") !== false){
            $GLOBALS['color_UA'] = "color_eyn";
            $GLOBALS['color_UA_Hex'] = "#5A4A94";
            $GLOBALS['color_UA_a'] = "eyn";
        }
        elseif (strpos($v_dir, "/escuelas/humanidades") !== false){
            $GLOBALS['color_UA'] = "color_h";
            $GLOBALS['color_UA_Hex'] = "#E2AC0F";
            $GLOBALS['color_UA_a'] = "humanidades";
        }
        elseif (strpos($v_dir, "/institutos") !== false){
            $GLOBALS['color_UA'] = "color_inst";
            $GLOBALS['color_UA_Hex'] = "#3BA3AE";
            $GLOBALS['color_UA_a'] = "institutos";
        }
        elseif (strpos($v_dir, "/academica_arte") !== false){
            $GLOBALS['color_UA'] = "color_inst";
            $GLOBALS['color_UA_Hex'] = "#3BA3AE";
            $GLOBALS['color_UA_a'] = "institutos";
        }
        elseif (strpos($v_dir, "/arte_experimental") !== false){
            $GLOBALS['color_UA'] = "color_inst";
            $GLOBALS['color_UA_Hex'] = "#444";
            $GLOBALS['color_UA_a'] = "institutos";
        }
        else {
            $GLOBALS['color_UA'] = "color_oficial";
            $GLOBALS['color_UA_Hex'] = "#2C88CD";
            $GLOBALS['color_UA_a'] = "color_oficial";
        }

    }
}


namespace lib\Template;

/**
 * Clase encargada de tomar un string (url de una carpeta)
 * y hace el include de esa url
 *
 */
class Command
{   

    private $areaComandoLlaves;
    /**
    * Es una clase hijo de esta clase. un objeto
    */
    private $patron;
 
    private $listCommands = array('embed', 'include');

    public $dirTemplateParent;
    /**
     * Obtiene la ruta al template
     * este debe tener permisos de lectura
     * retorna una Exception en caso de que 
     * el archivo especificado no se encuentre.
     *
     * @param string $filename
     */
    public function __construct($areaComandoLlaves, $line, $variables, $dirTemplateParent)
    {
        if (is_null($areaComandoLlaves)){
            throw new Exception("El comando pasado no puede ser vacío", 1);
        }

        $this->variables = $variables;
        $this->areaComandoLlaves = $areaComandoLlaves;
        $this->dirTemplateParent = $dirTemplateParent;
        $this->comando = $this->setComando($line); // Command Pattern

    }


    public function setComando($line){
        try{
            if(preg_match("/{{\s*(\w+)\s+([\w\"\.\/\-\_\?]+)\s*}}/i", $this->areaComandoLlaves[1], $grupos) > 0){
                // Es una función con 1 parámetro
                $funcion = $grupos[1];
                $filename = $grupos[2];
                switch ($funcion) {
                    case 'embed':
                        $this->patron = new Function_Embed($filename, $this->variables);
                        echo $this->patron->render();
                        break;

                    case 'include':
                        $filename = str_replace('"', "", $filename);
                        $filename = str_replace("'", "", $filename);
                        $this->patron = new Function_Include($this->dirTemplateParent.$filename);
                        echo $this->patron->render();
                        break;
                    default:
                        # code...
                        $similares = array();
                        foreach ($this->listCommands as $key => $value) {
                            similar_text ( $funcion, $value, $percent );
                            
                            if($percent > 50){
                                array_push($similares, $value);
                            }
                            
                        }

                        if ( count($similares) > 0){
                            $valoresPosibles = join(", ", $similares);
                            throw new Exception("Error: La función <i>" . $funcion . "</i> no existe. Tal vez, quisiste poner <i>". $valoresPosibles ."</i>?", 1);
                        }else{
                            throw new Exception("Error: La función <i>" . $funcion . "</i> no existe.", 1);
                        }
                        break;
                }
            
            }
        }catch(Exception $e)
        {
            $templateExc = new TemplateException($e);
            echo $templateExc;
        }
    }


    /**
     * Devuelve el valor final que debe quedar en la línea.
     * @return string
     */
    public function render(){
        return $this->comando->render();
    }
}


namespace lib\Template;


class Command_Function{
    private $_filename;
    
    // private $root_path = 'C:/www/unsam2015/';
    /**
     * Obtiene la ruta al template
     * este debe tener permisos de lectura
     * retorna una Exception en caso de que 
     * el archivo especificado no se encuentre.
     *
     */
    public function __construct()
    {
       
    }


    public function chequeoRuta($filename){
        $util = new Util();
        $filename = $util->limpiarCadena($filename);
        $filename = $filename;
        if (file_exists($filename)) {
            return $filename;
        } else {            
            return false;
        }
    }


    /**
     * Hace el include de archivos php.
     */
    public function render(){
        return $this->_filename;
    }
}



namespace lib\Template;

/**
 * Clase encargada de tomar un string (url de una carpeta)
 * y hace el include de esa url
 *
 */
class Function_Embed extends Command_Function
{
    private $_filename;
    public $variable;

    public function __construct($filename, $variables)
    {
        if($url = $this->chequeoRuta($filename)){
            $this->_filename = $url;
        }elseif($url = $this->chequeoRuta($variables[$filename])){
            $this->_filename = $url;
        }else{
            throw new \Exception("<strong>Error intento de embed:</strong> El archivo no existe $variables[$filename]", 96);

        }
    }

    /**
     * Hace el include de archivos php.
     */
    public function render(){
        ob_start();
        include $this->_filename;
        $string = ob_get_clean();
        return $string;
    }
}


namespace lib\Template;


class Function_Include extends Command_Function
{
    private $_filename;
    
    public function __construct($filename)
    {
        $this->_filename = $this->chequeoRuta($filename);
    }

    /**
     * Hace el include de archivos php.
     */
    public function render(){
        ob_start();
        include $this->_filename;
        $string = ob_get_clean();
        return $string;
    }
}








namespace lib\Template;

class Util{
    public function limpiarCadena($str){
        try {
            //Quitar comillas dobles par que quede solo la cadena de la url
            $str = str_replace('"', '', $str);
            $str = str_replace("'", "", $str);
            $str = trim($str);

            return $str;
        } catch (Exception $e) {
            $templateExc = new TemplateException($e);
            echo $templateExc;       
        }
    }
}


namespace lib\Template;

/* EXCEPTION STYLIZED */
class TemplateException 
{
    // Redefinir la excepción, por lo que el mensaje no es opcional
    public function __construct(Exception $exception = null) {
        $this->exception = $exception;
    }

    // representación de cadena personalizada del objeto
    public function __toString() {
        $msgReturn = "Exception [{$this->exception->getCode()}]: {$this->exception->getMessage()}\n";
        return "<div style='color:red'>".$msgReturn."</div>";

    }

    public function funciónPersonalizada() {
        echo "Una función personalizada para este tipo de excepción\n";
    }
}


