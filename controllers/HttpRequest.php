<?php
namespace controllers;
/*
 *  simple HttpRequest example using PHP
 *  tom slankard
 */
class HttpRequest {
  public $url = null;
  public $method = 'GET';
  public $body = null;
  public $headers = Array();
  public $allow_redirect = true;
  private $url_info = null;
  private $host_name = null; 
  private $host_ip = null;
  private $response_body = null;
  private $response_headers = Array();
  private $response_code = null;
  private $response_message = null;
  private $port = null;
  private $verbose = true;

  public function __construct($url, $method = 'GET', $user = null, $pass = null) {
    $this->url = $url;
    $this->method = $method;
    //  parse url
    $this->url_info = parse_url($url);

    $this->host_name = $this->url_info['host'];
    $this->host_ip = gethostbyname($this->host_name);

    //  get port number given the scheme
    if(!isset($this->url_info['port'])) {
      if($this->url_info['scheme'] == "http")
        $this->port = 80;
      else if($this->url_info['scheme'] == "https")
        $this->port = 443;
    } else {
      $this->port = $this->url_info['port'];
    }

    //  add default headers
    $this->headers["Host"] = "$this->host_name";
    // $this->headers["Connection"] = "close";

    // Set Authorization if user is not null
    if(!is_null($user))
    {
      $encode = base64_encode($user.':'.$pass);
      $this->headers["Authorization"] = "Basic $encode";
    }

  }

  private function constructRequest() {
    $path = "/";
    if(isset($this->url_info['path']))
    {
      $path = $this->url_info['path'];

      /* Se agrega nueva funcionalidad para pasar querys a la url */
      if(isset($this->url_info['query']))
      {
        $path .= "?".$this->url_info['query'];
      }
    }

    $req = "$this->method $path HTTP/1.1\r\n";

    foreach($this->headers as $header => $value) {
      $req .= "$header: $value\r\n";
    }

    return "$req\r\n";
  }

  ///  reads a line from a file
  function readLine($fp)
  {
    $line = "";
    while (!feof($fp)) {
      // $line .= fgets($fp, 2048);
      $line .= fgets($fp, 128);
      // $line .= fgets($fp);
      if (substr($line, -1) == "\n") {
        return trim($line, "\r\n");
      }
    }
    return $line;
  }


  public function send() {
    $fp = fsockopen($this->host_ip, $this->port, $errno, $errstr, 30);

    if (!$fp) {
      echo "$errstr ($errno)<br />\n";
    } else {
        

    //  construct request
    $request = $this->constructRequest();

    //  write request to socket
    // fwrite($fp, $request);
    fputs($fp, $request);

    if(!empty($this->body))
    {
      fputs($fp, $this->body);
    }


    //  read the status line
    $line = $this->readline($fp);
    $status = explode(" ", $line);

    //  make sure the HTTP version is valid
    if(!isset($status[0]) || !preg_match("/^HTTP\/\d+\.?\d*/", $status[0]))
      die("Couldn't get HTTP version from response.");
    //  get the response code
    if(!isset($status[1]))
      die("Couldn't get HTTP response code from response.");
    else $this->response_code = $status[1];
    
    //  get the reason, e.g. "not found"
    if(!isset($status[2]))
      die("Couldn't get HTTP response reason from response.");
    else $this->response_reason = $status[2];


    //  read the headers
    do {
      $line = $this->readLine($fp);
      if($line != "") { 
        $header = explode(":", $line);
        $this->response_headers[$header[0]] = ltrim($header[1]);
      }
    } while(!feof($fp) && $line != "");
    //  read the body

    $this->response_body = "\n";
    do {
      $line = $this->readLine($fp); {
        /*
        @TODO: Comprender y corregir por qué dentro del body de vuelve una cadena de 717d antes del comienzo del json
        */
        if($line && strlen($line) != 4)
          $this->response_body .= "$line\n";
      }
    } while(!feof($fp));
    //  close the connection
    fclose($fp);
    return TRUE;
    }
  }

  public function setBody($body) {
    $this->body = $body;
  }

  public function getResponseStatus() {
    return $this->response_code;
  }
  public function getHeaders() {
    return $this->response_headers;
  }
  public function getResponseBody() {
    return $this->response_body;
  }
}

?>