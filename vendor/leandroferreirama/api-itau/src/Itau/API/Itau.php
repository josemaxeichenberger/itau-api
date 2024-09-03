<?php
namespace Itau\API;

use Itau\API\BoleCode\BoleCode;
use Itau\API\BoleCode\BoleCodeResponse;
use Itau\API\Boleto\Boleto;
use Itau\API\Boleto\BoletoResponse;
use Itau\API\Pix\Pix;
use Itau\API\Pix\PixResponse;
use Itau\API\Vencimento\Vencimento;

/**
 * Class Itau
 *
 * @package Itau\API
 */
class Itau
{

    private string $client_id;
    private string $client_secret;
    private string $certificate;
    private string $certificateKey;
    private $environment;
    private $authorizationToken;

    private $debug = false;

    public function __construct(string $client_id, string $client_secret, string $certificate, string $certificateKey)
    {
        $this->setClientId($client_id);
        $this->setClientSecret($client_secret);
        $this->setCertificate($certificate);
        $this->setCertificateKey($certificateKey);
        $this->setEnvironment(Environment::production());
    }

    /**
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     *
     * @param string $client_id
     */
    public function setClientId($client_id)
    {
        $this->client_id = (string) $client_id;

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     *
     * @param mixed $client_secret
     */
    public function setClientSecret($client_secret)
    {
        $this->client_secret = (string) $client_secret;

        return $this;
    }

    public function getCertificate()
    {
        return $this->certificate;
    }

    public function setCertificate($certificate)
    {
        $this->certificate = (string) $certificate;

        return $this;
    }

    public function getCertificateKey()
    {
        return $this->certificateKey;
    }

    public function setCertificateKey($certificateKey)
    {
        $this->certificateKey = (string) $certificateKey;

        return $this;
    }

    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    public function setEnvironment(Environment $environment): self
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getAuthorizationToken()
    {
        return $this->authorizationToken;
    }

    /**
     *
     * @param mixed $authorizationToken
     */
    public function setAuthorizationToken($authorizationToken)
    {
        $this->authorizationToken = (string) $authorizationToken;

        return $this;
    }

    /**
     *
     * @return bool|null
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     *
     * @param bool|null $debug
     */
    public function setDebug($debug = false)
    {
        $this->debug = $debug;

        return $this;
    }

    public function pix(Pix $pix): PixResponse
    {
        $pixResponse = new PixResponse();
        try{
            if ($this->debug) {
                print $pix->toJSON();
            }

            $request = new Request($this);
            $response = $request->post($this, "{$this->getEnvironment()->getApiPixUrl()}/cob", $pix->toJSON());
           
            
            // Add fields do not return in response
            $pixResponse->mapperJson($pix->toArray());
            // Add response fields
            $pixResponse->mapperJson($response);
            $pixResponse->setStatus(BaseResponse::STATUS_CONFIRMED);
            return $pixResponse;

        } catch (\Exception $e) {
            return $this->generateErrorResponse($pixResponse, $e);
        }
    }

    public function boleCode(BoleCode $boleCode): BoleCodeResponse
    {
        $boleCodeResponse = new BoleCodeResponse();
        try{
            if ($this->debug) {
                print $boleCode->toJSON();
            }

            $request = new Request($this);
            $response = $request->post($this, "{$this->getEnvironment()->getApiBoleCodeUrl()}/boletos_pix", $boleCode->toJSON());
           
            // Add fields do not return in response
            $boleCodeResponse->mapperJson($boleCode->toArray());
            // Add response fields
            $boleCodeResponse->mapperJson($response);
            $boleCodeResponse->setStatus(BaseResponse::STATUS_CONFIRMED);
            return $boleCodeResponse;

        } catch (\Exception $e) {
            return $this->generateErrorResponse($boleCodeResponse, $e);
        }
    }

    public function alterarVencimentoBoleto($agencia, $contaComDigito, $carteira, $nossoNumero, Vencimento $vencimento)
    {
        $boletoResponse = new BoletoResponse();

        $path = str_pad($agencia, 4, '0', STR_PAD_LEFT).str_pad($contaComDigito, 8, '0', STR_PAD_LEFT).str_pad($carteira, 3, '0', STR_PAD_LEFT).str_pad($nossoNumero, 8, '0', STR_PAD_LEFT);
        $request = new Request($this);
        $response = $request->patch($this, "{$this->getEnvironment()->getApiBoletoUrl()}/boletos/{$path}/data_vencimento", $vencimento->toJSON());
        $boletoResponse->mapperJson($response);

        return $boletoResponse;
    }

    public function consultarBoleto($id_beneficiario, $nossoNumero)
    {
        $boletoResponse = new BoletoResponse();

        // $id_beneficiario = intval(str_pad($agencia, 4, '0', STR_PAD_LEFT).str_pad($contaComDigito, 8, '0', STR_PAD_LEFT));
        $nosso_numero = str_pad($nossoNumero, 8, '0', STR_PAD_LEFT);
        $request = new Request($this);
        $response = $request->get($this, "{$this->getEnvironment()->getApiBoletoConsultaUrl()}/boletos?id_beneficiario={$id_beneficiario}");
        // Add response fields
        $boletoResponse->mapperJson($response);

        return $boletoResponse;
    }

    public function baixarBoleto($agencia, $contaComDigito, $carteira, $nossoNumero)
    {
        $boletoResponse = new BoletoResponse();

        $path = str_pad($agencia, 4, '0', STR_PAD_LEFT).str_pad($contaComDigito, 8, '0', STR_PAD_LEFT).str_pad($carteira, 3, '0', STR_PAD_LEFT).str_pad($nossoNumero, 8, '0', STR_PAD_LEFT);
        $request = new Request($this);
        $response = $request->patch($this, "{$this->getEnvironment()->getApiBoletoUrl()}/boletos/{$path}/baixa", '{}');
        // Add response fields
        $boletoResponse->mapperJson($response);

        return $boletoResponse;
    }

    private function generateErrorResponse(BaseResponse $baseResponse, $e)
    {
        $baseResponse->mapperJson(json_decode($e->getMessage(), true));
        
        if (empty($baseResponse->getStatus())) {
            $baseResponse->setStatus(BaseResponse::STATUS_ERROR);
        }
        
        return $baseResponse;
    }
}
