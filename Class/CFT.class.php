<?php


require_once 'Config.php';
require_once 'ConexaoMysql.php';
class CFT extends ConexaoMysql {

  public $tabel;

  public function getTabel() {
    return $this->tabel;
  }

  public function setTabel($tabel) {
    $this->tabel = $tabel;
    return $this;
  }

  function Ler_Colunas() {
    $tabel = $this->getTabel();
    $ctf = $this->pdo->prepare("SHOW COLUMNS FROM " . $tabel);
    $ctf->execute();
    return $ctf->fetchAll();
  }

  function Ler_tabelas() {
    $ctf = $this->pdo->prepare("SHOW TABLES FROM  " . "barberwo_base");    
     $ctf->execute();
    return $ctf->fetchAll();
  }

}

