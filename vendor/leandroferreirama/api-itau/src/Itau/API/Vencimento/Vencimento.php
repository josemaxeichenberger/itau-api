<?php
namespace Itau\API\Vencimento;

use Itau\API\TraitEntity;

class Vencimento implements \JsonSerializable
{
    use TraitEntity;

    private string $data_vencimento;

    public function __construct($vencimento)
    {
        $this->data_vencimento = $vencimento;
    }

    public function setDataVencimento($vencimento): self
    {
        $this->data_vencimento = $vencimento;
        return $this;
    }
}