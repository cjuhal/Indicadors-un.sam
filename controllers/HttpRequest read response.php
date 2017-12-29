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