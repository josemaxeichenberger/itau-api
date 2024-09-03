<?php
date_default_timezone_set('America/Sao_Paulo');

include('../Class/Config.php');
include('../Class/instalacoes.class.php');
include('../Class/execucaoCron.class.php');
$protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$dominioComProtocolo = $protocolo . '://' . $_SERVER['HTTP_HOST'];
$instalacoes = new instalacoes();
$instalacoes->setDominio1(DOMINIO);
$DM = $instalacoes->VeificaDominio1();

$dbHost = DB_HOST; // MySQL Hostname
$dbUser = DB_USER; // MySQL Username
$dbPass = DB_PASS; // MySQL Password
$dbName = DB_NAME; // MySQL Database Name
/* Change the database character set to something that supports the language you'll
   be using. Example, set this to utf16 if you use Chinese or Vietnamese characters */
$charset = 'utf8mb4';
/* Set this if you use a non-standard MySQL port. */
$dbPort = 3306;

/* Domain of cookie (99.99% chance you don't need to edit this at all) */
define('COOKIE_DOMAIN', '');
try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=$charset;port=$dbPort", $dbUser, $dbPass);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // You can now use the $pdo object to perform database operations
    // For example, you can run queries like $pdo->query('SELECT * FROM your_table');

} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
}
// URL do endpoint
$url = 'https://cswh2.elian.com.br:5556/api/cadastrosgerais/v10/fornecedor?situacao=1&paginacao=2000';

