<?php
require_once 'ConexaoMysql.php';
class antecipadasDetalhes extends ConexaoMysql
{
    public $id;
    public $antecipada;
    public $operacao;
    public $data;
    public $valororiginal;
    public $descontojuros;
    public $valor;
    public function getId()
    {
        return $this->id;
    }
    public function getAntecipada()
    {
        return $this->antecipada;
    }
    public function getOperacao()
    {
        return $this->operacao;
    }
    public function getData()
    {
        return $this->data;
    }
    public function getValororiginal()
    {
        return $this->valororiginal;
    }
    public function getDescontojuros()
    {
        return $this->descontojuros;
    }
    public function getValor()
    {
        return $this->valor;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setAntecipada($antecipada)
    {
        $this->antecipada = $antecipada;
    }
    public function setOperacao($operacao)
    {
        $this->operacao = $operacao;
    }
    public function setData($data)
    {
        $this->data = $data;
    }
    public function setValororiginal($valororiginal)
    {
        $this->valororiginal = $valororiginal;
    }
    public function setDescontojuros($descontojuros)
    {
        $this->descontojuros = $descontojuros;
    }
    public function setValor($valor)
    {
        $this->valor = $valor;
    }
    public function Insert()
    {
        $antecipadasdetalhes = $this->pdo->prepare("INSERT INTO antecipadasDetalhes (
            id,
            antecipada,
            operacao,
            data,
            valorOriginal,
            descontoJuros,
            valor,
        ) VALUES (
            :id,
            :antecipada,
            :operacao,
            :data,
            :valororiginal,
            :descontojuros,
            :valor
        )");
        $antecipadasdetalhes->bindValue(':id', $this->getId());
        $antecipadasdetalhes->bindValue(':antecipada', $this->getAntecipada());
        $antecipadasdetalhes->bindValue(':operacao', $this->getOperacao());
        $antecipadasdetalhes->bindValue(':data', $this->getData());
        $antecipadasdetalhes->bindValue(':valororiginal', $this->getValororiginal());
        $antecipadasdetalhes->bindValue(':descontojuros', $this->getDescontojuros());
        $antecipadasdetalhes->bindValue(':valor', $this->getValor());
        try {
            return $antecipadasdetalhes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Update()
    {
        $antecipadasdetalhes = $this->pdo->prepare("UPDATE antecipadasDetalhes SET
            data = :data,
            valorOriginal = :valororiginal,
            descontoJuros = :descontojuros,
            valor = :valor
        WHERE  id = :id
        ");
        $antecipadasdetalhes->bindValue(':id', $this->getId());
        $antecipadasdetalhes->bindValue(':antecipada', $this->getAntecipada());
        $antecipadasdetalhes->bindValue(':operacao', $this->getOperacao());
        $antecipadasdetalhes->bindValue(':data', $this->getData());
        $antecipadasdetalhes->bindValue(':valororiginal', $this->getValororiginal());
        $antecipadasdetalhes->bindValue(':descontojuros', $this->getDescontojuros());
        $antecipadasdetalhes->bindValue(':valor', $this->getValor());
        try {
            return $antecipadasdetalhes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Delete()
    {
        $antecipadasdetalhes = $this->pdo->prepare("DELETE FROM antecipadasDetalhes
            WHERE  antecipada = :antecipada
        ");
        $antecipadasdetalhes->bindValue(':antecipada', $this->getAntecipada());
        try {
            return $antecipadasdetalhes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Select()
    {
        $antecipadasdetalhes = $this->pdo->prepare("SELECT * FROM antecipadasDetalhes
            WHERE  id = :id
        ");
        $antecipadasdetalhes->bindValue(':id', $this->getId());
        try {
            $antecipadasdetalhes->execute();
            return $antecipadasdetalhes->fetchAll();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function Select_antecipadasDetalhes()
    {
        $antecipadasdetalhes = $this->pdo->prepare("select count(*) as totaldupli from antecipadasDetalhes 
        where antecipadasDetalhes.antecipada = :id
        having totaldupli > 0
        union select count(*) as totaldupli from boletos
        where boletos.operacao = :id
        having totaldupli > 0");
        $antecipadasdetalhes->bindValue(':id', $this->getId());
        try {
            $antecipadasdetalhes->execute();
            return $antecipadasdetalhes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function antecipadasDetalhesDuplicatas()
    {
        $antecipadasdetalhes = $this->pdo->prepare("SELECT antecipadasDetalhes.*, 
        (select operacoes.vencimento from operacoes where operacoes.id = antecipadasDetalhes.operacao)  as vencimento,
        antecipadas.descontoTaxas as descontoTaxas
        FROM antecipadasDetalhes 
        inner join antecipadas on antecipadas.id = antecipadasDetalhes.antecipada
        WHERE antecipada = :id
        ORDER BY antecipadasDetalhes.operacao ASC");
        $antecipadasdetalhes->bindValue(':id', $this->getId());
        try {
            $antecipadasdetalhes->execute();
            return $antecipadasdetalhes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function antecipadasDetalhesDuplicatasRel()
    {
        $antecipadasdetalhes = $this->pdo->prepare("SELECT antecipadasDetalhes.*, 
        (select operacoes.vencimento from operacoes where operacoes.id = antecipadasDetalhes.operacao)  as vencimento,
        (select operacoes.cnpj from operacoes where operacoes.id = antecipadasDetalhes.operacao)  as cnpj,
        antecipadas.descontoTaxas as descontoTaxas
        FROM antecipadasDetalhes 
        inner join antecipadas on antecipadas.id = antecipadasDetalhes.antecipada
        -- WHERE antecipada = :id
        ORDER BY antecipadasDetalhes.operacao ASC");
        // $antecipadasdetalhes->bindValue(':id', $this->getId());
        try {
            $antecipadasdetalhes->execute();
            return $antecipadasdetalhes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function buscadesconto()
    {
        $antecipadasdetalhes = $this->pdo->prepare("SELECT * FROM antecipadasDetalhes WHERE operacao = :operacao ");
        $antecipadasdetalhes->bindValue(':operacao', $this->getOperacao());
        try {
            $antecipadasdetalhes->execute();
            return $antecipadasdetalhes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function buscaNotas()
    {
        $antecipadasdetalhes = $this->pdo->prepare("SELECT * FROM antecipadasDetalhes WHERE antecipada = :antecipada ");
        $antecipadasdetalhes->bindValue(':antecipada', $this->getAntecipada());
        try {
            $antecipadasdetalhes->execute();
            return $antecipadasdetalhes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function ResumoOp()
    {
        $antecipadasdetalhes = $this->pdo->prepare("SELECT *,operacoes.clicksign_key as clicksign_keyBuscar,fornecedores.email as email, antecipadasDetalhes.descontoJuros as descontoJuros, antecipadas.descontoTaxas as descontoTaxas, antecipadasDetalhes.valorOriginal as Original,   antecipadasDetalhes.valor as valor_antecip, ( select antecipadas.valor from antecipadas where id = :antecipada ) as valor_antecip_liq FROM antecipadasDetalhes 
        inner join boletos on boletos.operacao = antecipadasDetalhes.operacao
        inner join antecipadas on antecipadas.id = antecipadasDetalhes.antecipada
        inner join operacoes on operacoes.id = antecipadasDetalhes.operacao
        inner join fornecedores on fornecedores.cnpj = operacoes.cnpj 
        WHERE antecipadasDetalhes.antecipada = :antecipada");
        $antecipadasdetalhes->bindValue(':antecipada', $this->getAntecipada());
        try {
            $antecipadasdetalhes->execute();
            return $antecipadasdetalhes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
}
