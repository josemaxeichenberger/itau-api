<?php
namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;
use JsonSerializable;

class Pagador implements JsonSerializable
{
    use TraitEntity;

    private Pessoa $pessoa;
    private Endereco $endereco;

    public function pessoa(): Pessoa
    {
        $pessoa = new Pessoa();

        $this->setPessoa($pessoa);

        return $pessoa;
    }

    public function setPessoa(Pessoa $pessoa): self
    {
        $this->pessoa = $pessoa;
        return $this;
    }

    public function endereco(): Endereco
    {
        $endereco = new Endereco();

        $this->setEndereco($endereco);

        return $endereco;
    }

    public function setEndereco(Endereco $endereco): self
    {
        $this->endereco = $endereco;
        return $this;
    }
}