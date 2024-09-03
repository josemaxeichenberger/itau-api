<?php

@session_start();
require_once 'Config.php';

class ConexaoMysql {

  protected $pdo;
 public function __construct() {
      
    try {
      $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $_SESSION['conect'] =  "Exito";      
    } catch (PDOException $e) {
       $_SESSION['conect'] =  "Falha";
     
      
    }
  }
  
  


}

?>