<?php

namespace Itau\API\BoleCode;

use Itau\API\BaseResponse;

class BoleCodeResponse extends BaseResponse
{
    protected $emv;
    protected $txid;

    public function getTxid()
    {
        return $this->txid;
    }

    public function getPixCopiaECola()
    {
        return $this->emv;
    }
}