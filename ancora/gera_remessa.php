<?php

  session_start();
  if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'ancora') {
    header("Location: ../pagina_de_acesso_nao_autorizado.php");
    exit();
  }
  require_once('../Class/Config.php');
  $con = new mysqli(DB_HOST, DB_USER,DB_PASS, DB_NAME);

	function prepared_query($mysqli, $sql, $params, $types = "") {    
    $stmt = $mysqli->prepare($sql);
		if (sizeof($params) > 0) {
			$types = $types ?: str_repeat("s", count($params));
			$stmt->bind_param($types, ...$params);
		}    
    $stmt->execute();
    return $stmt;
	}

  function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
  }
  $entityBody = file_get_contents('php://input');

  
  $sql  = "SELECT COALESCE(MAX(remessa),0) AS remessa FROM `boletos`";
  $stmt = prepared_query($con, $sql, [], '');
  $res  = $stmt->get_result()->fetch_row();
  $stmt->close();

  $remessa = floatval($res[0]) + 1;
  if ($entityBody) {
      echo json_encode(str_pad($remessa, 6, '0', STR_PAD_LEFT).'.REM');
      die();
  }

  $nome    = '../remessas/CB'.str_pad($remessa, 6, '0', STR_PAD_LEFT).'.REM';
  $arquivo = fopen($nome, 'w+');
  $i = 1; //contador registros

//0
  $header  = '0';                                 //tipo de registro
//1
  $header .= '1';                                 //operação
//REMESSA
  $header .= 'REMESSA';                           //literal remessa
//01
  $header .= '01';                                //codigo do serviço
//COBRANCA       
  $header .= str_pad('COBRANCA', 15);             //literal do serviço
//0862
  $header .= '0862';                              //agencia
//00
  $header .= '00';                                //zeros 2x
//99570
  $header .= '55792';                             //conta
//1
  $header .= '3';                                 //dac
//        
  $header .= str_repeat(' ', 8);                  //brancos 8x
//LAWSEC S/A                    
  $header .= str_pad('FINTEX SECURITIZADORA LTDA', 30);           //nome da empresa
//341
  $header .= '341';                               //codigo do banco
//ITAU           
  $header .= str_pad('ITAU', 15);                 //nome do banco
//031122
  $header .= date('dmy');                         //data geração
//                                                                                                                                                                                                                                                                                                      
  $header .= str_repeat(' ', 294);                //brancos 294x
