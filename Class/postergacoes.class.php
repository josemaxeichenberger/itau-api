<?php
require_once 'ConexaoMysql.php';
class postergacoes extends ConexaoMysql
{
    public $id;
    public $data;
    public $valororiginal;
    public $juros;
    public $taxas;
    public $valor;
    public $status;
    public $tipo;
    public $confirmada;
    public function getId()
    {
        return $this->id;
    }
    public function getData()
    {
        return $this->data;
    }
    public function getValororiginal()
    {
        return $this->valororiginal;
    }
    public function getJuros()
    {
        return $this->juros;
    }
    public function getTaxas()
    {
        return $this->taxas;
    }
    public function getValor()
    {
        return $this->valor;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function getConfirmada()
    {
        return $this->confirmada;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setData($data)
    {
        $this->data = $data;
    }
    public function setValororiginal($valororiginal)
    {
        $this->valororiginal = $valororiginal;
    }
    public function setJuros($juros)
    {
        $this->juros = $juros;
    }
    public function setTaxas($taxas)
    {
        $this->taxas = $taxas;
    }
    public function setValor($valor)
    {
        $this->valor = $valor;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function setConfirmada($confirmada)
    {
        $this->confirmada = $confirmada;
    }
    public function Insert()
    {
        $postergacoes = $this->pdo->prepare("INSERT INTO postergacoes (
            id,
            data,
            valorOriginal,
            juros,
            taxas,
            valor,
            status,
            tipo,
            confirmada,
        ) VALUES (
            :id,
            :data,
            :valororiginal,
            :juros,
            :taxas,
            :valor,
            :status,
            :tipo,
            :confirmada
        )");
        $postergacoes->bindValue(':id', $this->getId());
        $postergacoes->bindValue(':data', $this->getData());
        $postergacoes->bindValue(':valororiginal', $this->getValororiginal());
        $postergacoes->bindValue(':juros', $this->getJuros());
        $postergacoes->bindValue(':taxas', $this->getTaxas());
        $postergacoes->bindValue(':valor', $this->getValor());
        $postergacoes->bindValue(':status', $this->getStatus());
        $postergacoes->bindValue(':tipo', $this->getTipo());
        $postergacoes->bindValue(':confirmada', $this->getConfirmada());
        try {
            return $postergacoes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Update()
    {
        $postergacoes = $this->pdo->prepare("UPDATE postergacoes SET
            data = :data,
            valorOriginal = :valororiginal,
            juros = :juros,
            taxas = :taxas,
            valor = :valor,
            status = :status,
            tipo = :tipo,
            confirmada = :confirmada
        WHERE  id = :id
        ");
        $postergacoes->bindValue(':id', $this->getId());
        $postergacoes->bindValue(':data', $this->getData());
        $postergacoes->bindValue(':valororiginal', $this->getValororiginal());
        $postergacoes->bindValue(':juros', $this->getJuros());
        $postergacoes->bindValue(':taxas', $this->getTaxas());
        $postergacoes->bindValue(':valor', $this->getValor());
        $postergacoes->bindValue(':status', $this->getStatus());
        $postergacoes->bindValue(':tipo', $this->getTipo());
        $postergacoes->bindValue(':confirmada', $this->getConfirmada());
        try {
            return $postergacoes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Delete()
    {
        $postergacoes = $this->pdo->prepare("DELETE FROM postergacoes
            WHERE  id = :id
        ");
        $postergacoes->bindValue(':id', $this->getId());
        try {
            return $postergacoes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Select()
    {
        $postergacoes = $this->pdo->prepare("SELECT * FROM postergacoes
            WHERE  id = :id
        ");
        $postergacoes->bindValue(':id', $this->getId());
        try {
            $postergacoes->execute();
            return $postergacoes->fetchAll();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function SelectId()
    {
        $postergacoes = $this->pdo->prepare("SELECT * FROM postergacoes
            WHERE  id = :id
        ");
        $postergacoes->bindValue(':id', $this->getId());
        try {
            $postergacoes->execute();
            return $postergacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

}
