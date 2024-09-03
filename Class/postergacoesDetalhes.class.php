<?php
require_once 'ConexaoMysql.php';
class postergacoesDetalhes extends ConexaoMysql
{
    public $id;
    public $id_postergacao;
    public $id_operacao;
    public $valororiginal;
    public $juros;
    public $taxas;
    public $valor;
    public $status;
    public $tipo;
    public $confirmada;
    public $id_postergada;
    public function getId()
    {
        return $this->id;
    }
    public function getId_postergacao()
    {
        return $this->id_postergacao;
    }
    public function getId_operacao()
    {
        return $this->id_operacao;
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
    public function getId_postergada()
    {
        return $this->id_postergada;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setId_postergacao($id_postergacao)
    {
        $this->id_postergacao = $id_postergacao;
    }
    public function setId_operacao($id_operacao)
    {
        $this->id_operacao = $id_operacao;
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
    public function setId_postergada($id_postergada)
    {
        $this->id_postergada = $id_postergada;
    }
    public function Insert()
    {
        $postergacoesdetalhes = $this->pdo->prepare("INSERT INTO postergacoesDetalhes (
            id,
            id_postergacao,
            id_operacao,
            valorOriginal,
            juros,
            taxas,
            valor,
            status,
            tipo,
            confirmada,
            id_postergada,
        ) VALUES (
            :id,
            :id_postergacao,
            :id_operacao,
            :valororiginal,
            :juros,
            :taxas,
            :valor,
            :status,
            :tipo,
            :confirmada,
            :id_postergada
        )");
        $postergacoesdetalhes->bindValue(':id', $this->getId());
        $postergacoesdetalhes->bindValue(':id_postergacao', $this->getId_postergacao());
        $postergacoesdetalhes->bindValue(':id_operacao', $this->getId_operacao());
        $postergacoesdetalhes->bindValue(':valororiginal', $this->getValororiginal());
        $postergacoesdetalhes->bindValue(':juros', $this->getJuros());
        $postergacoesdetalhes->bindValue(':taxas', $this->getTaxas());
        $postergacoesdetalhes->bindValue(':valor', $this->getValor());
        $postergacoesdetalhes->bindValue(':status', $this->getStatus());
        $postergacoesdetalhes->bindValue(':tipo', $this->getTipo());
        $postergacoesdetalhes->bindValue(':confirmada', $this->getConfirmada());
        $postergacoesdetalhes->bindValue(':id_postergada', $this->getId_postergada());
        try {
            return $postergacoesdetalhes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Update()
    {
        $postergacoesdetalhes = $this->pdo->prepare("UPDATE postergacoesDetalhes SET
            valorOriginal = :valororiginal,
            juros = :juros,
            taxas = :taxas,
            valor = :valor,
            status = :status,
            tipo = :tipo,
            confirmada = :confirmada,
        WHERE  id = :id
        ");
        $postergacoesdetalhes->bindValue(':id', $this->getId());
        $postergacoesdetalhes->bindValue(':id_postergacao', $this->getId_postergacao());
        $postergacoesdetalhes->bindValue(':id_operacao', $this->getId_operacao());
        $postergacoesdetalhes->bindValue(':valororiginal', $this->getValororiginal());
        $postergacoesdetalhes->bindValue(':juros', $this->getJuros());
        $postergacoesdetalhes->bindValue(':taxas', $this->getTaxas());
        $postergacoesdetalhes->bindValue(':valor', $this->getValor());
        $postergacoesdetalhes->bindValue(':status', $this->getStatus());
        $postergacoesdetalhes->bindValue(':tipo', $this->getTipo());
        $postergacoesdetalhes->bindValue(':confirmada', $this->getConfirmada());
        $postergacoesdetalhes->bindValue(':id_postergada', $this->getId_postergada());
        try {
            return $postergacoesdetalhes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function DeleteOp()
    {
        $postergacoesdetalhes = $this->pdo->prepare("DELETE FROM postergacoesDetalhes
            WHERE  id_postergacao = :id_postergacao
        ");
              $postergacoesdetalhes->bindValue(':id_postergacao', $this->getId_postergacao());

        try {
            return $postergacoesdetalhes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function CountOp()
    {
        $postergacoesdetalhes = $this->pdo->prepare("SELECT COUNT(*) as totaldupli  FROM postergacoesDetalhes
            WHERE  id_postergacao = :id_postergacao
        ");
              $postergacoesdetalhes->bindValue(':id_postergacao', $this->getId_postergacao());

        try {
             $postergacoesdetalhes->execute();
             return $postergacoesdetalhes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Delete()
    {
        $postergacoesdetalhes = $this->pdo->prepare("DELETE FROM postergacoesDetalhes
            WHERE  id = :id
        ");
        $postergacoesdetalhes->bindValue(':id', $this->getId());
        try {
            return $postergacoesdetalhes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Select()
    {
        $postergacoesdetalhes = $this->pdo->prepare("SELECT * FROM postergacoesDetalhes
            WHERE  id = :id
        ");
        $postergacoesdetalhes->bindValue(':id', $this->getId());
        try {
            $postergacoesdetalhes->execute();
            return $postergacoesdetalhes->fetchAll();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function SelectID()
    {
        $postergacoesdetalhes = $this->pdo->prepare("SELECT * FROM postergacoesDetalhes
            WHERE  id = :id
        ");
        $postergacoesdetalhes->bindValue(':id', $this->getId());
        try {
            $postergacoesdetalhes->execute();
            return $postergacoesdetalhes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Select_totaloperado_postergacao()
    {
        $postergacoesdetalhes = $this->pdo->prepare("select sum(valor) as valor from postergacoesDetalhes where postergacoesDetalhes.id_operacao = :id");
        $postergacoesdetalhes->bindValue(':id', $this->getId());
        try {
            $postergacoesdetalhes->execute();
            return $postergacoesdetalhes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Detales_postergacao()
    {
        $postergacoesdetalhes = $this->pdo->prepare("SELECT * FROM postergacoesDetalhes WHERE id_postergacao = :id_operacao ORDER BY postergacoesDetalhes.id_postergacao ASC");
        $postergacoesdetalhes->bindValue(':id_operacao', $this->getId_operacao());
        try {
            $postergacoesdetalhes->execute();
            return $postergacoesdetalhes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Get_Operacao_Vencimento()
    {
        try {
            $postergacoesdetalhes = $this->pdo->prepare("SELECT operacoes.vencimento as vencimento, operacoes.nota as nota, operacoes.status as status, operacoes.confirmada as confirmada, operacoes.id as id, boletos.id as boleto_id from operacoes inner join boletos on operacoes.id = boletos.operacao where operacoes.id = :id_operacao");
            $postergacoesdetalhes->bindValue(':id_operacao', $this->getId_operacao());
            $postergacoesdetalhes->execute();
            return $postergacoesdetalhes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    function generateMultipleIdsQuery($status, $inicio, $termino) {
        $query = "SELECT DISTINCT GROUP_CONCAT(id_operacao) as multiple_ids, id_postergacao as id FROM `postergacoesDetalhes` 
                  INNER JOIN operacoes ON operacoes.id = postergacoesDetalhes.id_postergada";
    
        if ($status) {
            if ($status == "4") {
                $query .= " AND operacoes.status = 5";
            } else {
                $query .= " AND operacoes.status = 6";
            }
        }
    
        if ($inicio) {
            $query .= " AND operacoes.dataOPE >= :inicio";
        }
    
        if ($termino) {
            $query .= " AND operacoes.dataOPE <= :termino";
        }
    
        $query .= " GROUP BY id_postergacao HAVING COUNT(postergacoesDetalhes.id) > 1";
    
        $stmt = $this->pdo->prepare($query);
    
        if ($inicio) {
            $stmt->bindParam(':inicio', $inicio);
        }
    
        if ($termino) {
            $stmt->bindParam(':termino', $termino);
        }
    
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function SelectNota()
    {
        $postergacoesdetalhes = $this->pdo->prepare("SELECT * FROM postergacoesDetalhes
            WHERE  id_postergada = :id_postergada
        ");
        $postergacoesdetalhes->bindValue(':id_postergada', $this->getId_postergada());
        try {
            $postergacoesdetalhes->execute();
            return $postergacoesdetalhes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function SelectNotas()
    {
        $postergacoesdetalhes = $this->pdo->prepare("SELECT * FROM postergacoesDetalhes
            WHERE  id_postergacao = :id_postergacao
        ");
        $postergacoesdetalhes->bindValue(':id_postergacao', $this->getId_postergacao());
        try {
            $postergacoesdetalhes->execute();
            return $postergacoesdetalhes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
}
