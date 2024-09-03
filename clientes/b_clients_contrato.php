<?php
  session_start();
  if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'cliente') {
    header("Location: ../pagina_de_acesso_nao_autorizado.php");
    exit();
}
  setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
  date_default_timezone_set('America/Sao_Paulo');

	$con = new mysqli('localhost', 'lawsmart_agricopel', 'law2023', 'lawsmart_agricopelTeste');
	mysqli_set_charset($con, 'utf8');

  $cnpj = $_SESSION['cnpj']; // cnpj
  $dados = json_decode(file_get_contents('php://input'), true);
  $id = $dados['id']; //id operacao

	function prepared_query($mysqli, $sql, $params, $types = "") {    
    $stmt = $mysqli->prepare($sql);
		if (sizeof($params) > 0) {
			$types = $types ?: str_repeat("s", count($params));
			$stmt->bind_param($types, ...$params);
		}    
    $stmt->execute();
    return $stmt;
	}

  function formataCpfCnpj($str) {
    $ret = '';
    if (strlen($str) == 14) {
      $ret = substr($str, 0, 2).'.'.substr($str, 2, 3).'.'.substr($str, 5, 3).'/'.substr($str, 8, 4).'-'.substr($str, -2);
    } else {
      $ret = substr($str, 0, 3).'.'.substr($str, 3, 3).'.'.substr($str, 6, 3).'-'.substr($str, -3);
    }
    return $ret;
  }

  function formataFone($str) {
    return '('.substr($str, 0, 2).') '.substr($str, 2, 5).'-'.substr($str, -4);
  }

  function formataCep($str) {
    return substr($str, 0, 2).'.'.substr($str, 2, 3).'-'.substr($str, -3);
  }

  function formataData($str) {
    $d = explode('-', $str);
    return $d[2].'/'.$d[1].'/'.$d[0];
  }

  class Extenso {
    public static function removerFormatacaoNumero($strNumero) {
        $strNumero = trim( str_replace("R$", null, $strNumero) );
        $vetVirgula = explode( ",", $strNumero );
        if ( count( $vetVirgula ) == 1 ) {
            $acentos = array(".");
            $resultado = str_replace( $acentos, "", $strNumero );
            return $resultado;
        } else if ( count( $vetVirgula ) != 2 ) {
            return $strNumero;
        }
        $strNumero = $vetVirgula[0];
        $strDecimal = mb_substr( $vetVirgula[1], 0, 2 );
        $acentos = array(".");
        $resultado = str_replace( $acentos, "", $strNumero );
        $resultado = $resultado . "." . $strDecimal;
        return $resultado;
    }

    public static function converte($valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false) {
        $valor = self::removerFormatacaoNumero( $valor );
        $singular = null;
        $plural = null;
        if ( $bolExibirMoeda ) {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        } else {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezessete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
        if ( $bolPalavraFeminina ) {
            if ($valor == 1)
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            else
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");

            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas","quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
        }
        $z = 0;
        $valor = number_format( $valor, 2, ".", "." );
        $inteiro = explode( ".", $valor );
        for ( $i = 0; $i < count( $inteiro ); $i++ )
            for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ )
                $inteiro[$i] = "0" . $inteiro[$i];

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count( $inteiro ) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
        for ( $i = 0; $i < count( $inteiro ); $i++ ) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count( $inteiro ) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ( $valor == "000")
                $z++;
            elseif ( $z > 0 )
                $z--;

            if ( ($t == 1) && ($z > 0) && ($inteiro[0] > 0) )
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];

            if ( $r )
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }
        $rt = mb_substr( $rt, 1 );
        return($rt ? trim( $rt ) : "zero");
    }
  }

  $sql = "SELECT * FROM `fornecedores` where cnpj=?";
  $stmt = prepared_query($con, $sql, [$cnpj], 's');
  $empresa = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
  $stmt->close();

  $sql = "SELECT * FROM operacoes WHERE id IN (?)";
  $stmt = prepared_query($con, $sql, [$id], 'i');
  $operacao = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close(); 
    
  $trs = '';
  $vlrtot = 0;
  foreach ($operacao as $op) {
    $trs .= '
      <tr>
        <td class="center">'.$op['nota'].'</td>
        <td class="left">'.$empresa['razao'].'</td>
        <td class="center">'.formataCpfCnpj($empresa['cnpj']).'</td>
        <td class="center">'.date('d/m/Y').'</td>
        <td class="right">R$ '.number_format($op['valor'], 2, ',', '.').'</td>
      </tr>
    ';
    
    $vlrtot += $op['valor'];
  }
  $table = '
  <table>
    <thead>
      <tr>
        <td>DOCUMENTO</td>
        <td>DEVEDOR-SACADO</td>
        <td>CNPJ/CPF</td>
        <td>VENCIMENTO</td>
        <td>VALOR DE FACE</td>
      </tr>
    </thead>
    <tbody>
    '.$trs.'
    </tbody>
  </table>
  ';

  $html = '
  <h3>INSTRUMENTO PARTICULAR DE CESSÃO DE CRÉDITOS, DIREITOS, OBRIGAÇÕES E OUTRAS AVENÇAS</h3>
  <p>
    <span class="under">CEDENTE:</span> '.$empresa["razao"].', pessoa jurídica de direito privado, inscrita no CNPJ/MF sob o nº '.formataCpfCnpj($empresa["cnpj"]).', com sede '.$empresa["rua"].', '.$empresa["numero"].'- '.$empresa["estado"].', CEP '.formataCep($empresa["cep"]).'
    <br><span class="bold">Representante Legal:</span> '.$empresa["representante"].'
    <br><span class="bold">CPF/MF</span> nº '.formataCpfCnpj($empresa["cpf"]).'
    <br><span class="bold">Endereço:</span>  '.$empresa["rua"].', '.$empresa["numero"].'- '.$empresa["estado"].', CEP '.formataCep($empresa["cep"]).'
    <br><span class="bold">Telefone:</span> '.formataFone($empresa["telefone"]).'
    <br><span class="bold">e-mail:</span> '.$empresa["email"].'
    <br>doravante simplesmente denominado de CEDENTE. 
  </p>
  <p>
    <span class="under">CESSIONÁRIO:</span> FIXTECH INVESTIMENTOS LTDA, pessoa jurídica de direito privado, devidamente inscrita perante o CNPJ/MF sob o nº 50.653.734/0001-48, com sede na Rua Feliciano Bortolini, nº 1640, sala 7, Barra do Rio Cerro, CEP 89.260-090, Jaraguá do Sul – Estado de Santa Catarina.
    <br><span class="bold">Representante Legal:</span> Paulo Cesar Chiodini
    <br><span class="bold">RG</span> nº 1.985.249
    <br><span class="bold">CPF/MF</span> nº 569.932.009-10
    <br><span class="bold">Estado Civil:</span> Casado
    <br><span class="bold">Nacionalidade:</span> Brasileiro
    <br><span class="bold">Profissão:</span> Empresário
    <br><span class="bold">Endereço:</span> Rua 29 de Outubro, nº 55, AP 1001, Bairro Centro, CEP 89.252-090, Jaraguá do Sul – Estado de Santa Catarina.
    <br><span class="bold">Telefone:</span> (47) 3307-5808
    <br><span class="bold">e-mail:</span> notificacao@lawsecsa.com.br
    <br>doravante simplesmente denominado de CESSIONÁRIO. 
  </p>
  <p>
    <span class="under">INTERVENIENTE RESPONSÁVEL(IS) SOLIDÁRIO(S):</span>
    <br><span class="bold">Nome:</span> '.$empresa["representante"].'
    <br><span class="bold">CPF/MF</span> nº '.formataCpfCnpj($empresa["cpf"]).'
    <br><span class="bold">Endereço:</span> '.$empresa["rua"].', '.$empresa["numero"].'- '.$empresa["estado"].', CEP '.formataCep($empresa["cep"]).'
    <br><span class="bold">Telefone:</span> '.formataFone($empresa["telefone"]).'
    <br><span class="bold">e-mail:</span> '.$empresa["email"].'
    <br>doravante simplesmente denominado de INTERVENIENTE RESPONSÁVEL(IS) SOLIDÁRIO(S) ou apenas RESPONSÁVEL(IS) SOLIDÁRIO(S) 
  </p>
  <p>
    <span class="under">INTERVENIENTE FIEL DEPOSITÁRIO:</span>
    <br><span class="bold">Nome:</span> '.$empresa["representante"].'
    <br><span class="bold">CPF/MF</span> nº '.formataCpfCnpj($empresa["cpf"]).'
    <br><span class="bold">Endereço:</span> '.$empresa["rua"].', '.$empresa["numero"].'- '.$empresa["estado"].', CEP '.formataCep($empresa["cep"]).'
    <br><span class="bold">Telefone:</span> '.formataFone($empresa["telefone"]).'
    <br><span class="bold">e-mail:</span> '.$empresa["email"].'
    <br>doravante simplesmente denominado de INTERVENIENTE FIEL DEPOSITÁRIO ou apenas FIEL DEPOSITÁRIO.
  </p>
  <p>
    Considerando que o CEDENTE, é único, exclusivo e legítimo titular dos créditos, identificados e descritos no quadro constante da cláusula 1.1, bem como de todos os direitos acessórios aos créditos, incluindo multa(s), juros remuneratórios, encargos moratórios, correção monetária, e toda e qualquer garantia, real ou pessoal ou fiduciária, ainda existentes, que garanta, total ou parcialmente, o seu pagamento; 
  </p>
  <p>
    Considerando que o CEDENTE, desejando ceder, de forma irrevogável e irretratável, os CRÉDITOS, direitos e obrigações decorrentes deste objeto de cessão e transferência, o qual faz através de endosso pleno em preto com cláusula de responsabilidade pela solvabilidade do crédito – nos termos do art. 914 e seus parágrafos combinado com os artigos art. 286 a 298 do Código Civil - e a CESSIONÁRIA desejando adquiri-los, (sendo CEDENTE e CESSIONÁRIA doravante designados como “PARTES”), resolvem celebrar o presente <span class="bold">Instrumento Particular de Cessão de Créditos, Direitos, Obrigações e Outras Avenças (“<span class="under">Contrato de Cessão</span>”)</span>, e o fazem por esta e na melhor forma de direito, nos termos dos artigos 286 a 298 e 893 do Código Civil Brasileiro e de acordo com as cláusulas e condições a seguir estipuladas. 
  </p>
  <p>
    <span class="under">1. CESSÃO</span>
    <br><br>
    1.1 Por meio do presente contrato, a CEDENTE cede e transfere à CESSIONÁRIA, enquanto vigente e nos limites deste contrato, os Títulos de Crédito a seguir listados, incluindo seus acessórios, bem como todos os instrumentos que os representam, inclusive notas fiscais eletrônicas de venda de mercadoria e/ou prestação dos serviços originários dos créditos e os respectivos comprovantes da entrega da mercadoria e/ou prestação de serviços, bem assim, como os eventuais anexos e garantias constituídas, sub-rogando todos os seus direitos, inalterados, à CESSIONÁRIA.
    <br><br>
    '.$table.'
    <br>
  </p>
  <p>
    1.2 Os créditos mencionados e listados no item 1.1 acima, estão sendo endossados pela CEDENTE em favor da CESSIONÁRIA, mediante endosso pleno, assumindo a CEDENTE-ENDOSSATÁRIA, expressamente, a obrigação de responder solidariamente pelo aceite e pagamento dos créditos cedidos à CESSIONÁRIA.
  </p>
  <p>
    1.3 Declara a CEDENTE que os Créditos cedidos estão livres de quaisquer ônus ou gravames de qualquer natureza, responsabilizando-se a CEDENTE civil e criminalmente pela existência, legalidade, legitimidade e veracidade dos créditos representados pelos títulos vendidos à CESSIONÁRIA, pelos riscos e vícios redibitórios decorrentes dos créditos e títulos que os representem, bem como pela solvência do sacado-devedor, ficando o FIEL DEPOSITÁRIO, responsável pela guarda dos mesmos e apresentá-los quando requisitados por escrito (item 4.3) pela CESSIONÁRIA, no prazo de 48 (quarenta e oito) horas contados da solicitação – sob pena de incorrer nas penalidades legalmente cabíveis, observando, sempre, o disposto no artigo 638 do Código Civil, o artigo 168 do Código Penal, e o art. 5.º, LXII, da Constituição Federal.
  </p>
  <p>
    1.4 Obriga-se ainda, a CEDENTE, de imediato, a dar ciência ao devedor-sacado da alienação dos créditos e/ou títulos objeto do presente contrato, informando ao devedor-sacado que o respectivo pagamento deverá ser feito diretamente e somente à CESSIONÁRIA ou à sua ordem.
  </p>
  <p>
    1.5 Declara, ainda, a CEDENTE, com relação aos créditos cedidos nos termos deste contrato e que são objeto de securitização, que:
  </p>
  <p>
    (i) Os títulos de créditos ora cedidos não foram objeto de qualquer outra alienação, compromisso de alienação, cessão ou mesmo oneração, inexistindo qualquer direito do devedor-sacado contra a CEDENTE ou qualquer acordo, transação e/ou novação entre a CEDENTE e o devedor-sacado (ou terceiros) que possa ensejar qualquer arguição de compensação e/ou outra forma de extinção, redução ou modificação das condições de pagamento e valor dos créditos cedidos à CESSIONÁRIA.
  </p>
  <p>
    (ii) Obriga-se, expressamente, a não celebrar com o devedor-sacado qualquer ajuste ou repactuação do valor do crédito sem prévia anuência da CESSIONÁRIA, que, em virtude da transferência dos direitos creditórios passa a ser a única e legítima credora das obrigações do devedor-sacado.
  </p>
  <p>
    (iii) Obriga-se, igualmente, a informar à CESSIONÁRIA, por escrito e no prazo de 24h (vinte e quatro horas) contado do evento, a existência de qualquer reclamação, modificação ou cancelamento de documentos, entrega de mercadorias ou prestação de serviços que deram origem aos créditos negociados com a CESSIONÁRIA.
  </p>
  <p>
    (iv) Os títulos negociados também poderão ser emitidos, endossados e avalizados eletronicamente, independentemente de serem ou não produzidos com a utilização de processo de certificação disponibilizado pela ICP-Brasil (Infra-Estrutura de Chaves Públicas) na forma do § 2º, art. 10, da MP 2.200-2 , assim como a nota fiscal poderá ser enviada em arquivo XML, independentemente de serem ou não produzidos com a utilização de processo de certificação disponibilizado pela ICP-Brasil.
  </p>
  <p>
    1.6 A CEDENTE e o(s) INTERVENIENTE(S) RESPONSÁVEL(EIS) SOLIDÁRIO(S) responsabilizam-se perante a CESSIONÁRIA, pelos riscos e prejuízos que possam advir dos créditos e/ou títulos negociados, inclusive pela solvência do devedor-sacado e pela boa liquidação e pagamento do crédito, caso ele não seja efetuado pelo devedor-sacado na data de seu vencimento, bem como na hipótese de serem opostas quaisquer exceções quanto à legitimidade, legalidade e veracidade do crédito.
  </p>
  <p>
    1.7 A CEDENTE e o(s) INTERVENIENTE(S) RESPONSÁVEL(EIS) SOLIDÁRIO(S) também respondem integralmente junto à CESSIONÁRIA pelos créditos negociados, e pelas obrigações decorrentes do endosso realizado em favor da CESSIONÁRIA, nas seguintes situações:
  </p>
  <p>
    (i) Se os créditos representados pelos títulos vendidos forem objeto de outra cessão, alienação, ajuste ou oneração, sem o consentimento prévio e expresso da CESSIONÁRIA;
  </p>
  <p>
    (ii) Se os créditos adquiridos pela CESSIONÁRIA forem objeto de acordo entre a CEDENTE e o devedor-sacado, que possa ensejar arguição ou compensação e/ou qualquer outra forma de redução, extinção ou modificação de qualquer das condições que interfiram ou prejudiquem um dos direitos decorrentes dos títulos negociados;
  </p>
  <p>
    (iii) Se o devedor-sacado refutar ou devolver total ou parcialmente os produtos, mercadorias ou prestação de serviços fornecidos. Nesse caso, a CEDENTE, na pessoa de seu representante legal, indicado no preâmbulo desse contrato, receberá as mercadorias devolvidas como FIEL DEPOSITÁRIO da CESSIONÁRIA, sujeitando-se a todas as penalidades legais e, em especial, às condições previstas neste Contrato;
  </p>
  <p>
    (iv) Se a CEDENTE promover qualquer alteração nos seus atos constitutivos (do contrato social, estatuto) ou mudança de endereço sem conhecimento prévio da CESSIONÁRIA;
  </p>
  <p>
    (v) Se o devedor-sacado for judicialmente reconhecido como insolvente, ou falido;
  </p>
  <p>
    (vi) Se a CEDENTE receber em pagamento, no todo ou em parte, valores relativos aos créditos e/ou títulos que os representem negociados com a CESSIONÁRIA. Nesse caso, além das cominações legais relativas à corresponsabilidade da CEDENTE pelo endosso, a CEDENTE, na pessoa de seu representante legal, ficará como FIEL DEPOSITÁRIO dos valores recebidos, obrigando-se a devolvê-los à CESSIONÁRIA no prazo máximo de 24h (vinte e quatro horas), sob pena de, decorrido esse prazo, ficar caracterizada a apropriação indébita e estelionato (art. 168 e 171, do Código Penal); facultando à CESSIONÁRIA oferecer notícia crime para instauração de inquérito policial.
  </p>
  <p>
    (vii) Se for oposta qualquer exceção, oposição, defesa ou justificativa pelo devedor-sacado baseada em fato de responsabilidade da CEDENTE ou contrária aos termos deste contrato;
  </p>
  <p>
    (viii) Se for oposta qualquer exceção, defesa ou justificativa pelo devedor-sacado baseada na recusa ou aceitação de mercadoria ou serviço ou qualquer forma de mora ou inadimplemento da CEDENTE junto ao mesmo devedor-sacado;
  </p>
  <p>
    (ix) Se houver contraprotesto do devedor-sacado e/ou qualquer reclamação judicial deste contra a CEDENTE; ou, ainda;
  </p>
  <p>
    (x) Em caso de inadimplemento baseado em alegação de caso fortuito ou força maior.
  </p>
  <p>
    1.8. Sobrevindo a constatação de não pagamento do devedor-sacado no vencimento ou de quaisquer vícios ou exceções na origem dos créditos e/ou títulos que os representam os títulos negociados entre as partes, obrigam-se a CEDENTE e o(s) INTERVENIENTE(S) RESPONSÁVEL(EIS) SOLIDÁRIO(S), a recomprá-los da CESSIONÁRIA, no prazo de 48 (quarenta e oito) horas, contados da comunicação do evento pela CESSIONÁRIA, pelo valor de face do título negociado, acrescido da multa de 3% (três por cento), juros de mora de 3,5% (três e meio por cento) ao mês, nos termos do art. 406 do Código Civil, bem como da devida atualização monetária segundo índices oficiais regularmente estabelecidos, das perdas e danos e honorários de advogado na ordem de 20% do saldo devedor, tudo conforme autorizam os artigos 389 ao 392 e 394 ao 396 do Código Civil.
  </p>
  <p>
    1.9 A recusa na recompra dos créditos e/ou títulos ou a sua não realização no prazo previsto no item 1.8 acima, acarretará negativação, apontamento dos títulos para protesto e a imediata exigibilidade dos créditos, ensejando a cobrança judicial contra a CEDENTE, ENDOSSANTE(S), INTERVENIENTE(S)RESPONSÁVEL(EIS) SOLIDÁRIO(S) dos créditos e/ou títulos não pago(s).
  </p>
  <p>
    1.10 A tolerância da CESSIONÁRIA quanto ao disposto no item 1.8, constituirá ato de mera liberalidade, não implicando, tácita ou implicitamente, em renúncia ou novação quanto às obrigações previstas.
  </p>
  <p>
    1.11 No caso de a CESSIONÁRIA acionar judicialmente o devedor-sacado em decorrência da inadimplência, assim como nos casos previstos no item 1.8, obrigam-se a CEDENTE e INTERVENIENTE(S) RESPONSÁVEL(EIS) SOLIDÁRIO(S),  a reembolsar na integralidade, com todos os acréscimos legais, o valor desembolsado pela CESSIONÁRIA, incluindo despesas com advogados na ordem de 20% (vinte por cento) do saldo devedor e custas processuais.
  </p>
  <p>
    1.12 O simples pagamento das multas previstas neste contrato não exime a parte infratora do cumprimento das demais obrigações resultantes deste contrato.
  </p>
  <p>
    1.13 As penalidades porventura aplicadas em conformidade com o disposto neste contrato serão consideradas dívida líquida e certa, servindo para tanto o presente contrato como título executivo extrajudicial.
  </p>
  <p>
    1.14 Realizada a compra e venda de créditos e/ou títulos que os representem, e constada a má-fé da CEDENTE ou a existência de vícios na origem do crédito, seja quanto à sua existência, seja quanto à sua legalidade e legitimidade, a CEDENTE e INTERVENIENTE(S) RESPONSÁVEL(EIS) SOLIDÁRIO(S) responderá(ão) pela pena de multa fixada no valor correspondente ao valor total de face do(s) crédito(s) e/ou título(s) negociado(s), independentemente das demais penalidades previstas no presente contrato.
  </p>
  <p>
    1.15 A não aplicação da multa prevista no item 1.14 pela CESSIONÁRIA, constituirá ato de mera liberalidade, não implicando, tácita ou implicitamente, em renúncia a direito ou novação de obrigações.
  </p>
  <p>
    <span class="bold under">2. PAGAMENTO</span>
    <br><br>
    2.1 Em contraprestação à cessão dos Créditos arrolados, identificadas e descritas no quadro constante da cláusula 1.1 do presente Contrato, a CESSIONÁRIA pagará o valor de R$ '.number_format($vlrtot, 2, ',', '.').' ('.Extenso::converte(str_replace('.', ',', $vlrtot), true, false).') única e exclusivamente à CEDENTE, via Sistema de Pagamentos Brasileiros - SPB, utilizando-se de Transação Eletrônica Disponível - TED ou Documento de Ordem de Crédito - DOC, crédito em conta corrente, PIX, ou ainda, através de cheque nominativo em favor da CEDENTE.
  </p>
  <p>
    <span class="bold under">3. DA OUTORGA DE GARANTIAS – RESPONSABILIDADE SOLIDÁRIA</span>
    <br><br>
    3.1 Expressamente, na forma dos artigos 264, 265 e seguintes do Código Civil, o(s) INTERVENIENTE(S) RESPONSÁVEL(EIS) SOLIDÁRIO(S)s, já qualificados anteriormente, assinam o presente contrato como corresponsáveis solidários e principais pagadores com a CEDENTE por todas as obrigações aqui estabelecidas, cuja responsabilidade perdurará até o total e definitivo cumprimento das obrigações avençadas e abrangidas por este contrato, substituindo sua responsabilidade para todos os títulos cedidos, na vigência deste contrato.
  </p>
  <p>
    3.2 A substituição do(s) INTERVENIENTE(s) RESPONSÁVEL(EIS) SOLIDÁRIO(S) dependerá de anuência prévia e expressa aprovação da CESSIONÁRIA.
  </p>
  <p>
    3.3 Em função do caráter pro solvendo que as cessões de crédito se revestirão, a CEDENTE e o(s) INTERVENIENTE(s) RESPONSÁVEL(EIS) SOLIDÁRIO(S), emitem neste ato, em favor da CESSIONÁRIA, Nota Promissória com vencimento à vista no valor total dos títulos cedidos, a qual passa a fazer parte integrante e inseparável deste contrato.
  </p>
  <p>
    <span class="bold under">4. DAS COMUNICAÇÕES,  NOTIFICAÇÕES e ASSINATURAS:</span>
    <br><br>
    4.1 Elegem as partes que qualquer comunicação e/ou notificação entre as partes deverão ocorrer exclusivamente observando os dados constantes do preâmbulo deste Instrumento, ou sejam, através de seus endereços eletrônicos (e-mail) e/ou através do número de telefonia móvel e o uso de plataformas de comunicação instantânea, exemplificativamente, mas não se limitando, a whatsapp e telegram. Todas as notificações decorrentes deste Contrato deverão ser feitas por escrito e serão consideradas eficazes: a) quando da transmissão por plataforma de comunicação instantânea, b) quando por envio para o e-mail declarado ou c) quando postado para o endereço eletrônico das partes, independentemente de certificação digital, nos termos do § 2º, art. 10, da MP 2.200-2. Para efeito de qualquer notificação, observar-se-ão os dados constantes do preâmbulo deste Instrumento, que somente poderão ser alterados por notificação enviada por uma Parte à outra, comunicando expressamente as alterações dos dados para contato, em especial os endereços físicos, de telefonia móvel e eletrônicos, sob pena de serem consideradas válidas e recebidas as comunicações realizadas, assim destinadas:
  </p>
  <p>
    (i) Para a CEDENTE – '.$empresa["razao"].' - CNPJ/MF sob o nº '.formataCpfCnpj($empresa["cnpj"]).', na pessoa de seu representante legal, Sr. '.$empresa["representante"].'
    <br>a.1) e-mail: '.$empresa["email"].'
    <br>a.2) fone móvel: '.formataFone($empresa["telefone"]).'
  </p>
  <p>
    (ii) Para o CESSIONÁRIO - FIXTECH INVESTIMENTOS LTDA - CNPJ/MF sob o nº 50.653.734/0001-48 na pessoa de seu representante legal, Sr. Paulo Cesar Chiodini 
    <br>b.1) e-mail: notificacao@lawsec.com.br 
    <br>b.2) fone móvel: 47-3307-5808
  </p>
  <p>
    (iii) Para o INTERVENIENTE RESPONSÁVEL SOLIDÁRIO, Sr(a). '.$empresa["representante"].'
    <br>c.1) e-mail: '.$empresa["email"].'
    <br>c.2) fone móvel: '.formataFone($empresa["telefone"]).'
  </p>
  <p>
    (iv) Para a INTERVENIENTE FIEL DEPOSITÁRIO, Sr(a). ). '.$empresa["representante"].'
    <br>d.1) e-mail: '.$empresa["email"].'
    <br>d.2) fone móvel: '.formataFone($empresa["telefone"]).'
  </p>
  <p>
    4.2 Declaram as partes que averiguaram os endereços eletrônicos e números de telefones móveis acima descritos e por atestarem serem detentores e usuários dos mesmos, declaram sua concordância na utilização dos mesmos para qualquer comunicação ou notificação, obrigando-se, em caso de desuso ou alteração, comunicar as demais partes em até 15 (quinze) dias, por escrito, bem com firmarem termo aditivo.
  </p>
  <p>
    4.3 Reconhecem as partes, nos termos do § 2º, art. 10, da MP 2.200-2, que as assinaturas digitais e/ou eletrônicas apostas neste instrumento como em qualquer título de crédito com sua origem vinculada ao presente instrumento de compromisso, independentemente de serem ou não produzidos com a utilização de processo de certificação disponibilizado pela ICP-Brasil, é admitido como válido, gerando por via de consequência todos seus efeitos legais perante as partes e quaisquer terceiros.
  </p>
  <p>
    <span class="bold under">5. DA CUSTÓDIA DE INFORMAÇÕES NA FORMA DA LEI 13.709/2018</span>
		<br><br>
		5.1 As partes comprometem-se a cumprir os requisitos estabelecidos neste instrumento e na legislação de proteção de dados aplicável no Brasil, incluindo, mas não se limitando à Lei nº 13.709 de agosto de 2018 (“Lei Geral de Proteção de Dados Pessoais” ou “LGPD”).
  </p>
	<p>
		5.2 A CEDENTE, o RESPONSÁVEL(IS) SOLIDÁRIO(S)e o FIEL DEPOSITÁRIO autorizam a coleta de dados pessoais imprescindíveis a execução do presente contrato, nos termos da Lei nº 13.709 de agosto de 2018, tais como (i) dados relacionados à sua identificação pessoal, a fim de que se garanta a fiel contratação pelo respectivo titular do contrato e; (ii) dados relacionados ao endereço, haja vista a necessidade de identificar o local em que esta encontra-se sediada.
	</p>
	<p>
		5.2.1 A CEDENTE, o RESPONSÁVEL(IS) SOLIDÁRIO(S) e o FIEL DEPOSITÁRIO reconhecem que todos os dados pessoais solicitados e coletados são os estritamente necessários para os fins almejados neste contrato.
	</p>
	<p>
		5.2.2 A CEDENTE, o RESPONSÁVEL(IS) SOLIDÁRIO(S) e o FIEL DEPOSITÁRIO autorizam o compartilhamento de seus dados, para os fins descritos neste item, com terceiros legalmente legítimos para defender os interesses da CESSIONÁRIA, bem como da(s) CEDENTE(S).
	</p>
	<p>
		5.3 A CEDENTE, o RESPONSÁVEL(IS) SOLIDÁRIO(S) e o FIEL DEPOSITÁRIO possuem tempo determinado de 03 (três) anos para acesso aos próprios dados armazenados, podendo também solicitar a exclusão dos referidos dados que foram previamente coletados com o seu consentimento, nos termos da Lei nº 13.709 de agosto de 2018.
	</p>
	<p>
		5.3.1 Caso a CEDENTE, o RESPONSÁVEL(IS) SOLIDÁRIO(S) e o FIEL DEPOSITÁRIO pretendam realizar a exclusão de algum dado coletado, deverão preencher uma declaração neste sentido, ciente que a revogação de determinados dados poderá importar em eventuais prejuízos na prestação de serviços.
	</p>
	<p>
		5.4 As partes comprometem-se, neste ato, a não utilizar os Dados para outros fins que não aos oriundos do presente Contrato de Prestação de Serviços.
	</p>
	<p>
		5.5 Ficarão armazenados os dados pessoais coletados, pelo prazo descrito no item 6.3, em caso de rescisão contratual, comprometendo-se a CESSIONÁRIA a descartá-los de forma adequada.
	</p>
	<p>
		<span class="bold under">6. DISPOSIÇÕES FINAIS</span>
		<br><br>
		6.1 Este Contrato tornar-se-á eficaz na data de sua assinatura e permanecerá em vigor até a total liquidação/pagamento dos Créditos por parte dos respectivos Devedores. 
	</p>
	<p>
		6.2 Os direitos de cada Parte previstos neste Contrato (i) são cumulativos com outros direitos previstos em lei, a menos que expressamente os excluam; e (ii) só admitem renúncia por escrito e específica. O não exercício, total ou parcial, de qualquer direito decorrente do presente Contrato, ou de seus Aditamentos, não implicará novação da obrigação ou renúncia ao respectivo direito por seu titular.
	</p>
	<p>
		6.3 Se qualquer disposição deste Contrato ou de seus Aditamentos for considerada inválida e/ou ineficaz, as Partes deverão envidar seus melhores esforços para substituí-la por outra de conteúdo similar e com os mesmos efeitos. A eventual invalidade e/ou ineficácia de uma ou mais cláusulas não afetará as demais disposições do presente Contrato ou de seus Aditamentos.
	</p>
	<p>
		6.5 As Partes se comprometem a empregar seus melhores esforços para resolver através de negociações qualquer disputa ou controvérsia relacionada a este Contrato ou aos Aditamentos.
	</p>
	<p>
		6.6 O inadimplemento de qualquer das obrigações previstas neste Contrato e seus aditamentos, por qualquer das partes, ensejará o direito de a parte lesada promover a execução específica para o cumprimento destas obrigações revestindo-se, para tal fim, o presente contrato, das características de título executivo extrajudicial, na forma do art. 784, II do Código de Processo Civil. Para tanto, reputa-se líquido e certo, para todos os fins de direito, o valor da soma de todos os créditos e/ou títulos que os representem (abrangendo principal e acessórios) objeto das operações formalizadas através deste contrato e dos respectivos Aditamentos celebrados entre as Partes.
	</p>
	<p>
		6.7 Para que o presente contrato e eventuais aditamentos operem plenamente seus efeitos jurídicos perante terceiros, poderão a qualquer momento ser levados a registro no Cartório de Registro Público de Títulos e Documentos. As despesas relativas ao registro do contrato correrão por conta exclusiva da CEDENTE.
	</p>
	<p>
		6.8 O presente contrato é firmado em caráter irrevogável e irretratável, obrigando-se as partes, seus herdeiros e sucessores, não podendo ser transferido ou cedido por qualquer das Partes, no todo ou em Parte, sem a prévia aprovação por escrita da outra Parte.
	</p>
	<p>
		6.9 Quaisquer alterações do presente contrato somente serão válidas quando feitas por escrito e assinadas pelas Partes, mediante a celebração do competente Aditamento.
	</p>
	<p>
		6.10 A nomenclatura utilizada como título das seções do presente Contrato tem apenas fins de referência, não definindo, limitando ou restringindo quaisquer de seus termos ou condições. 
	</p>
	<p>
		6.11 O contrato reflete as manifestações de vontade das partes, declarando que a decretação de estado de calamidade pública pela União Federal, Estados ou Municípios, qualquer que seja a razão incluindo-se pandemias, não modificará
	</p>
	<p>
		as obrigações e disposições contidas neste instrumento, renunciando, expressamente, a todo e qualquer prazo de natureza material e processual que impeçam ou obstem a pretensão executiva do objeto do contrato, em especial os contidos em legislações transitórias promulgadas ou publicadas durante e/ou após o estado de calamidade pública, inclusive normas que afastem a incidência dos juros, correção monetária e multas, na hipótese de inadimplemento ou descumprimento contratual.
	</p>
	<p>
		As Partes neste ato elegem o Foro da Comarca de Jaraguá do Sul, Estado de Santa Catarina, com expressa exclusão de qualquer outro, ainda que privilegiado, como competente para dirimir quaisquer dúvidas e/ou questões oriundas deste Contrato ou de eventuais aditamentos.
	</p>
	<p>
		E, por estarem assim justas e contratadas, as Partes assinam o presente contrato em uma única via, na forma digital, na presença de duas testemunhas.
	</p>
	<p>
		Jaraguá do Sul, '.date("d").'/'.date("m").'/'.date("Y").'.
	</p>
	<p><br><br><br>
		<span class="bold">CEDENTE				
		<br>'.$empresa["razao"].'
		<br>CNPJ/MF sob o nº '.formataCpfCnpj($empresa["cnpj"]).'
    </span>
	</p>
  <p><br><br><br>
  <span class="bold">CESSIONÁRIO
  <br>FIXTECH INVESTIMENTOS LTDA
  <br>CNPJ/MF sob o nº 50.653.734/0001-48
  </span>
