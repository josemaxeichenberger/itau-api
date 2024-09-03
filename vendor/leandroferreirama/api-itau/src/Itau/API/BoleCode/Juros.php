<?php
namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;
use JsonSerializable;

class Juros implements JsonSerializable
{
    use TraitEntity;

    const SEM_JUROS = '05';
    const PERCENTUAL_MENSAL = '90';

    private string $codigo_tipo_juros;
    private string $percentual_juros;

    public function setJuros($codigo, $percentual): self
    {
        $this->codigo_tipo_juros = $codigo;
        if($codigo != self::SEM_JUROS){
            $this->percentual_juros = $percentual*100000;
        }
        return $this;
    }
}