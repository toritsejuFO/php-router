<?php
include_once 'IRequest.php';

// Allows access to all $_SERVER properties and $_POST data(for post requests)
class Request Implements IRequest {
  function __construct () {
    $this->bootstrapSelf();
  }
  
  private function bootstrapSelf() {
    foreach ($_SERVER as $key => $value) {
      $this->{$this->toCamelCase($key)} = $value;
    }
  }
  
  private function toCamelCase ($string) {
    $result = strtolower($string);
    preg_match_all('/_[a-z]/', $result, $matches);
    
    foreach ($matches[0] as $match) {
      $c = str_replace('_', '', strtoupper($match));
      $result = str_replace($match, $c, $result);
    }
    
    return $result;
  }
  
  public function getBody() {
    if ($this->requestMethod === 'GET') return;
    
    if ($this->requestMethod === 'POST') {
      $body = new Body();
      
      foreach($_POST as $key => $value) {
        $body->{$key} = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        $body;
      }
      
      return $body;
    }
  }
  
}

class Body {}