</p>
	
	<p><br><br><br>
		<span class="bold">INTERVENIENTE RESPONSÁVEL SOLIDÁRIO	   	
		<br>'.$empresa["representante"].'			
		<br>CPF/MF nº '.formataCpfCnpj($empresa["cpf"]).'			
    </span>
	</p>
	<p><br><br><br>
		<span class="bold">INTERVENIENTE FIEL DEPOSITÁRIO
		<br>'.$empresa["representante"].'
		<br>CPF/MF nº '.formataCpfCnpj($empresa["cpf"]).'
    </span>
	</p>
	';
/*
	<p>
		Testemunhas:
		<br><br><br><br>
    <div>
      <div class="fleft">
        __________________________________
        <br>Nome:
        <br>CPF/MF nº 
      </div>
      <div class="fright">
        __________________________________
        <br>Nome:
        <br>CPF/MF nº 
      </div>
    </div>
	</p>
  gilberto@lawsecsa.com.br
  Lawsmart@2022
*/
	include('../mpdf/mpdf.php');
  $contrato = 'contrato_'.$empresa['cnpj'].'_'.str_replace(',', '_', $id).'.pdf';
	$mpdf = new mPDF();
  $css = file_get_contents('contrato.css');
  $mpdf->WriteHTML($css, 1);	
	$mpdf->setHTMLFooter('<p class="footer">Página <b>{PAGENO}</b> de <b>{nbpg}</b></p>');
	$mpdf->AddPage('P', 'A4', '', '', '', 13, 13, 13, 13, 5, 5);
	$mpdf->WriteHTML($html);
	$mpdf->Output('../contratos/'.$contrato);

  $json = '';
  if (file_exists('../contratos/'.$contrato)) {
    $json = array('criado' => true, 'emailEmpresa' => $empresa['email'], 'nome' => 'contratos/'.$contrato);
  } else {
    $json = array('criado' => false, 'emailEmpresa' => '', 'nome' => '');
  }

  echo json_encode($json);

?>