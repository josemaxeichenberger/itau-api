<?php
require_once 'ConexaoMysql.php';
class taxas extends ConexaoMysql
{
    public $id;
    public $titulo;
    public $valor;
    public $cobranca;
    public function getId()
    {
        return $this->id;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function getValor()
    {
        return $this->valor;
    }
    public function getCobranca()
    {
        return $this->cobranca;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }
    public function setValor($valor)
    {
        $this->valor = $valor;
    }
    public function setCobranca($cobranca)
    {
        $this->cobranca = $cobranca;
    }
    public function Insert()
    {
        $taxas = $this->pdo->prepare("INSERT INTO taxas (
            id,
            titulo,
            valor,
            cobranca,
        ) VALUES (
            :id,
            :titulo,
            :valor,
            :cobranca
        )");
        $taxas->bindValue(':id', $this->getId());
        $taxas->bindValue(':titulo', $this->getTitulo());
        $taxas->bindValue(':valor', $this->getValor());
        $taxas->bindValue(':cobranca', $this->getCobranca());
        try {
            return $taxas->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Update()
    {
        $taxas = $this->pdo->prepare("UPDATE taxas SET
            titulo = :titulo,
            valor = :valor,
            cobranca = :cobranca
        WHERE  id = :id
        ");
        $taxas->bindValue(':id', $this->getId());
        $taxas->bindValue(':titulo', $this->getTitulo());
        $taxas->bindValue(':valor', $this->getValor());
        $taxas->bindValue(':cobranca', $this->getCobranca());
        try {
            return $taxas->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Delete()
    {
        $taxas = $this->pdo->prepare("DELETE FROM taxas
            WHERE  id = :id
        ");
        $taxas->bindValue(':id', $this->getId());
        try {
            return $taxas->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Select()
    {
        $taxas = $this->pdo->prepare("SELECT * FROM taxas
            WHERE  id = :id
        ");
        $taxas->bindValue(':id', $this->getId());
        try {
            $taxas->execute();
            return $taxas->fetchAll();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function SelectAll()
    {
        $taxas = $this->pdo->prepare("SELECT * FROM taxas ");
        try {
            $taxas->execute();
            return $taxas->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
}
