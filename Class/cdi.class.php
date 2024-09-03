<?php
require_once 'ConexaoMysql.php';
class cdi extends ConexaoMysql
{
    public $id;
    public $ano;
    public $mes;
    public $valor;
    public function getId()
    {
        return $this->id;
    }
    public function getAno()
    {
        return $this->ano;
    }
    public function getMes()
    {
        return $this->mes;
    }
    public function getValor()
    {
        return $this->valor;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setAno($ano)
    {
        $this->ano = $ano;
    }
    public function setMes($mes)
    {
        $this->mes = $mes;
    }
    public function setValor($valor)
    {
        $this->valor = $valor;
    }
    public function Insert()
    {
        $cdi = $this->pdo->prepare("INSERT INTO cdi (
            id,
            ano,
            mes,
            valor,
        ) VALUES (
            :id,
            :ano,
            :mes,
            :valor
        )");
        $cdi->bindValue(':id', $this->getId());
        $cdi->bindValue(':ano', $this->getAno());
        $cdi->bindValue(':mes', $this->getMes());
        $cdi->bindValue(':valor', $this->getValor());
        try {
            return $cdi->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Update()
    {
        $cdi = $this->pdo->prepare("UPDATE cdi SET
            ano = :ano,
            mes = :mes,
            valor = :valor
        WHERE  id = :id
        ");
        $cdi->bindValue(':id', $this->getId());
        $cdi->bindValue(':ano', $this->getAno());
        $cdi->bindValue(':mes', $this->getMes());
        $cdi->bindValue(':valor', $this->getValor());
        try {
            return $cdi->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Delete()
    {
        $cdi = $this->pdo->prepare("DELETE FROM cdi
            WHERE  id = :id
        ");
        $cdi->bindValue(':id', $this->getId());
        try {
            return $cdi->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Select()
    {
        $cdi = $this->pdo->prepare("SELECT * FROM cdi
            WHERE  id = :id
        ");
        $cdi->bindValue(':id', $this->getId());
        try {
            $cdi->execute();
            return $cdi->fetchAll();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Rentabilidade()
    {
        $cdi = $this->pdo->prepare("SELECT valor,mes 
        FROM cdi 
        WHERE ano = YEAR(CURRENT_DATE)
        ORDER BY mes");
        try {
            $cdi->execute();
            return $cdi->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function SelectAll()
    {
        $cdi = $this->pdo->prepare("SELECT * FROM cdi
            
        ");
        try {
            $cdi->execute();
            return $cdi->fetchAll();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
}
