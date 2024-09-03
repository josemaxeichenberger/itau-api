<?php

require __DIR__ . "/vendor/autoload.php";

use Itau\API\Itau;

try{
    $itau = new Itau(
        "1a5796ef-ec1e-454a-a442-8bf4646e203f",
        "5e6ca3b1-4060-4e6c-9201-c55a6ff833ec",
        "certificado.cert",
        "ARQUIVO_CHAVE_PRIVADA.key"
    );
  
    $nossoNumero ='1234567890';
    #$itau->setDebug(true);
    $id_beneficiario ='086200190857';
    
    $response = $itau->consultarBoleto($id_beneficiario, $nossoNumero);
    
    if($response->getStatusCode() == 200){
        var_dump($response);
        // Sucesso quando retornado o status code 204
        echo "Boleto consultado com sucesso!";
    } elseif ($response->getStatusCode() == 404) {
        // Boleto não encontrado
        echo "Boleto não encontrado.";
    } else {
        // Erro ao consultar boleto
        echo "Erro ao consultar boleto: " . $response->getStatusCode();
    }
} catch(Exception $e){
    // Erro ao consultar boleto
    echo "Erro ao consultar boleto: " . $e->getMessage();
}