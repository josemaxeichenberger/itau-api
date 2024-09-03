<?php
namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;
use JsonSerializable;

class DadosIndividuaisBoleto implements JsonSerializable
{
    use TraitEntity;

    private string $numero_nosso_numero;
    private string $data_vencimento;
    private string $valor_titulo;
    private string $data_limite_pagamento;

    public function setDados(
        string $nossoNumero, string $dataVencimento, string $valor, ?string $limitePagamento = null
    ): self
    {
        $this->numero_nosso_numero = str_pad($nossoNumero, 8, '0', STR_PAD_LEFT);
        $this->data_vencimento = $dataVencimento;
        $this->valor_titulo = ($valor*100);
        if(!empty($limitePagamento)){
            $this->data_limite_pagamento = $limitePagamento;
        }
        
        return $this;
    }
}