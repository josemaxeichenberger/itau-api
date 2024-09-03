<?php

require __DIR__ . "/vendor/autoload.php";

use Itau\API\Itau;
use Itau\API\BoleCode\BoleCode;

try{
    $itau = new Itau(
        "1a5796ef-ec1e-454a-a442-8bf4646e203f",
        "5e6ca3b1-4060-4e6c-9201-c55a6ff833ec",
        "certificado.cert",
        "ARQUIVO_CHAVE_PRIVADA.key"
    );

    #Descomente este trecho caso queira imprimir na tela o JSON da requisição
    // $itau->setDebug(true);

    $modo =BoleCode::ETAPA_TESTE; // Modo de teste
    $agencia = '0862'; // Agência
    $conta = '19085'; // Conta
    $contaDV = '7'; // Dígito verificador da conta
    $valor = 100.00; // Valor do boleto
    $tipoBoleto = '01' ; // Tipo de boleto (DM = Duplicata Mercantil)
    $numeroDocumento = '1234567890'; // Número do documento
    $nome = 'João da Silva'; // Nome do beneficiário
    $tipoPessoa = 'F'; // Tipo de pessoa (F = Física)
    $documento = '12345678909'; // Documento do beneficiário (CPF ou CNPJ)
    $endereco = 'Rua dos Testes, 123'; // Endereço do beneficiário
    $numero = '123'; // Número do endereço
    $complemento = 'Apto 101'; // Complemento do endereço
    $bairro = 'Bairro dos Testes'; // Bairro do endereço
    $cidade = 'Cidade dos Testes'; // Cidade do endereço
    $siglaEstado = 'SP'; // Sigla do estado do endereço
    $cep = '12345678'; // CEP do endereço
    $nossoNumero = '12345678'; // Nosso número do boleto
    $vencimento = '2024-09-03'; // Data de vencimento do boleto
    $chavePix = '32527198000152'; // Chave Pix do beneficiário
    $tipoMulta = '02'; // Tipo de multa (P = Percentual)
    $percentualMulta = 2.00; // Percentual de multa
    $tipoJuros = '05'; // Tipo de juros (P = Percentual)
    $percentualJuros = 1.00; // Percentual de juros
    
    $boleCode = new BoleCode(
        $modo, $agencia, $conta, $contaDV, $valor, $tipoBoleto, $numeroDocumento, $nome, $tipoPessoa,
        $documento, $endereco, $numero, $complemento, $bairro, $cidade, $siglaEstado, $cep, $nossoNumero,
        $vencimento, $chavePix, $tipoMulta, $percentualMulta, $tipoJuros, $percentualJuros
    );
    $response = $itau->boleCode($boleCode);
    // var_dump($response);

    #Caso tenha sucesso, conseguirá recuperar o TXID dessa maneira
    $response->getTxid();

    #PIXCOPIA E COLA - Em caso de sucesso
    $response->getPixCopiaECola();
    

} catch(Exception $e){
    return $e->getMessage();

}