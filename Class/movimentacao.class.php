<?php
require_once 'ConexaoMysql.php';
class movimentacao extends ConexaoMysql
{
    public $id;
    public $tipo;
    public $titulo;
    public $data;
    public $valor;
    public $status;
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
    public function getValor()
    {
        return $this->valor;
    }
    public function getStatus()
    {
        return $this->status;
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
    public function setValor($valor)
    {
        $this->valor = $valor;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function Insert()
    {
        $movimentacao = $this->pdo->prepare("INSERT INTO movimentacao (
            tipo,
            titulo,
            data,
            valor,
            status
        ) VALUES (
            :tipo,
            :titulo,
            :data,
            :valor,
            :status
        )");
        $movimentacao->bindValue(':tipo', $this->getTipo());
        $movimentacao->bindValue(':titulo', $this->getTitulo());
        $movimentacao->bindValue(':data', $this->getData());
        $movimentacao->bindValue(':valor', $this->getValor());
        $movimentacao->bindValue(':status', $this->getStatus());
        try {
            return $movimentacao->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Update()
    {
        $movimentacao = $this->pdo->prepare("UPDATE movimentacao SET
            tipo = :tipo,
            titulo = :titulo,
            data = :data,
            valor = :valor,
            status = :status
        WHERE  id = :id
        ");
        $movimentacao->bindValue(':id', $this->getId());
        $movimentacao->bindValue(':tipo', $this->getTipo());
        $movimentacao->bindValue(':titulo', $this->getTitulo());
        $movimentacao->bindValue(':data', $this->getData());
        $movimentacao->bindValue(':valor', $this->getValor());
        $movimentacao->bindValue(':status', $this->getStatus());
        try {
            return $movimentacao->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Delete()
    {
        $movimentacao = $this->pdo->prepare("DELETE FROM movimentacao
            WHERE  id = :id
        ");
        $movimentacao->bindValue(':id', $this->getId());
        try {
            return $movimentacao->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Select()
    {
        $movimentacao = $this->pdo->prepare("SELECT * FROM movimentacao
        ");
        try {
            $movimentacao->execute();
            return $movimentacao->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Get_MontantePositivo()
    {
        $movimentacao = $this->pdo->prepare("SELECT SUM(valor) as aportes FROM movimentacao WHERE tipo = 'aporte'");
        try {
            $movimentacao->execute();
            return $movimentacao->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Get_MontanteNegativo()
    {
        $movimentacao = $this->pdo->prepare("SELECT SUM(valor) as retiradas FROM movimentacao WHERE tipo = 'retirada' ");
        try {
            $movimentacao->execute();
            return $movimentacao->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Get_Mes_Aplicado()
    {
        $movimentacao = $this->pdo->prepare("SELECT MONTH(movimentacao.data) as mes, YEAR(movimentacao.data) as ano FROM movimentacao WHERE tipo = 'aporte'");
        try {
            $movimentacao->execute();
            return $movimentacao->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function Get_Total_Despesas()
    {
        $movimentacao = $this->pdo->prepare( "SELECT COALESCE(SUM(valor), 0) as despesa FROM movimentacao WHERE tipo = 'despesa'");
        try {
            $movimentacao->execute();
            return $movimentacao->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Get_MontanteAplicado()
    {
        $movimentacao = $this->pdo->prepare( "select movimentacao.data as data, movimentacao.valor from movimentacao where movimentacao.tipo = 'aporte'");
        try {
            $movimentacao->execute();
            return $movimentacao->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
}
