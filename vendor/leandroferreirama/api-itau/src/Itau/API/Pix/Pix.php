<?php
namespace Itau\API\Pix;

use Itau\API\TraitEntity;

class Pix implements \JsonSerializable
{
    use TraitEntity;

    private string $chave;
    private string $txid;
    private Valor $valor;


    public function setChave($chave): self
    {
        $this->chave = $chave;
        return $this;
    }

    public function setTxid($txid): self
    {
        $this->txid = $txid;
        return $this;
    }

    public function valor(): Valor
    {
        $valor = new Valor();

        $this->setValor($valor);

        return $valor;
    }

    public function setValor(Valor $valor): self
    {
        $this->valor = $valor;
        return $this;
    }
}