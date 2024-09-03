<?php

namespace Itau\API;

class BaseResponse implements \JsonSerializable
{
    use TraitEntity;

    const STATUS_AUTHORIZED = "AUTHORIZED";
    const STATUS_CONFIRMED = "CONFIRMED";
    const STATUS_PENDING = "PENDING";
    const STATUS_WAITING = "WAITING";
    const STATUS_APPROVED = "APPROVED";
    const STATUS_CANCELED = "CANCELED";
    const STATUS_DENIED = "DENIED";
    const STATUS_ERROR = "ERROR";

    private $responseJSON;
    private $status_code;
    private $status;
    private $mensagem;
    private $codigo;

    public function jsonSerialize():mixed
    {
        return get_object_vars($this);
    }

    public function mapperJson($json)
    {
        if (is_array($json)) {
            array_walk_recursive($json, function ($value, $key) {

                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            });
        }

        $this->setResponseJSON($json);

        return $this;
    }

    public function setResponseJSON($array)
    {
        $this->responseJSON = json_encode($array, JSON_PRETTY_PRINT);

        return $this;
    }

    public function setStatusCode($status_code)
    {
        $this->status_code = $status_code;

        return $this;
    }

    public function getStatusCode()
    {
        return empty($this->status_code) ? $this->codigo : $this->status_code;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        if ($this->status_code == 200) {
            $this->status = self::STATUS_CONFIRMED;
        } elseif ($this->status_code == 201) {
            $this->status = self::STATUS_AUTHORIZED;
        } elseif ($this->status_code == 202) {
            $this->status = self::STATUS_AUTHORIZED;
        } elseif ($this->status_code == 400) {
            $this->status = self::STATUS_ERROR;
        } elseif ($this->status_code == 402) {
            $this->status = self::STATUS_ERROR;
        } elseif ($this->status_code == 500) {
            $this->status = self::STATUS_ERROR;
        }
    }

    public function getMensagem(): ?string
    {
        return $this->mensagem;
    }
}