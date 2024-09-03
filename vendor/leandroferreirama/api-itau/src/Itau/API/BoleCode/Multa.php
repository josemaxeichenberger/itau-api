<?php
namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;
use JsonSerializable;

class Multa implements JsonSerializable
{
    use TraitEntity;

    const SEM_MULTA = '03';
    const PERCENTUAL = '02';

    private string $codigo_tipo_multa;
    private string $percentual_multa;

    public function setMulta($codigo, $percentual): self
    {
        $this->codigo_tipo_multa = $codigo;
        $this->percentual_multa = $percentual*100000;
        return $this;
    }
}