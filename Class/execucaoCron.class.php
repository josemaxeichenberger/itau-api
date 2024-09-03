<?php
require_once 'ConexaoMysql.php';
class execucaoCron extends ConexaoMysql
{
    public $id;
    public $tipo;
    public $data;
    public $curl;
    public function getId()
    {
        return $this->id;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function getData()
    {
        return $this->data;
    }
    public function getCurl()
    {
        return $this->curl;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function setData($data)
    {
        $this->data = $data;
    }
    public function setCurl($curl)
    {
        $this->curl = $curl;
    }
    public function Insert()
    {
        $execucaocron = $this->pdo->prepare("INSERT INTO execucaoCron (
            tipo,
            data,
            curl
        ) VALUES (
            :tipo,
            :data,
            :curl
        )");
        $execucaocron->bindValue(':tipo', $this->getTipo());
        $execucaocron->bindValue(':data', $this->getData());
        $execucaocron->bindValue(':curl', $this->getCurl());
        try {
            return $execucaocron->execute();
        } catch (Exception $retorno) {
        }
    }
    public function Update()
    {
        $execucaocron = $this->pdo->prepare("UPDATE execucaoCron SET
            tipo = :tipo,
            data = :data,
            curl = :curl
        WHERE  id = :id
        ");
        $execucaocron->bindValue(':id', $this->getId());
        $execucaocron->bindValue(':tipo', $this->getTipo());
        $execucaocron->bindValue(':data', $this->getData());
        $execucaocron->bindValue(':curl', $this->getCurl());
        try {
            return $execucaocron->execute();
        } catch (Exception $retorno) {
        }
    }
    public function Delete()
    {
        $execucaocron = $this->pdo->prepare("DELETE FROM execucaoCron
            WHERE  id = :id
        ");
        $execucaocron->bindValue(':id', $this->getId());
        try {
            return $execucaocron->execute();
        } catch (Exception $retorno) {
        }
    }
    public function Select()
    {
        $execucaocron = $this->pdo->prepare("SELECT * FROM execucaoCron
            WHERE  id = :id
        ");
        $execucaocron->bindValue(':id', $this->getId());
        try {
            $execucaocron->execute();
            return $execucaocron->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
        }
    }
    public function SelectAll()
    {
        $execucaocron = $this->pdo->prepare("SELECT * FROM execucaoCron");        
        try {
            $execucaocron->execute();
            return $execucaocron->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
}
