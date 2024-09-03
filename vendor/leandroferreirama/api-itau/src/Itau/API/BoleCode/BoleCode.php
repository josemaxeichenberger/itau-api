<?php
namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;

class BoleCode implements \JsonSerializable
{
    use TraitEntity;

    const ETAPA_TESTE = "simulacao";
    const ETAPA_EFETIVO = "efetivacao";

    private string $etapa_processo_boleto;
    private Beneficiario $beneficiario;
    private DadoBoleto $dado_boleto;
    private DadosQrcode $dados_qrcode;

    public function __construct(
        $modo, $agencia, $conta, $contaDV, $valor, $tipoBoleto, $numeroDocumento, $nome, $tipoPessoa,
        $documento, $endereco, $numero, $complemento, $bairro, $cidade, $siglaEstado, $cep, $nossoNumero, 
        $vencimento, $chavePix, $tipoMulta, $percentualMulta, $tipoJuros, $percentualJuros
    )
    {
        $this->setEtapaProcessoBoleto($modo)
            ->beneficiario()->setIdBeneficiario($agencia, $conta.$contaDV);
        $dadoBoleto = $this->dadoBoleto()
            ->setDados($valor, $tipoBoleto, $numeroDocumento);
        $pagador = $dadoBoleto->pagador();
        $pessoa = $pagador->pessoa()->setNomePessoa($nome);
        $tipoPessoa = $pessoa->tipoPessoa()
            ->setPessoa($tipoPessoa, $documento);
        $pagador->endereco()->setEndereco(
            $endereco, $numero, $complemento, $bairro, $cidade, $siglaEstado, $cep
        );
            
        $dadoBoleto->dadosIndividuais()->setDados(
            $nossoNumero, $vencimento, $valor
        );

        $dadoBoleto->multa()->setMulta($tipoMulta, $percentualMulta);
        $dadoBoleto->juros()->setJuros($tipoJuros, $percentualJuros);

        $this->dadosQrCode()->setChave($chavePix);
    }
    public function setEtapaProcessoBoleto($etapa): self
    {
        $this->etapa_processo_boleto = $etapa;
        return $this;
    }

    public function beneficiario(): Beneficiario
    {
        $beneficiario = new Beneficiario();

        $this->setBeneficiario($beneficiario);

        return $beneficiario;
    }

    public function getBeneficiario(): Beneficiario
    {
        return $this->beneficiario;
    }

    public function setBeneficiario(Beneficiario $beneficiario): self
    {
        $this->beneficiario = $beneficiario;
        return $this;
    }

    public function dadoBoleto(): DadoBoleto
    {
        $dado = new DadoBoleto();

        $this->setDadoBoleto($dado);

        return $dado;
    }

    private function setDadoBoleto(DadoBoleto $dado): self
    {
        $this->dado_boleto = $dado;
        return $this;
    }

    public function dadosQrCode(): DadosQrCode
    {
        $dado = new DadosQrCode();

        $this->setDadosQrCode($dado);

        return $dado;
    }

    private function setDadosQrCode(DadosQrCode $dado): self
    {
        $this->dados_qrcode = $dado;
        return $this;
    }
}