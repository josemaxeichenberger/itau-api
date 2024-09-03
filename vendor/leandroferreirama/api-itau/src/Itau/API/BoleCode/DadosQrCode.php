<?php

namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;
use JsonSerializable;

class DadosQrCode implements JsonSerializable
{
    use TraitEntity;

    private string $chave;

    public function setChave(string $chave): self
    {
        $this->chave = $chave;
        return $this;
    }
}