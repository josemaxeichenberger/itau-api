<?php
require_once 'ConexaoMysql.php';
class data extends ConexaoMysql
{
    public $id;
    public $tipo;
    public $titulo;
    public $data;
    public function getId()
    {
        return $this->id;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function getData()
    {
        return $this->data;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }
    public function setData($data)
    {
        $this->data = $data;
    }
    public function Insert()
    {
        $data = $this->pdo->prepare("INSERT INTO data (
            tipo,
            titulo,
            data
        ) VALUES (
            :tipo,
            :titulo,
            :data
        )");
        $data->bindValue(':tipo', $this->getTipo());
        $data->bindValue(':titulo', $this->getTitulo());
        $data->bindValue(':data', $this->getData());
        try {
            return $data->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Update()
    {
        $data = $this->pdo->prepare("UPDATE data SET
            tipo = :tipo,
            titulo = :titulo,
            data = :data
        WHERE  id = :id
        ");
        $data->bindValue(':id', $this->getId());
        $data->bindValue(':tipo', $this->getTipo());
        $data->bindValue(':titulo', $this->getTitulo());
        $data->bindValue(':data', $this->getData());
        try {
            return $data->execute();
        } catch (Exception $retorno) {
        }
    }
    public function Delete()
    {
        $data = $this->pdo->prepare("DELETE FROM data
            WHERE  id = :id
        ");
        $data->bindValue(':id', $this->getId());
        try {
            return $data->execute();
        } catch (Exception $retorno) {
        }
    }
    public function SelectAll()
    {
        $data = $this->pdo->prepare("SELECT * FROM data");
        try {
            $data->execute();
            return $data->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
        }
    }

    public function SelectData()
    {
        $data = $this->pdo->prepare("SELECT * FROM data WHERE data = :data");
        $data->bindValue(':data', $this->getData());

        try {
            $data->execute();
            return $data->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
        }
    }
}
