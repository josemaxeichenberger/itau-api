<?php 
require_once 'ConexaoMysql.php';
class efetivadas_parcelas extends ConexaoMysql {
    public $id;
    public $operacao;
    public $efetivada;
    public $parcela;
    public $vencimento;
    public $valor;
    public $taxas;
    public $juros;
    public function getId(){
        return $this->id;
    }
    public function getOperacao(){
        return $this->operacao;
    }
    public function getEfetivada(){
        return $this->efetivada;
    }
    public function getParcela(){
        return $this->parcela;
    }
    public function getVencimento(){
        return $this->vencimento;
    }
    public function getValor(){
        return $this->valor;
    }
    public function getTaxas(){
        return $this->taxas;
    }
    public function getJuros(){
        return $this->juros;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setOperacao($operacao){
        $this->operacao = $operacao;
    }
    public function setEfetivada($efetivada){
        $this->efetivada = $efetivada;
    }
    public function setParcela($parcela){
        $this->parcela = $parcela;
    }
    public function setVencimento($vencimento){
        $this->vencimento = $vencimento;
    }
    public function setValor($valor){
        $this->valor = $valor;
    }
    public function setTaxas($taxas){
        $this->taxas = $taxas;
    }
    public function setJuros($juros){
        $this->juros = $juros;
    }
    public function Insert() {
        $efetivadas_parcelas = $this->pdo->prepare("INSERT INTO efetivadas_parcelas (
            id,
            operacao,
            efetivada,
            parcela,
            vencimento,
            valor,
            taxas,
            juros,
        ) VALUES (
            :id,
            :operacao,
            :efetivada,
            :parcela,
            :vencimento,
            :valor,
            :taxas,
            :juros
        )");
        $efetivadas_parcelas->bindValue(':id' ,$this->getId());
        $efetivadas_parcelas->bindValue(':operacao' ,$this->getOperacao());
        $efetivadas_parcelas->bindValue(':efetivada' ,$this->getEfetivada());
        $efetivadas_parcelas->bindValue(':parcela' ,$this->getParcela());
        $efetivadas_parcelas->bindValue(':vencimento' ,$this->getVencimento());
        $efetivadas_parcelas->bindValue(':valor' ,$this->getValor());
        $efetivadas_parcelas->bindValue(':taxas' ,$this->getTaxas());
        $efetivadas_parcelas->bindValue(':juros' ,$this->getJuros());
        try {
            return $efetivadas_parcelas->execute();
        }
catch (Exception $retorno) {
    return $retorno->getMessage();
        
        }
    }
    public function Update() {
        $efetivadas_parcelas = $this->pdo->prepare("UPDATE efetivadas_parcelas SET
            operacao = :operacao,
            efetivada = :efetivada,
            parcela = :parcela,
            vencimento = :vencimento,
            valor = :valor,
            taxas = :taxas,
            juros = :juros
        WHERE  id = :id
        ");
        $efetivadas_parcelas->bindValue(':id' ,$this->getId());
        $efetivadas_parcelas->bindValue(':operacao' ,$this->getOperacao());
        $efetivadas_parcelas->bindValue(':efetivada' ,$this->getEfetivada());
        $efetivadas_parcelas->bindValue(':parcela' ,$this->getParcela());
        $efetivadas_parcelas->bindValue(':vencimento' ,$this->getVencimento());
        $efetivadas_parcelas->bindValue(':valor' ,$this->getValor());
        $efetivadas_parcelas->bindValue(':taxas' ,$this->getTaxas());
        $efetivadas_parcelas->bindValue(':juros' ,$this->getJuros());
        try {
            return $efetivadas_parcelas->execute();
        }
catch (Exception $retorno) {
    return $retorno->getMessage();
        
        }
    }
    public function Delete() {
        $efetivadas_parcelas = $this->pdo->prepare("DELETE FROM efetivadas_parcelas
            WHERE  id = :id
        ");
        $efetivadas_parcelas->bindValue(':id' ,$this->getId());
        try {
            return $efetivadas_parcelas->execute();
        }
catch (Exception $retorno) {
    return $retorno->getMessage();
        
        }
    }
    public function Select() {
        $efetivadas_parcelas = $this->pdo->prepare("SELECT * FROM efetivadas_parcelas
            WHERE  id = :id
        ");
        $efetivadas_parcelas->bindValue(':id' ,$this->getId());
        try {
            $efetivadas_parcelas->execute();
            return $efetivadas_parcelas->fetchAll();
        }
catch (Exception $retorno) {
    return $retorno->getMessage();
        
        }
    }
}