function registrarLog($mensagem)
{
    // Caminho do arquivo de log
    $caminhoArquivoLog = 'Fornecedoreslog.txt';

    // Adiciona data e hora à mensagem
    $mensagemFormatada = date('Y-m-d H:i:s') . ' - ' . $mensagem . PHP_EOL;

    // Registra a mensagem no arquivo de log
    error_log($mensagemFormatada, 3, $caminhoArquivoLog);
}
registrarLog("Executado dia: " . date('d/m/Y H:i:s'));
// Função para verificar se uma string é um JSON válido
function isJson($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}
while (true) {
    // Headers da requisição
    $headers = array(
        'accept: application/json',
        'empresa:1',
        'Authorization: eyJhbGciOiJFUzI1NiJ9.eyJpc3MiOiJhcGkiLCJhdWQiOiJhcGkiLCJleHAiOjE4Njg3OTI0MzksInN1YiI6Imxhd3NlYy5lIiwiY3N3VG9rZW4iOiJCcDhDcTNaSiIsImRiTmFtZVNwYWNlIjoiY29uc2lzdGVtIn0.RW0ijPcx_dcUBiqrEz2leI19x22aXgB3fGcsPaxcRs0hQhCqMiJJ-Yn9hTbn18SHl7wK4DicW39ZC_oj2eqS8A'
    );

    // Inicialização da sessão cURL
    $ch = curl_init();

    // Configurações da requisição
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execução da requisição
    $response = curl_exec($ch);
    // Verifica erros
    if (curl_errno($ch)) {
        echo 'Erro na requisição cURL: ' . curl_error($ch);
        $www =curl_error($ch);
        $execucaoCron = new execucaoCron();
        $execucaoCron->setTipo('Fornecedor');
        $execucaoCron->setCurl($www);
        $execucaoCron->setData(date('Y-m-d H:i:s'));
        $execucaoCron->Insert();
    }

    // Fecha a sessão cURL
    curl_close($ch);

    if (!empty($response)) {

        // Verifica se a resposta é um JSON válido
        if (isJson($response)) {
            $www ='curl -X GET \
            -H "accept: application/json" \
            -H "empresa: 1" \
            -H "Authorization: eyJhbGciOiJFUzI1NiJ9.eyJpc3MiOiJhcGkiLCJhdWQiOiJhcGkiLCJleHAiOjE4Njg3OTI0MzksInN1YiI6Imxhd3NlYy5lIiwiY3N3VG9rZW4iOiJCcDhDcTNaSiIsImRiTmFtZVNwYWNlIjoiY29uc2lzdGVtIn0.RW0ijPcx_dcUBiqrEz2leI19x22aXgB3fGcsPaxcRs0hQhCqMiJJ-Yn9hTbn18SHl7wK4DicW39ZC_oj2eqS8A" \
            "'.$url.'"
          ';
            $execucaoCron = new execucaoCron();
            $execucaoCron->setTipo('Fornecedor');
            $execucaoCron->setCurl($www);
            $execucaoCron->setData(date('Y-m-d H:i:s'));
            $execucaoCron->Insert();
            // Decodifica a resposta JSON
            $data = json_decode($response, true);
            $url = 'https://cswh2.elian.com.br:5556/api/cadastrosgerais/v10/fornecedor?situacao=1&paginacao=2000&continuationToken=' . $data['continuationToken'];

            foreach ($data['data'] as $input_data) {

                if ($input_data['codGrupo'] == 50) {
                    switch ($input_data['item']) {
                        case '1':
                        case '2':
                        case '4':
                        case '5':
                        case '7':
                        case '10':
                        case '11':
                        case '13':
                        case '15':
                        case '16':
                        case '17':
                        case '19':
                            $tipo = 'fornecedor';
                            $fornecedorRazao = $input_data['nome'];
                            $fornecedorCNPJ = $input_data['cpfCnpj'];
                            $fornecedorEmail = $input_data['email'];
                            if ($fornecedorEmail  == '') {
                                $fornecedorEmail = $input_data['codFornecedor'] . '@alteraremail.teste';
                            }
                            $fornecedorTelefone =$telefone = preg_replace('/[\x00-\x1F\x7F\xA0\xAD\x{200B}]+/u', '', 
                            $input_data['telefone']);
                            // $fornecedorTaxaJuros =  str_replace([' ', ','], '', $input_data['fornecedorTaxaJuros']);
                            $fornecedorLimiteRaw = 0.00;
                            $fornecedorLimite = number_format(floatval($fornecedorLimiteRaw), 2, '', '.');
                            $fornecedorTAC = 100.00; //!empty($input_data['fornecedorTAC']) ? $input_data['fornecedorTAC'] : 0;
                            $fornecedorTED = 20.00; //!empty($input_data['fornecedorTED']) ? $input_data['fornecedorTED'] : 0;
                            $fornecedorCustoBoleto  = 5.00; //preg_replace("/[^0-9]/", "", $fornecedorCustoBoleto);
                            $fornecedorTaxaJuros  = 4.00; //preg_replace("/[^0-9]/", "", $fornecedorTaxaJuros);
                            // Verifique se o fornecedor já existe pelo CNPJ
                            $stmtCheckExistence = $pdo->prepare('SELECT COUNT(*) FROM fornecedores WHERE cnpj = ?');
                            $stmtCheckExistence->execute([$fornecedorCNPJ]);
                            $countExistence = $stmtCheckExistence->fetchColumn();

                            if ($countExistence > 0) {
                                echo json_encode(['error' => 'Fornecedor com o mesmo CNPJ já existe']);
                            } else {
                                $ANCORA   = $DM['razao'];
                                $VAR_NOME = $fornecedorRazao;
                                $LINK     =  'https://'.DOMINIO;
                                $template = file_get_contents('../Class/fornecedores/law-chain.html');
                                $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
                                $template = str_replace('{ANCORA}', $ANCORA, $template);
                                $template = str_replace('{LINK}', $LINK, $template);
                                $template = str_replace('{VAR_PARAM1}',  $fornecedorEmail, $template);
                                $template = str_replace('{VAR_PARAM2}',  $fornecedorCNPJ, $template);
                                $recipient_email = $fornecedorEmail;
                                $subject         = 'Conheça a LAW Smart Chain';
                                $body            =  $template;
                                $status          = 'pendente';
                                $type            = 'SmartChain';
                                $created_at      = date('Y-m-d H:i:s');
                                $sent_at         = null;
                                $stmt = $pdo->prepare('INSERT INTO `emails`(`recipient_email`, `subject`, `body`, `status`, `type`, `created_at`, `sent_at`) VALUES (?,?,?,?,?,?,?)');
                                //Descomentar Assim que form pra producao
                                $stmt->execute([$recipient_email,  $subject, $body, $status, $type, $created_at, $sent_at]);
        
                                // Inserir no banco de dados
                                $stmt = $pdo->prepare('INSERT INTO fornecedores (razao, cnpj,tipo, email, telefone, juros, limite, boleto, tac, ted,status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)');
                                $stmt->execute([$fornecedorRazao,  $fornecedorCNPJ, $tipo, $fornecedorEmail, $fornecedorTelefone, $fornecedorTaxaJuros, $fornecedorLimite, $fornecedorCustoBoleto, $fornecedorTAC, $fornecedorTED,1]);
                                
                                echo json_encode(['success' => true,  'message' => 'Fornecedor adicionado com sucesso']);
                            }
                            break;
                    }
                }
            }

            // Verifica se há mais páginas disponíveis
            if (empty($data['data'])) {
                break; // Sai do loop se não houver mais dados
            }
        } else {
            echo 'Erro: A resposta da página  não é um JSON válido.';
            exit;
        }
    } else {
        echo 'Erro: A resposta da página está vazia.';
        exit;
    }
}
