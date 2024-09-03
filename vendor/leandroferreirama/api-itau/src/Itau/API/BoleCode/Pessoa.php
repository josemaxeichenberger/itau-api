<?php

namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;
use JsonSerializable;

class Pessoa implements JsonSerializable
{
    use TraitEntity;

    private string $nome_pessoa;
    private TipoPessoa $tipo_pessoa;

    public function setNomePessoa($nome): self
    {
        $this->nome_pessoa = mb_substr($nome, 0, 50);
        return $this;
    }

    public function tipoPessoa(): TipoPessoa
    {
        $tipoPessoa = new TipoPessoa();

        $this->setTipoPessoa($tipoPessoa);

        return $tipoPessoa;
    }

    public function setTipoPessoa(TipoPessoa $tipoPessoa): self
    {
        $this->tipo_pessoa = $tipoPessoa;
        return $this;
    }
}