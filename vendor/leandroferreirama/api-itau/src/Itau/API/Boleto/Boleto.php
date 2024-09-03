<?php
namespace Itau\API\Boleto;

use Itau\API\TraitEntity;

class Boleto implements \JsonSerializable
{
    use TraitEntity;

    private string $id_beneficiario;
    private string $nosso_numero;

    public function __construct($agencia, $contaComDigito, $nossoNumero)
    {
        $this->id_beneficiario = str_pad($agencia, 4, '0', STR_PAD_LEFT).str_pad($contaComDigito, 8, '0', STR_PAD_LEFT);
        $this->nosso_numero = $nossoNumero;
    }
}