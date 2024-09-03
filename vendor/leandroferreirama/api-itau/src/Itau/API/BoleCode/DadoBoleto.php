<?php

namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;

class DadoBoleto implements \JsonSerializable
{
    use TraitEntity;

    const ESPECIE_DM = '01';
    const ESPECIE_DS = '08';

    private string $descricao_instrumento_cobranca = "boleto_pix";
    private int $codigo_carteira = 109;
    private string $valor_total_titulo;
    private string $codigo_especie;
    private string $data_emissao;
    private string $texto_seu_numero;
    private Pagador $pagador;
    private ?array $dados_individuais_boleto = [];
    private Juros $juros;
    private Multa $multa;


    public function __construct()
    {
        $this->data_emissao = date("Y-m-d");
    }

    public function setDados(string $valor, string $codigoEspecia,string $numero): self
    {
        $this->valor_total_titulo = round($valor*100);
        $this->codigo_especie = $codigoEspecia;
        $this->texto_seu_numero = $numero;
        return $this;
    }

    public function pagador(): Pagador
    {
        $pagador = new Pagador();

        $this->setPagador($pagador);

        return $pagador;
    }

    private function setPagador(Pagador $pagador): self
    {
        $this->pagador = $pagador;
        return $this;
    }

    public function dadosIndividuais(): DadosIndividuaisBoleto
    {
        $dados = new DadosIndividuaisBoleto();

        $this->setDadosIndividuaisBoleto($dados);

        return $dados;
    }

    private function setDadosIndividuaisBoleto(DadosIndividuaisBoleto $dados): self
    {
        array_push($this->dados_individuais_boleto, $dados);
        return $this;
    }

    public function juros(): Juros
    {
        $juros = new Juros();

        $this->setJuros($juros);

        return $juros;
    }

    private function setJuros(Juros $juros): self
    {
        $this->juros = $juros;
        return $this;
    }

    public function multa(): Multa
    {
        $multa = new Multa();

        $this->setMulta($multa);

        return $multa;
    }

    private function setMulta(Multa $multa): self
    {
        $this->multa = $multa;
        return $this;
    }
}