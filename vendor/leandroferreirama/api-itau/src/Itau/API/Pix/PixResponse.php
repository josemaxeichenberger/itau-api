<?php

namespace Itau\API\Pix;

use Itau\API\BaseResponse;

class PixResponse extends BaseResponse
{
    protected $txid;
    protected $pixCopiaECola;

    public function getTxid()
    {
        return $this->txid;
    }

    public function getPixCopiaECola()
    {
        return $this->pixCopiaECola;
    }
}