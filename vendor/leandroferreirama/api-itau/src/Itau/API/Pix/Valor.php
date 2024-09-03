<?php

namespace Itau\API\Pix;

use Itau\API\TraitEntity;

class Valor implements \JsonSerializable
{
    use TraitEntity;

    private string $original;

    public function setOriginal(string $original): self
    {
        $this->original = $original;
        return $this;
    }
}