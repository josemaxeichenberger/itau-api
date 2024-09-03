<?php

namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;
use JsonSerializable;

class Endereco implements JsonSerializable
{
    use TraitEntity;

    private string $nome_logradouro;
    private string $nome_bairro;
    private string $nome_cidade;
    private string $sigla_UF;
    private string $numero_CEP;
    private string $complemento;
    private string $numero;

    public function setEndereco(
        string $rua, string $numero, string $complemento, string $bairro, string $cidade, string $uf, string $cep
    ): self
    {
        $this->nome_logradouro = $this->textClear($rua, 45);
        $this->nome_bairro = $this->textClear($bairro, 15);
        $this->nome_cidade = $this->textClear($cidade, 20);
        $this->sigla_UF = $this->textClear($uf, 2);
        $this->numero_CEP = preg_replace("/[^0-9]/", "", $cep);
        $this->complemento = $this->textClear($complemento, 10);
        $this->numero = $this->textClear($numero, 10);

        return $this;
    }

    public function textClear(?string $value, int $count): ?string
    {
        if(empty($value)){
            return null;
        }
        return mb_substr($this->textClearSpecialChar($value), 0, $count);
    }

    public function textClearSpecialChar(string $value): ?string
    {
        return preg_replace("/[^\w]/", "", $value);
    }
}