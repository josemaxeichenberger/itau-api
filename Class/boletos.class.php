<?php
require_once 'ConexaoMysql.php';
class boletos extends ConexaoMysql
{
    public $id;
    public $cnpj;
    public $vencimento;
    public $valor;
    public $operacao;
    public $documento;
    public $nosso_numero;
    public $nosso_numero_banco;
    public $nosso_numero_dac;
    public $emissao;
    public $registro;
    public $ocorrencia;
    public $data_ocorrencia;
    public $data_registro;
    public $remessa;
    public $retorno;
    public $tarifa;
    public $iof;
    public $abatimento;
    public $descontos;
    public $mora_multa;
    public $creditado;
    public $outros_creditos;
    public $cod_liquidacao;
    public $mensagem;
    public $status;
    public function getId()
    {
        return $this->id;
    }
    public function getCnpj()
    {
        return $this->cnpj;
    }
    public function getVencimento()
    {
        return $this->vencimento;
    }
    public function getValor()
    {
        return $this->valor;
    }
    public function getOperacao()
    {
        return $this->operacao;
    }
    public function getDocumento()
    {
        return $this->documento;
    }
    public function getNosso_numero()
    {
        return $this->nosso_numero;
    }
    public function getNosso_numero_banco()
    {
        return $this->nosso_numero_banco;
    }
    public function getNosso_numero_dac()
    {
        return $this->nosso_numero_dac;
    }
    public function getEmissao()
    {
        return $this->emissao;
    }
    public function getRegistro()
    {
        return $this->registro;
    }
    public function getOcorrencia()
    {
        return $this->ocorrencia;
    }
    public function getData_ocorrencia()
    {
        return $this->data_ocorrencia;
    }
    public function getData_registro()
    {
        return $this->data_registro;
    }
    public function getRemessa()
    {
        return $this->remessa;
    }
    public function getRetorno()
    {
        return $this->retorno;
    }
    public function getTarifa()
    {
        return $this->tarifa;
    }
    public function getIof()
    {
        return $this->iof;
    }
    public function getAbatimento()
    {
        return $this->abatimento;
    }
    public function getDescontos()
    {
        return $this->descontos;
    }
    public function getMora_multa()
    {
        return $this->mora_multa;
    }
    public function getCreditado()
    {
        return $this->creditado;
    }
    public function getOutros_creditos()
    {
        return $this->outros_creditos;
    }
    public function getCod_liquidacao()
    {
        return $this->cod_liquidacao;
    }
    public function getMensagem()
    {
        return $this->mensagem;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }
    public function setVencimento($vencimento)
    {
        $this->vencimento = $vencimento;
    }
    public function setValor($valor)
    {
        $this->valor = $valor;
    }
    public function setOperacao($operacao)
    {
        $this->operacao = $operacao;
    }
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }
    public function setNosso_numero($nosso_numero)
    {
        $this->nosso_numero = $nosso_numero;
    }
    public function setNosso_numero_banco($nosso_numero_banco)
    {
        $this->nosso_numero_banco = $nosso_numero_banco;
    }
    public function setNosso_numero_dac($nosso_numero_dac)
    {
        $this->nosso_numero_dac = $nosso_numero_dac;
    }
    public function setEmissao($emissao)
    {
        $this->emissao = $emissao;
    }
    public function setRegistro($registro)
    {
        $this->registro = $registro;
    }
    public function setOcorrencia($ocorrencia)
    {
        $this->ocorrencia = $ocorrencia;
    }
    public function setData_ocorrencia($data_ocorrencia)
    {
        $this->data_ocorrencia = $data_ocorrencia;
    }
    public function setData_registro($data_registro)
    {
        $this->data_registro = $data_registro;
    }
    public function setRemessa($remessa)
    {
        $this->remessa = $remessa;
    }
    public function setRetorno($retorno)
    {
        $this->retorno = $retorno;
    }
    public function setTarifa($tarifa)
    {
        $this->tarifa = $tarifa;
    }
    public function setIof($iof)
    {
        $this->iof = $iof;
    }
    public function setAbatimento($abatimento)
    {
        $this->abatimento = $abatimento;
    }
    public function setDescontos($descontos)
    {
        $this->descontos = $descontos;
    }
    public function setMora_multa($mora_multa)
    {
        $this->mora_multa = $mora_multa;
    }
    public function setCreditado($creditado)
    {
        $this->creditado = $creditado;
    }
    public function setOutros_creditos($outros_creditos)
    {
        $this->outros_creditos = $outros_creditos;
    }
    public function setCod_liquidacao($cod_liquidacao)
    {
        $this->cod_liquidacao = $cod_liquidacao;
    }
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function Insert()
    {
        $boletos = $this->pdo->prepare("INSERT INTO boletos (
            id,
            cnpj,
            vencimento,
            valor,
            operacao,
            documento,
            nosso_numero,
            nosso_numero_banco,
            nosso_numero_dac,
            emissao,
            registro,
            ocorrencia,
            data_ocorrencia,
            data_registro,
            remessa,
            retorno,
            tarifa,
            iof,
            abatimento,
            descontos,
            mora_multa,
            creditado,
            outros_creditos,
            cod_liquidacao,
            mensagem,
            status,
        ) VALUES (
            :id,
            :cnpj,
            :vencimento,
            :valor,
            :operacao,
            :documento,
            :nosso_numero,
            :nosso_numero_banco,
            :nosso_numero_dac,
            :emissao,
            :registro,
            :ocorrencia,
            :data_ocorrencia,
            :data_registro,
            :remessa,
            :retorno,
            :tarifa,
            :iof,
            :abatimento,
            :descontos,
            :mora_multa,
            :creditado,
            :outros_creditos,
            :cod_liquidacao,
            :mensagem,
            :status
        )");
        $boletos->bindValue(':id', $this->getId());
        $boletos->bindValue(':cnpj', $this->getCnpj());
        $boletos->bindValue(':vencimento', $this->getVencimento());
        $boletos->bindValue(':valor', $this->getValor());
        $boletos->bindValue(':operacao', $this->getOperacao());
        $boletos->bindValue(':documento', $this->getDocumento());
        $boletos->bindValue(':nosso_numero', $this->getNosso_numero());
        $boletos->bindValue(':nosso_numero_banco', $this->getNosso_numero_banco());
        $boletos->bindValue(':nosso_numero_dac', $this->getNosso_numero_dac());
        $boletos->bindValue(':emissao', $this->getEmissao());
        $boletos->bindValue(':registro', $this->getRegistro());
        $boletos->bindValue(':ocorrencia', $this->getOcorrencia());
        $boletos->bindValue(':data_ocorrencia', $this->getData_ocorrencia());
        $boletos->bindValue(':data_registro', $this->getData_registro());
        $boletos->bindValue(':remessa', $this->getRemessa());
        $boletos->bindValue(':retorno', $this->getRetorno());
        $boletos->bindValue(':tarifa', $this->getTarifa());
        $boletos->bindValue(':iof', $this->getIof());
        $boletos->bindValue(':abatimento', $this->getAbatimento());
        $boletos->bindValue(':descontos', $this->getDescontos());
        $boletos->bindValue(':mora_multa', $this->getMora_multa());
        $boletos->bindValue(':creditado', $this->getCreditado());
        $boletos->bindValue(':outros_creditos', $this->getOutros_creditos());
        $boletos->bindValue(':cod_liquidacao', $this->getCod_liquidacao());
        $boletos->bindValue(':mensagem', $this->getMensagem());
        $boletos->bindValue(':status', $this->getStatus());
        try {
            return $boletos->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Update()
    {
        $boletos = $this->pdo->prepare("UPDATE boletos SET
            cnpj = :cnpj,
            vencimento = :vencimento,
            valor = :valor,
            operacao = :operacao,
            documento = :documento,
            nosso_numero = :nosso_numero,
            nosso_numero_banco = :nosso_numero_banco,
            nosso_numero_dac = :nosso_numero_dac,
            emissao = :emissao,
            registro = :registro,
            ocorrencia = :ocorrencia,
            data_ocorrencia = :data_ocorrencia,
            data_registro = :data_registro,
            remessa = :remessa,
            retorno = :retorno,
            tarifa = :tarifa,
            iof = :iof,
            abatimento = :abatimento,
            descontos = :descontos,
            mora_multa = :mora_multa,
            creditado = :creditado,
            outros_creditos = :outros_creditos,
            cod_liquidacao = :cod_liquidacao,
            mensagem = :mensagem,
            status = :status
        WHERE  id = :id
        ");
        $boletos->bindValue(':id', $this->getId());
        $boletos->bindValue(':cnpj', $this->getCnpj());
        $boletos->bindValue(':vencimento', $this->getVencimento());
        $boletos->bindValue(':valor', $this->getValor());
        $boletos->bindValue(':operacao', $this->getOperacao());
        $boletos->bindValue(':documento', $this->getDocumento());
        $boletos->bindValue(':nosso_numero', $this->getNosso_numero());
        $boletos->bindValue(':nosso_numero_banco', $this->getNosso_numero_banco());
        $boletos->bindValue(':nosso_numero_dac', $this->getNosso_numero_dac());
        $boletos->bindValue(':emissao', $this->getEmissao());
        $boletos->bindValue(':registro', $this->getRegistro());
        $boletos->bindValue(':ocorrencia', $this->getOcorrencia());
        $boletos->bindValue(':data_ocorrencia', $this->getData_ocorrencia());
        $boletos->bindValue(':data_registro', $this->getData_registro());
        $boletos->bindValue(':remessa', $this->getRemessa());
        $boletos->bindValue(':retorno', $this->getRetorno());
        $boletos->bindValue(':tarifa', $this->getTarifa());
        $boletos->bindValue(':iof', $this->getIof());
        $boletos->bindValue(':abatimento', $this->getAbatimento());
        $boletos->bindValue(':descontos', $this->getDescontos());
        $boletos->bindValue(':mora_multa', $this->getMora_multa());
        $boletos->bindValue(':creditado', $this->getCreditado());
        $boletos->bindValue(':outros_creditos', $this->getOutros_creditos());
        $boletos->bindValue(':cod_liquidacao', $this->getCod_liquidacao());
        $boletos->bindValue(':mensagem', $this->getMensagem());
        $boletos->bindValue(':status', $this->getStatus());
        try {
            return $boletos->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function DeleteOp()
    {
        $boletos = $this->pdo->prepare("DELETE FROM boletos
            WHERE  operacao = :operacao
        ");
        $boletos->bindValue(':operacao', $this->getOperacao());
        try {
            return $boletos->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Delete()
    {
        $boletos = $this->pdo->prepare("DELETE FROM boletos
            WHERE  id = :id
        ");
        $boletos->bindValue(':id', $this->getId());
        try {
            return $boletos->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Select()
    {
        $boletos = $this->pdo->prepare("SELECT * FROM boletos
            WHERE  id = :id
        ");
        $boletos->bindValue(':id', $this->getId());
        try {
            $boletos->execute();
            return $boletos->fetchAll();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function SelectTotalPago()
    {
        $boletos = $this->pdo->prepare("SELECT sum(valor) as total_pago FROM `boletos` where status = :status");
        $boletos->bindValue(':status', $this->getStatus());
        try {
            $boletos->execute();
            return $boletos->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Titulos_a_Pagar()
    {
        $boletos = $this->pdo->prepare("select month(boletos.vencimento) as mes, count(boletos.id) as total from boletos where year(boletos.vencimento) = YEAR(CURRENT_DATE) group by month(boletos.vencimento)");
        try {
            $boletos->execute();
            return $boletos->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function Titulos_Pagos()
    {
        $boletos = $this->pdo->prepare("select month(boletos.data_ocorrencia) as mes, count(boletos.id) as total from boletos where year(boletos.data_ocorrencia) = YEAR(CURRENT_DATE) and boletos.status = 9 group by month(boletos.data_ocorrencia)");
        try {
            $boletos->execute();
            return $boletos->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
}
