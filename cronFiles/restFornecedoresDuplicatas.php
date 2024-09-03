<?php
include('../Class/Config.php');
include('../Class/instalacoes.class.php');
include('../Class/execucaoCron.class.php');
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
$instalacoes = new instalacoes();
$instalacoes->setDominio1(DOMINIO);
$DM = $instalacoes->VeificaDominio1();

$anoAtual = date('Y');
$dataCorte = date('Y-m-d', strtotime($dataAtual . ' +7 days'));
$new_content = '';
$anoFuturo = $anoAtual + 5;
$url = 'https://csw.elian.com.br:5556/api/financeiro/v10/contasPagar?situacao=0&dataVencimentoIni=' . $anoAtual . '-01-01&dataVencimentoFim=' . $anoFuturo . '-12-31&paginacao=2000';
while (true) {
    $headers = array(
        'accept: application/json',
        'empresa: 1',
        'Authorization: eyJhbGciOiJFUzI1NiJ9.eyJpc3MiOiJhcGkiLCJhdWQiOiJhcGkiLCJleHAiOjE4Njg3OTI0MzksInN1YiI6Imxhd3NlYy5lIiwiY3N3VG9rZW4iOiJCcDhDcTNaSiIsImRiTmFtZVNwYWNlIjoiY29uc2lzdGVtIn0.RW0ijPcx_dcUBiqrEz2leI19x22aXgB3fGcsPaxcRs0hQhCqMiJJ-Yn9hTbn18SHl7wK4DicW39ZC_oj2eqS8A'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Erro na requisição cURL: ' . curl_error($ch);
        $www = curl_error($ch);
        $execucaoCron = new execucaoCron();
        $execucaoCron->setTipo('Duplicatas Fornecedor');
        $execucaoCron->setCurl($www);
        $execucaoCron->setData(date('Y-m-d H:i:s'));
        $execucaoCron->Insert();
    }
    curl_close($ch);
    $data = json_decode($response, true);
    if ($data === null) {
        echo 'Erro ao decodificar a resposta JSON.';
    } else {
        $www = 'curl -X GET \
        -H "accept: application/json" \
        -H "empresa: 1" \
        -H "Authorization: eyJhbGciOiJFUzI1NiJ9.eyJpc3MiOiJhcGkiLCJhdWQiOiJhcGkiLCJleHAiOjE4Njg3OTI0MzksInN1YiI6Imxhd3NlYy5lIiwiY3N3VG9rZW4iOiJCcDhDcTNaSiIsImRiTmFtZVNwYWNlIjoiY29uc2lzdGVtIn0.RW0ijPcx_dcUBiqrEz2leI19x22aXgB3fGcsPaxcRs0hQhCqMiJJ-Yn9hTbn18SHl7wK4DicW39ZC_oj2eqS8A" \
        "' . $url . '"
      ';
        $execucaoCron = new execucaoCron();
        $execucaoCron->setTipo('Duplicatas Fornecedor');
        $execucaoCron->setCurl($www);
        $execucaoCron->setData(date('Y-m-d H:i:s'));
        $execucaoCron->Insert();
        // $url = 'https://csw.elian.com.br:5556/api/financeiro/v10/contasPagar?continuationToken=' . $data['continuationToken'];
        $url = 'https://csw.elian.com.br:5556/api/financeiro/v10/contasPagar?situacao=0&dataVencimentoIni=' . $anoAtual . '-01-01&dataVencimentoFim=' . $anoFuturo . '-12-31&paginacao=2000&continuationToken=' . $data['continuationToken'];

        foreach ($data as $item) {
            foreach ($item as $r) {
                if (strtotime($r['dataVencimento']) >= strtotime($dataCorte)) {

                    $fornecedorCNPJ =  $r['dadosCustomizados'][0]["valor"];
                    $possuiNF =  $r['dadosCustomizados'][1]["valor"];
                    $notaTeste = $r['numDocumento'];
                    // if ($possuiNF == 1) {
                    $stmtCheckExistence1 = $pdo->prepare('SELECT COUNT(*) FROM fornecedores WHERE cnpj = ?');
                    $stmtCheckExistence1->execute([$fornecedorCNPJ]);
                    $countExistence1 = $stmtCheckExistence1->fetchColumn();
                    $DADOSFORNECEDOR = $pdo->prepare('SELECT * FROM fornecedores WHERE cnpj = ?');
                    $DADOSFORNECEDOR->execute([$fornecedorCNPJ]);
                    $DADOSFORNECEDOR = $DADOSFORNECEDOR->fetch();
                    if ($countExistence1 > 0) {
                        $valor = str_replace(['.', ','], ['', '.'], $r['valorDocumento']);
                        $numDocumento = $r['numDocumento'];
                        if (strpos($numDocumento, '/') !== false) {
                            // Se já contém '/', não faz nada
                        } else {
                            // Se não contém '/', adiciona '/1' ao final da string
                            $numDocumento .= '/1';
                        }
                        $r['numDocumento'] = $numDocumento;
                        $stmtCheckExistence = $pdo->prepare('SELECT * FROM `operacoes` WHERE `cnpj` =? and `nota` =? and tipo = ?');
                        $stmtCheckExistence->execute([$fornecedorCNPJ,  $r['numDocumento'], 'fornecedor']);
                        $countExistence = $stmtCheckExistence->fetchColumn();

                        if ($countExistence > 0) {
                            echo json_encode(['error' => 'Nota já existe', 'Nota' =>  $r['numDocumento']]) . PHP_EOL;
                        } else {
                            // Supomos que $r['numDocumento'] é a string que queremos verificar
                            $numDocumento = $r['numDocumento'];

                            // Verifica se a string contém o caractere '/'
                            if (strpos($numDocumento, '/') !== false) {
                                // Se já contém '/', não faz nada
                            } else {
                                // Se não contém '/', adiciona '/1' ao final da string
                                $numDocumento .= '/1';
                            }

                            // Atualize o valor em $r['numDocumento']
                            $r['numDocumento'] = $numDocumento;

                            $formattedDate = $r['dataVencimento']; //date('Y-m-d', strtotime($r['dataVencimento'])).PHP_EOL;  
                            // $originalFormat = 'Ymd';
                            // $desiredFormat = 'Y-m-d';
                            //  echo    $dateTime = DateTime::createFromFormat($originalFormat, $dateString);
                            // if ($dateTime instanceof DateTime && $dateTime->format($originalFormat) === $dateString) {
                            // $formattedDate = $dateTime->format($desiredFormat);
                            $stmt = $pdo->prepare('INSERT INTO `operacoes`( `cnpj`, `nota`, `vencimento`, `valor`, `dataOPE`, `tipo`, `status`, `clicksign_key`, `confirmada`) VALUES (?,?,?,?,?,?,?,?,?)');
                            $res =  $stmt->execute([$fornecedorCNPJ,   $r['numDocumento'], $formattedDate, $valor, $formattedDate, 'fornecedor', 0, NULL, 0]);
                            ///////////////////////////////////////
                            $dt = $r['dataVencimento'];
                            $nf = explode('/', $r['numDocumento']);
                            $juros = (floatval($DADOSFORNECEDOR['juros']) === 0) ? 2.5 : floatval($DADOSFORNECEDOR['juros']);
                            $ano = date('Y'); // Obtém o ano atual
                            $mes = date('n'); // Obtém o mês atual sem zero à esquerda
                            $dataVencimento =  $r['dataVencimento'];
                            // Obter o número de dias no mês atual
                            $diasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
                            $diaSem = intval(date('N', strtotime($dt)));
                            $diasAd = 0;

                            switch ($diaSem) {
                                case 0:
                                    $diasAd += 2;
                                    break;
                                case 5:
                                    $diasAd += 3;
                                    break;
                                case 6:
                                    $diasAd += 3;
                                    break;
                            }
                            $dias = floor((strtotime($dt) - strtotime(date('Y-m-d'))) / (60 * 60 * 24)) + $diasAd;

                            $jurosDia = number_format($juros / $diasMes, 2);

                            $valorDesconto = number_format((floatval($valor) * ($jurosDia / 100)) * $dias, 2);


                            $trHTML = '<thead>
                                              <tr style="background-color:#e0e0e0;color:#000;text-align:center;font-weight:bold;text-transform:uppercase">
                                                  <td style="padding:10px; white-space: nowrap;text-align:center;">Nota Fiscal</td>
                                                  <td style="padding:10px; white-space: nowrap;text-align:center;">Parcela</td>
                                                  <td style="padding:10px; white-space: nowrap;text-align:center;">A receber</td>
                                                  <td style="padding:10px; white-space: nowrap;text-align:center;">Vencimento</td>
                                                  <td style="padding:10px; white-space: nowrap;text-align:center;">Juros/mês</td>
                                                  <td style="padding:10px; white-space: nowrap;text-align:center;">Dias</td>
                                                  <td style="padding:10px; white-space: nowrap;text-align:center;">Descontos</td>
                                              </tr>
                                            </thead>
                                            <tbody>
      
                                            <tr style="background-color:#fff;color:#000;text-align:left;border:0px solid white">                                   
                                              <td  style="padding:10px">
                                                  
                                                  <span class="text-dark fw-bolder d-block fs-5">' . $nf[0] . '</span>
                                              </td>
                                              <td  style="padding:10px">
                                                  
                                                  <span class="text-dark fw-bolder d-block fs-5">' . $nf[1] . '</span>
                                              </td>
                                              <td  style="padding:10px">
                                                  
                                                  <span class="text-dark fw-bolder d-block fs-5">' . number_format($valor, 2) . '</span>
                                              </td>
                                              <td  style="padding:10px">
                                                  
                                                  <span class="text-dark fw-bolder d-block fs-5">' . date('d/m/Y', strtotime($r['dataVencimento'])) . '</span>
                                              </td>
                                              <td  style="padding:10px">
                                                  
                                                  <span class="text-dark fw-bolder d-block fs-5">' . $juros . '%</span>
                                              </td>
                                              <td  style="padding:10px">
                                                  
                                                  <span class="text-dark fw-bolder d-block fs-5">' . $dias . '</span>
                                              </td>
                                              <td  style="padding:10px">
                                                  
                                                  <span class="text-dark fw-bolder d-block fs-5">' . number_format((floatval($valor) * ($jurosDia / 100)) * $dias, 2) . '</span>
                                              </td>
                                              
                                              </tr>
                                              </tbody>
      
                                          ';

                            $VAR_NOME = $DADOSFORNECEDOR['razao'];
                            $LINK     = 'https://' . DOMINIO;
                            if ($DADOSFORNECEDOR['tipo'] == 'fornecedor') {
                                $template = file_get_contents('../Class/fornecedores/aguardando-recebiveis.html');
                            }
                            if ($DADOSFORNECEDOR['tipo'] == 'cliente') {
                                $template = file_get_contents('../Class/clientes/aguardando-recebiveis.html');
                            }
                            $ANCORA   = $DM['razao'];
                            $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
                            $template = str_replace('{ANCORA}', $ANCORA, $template);
                            $template = str_replace('{LINK}', $LINK, $template);
                            $template = str_replace('{TABELA}',  $trHTML, $template);
                            $recipient_email = $DADOSFORNECEDOR['email'];
                            $subject         = 'Aguardando Recebíveis';
                            $body            =  $template;
                            $status          = 'pendente';
                            $type            = 'Disponíveis';
                            $created_at      = date('Y-m-d H:i:s');
                            $sent_at         = null;
                            $dataAtual = strtotime('today');
                            if (strtotime($dataVencimento) > $dataAtual) {
                                $emails = $pdo->prepare('INSERT INTO `emails`(`recipient_email`, `subject`, `body`, `status`, `type`, `created_at`, `sent_at`) VALUES (?,?,?,?,?,?,?)');
                                $emails->execute([$recipient_email,  $subject, $body, $status, $type, $created_at, $sent_at]);
                                /////////////////////////////////////
                            }
                            echo json_encode(['success' => true, 'message' => 'Nota' .  $r['numDocumento']  . ' adicionado com sucesso, Vencimento dia ' . $formattedDate]) . PHP_EOL;
                        }
                        // else {
                        //     echo json_encode(['error' => 'duplicataVencimento Null', 'Data' => $formattedDate, 'Page' => $page]);
                        // }
                    }
                    // } else {
                    //     echo 'CNPJ NAO ENCONTRADO ' . $fornecedorCNPJ . ';' . PHP_EOL;
                    // }
                }
            }
        }
    }
    if (!$data['continuationToken']) {
        echo 'continuationToken= ' . $data['continuationToken'] . PHP_EOL;
        exit;
    }
    $new_content = $data['continuationToken'];



    echo "Ultimo token " .  $new_content . PHP_EOL;
}
