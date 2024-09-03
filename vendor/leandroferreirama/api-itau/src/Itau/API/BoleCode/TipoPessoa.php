<?php

namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;
use JsonSerializable;

class TipoPessoa implements JsonSerializable
{
    use TraitEntity;

    const PESSOA_FISICA = 'F';
    const PESSOA_JURIDICA = 'J';

    private string $codigo_tipo_pessoa;
    private string $numero_cadastro_pessoa_fisica;
    private string $numero_cadastro_nacional_pessoa_juridica;

    public function setPessoa(string $tipoPessoa, $numero): self
    {
        $this->codigo_tipo_pessoa = $tipoPessoa;
        if($this->codigo_tipo_pessoa == self::PESSOA_FISICA){
            $this->numero_cadastro_pessoa_fisica = preg_replace("/[^0-9]/", "", $numero);
        } else {
            $this->numero_cadastro_nacional_pessoa_juridica = preg_replace("/[^0-9]/", "", $numero);
        }
        return $this;
    }
}