//000001  
  $header .= str_pad($i++, 6, '0', STR_PAD_LEFT); //nº sequencial
  $header .= chr(13).chr(10);
  // $linha .= chr(13).chr(10);
  
  fwrite($arquivo, $header);

  $sql = "SELECT * FROM boletos WHERE status=? and operacao not in (select operacao from antecipadasDetalhes) and operacao in (select id from operacoes where status = 5)";
  $stmt = prepared_query($con, $sql, ['P'], 's');
  $boletos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close();

  $sql = "SELECT * FROM boletos WHERE status=? and operacao in (select operacao from antecipadasDetalhes) and operacao in (select id from operacoes where status = 5)";
  $stmt = prepared_query($con, $sql, ['P'], 's');
  $boletos_antecipadas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close();

  foreach ($boletos_antecipadas as $boleto_antecipada) {
    $cnpj = array();
    $cnpj['cnpj'] = "82698085000198";
    // $cnpj['razao'] = "LAWSEC S/A";
    $cnpj['razao'] = "GRUPO ELIAN";
    $cnpj['numero'] = '215';
    $cnpj['rua'] = 'Manoel Francisco da Costa';
    $cnpj['bairro'] = 'Bairro Vieiras';
    $cnpj['cidade'] = 'Jaraguá do Sul';
    $cnpj['estado'] = 'SC'; 
    $cnpj['cep'] = '89257-000';


    
    //reg 1
    //1
    $linha =  '1';                                                    //tipo de registro                1
    //04
    $linha .= '04';                                                   //codigo de inscrição             3
    //13476058000158
    $linha .= $cnpj['cnpj'];                                    //nº inscrição empresa           17
    //0862
    $linha .= '0862';                                                 //agencia                        21
    //00
    $linha .= '00';                                                   //zeros 2x                       23
    //99570
    $linha .= '55792';                                                //conta                          28
    //1
    $linha .= '3';                                                    //dac                            29 
    //    
    $linha .= str_repeat(' ', 4);                                     //brancos 4x                     33
    //0000
    $linha .= '0000';                                                 //instrução/alegação             37
    //4138                     
    $linha .= str_pad($boleto_antecipada['operacao'], 25);                       //uso da empresa (ID operação)   62
    //00000017
    $linha .= str_pad($boleto_antecipada['nosso_numero'], 8, '0', STR_PAD_LEFT); //nosso numero                   70
    //0000000000000
    $linha .= str_repeat('0', 13);                                    //qtde moeda                     83
    //109
    $linha .= '109';                                                  //nº da carteira                 86
    //                     
    $linha .= str_repeat(' ', 21);                                    //brancos 21x                   107
    //I
    $linha .= 'I';                                                    //carteira                      108
    //01
    $linha .= '01';                                                   //código ocorrencia 09 = protestar 110
    //036588/001
    $linha .= str_pad(substr($boleto_antecipada['documento'], 0, 10), 10);                      //nº documento - nf             120
    //301122
    $dt = explode('-', $boleto_antecipada['vencimento']);
    $linha .= date("dmy",mktime(0,0,0,$dt[1],$dt[2],$dt[0]));         //vencimento                    126
    //0000000056041
    $vl = str_replace(',', '', str_replace('.', '', number_format($boleto_antecipada['valor'], 2)));
    $linha .= str_pad($vl, 13, '0', STR_PAD_LEFT);                    //valor do boleto               139
    //341
    $linha .= '341';                                                  //codigo do banco               142
    //00000
    $linha .= '00000';                                                //agencia cobradora             147
    //01
    $linha .= '01';                                                   //especie                       149
    //N
    $linha .= 'N';                                                    //aceite                        150
    //031122
    $linha .= date('dmy');                                            //data emissão                  156
    //00
    $linha .= '00';                                                   //instrução 1                   158
    //00
    $linha .= '00';                                                   //instrução 2                   160
    //0000000000745
    $linha .= str_pad('023', 13, '0', STR_PAD_LEFT);                  //juros de 1 dia                173
    //301122
    $linha .= date("dmy",mktime(0,0,0,$dt[1],$dt[2],$dt[0]));         //desconto até data vcto        179
    //0000000000000
    $linha .= str_pad('', 13, '0', STR_PAD_LEFT);                     //valor do desconto             192
    //0000000000000
    $linha .= str_pad('', 13, '0', STR_PAD_LEFT);                     //valor de iof                  205
    //0000000000000
    $linha .= str_pad('', 13, '0', STR_PAD_LEFT);                     //abatimento                    218


    //02
    $linha .= '02';                                                   //codigo inscrição 02 = cnpj    220
    //41273506000151
    $linha .= str_pad($cnpj['cnpj'], 14, '0', STR_PAD_LEFT);                                          //nº inscrição pagador cnpj cliente 234
    //WALLACE HESSLER LEAL TURCIO 09
    $nm = substr($cnpj['razao'], 0, 30);
    $linha .= str_pad(strtoupper($nm), 30);                           //nome pagador                  264
    //          
    $linha .= str_repeat(' ', 10);                                    //brancos 10x                   274
    //RUA CONRAD RIEGEL, 20                   
    $ed = substr(($cnpj['rua'].', '.$cnpj['numero']), 0, 40);
    $linha .= str_pad(strtoupper($ed), 40);                           //logradouro                    314
    //CENTRO      
    $br = substr($cnpj['bairro'], 0, 12);
    $linha .= str_pad(strtoupper($br), 12);                           //bairro                        326
    //89258070
    $linha .= str_pad($cnpj['cep'], 8);                               //cep                           334
    //JARAGUA DO SUL 
    $cd = tirarAcentos(substr($cnpj['cidade'], 0, 15));
    $linha .= str_pad(strtoupper($cd), 15);                           //cidade                        349
    //SC
    $linha .= str_pad(strtoupper($cnpj['estado']), 2);                //estado                        351
    //LAWSEC S/A                    
    $linha .= str_pad(strtoupper($cnpj['razao']), 30);                //beneficiario final            381
    //                                                                             
    $linha .= str_repeat(' ', 4);                                     //brancos 4x                    385
    //000000
    $linha .= str_repeat('0', 6);                                     //data mora                     391
    //00
    $linha .= '00';                                                   //prazo                         393
    // 
    $linha .= ' ';                                                    //brancos 1x                    394
    //000002
    $linha .= str_pad($i++, 6, '0', STR_PAD_LEFT);                    //nº sequencial                 400
    $linha .= chr(13).chr(10);

    //reg2
    //2
    $linha .= '2';                                              //tipo de registro                                                                        1
    //2
    $linha .= '2';                                              //cod multa 2 = VALOR EM PERCENTUAL COM DUAS CASAS DECIMAIS CONFORME ESTRUTURA DO CAMPO   2
    //30112022
    $linha .= date("dmY",mktime(0,0,0,$dt[1],$dt[2],$dt[0]));   //data da multa                                                                          10
    //0000000000500
    $linha .= str_pad('200', 13, '0', STR_PAD_LEFT);            //multa 5%                                                                               23
    //                                                                                                                                                                                                                                                                                                                                                                                   
    $linha .= str_repeat(' ', 371);                             //brancos 370x                                                                          393
    //000003
    $linha .= str_pad($i++, 6, '0', STR_PAD_LEFT);              //nº sequencial                                                                         399
    $linha .= chr(13).chr(10);


    $sqlfornecedores = "SELECT * FROM fornecedores WHERE cnpj=?";
    $stmtfornecedores = prepared_query($con, $sqlfornecedores, [$boleto_antecipada['cnpj']], 's');
    $fornecedores = $stmtfornecedores->get_result()->fetch_assoc();
    $stmtfornecedores->close();

    
    //reg5
    //5
    $linha .= '5';                                                    //tipo de registro              1
    //                                                                                                                        
    $linha .= str_repeat(' ', 120);                                   //email                       121
    //02
    $linha .= '02';                                                   //codigo inscrição 02 = cnpj  123
    //13476058000158
    $linha .=  $boleto_antecipada['cnpj'];                                       // nº inscrição = cnpj        137
    //RUA JORGE CZERNIEWICZ, 99               
    $linha .= str_pad(strtoupper( $fornecedores['rua'].','. $fornecedores['numero']), 40);   //logradouro                  177
    //CZERNIEWICZ 
    $linha .= str_pad(strtoupper($fornecedores['bairro']), 12);                 //bairro                      189
    //89255000
    $linha .= str_pad(strtoupper(str_replace([',','.','-'],'',$fornecedores['cep'])), 40);                                             //cep                         197
    //JARAGUA DO SUL 
    $linha .= str_pad(strtoupper($fornecedores['cidade']), 15);              //cidade                      212
    //SC
    $linha .= str_pad(strtoupper($fornecedores['estado']), 2);                                                  //estado                      214
    //                                                                                                                                                                                    
    $linha .= str_repeat(' ', 180);                                   //brancos 180x                394
    //000004
    $linha .= str_pad($i++, 6, '0', STR_PAD_LEFT);                    //nº sequencial               400
    $linha .= chr(13).chr(10);
    
    fwrite($arquivo, $linha);

    $sql = "UPDATE boletos SET remessa=?, STATUS=? WHERE id=?";
    $stmt = prepared_query($con, $sql, [$remessa, 'E', $boleto_antecipada['id']], 'isi');
    $stmt->close();
  }

  foreach ($boletos as $boleto) {
    $sql = "SELECT * FROM fornecedores WHERE cnpj=?";
    $stmt = prepared_query($con, $sql, [$boleto['cnpj']], 's');
    $cnpj = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    //reg 1
    //1
    $linha =  '1';                                                    //tipo de registro                1
    //04
    $linha .= '04';                                                   //codigo de inscrição             3
    //13476058000158
    $linha .= '13476058000158';                                       //nº inscrição empresa           17
    //0862
    $linha .= '0862';                                                 //agencia                        21
    //00
    $linha .= '00';                                                   //zeros 2x                       23
    //99570
    $linha .= '99570';                                                //conta                          28
    //1
    $linha .= '1';                                                    //dac                            29 
    //    
    $linha .= str_repeat(' ', 4);                                     //brancos 4x                     33
    //0000
    $linha .= '0000';                                                 //instrução/alegação             37
    //4138                     
    $linha .= str_pad($boleto['operacao'], 25);                       //uso da empresa (ID operação)   62
    //00000017
    $linha .= str_pad($boleto['nosso_numero'], 8, '0', STR_PAD_LEFT); //nosso numero                   70
    //0000000000000
    $linha .= str_repeat('0', 13);                                    //qtde moeda                     83
    //109
    $linha .= '109';                                                  //nº da carteira                 86
    //                     
    $linha .= str_repeat(' ', 21);                                    //brancos 21x                   107
    //I
    $linha .= 'I';                                                    //carteira                      108
    //01
    $linha .= '01';                                                   //código ocorrencia 09 = protestar 110
    //036588/001
    $linha .= str_pad(substr($boleto['documento'], 0, 10), 10);                      //nº documento - nf             120
    //301122
    $dt = explode('-', $boleto['vencimento']);
    $linha .= date("dmy",mktime(0,0,0,$dt[1],$dt[2],$dt[0]));         //vencimento                    126
    //0000000056041
    $vl = str_replace(',', '', str_replace('.', '', number_format($boleto['valor'], 2)));
    $linha .= str_pad($vl, 13, '0', STR_PAD_LEFT);                    //valor do boleto               139
    //341
    $linha .= '341';                                                  //codigo do banco               142
    //00000
    $linha .= '00000';                                                //agencia cobradora             147
    //01
    $linha .= '01';                                                   //especie                       149
    //N
    $linha .= 'N';                                                    //aceite                        150
    //031122
    $linha .= date('dmy');                                            //data emissão                  156
    //00
    $linha .= '00';                                                   //instrução 1                   158
    //00
    $linha .= '00';                                                   //instrução 2                   160
    //0000000000745
    $linha .= str_pad('023', 13, '0', STR_PAD_LEFT);                  //juros de 1 dia                173
    //301122
    $linha .= date("dmy",mktime(0,0,0,$dt[1],$dt[2],$dt[0]));         //desconto até data vcto        179
    //0000000000000
    $linha .= str_pad('', 13, '0', STR_PAD_LEFT);                     //valor do desconto             192
    //0000000000000
    $linha .= str_pad('', 13, '0', STR_PAD_LEFT);                     //valor de iof                  205
    //0000000000000
    $linha .= str_pad('', 13, '0', STR_PAD_LEFT);                     //abatimento                    218
    //02
    $linha .= '02';                                                   //codigo inscrição 02 = cnpj    220
    //41273506000151
    $linha .= str_pad($cnpj['cnpj'], 14, '0', STR_PAD_LEFT);                                          //nº inscrição pagador cnpj cliente 234
    //WALLACE HESSLER LEAL TURCIO 09
    $nm = substr($cnpj['razao'], 0, 30);
    $linha .= str_pad(strtoupper($nm), 30);                           //nome pagador                  264
    //          
    $linha .= str_repeat(' ', 10);                                    //brancos 10x                   274
    //RUA CONRAD RIEGEL, 20                   
    $ed = substr(($cnpj['rua'].', '.$cnpj['numero']), 0, 40);
    $linha .= str_pad(strtoupper($ed), 40);                           //logradouro                    314
    //CENTRO      
    $br = substr($cnpj['bairro'], 0, 12);
    $linha .= str_pad(strtoupper($br), 12);                           //bairro                        326
    //89258070
    $linha .= str_pad($cnpj['cep'], 8);                               //cep                           334
    //JARAGUA DO SUL 
    $cd = tirarAcentos(substr($cnpj['cidade'], 0, 15));
    $linha .= str_pad(strtoupper($cd), 15);                           //cidade                        349
    //SC
    $linha .= str_pad(strtoupper($cnpj['estado']), 2);                //estado                        351
    //LAWSEC S/A                    
    $linha .= str_pad(strtoupper($cnpj['razao']), 30);                  //beneficiario final            381
    //                                                                             
    $linha .= str_repeat(' ', 4);                                     //brancos 4x                    385
    //000000
    $linha .= str_repeat('0', 6);                                     //data mora                     391
    //00
    $linha .= '00';                                                   //prazo                         393
    // 
    $linha .= ' ';                                                    //brancos 1x                    394
    //000002
    $linha .= str_pad($i++, 6, '0', STR_PAD_LEFT);                    //nº sequencial                 400
    $linha .= chr(13).chr(10);

    //reg2
    //2
    $linha .= '2';                                              //tipo de registro                                                                        1
    //2
    $linha .= '2';                                              //cod multa 2 = VALOR EM PERCENTUAL COM DUAS CASAS DECIMAIS CONFORME ESTRUTURA DO CAMPO   2
    //30112022
    $linha .= date("dmY",mktime(0,0,0,$dt[1],$dt[2],$dt[0]));   //data da multa                                                                          10
    //0000000000500
    $linha .= str_pad('200', 13, '0', STR_PAD_LEFT);            //multa 5%                                                                               23
    //                                                                                                                                                                                                                                                                                                                                                                                   
    $linha .= str_repeat(' ', 371);                             //brancos 370x                                                                          393
    //000003
    $linha .= str_pad($i++, 6, '0', STR_PAD_LEFT);              //nº sequencial                                                                         399
    $linha .= chr(13).chr(10);

    //reg5
    //5
    $linha .= '5';                                                    //tipo de registro              1
    //                                                                                                                        
    $linha .= str_repeat(' ', 120);                                   //email                       121
    //02
    $linha .= '02';                                                   //codigo inscrição 02 = cnpj  123
    //13476058000158
    $linha .= $cnpj['cnpj'];                                       // nº inscrição = cnpj        137
    //RUA JORGE CZERNIEWICZ, 99               
    $linha .= str_pad(strtoupper('Rua José Theodoro Ribeiro, 1058'), 40);   //logradouro                  177
    //CZERNIEWICZ 
    $linha .= str_pad(strtoupper('Ilha da Figueira'), 12);                 //bairro                      189
    //89255000
    $linha .= '89258000';                                             //cep                         197
    //JARAGUA DO SUL 
    $linha .= str_pad(strtoupper('JARAGUA DO SUL'), 15);              //cidade                      212
    //SC
    $linha .= 'SC';                                                   //estado                      214
    //                                                                                                                                                                                    
    $linha .= str_repeat(' ', 180);                                   //brancos 180x                394
    //000004
    $linha .= str_pad($i++, 6, '0', STR_PAD_LEFT);                    //nº sequencial               400
    $linha .= chr(13).chr(10);
    
    fwrite($arquivo, $linha);

    $sql = "UPDATE boletos SET remessa=?, STATUS=? WHERE id=?";
    $stmt = prepared_query($con, $sql, [$remessa, 'E', $boleto['id']], 'isi');
    $stmt->close();
  }

  //9
  $trailer  = '9';
  //                                                                                                                                                                                                                                                                                                                                                                                                         
  $trailer .= str_repeat(' ', 393);
  //000062
  $trailer .= str_pad($i++, 6, '0', STR_PAD_LEFT);
  $trailer .= chr(13).chr(10);

  fwrite($arquivo, $trailer);
  fclose($arquivo);
  
  if (file_exists($nome)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($nome).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($nome));
    readfile($nome);
    
    exit;
  }
  // ob_clean();
  // flush();
  // readfile('CB'.str_pad($remessa, 6, '0', STR_PAD_LEFT).'.REM');
?>