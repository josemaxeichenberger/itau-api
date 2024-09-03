<?php
session_start();

function my_autoload($pClassName)
{
    include('../Class' . "/" . $pClassName . ".class.php");
}
spl_autoload_register("my_autoload");


if (isset($_SESSION['accessToken']) && isset($_POST['type'])) {
    // Configuração da URL com o access_token
    $accessToken = $_SESSION['accessToken'];
    $url = "https://app.clicksign.com/api/v1/signers?access_token={$accessToken}";

    // Dados do corpo da solicitação
    $signerData = [
        'signer' => [
            'email' => $_SESSION["email_resgiter"],
            'phone_number' => $_SESSION['telefone'],
            'auths' => [$_POST['type']],
            'name' => $_SESSION['nome_representante'],
            // 'documentation' => $_SESSION['cpf'],
            'birthday' => '',
            'has_documentation' => false,
            'selfie_enabled' => false,
            'handwritten_enabled' => false,
            'location_required_enabled' => false,
            'official_document_enabled' => false,
            'liveness_enabled' => false,
            'facial_biometrics_enabled' => false,
        ],
    ];

    // Converte os dados para formato JSON
    $jsonData = json_encode($signerData);

    // Inicializa a sessão cURL
    $ch = curl_init($url);

    // Configurações da requisição cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retorna a resposta como string
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

    // Executa a requisição e obtém a resposta
    $response = curl_exec($ch);

    // Obtenha o código HTTP da resposta
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Verifique se houve algum erro na requisição
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        echo json_encode(["error" => $error, "httpCode" => $httpCode]);
        curl_close($ch);
        return;
    }

    // Se o código HTTP não for bem-sucedido, não tente processar a resposta como JSON
    if ($httpCode < 200 || $httpCode >= 300) {
        echo json_encode(["error" => "Código HTTP não bem-sucedido: $httpCode", "response" => $response]);
        curl_close($ch);
        return;
    }

    // Decodificar a resposta JSON para um array associativo
    $responseArray = json_decode($response, true);

    // Verifique se houve erro na decodificação do JSON
    if ($responseArray === null) {
        echo json_encode(["error" => "Erro ao decodificar JSON"]);
        curl_close($ch);
        return;
    }

    // Caminho para o arquivo onde os dados serão salvos
    $filePath = 'file.json';

    // Salvar os dados JSON no arquivo
    $result = file_put_contents($filePath, json_encode($responseArray, JSON_PRETTY_PRINT));

    // Verifique se os dados foram salvos com sucesso
    if ($result === false) {
         json_encode(["error" => "Ocorreu um erro ao salvar os dados em file.json"]);
    } else {
        $signer = $responseArray['signer'];
        $key = $signer['key'];
        // $email = $signer['email'];
        $auths = $signer['auths'][0];
        // $delivery = $signer['delivery'];
        // $name = $signer['name'];
        // $documentation = $signer['documentation'];
        // $selfie_enabled = $signer['selfie_enabled'];
        // $handwritten_enabled = $signer['handwritten_enabled'];
        // $birthday = $signer['birthday'];
        // $phone_number = $signer['phone_number'];
        // $has_documentation = $signer['has_documentation'];
        // $created_at = $signer['created_at'];
        // $updated_at = $signer['updated_at'];
        // $official_document_enabled = $signer['official_document_enabled'];
        // $liveness_enabled = $signer['liveness_enabled'];
        // $facial_biometrics_enabled = $signer['facial_biometrics_enabled'];
        // $communicate_by = $signer['communicate_by'];
        // $location_required_enabled = $signer['location_required_enabled'];
        $assinante = new assinante();
        $assinante->Delete();
        $new_assinante = new assinante();
        $new_assinante->setAuths($auths);
        $new_assinante->setClicksign_key($key);
        $res = $new_assinante->Insert();

        // echo json_encode(["message" => "Os dados foram salvos com sucesso", "response" =>$signer]);
        echo json_encode(["message" => "Os dados foram salvos com sucesso", "response" => $responseArray]);

    }

    // Encerra a sessão cURL
    curl_close($ch);
}


