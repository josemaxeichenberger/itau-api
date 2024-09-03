<?php 
require_once 'ConexaoMysql.php';
class efetivadas extends ConexaoMysql {
    public $id;
    public $operacao;
    public $data;
    public $valortaxas;
    public $valororiginal;
    public $valorfinal;
    public function getId(){
        return $this->id;
    }
    public function getOperacao(){
        return $this->operacao;
    }
    public function getData(){
        return $this->data;
    }
    public function getValortaxas(){
        return $this->valortaxas;
    }
    public function getValororiginal(){
        return $this->valororiginal;
    }
    public function getValorfinal(){
        return $this->valorfinal;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setOperacao($operacao){
        $this->operacao = $operacao;
    }
    public function setData($data){
        $this->data = $data;
    }
    public function setValortaxas($valortaxas){
        $this->valortaxas = $valortaxas;
    }
    public function setValororiginal($valororiginal){
        $this->valororiginal = $valororiginal;
    }
    public function setValorfinal($valorfinal){
        $this->valorfinal = $valorfinal;
    }
    public function Insert() {
        $efetivadas = $this->pdo->prepare("INSERT INTO efetivadas (
            id,
            operacao,
            data,
            valorTaxas,
            valorOriginal,
            valorFinal,
        ) VALUES (
            :id,
            :operacao,
            :data,
            :valortaxas,
            :valororiginal,
            :valorfinal
        )");
        $efetivadas->bindValue(':id' ,$this->getId());
        $efetivadas->bindValue(':operacao' ,$this->getOperacao());
        $efetivadas->bindValue(':data' ,$this->getData());
        $efetivadas->bindValue(':valortaxas' ,$this->getValortaxas());
        $efetivadas->bindValue(':valororiginal' ,$this->getValororiginal());
        $efetivadas->bindValue(':valorfinal' ,$this->getValorfinal());
        try {
            return $efetivadas->execute();
        }
catch (Exception $retorno) {
    return $retorno->getMessage();
        
        }
    }
    public function Update() {
        $efetivadas = $this->pdo->prepare("UPDATE efetivadas SET
            operacao = :operacao,
            data = :data,
            valorTaxas = :valortaxas,
            valorOriginal = :valororiginal,
            valorFinal = :valorfinal
        WHERE  id = :id
        ");
        $efetivadas->bindValue(':id' ,$this->getId());
        $efetivadas->bindValue(':operacao' ,$this->getOperacao());
        $efetivadas->bindValue(':data' ,$this->getData());
        $efetivadas->bindValue(':valortaxas' ,$this->getValortaxas());
        $efetivadas->bindValue(':valororiginal' ,$this->getValororiginal());
        $efetivadas->bindValue(':valorfinal' ,$this->getValorfinal());
        try {
            return $efetivadas->execute();
        }
catch (Exception $retorno) {
    return $retorno->getMessage();
        
        }
    }
    public function Delete() {
        $efetivadas = $this->pdo->prepare("DELETE FROM efetivadas
            WHERE  id = :id
        ");
        $efetivadas->bindValue(':id' ,$this->getId());
        try {
            return $efetivadas->execute();
        }
catch (Exception $retorno) {
    return $retorno->getMessage();
        
        }
    }
    public function Select() {
        $efetivadas = $this->pdo->prepare("SELECT * FROM efetivadas
            WHERE  id = :id
        ");
        $efetivadas->bindValue(':id' ,$this->getId());
        try {
            $efetivadas->execute();
            return $efetivadas->fetchAll();
        }
catch (Exception $retorno) {
    return $retorno->getMessage();
        
        }
    }
}
