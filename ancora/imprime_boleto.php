<?php
session_start();
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'ancora') {
  header("Location: ../pagina_de_acesso_nao_autorizado.php");
  exit();
}
require_once('../Class/Config.php');
$con = new mysqli(DB_HOST, DB_USER,DB_PASS, DB_NAME);

$boleto_id = $con->real_escape_string($_GET['id']);

function prepared_query($mysqli, $sql, $params, $types = "") {    
  $stmt = $mysqli->prepare($sql);
  if (sizeof($params) > 0) {
    $types = $types ?: str_repeat("s", count($params));
    $stmt->bind_param($types, ...$params);
  }    
  $stmt->execute();
  return $stmt;
}

$sql = "SELECT * FROM boletos left join fornecedores on fornecedores.cnpj = boletos.cnpj and fornecedores.tipo = 'fornecedor' WHERE boletos.id LIKE ?";
$stmt = prepared_query($con, $sql, [$boleto_id], 's');
$boletos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$boleto = $boletos[0];
// echo $boleto["nosso_numero"];
$Avalista =  $boleto['razao'];
$AvalistaCnpj =  $boleto['cnpj'];
$data_vencimento = explode('-', $boleto["vencimento"]);
$dadosboleto["data_vencimento"] = $data_vencimento[2].'/'.$data_vencimento[1].'/'.$data_vencimento[0]; //vencimento
$dadosboleto["valor_boleto"] =  $boleto["valor"]; //valor
$dadosboleto["nosso_numero"] = $boleto["nosso_numero"]; //nosso_numero
$dadosboleto["identificador"] = $boleto["operacao"]; //operação
$dadosboleto["numero_documento"] = $boleto["documento"];	// nosso_numero
$data_emissao =  explode('-', $boleto["emissao"]);
$dadosboleto["data_documento"] = $data_emissao[2].'/'.$data_emissao[1].'/'.$data_emissao[0]; // data emissão

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = "GRUPO ELIAN";//$boleto["razao"];
$dadosboleto["sacadoCnpj"] = "82698085000198";
$dadosboleto["endereco1"] =  "Manoel Francisco da Costa, 215, Bairro Vieiras";//$boleto["rua"].",".$boleto["bairro"].",".$boleto["numero"];
$dadosboleto["endereco2"] = " 89257-000, Jaraguá do Sul, SC";///$boleto["cidade"].",".$boleto["estado"]." - ".$boleto["cep"];

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "";
$dadosboleto["demonstrativo2"] = "";
$dadosboleto["demonstrativo3"] = "";

$dadosboleto["cpf_cnpj"] = "5100827200179";
$dadosboleto["endereco"] = "";
$dadosboleto["cidade_uf"] = "";
$dadosboleto["cedente"] = "FINTEX SECURITIZADORA LTDA";


// hard-coded
$dadosboleto["agencia"] = '0862';
$dadosboleto["conta"] = '55792';
$dadosboleto["conta_dv"] = '3';
$dadosboleto["carteira"] = '109';
$dadosboleto["especie"] = "DM";

$dadosboleto["instrucoes1"] = "- Cobrar multa de 3% após vencimento";
$dadosboleto["instrucoes2"] = "- Cobrar mora de 5% após vencimento";
$dadosboleto["instrucoes3"] = "";
$dadosboleto["instrucoes4"] = "";






$codigobanco = "341";
$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
$nummoeda = "9";


$fator_vencimento = fator_vencimento($dadosboleto["data_vencimento"]);

//valor tem 10 digitos, sem virgula
$valor = formata_numero($dadosboleto["valor_boleto"],10,0,"valor");
$valor_numerico = str_pad(str_replace('.', '', $valor), 10, '0', STR_PAD_LEFT);
//agencia é 4 digitos
$agencia = formata_numero($dadosboleto["agencia"],4,0);
//conta é 5 digitos + 1 do dv
$conta = formata_numero($dadosboleto["conta"],5,0);
$conta_dv = formata_numero($dadosboleto["conta_dv"],1,0);
//carteira 175
$carteira = $dadosboleto["carteira"];
//nosso_numero no maximo 8 digitos
$nnum = formata_numero($dadosboleto["nosso_numero"],8,0);
// echo "noss_numero".$nnum;
$num_codigo_barras_campo1_no_dv = $codigobanco.$nummoeda.$carteira.substr($dadosboleto['nosso_numero'], 0, 2);
$num_codigo_barras_campo1 = $num_codigo_barras_campo1_no_dv.modulo_10($num_codigo_barras_campo1_no_dv);

$num_codigo_barras_campo2_no_dv = substr($dadosboleto['nosso_numero'], 2, 6).modulo_10($agencia.$conta.$carteira.$dadosboleto['nosso_numero']).substr($agencia, 0, 3);
$num_codigo_barras_campo2 = $num_codigo_barras_campo2_no_dv.modulo_10($num_codigo_barras_campo2_no_dv);

$num_codigo_barras_campo3_no_dv = substr($agencia, 3, 1).$dadosboleto['conta'].$dadosboleto['conta_dv'].'000';
$num_codigo_barras_campo3 = $num_codigo_barras_campo3_no_dv.modulo_10($num_codigo_barras_campo3_no_dv);

$num_codigo_barras_campo5 = $fator_vencimento.$valor_numerico;

$codigo_barras_dv = $num_codigo_barras_campo1_no_dv.$num_codigo_barras_campo2_no_dv.$num_codigo_barras_campo3_no_dv.$num_codigo_barras_campo5;

$codigo_barras_dv_certo = $codigobanco.$nummoeda.$fator_vencimento.$valor_numerico.$carteira.$dadosboleto['nosso_numero'].modulo_10($agencia.$conta.$carteira.$dadosboleto['nosso_numero']).$agencia.$conta.modulo_10($agencia.$conta).'000';
$num_codigo_barras_campo4 = digitoVerificador_barra($codigo_barras_dv_certo);

// echo "<br>";
// echo "codigo_barras_dv is".$codigo_barras_dv_certo;
// echo "<br>";
// echo "DV IS".$num_codigo_barras_campo4;
// echo "<br>";

// echo "OLD DV IS".modulo_11($num_codigo_barras_campo1_no_dv.$num_codigo_barras_campo2_no_dv.$num_codigo_barras_campo3_no_dv.$num_codigo_barras_campo5);
// echo "<br>";
$num_codigo_barras = $num_codigo_barras_campo1.'.'.$num_codigo_barras_campo2.'.'.$num_codigo_barras_campo3.'.'.$num_codigo_barras_campo4.'.'.$num_codigo_barras_campo5;
$codigo_barras = $num_codigo_barras_campo1.'.'.$num_codigo_barras_campo2.'.'.$num_codigo_barras_campo3.'.'.$num_codigo_barras_campo4.'.'.$num_codigo_barras_campo5;
// 43 numeros para o calculo do digito verificador

// Numero para o codigo de barras com 44 digitos
$linha = $codigo_barras;

$nossonumero = $carteira.'/'.$nnum.'-'.modulo_10($agencia.$conta.$carteira.$nnum);
$agencia_codigo = $agencia." / ". $conta."-".modulo_10($agencia.$conta);

$dadosboleto["codigo_barras"] = $codigo_barras;
$dadosboleto["linha_digitavel"] = $linha; // verificar
$dadosboleto["agencia_codigo"] = $agencia_codigo ;
$dadosboleto["nosso_numero"] = $nossonumero;
$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;



function modulo_11($num, $base=9, $r=0)  {
  /**
   *   Autor:
   *           Pablo Costa <pablo@users.sourceforge.net>
   *
   *   Função:
   *    Calculo do Modulo 11 para geracao do digito verificador 
   *    de boletos bancarios conforme documentos obtidos 
   *    da Febraban - www.febraban.org.br 
   *
   *   Entrada:
   *     $num: string numérica para a qual se deseja calcularo digito verificador;
   *     $base: valor maximo de multiplicacao [2-$base]
   *     $r: quando especificado um devolve somente o resto
   *
   *   Saída:
   *     Retorna o Digito verificador.
   *
   *   Observações:
   *     - Script desenvolvido sem nenhum reaproveitamento de código pré existente.
   *     - Assume-se que a verificação do formato das variáveis de entrada é feita antes da execução deste script.
   */                                        

  $soma = 0;
  $fator = 2;

  /* Separacao dos numeros */
  for ($i = strlen($num); $i > 0; $i--) {
      // pega cada numero isoladamente
      $numeros[$i] = substr($num,$i-1,1);
      // Efetua multiplicacao do numero pelo falor
      $parcial[$i] = $numeros[$i] * $fator;
      // Soma dos digitos
      $soma += $parcial[$i];
      if ($fator == $base) {
          // restaura fator de multiplicacao para 2 
          $fator = 1;
      }
      $fator++;
  }

  /* Calculo do modulo 11 */
  if ($r == 0) {
      $soma *= 10;
      $digito = $soma % 11;
      if ($digito == 10) {
          $digito = 0;
      }
      return $digito;
  } elseif ($r == 1){
      $resto = $soma % 11;
      return $resto;
  }
}
// FUNÇÕES
// Algumas foram retiradas do Projeto PhpBoleto e modificadas para atender as particularidades de cada banco

function digitoVerificador_barra($numero) {
	$resto2 = modulo_11($numero, 9, 1);
	$digito = 11 - $resto2;
     if ($digito == 0 || $digito == 1 || $digito == 10  || $digito == 11) {
        $dv = 1;
     } else {
        $dv = $digito;
     }
	 return $dv;
}

function formata_numero($numero,$loop,$insert,$tipo = "geral") {
	if ($tipo == "geral") {
		$numero = str_replace(",","",$numero);
		while(strlen($numero)<$loop){
			$numero = $insert . $numero;
		}
	}
	if ($tipo == "valor") {
		/*
		retira as virgulas
		formata o numero
		preenche com zeros
		*/
		$numero = str_replace(",","",$numero);
		while(strlen($numero)<$loop){
			$numero = $insert . $numero;
		}
	}
	if ($tipo == "convenio") {
		while(strlen($numero)<$loop){
			$numero = $numero . $insert;
		}
	}
	return $numero;
}


function fbarcode($valor){

$fino = 1 ;
$largo = 3 ;
$altura = 50 ;

  $barcodes[0] = "00110" ;
  $barcodes[1] = "10001" ;
  $barcodes[2] = "01001" ;
  $barcodes[3] = "11000" ;
  $barcodes[4] = "00101" ;
  $barcodes[5] = "10100" ;
  $barcodes[6] = "01100" ;
  $barcodes[7] = "00011" ;
  $barcodes[8] = "10010" ;
  $barcodes[9] = "01010" ;
  for($f1=9;$f1>=0;$f1--){ 
    for($f2=9;$f2>=0;$f2--){  
      $f = ($f1 * 10) + $f2 ;
      $texto = "" ;
      for($i=1;$i<6;$i++){ 
        $texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1);
      }
      $barcodes[$f] = $texto;
    }
  }


//Desenho da barra


//Guarda inicial
?><img src=imagens/p.png width=<?php echo $fino?> height=<?php echo $altura?> border=0><img 
src=imagens/b.png width=<?php echo $fino?> height=<?php echo $altura?> border=0><img 
src=imagens/p.png width=<?php echo $fino?> height=<?php echo $altura?> border=0><img 
src=imagens/b.png width=<?php echo $fino?> height=<?php echo $altura?> border=0><img 
<?php
$texto = $valor ;
if((strlen($texto) % 2) <> 0){
	$texto = "0" . $texto;
}

// Draw dos dados
while (strlen($texto) > 0) {
  $i = round(esquerda($texto,2));
  $texto = direita($texto,strlen($texto)-2);
  $f = $barcodes[$i];
  for($i=1;$i<11;$i+=2){
    if (substr($f,($i-1),1) == "0") {
      $f1 = $fino ;
    }else{
      $f1 = $largo ;
    }
?>
    src=imagens/p.png width=<?php echo $f1?> height=<?php echo $altura?> border=0><img 
<?php
    if (substr($f,$i,1) == "0") {
      $f2 = $fino ;
    }else{
      $f2 = $largo ;
    }
?>
    src=imagens/b.png width=<?php echo $f2?> height=<?php echo $altura?> border=0><img 
<?php
  }
}

// Draw guarda final
?>
src=imagens/p.png width=<?php echo $largo?> height=<?php echo $altura?> border=0><img 
src=imagens/b.png width=<?php echo $fino?> height=<?php echo $altura?> border=0><img 
src=imagens/p.png width=<?php echo 1?> height=<?php echo $altura?> border=0> 
  <?php
} //Fim da função

function esquerda($entra,$comp){
	return substr($entra,0,$comp);
}

function direita($entra,$comp){
	return substr($entra,strlen($entra)-$comp,$comp);
}

function fator_vencimento($data) {
	$data = explode("/",$data);
	$ano = $data[2];
	$mes = $data[1];
	$dia = $data[0];
    return(abs((_dateToDays("1997","10","07")) - (_dateToDays($ano, $mes, $dia))));
}

function _dateToDays($year,$month,$day) {
    $century = substr($year, 0, 2);
    $year = substr($year, 2, 2);
    if ($month > 2) {
        $month -= 3;
    } else {
        $month += 9;
        if ($year) {
            $year--;
        } else {
            $year = 99;
            $century --;
        }
    }
    return ( floor((  146097 * $century)    /  4 ) +
            floor(( 1461 * $year)        /  4 ) +
            floor(( 153 * $month +  2) /  5 ) +
                $day +  1721119);
}

function modulo_10($num) { 
		$numtotal10 = 0;
        $fator = 2;

        // Separacao dos numeros
        for ($i = strlen($num); $i > 0; $i--) {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num,$i-1,1);
            // Efetua multiplicacao do numero pelo (falor 10)
            // 2002-07-07 01:33:34 Macete para adequar ao Mod10 do Itaú
            $temp = $numeros[$i] * $fator; 
            $temp0=0;
            foreach (preg_split('//',$temp,-1,PREG_SPLIT_NO_EMPTY) as $k=>$v){ $temp0+=$v; }
            $parcial10[$i] = $temp0; //$numeros[$i] * $fator;
            // monta sequencia para soma dos digitos no (modulo 10)
            $numtotal10 += $parcial10[$i];
            if ($fator == 2) {
                $fator = 1;
            } else {
                $fator = 2; // intercala fator de multiplicacao (modulo 10)
            }
        }
		
        // várias linhas removidas, vide função original
        // Calculo do modulo 10
        $resto = $numtotal10 % 10;
        $digito = 10 - $resto;
        if ($resto == 0) {
            $digito = 0;
        }
		
        return $digito;
		
}

// Alterada por Glauber Portella para especificação do Itaú
function monta_linha_digitavel($codigo) {
		// campo 1
        $banco    = substr($codigo,0,3);
        $moeda    = substr($codigo,3,1);
        $ccc      = substr($codigo,19,3);
		$ddnnum   = substr($codigo,22,2);
		$dv1      = modulo_10($banco.$moeda.$ccc.$ddnnum);
		// campo 2
		$resnnum  = substr($codigo,24,6);
		$dac1     = substr($codigo,30,1);//modulo_10($agencia.$conta.$carteira.$nnum);
		$dddag    = substr($codigo,31,3);
		$dv2      = modulo_10($resnnum.$dac1.$dddag);
		// campo 3
		$resag    = substr($codigo,34,1);
		$contadac = substr($codigo,35,6); //substr($codigo,35,5).modulo_10(substr($codigo,35,5));
		$zeros    = substr($codigo,41,3);
		$dv3      = modulo_10($resag.$contadac.$zeros);
		// campo 4
		$dv4      = substr($codigo,4,1);
		// campo 5
        $fator    = substr($codigo,5,4);
        $valor    = substr($codigo,9,10);
		
        $campo1 = substr($banco.$moeda.$ccc.$ddnnum.$dv1,0,5) . '.' . substr($banco.$moeda.$ccc.$ddnnum.$dv1,5,5);
        $campo2 = substr($resnnum.$dac1.$dddag.$dv2,0,5) . '.' . substr($resnnum.$dac1.$dddag.$dv2,5,6);
        $campo3 = substr($resag.$contadac.$zeros.$dv3,0,5) . '.' . substr($resag.$contadac.$zeros.$dv3,5,6);
        $campo4 = $dv4;
        $campo5 = $fator.$valor;
		
        return "$campo1 $campo2 $campo3 $campo4 $campo5"; 
}

function geraCodigoBanco($numero) {
    $parte1 = substr($numero, 0, 3);
    $parte2 = modulo_11($parte1);
    return $parte1 . "-" . $parte2;
}

?>



<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>
<HTML>
<HEAD>
<TITLE><?php if(isset($dadosboleto["identificacao"])){ echo $dadosboleto["identificacao"];} ?></TITLE>
<META http-equiv=Content-Type content=text/html charset=ISO-8859-1>
<meta name="Generator" content="Projeto BoletoPHP - www.boletophp.com.br - Licença GPL" />
<style type=text/css>
<!--.cp {  font: bold 10px Arial; color: black}
<!--.ti {  font: 9px Arial, Helvetica, sans-serif}
<!--.ld { font: bold 15px Arial; color: #000000}
<!--.ct { FONT: 9px "Arial Narrow"; COLOR: #000033}
<!--.cn { FONT: 9px Arial; COLOR: black }
<!--.bc { font: bold 20px Arial; color: #000000 }
<!--.ld2 { font: bold 12px Arial; color: #000000 }
--></style>
</head>

<BODY text=#000000 bgColor=#ffffff topMargin=0 rightMargin=0>
<table width=666 cellspacing=0 cellpadding=0 border=0><tr><td valign=top class=cp><DIV ALIGN="CENTER">Instruções
de Impressão</DIV></TD></TR><TR><TD valign=top class=cp><DIV ALIGN="left">
<p>
<li>Imprima em impressora jato de tinta (ink jet) ou laser em qualidade normal ou alta (Não use modo econômico).<br>
<li>Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens mínimas à esquerda e à direita do formulário.<br>
<li>Corte na linha indicada. Não rasure, risque, fure ou dobre a região onde se encontra o código de barras.<br>
<li>Caso não apareça o código de barras no final, clique em F5 para atualizar esta tela.
<li>Caso tenha problemas ao imprimir, copie a seqüencia numérica abaixo e pague no caixa eletrônico ou no internet banking:<br><br>
<span class="ld2">
&nbsp;&nbsp;&nbsp;&nbsp;Linha Digitável: &nbsp;<?php echo $dadosboleto["linha_digitavel"]?><br>
&nbsp;&nbsp;&nbsp;&nbsp;Valor: &nbsp;&nbsp;R$ <?php echo $dadosboleto["valor_boleto"]?><br>
</span>
</DIV></td></tr></table><br><table cellspacing=0 cellpadding=0 width=666 border=0><TBODY><TR><TD class=ct width=666><img height=1 src=imagens/6.png width=665 border=0></TD></TR><TR><TD class=ct width=666><div align=right><b class=cp>Recibo
do Sacado</b></div></TD></tr></tbody></table><table width=666 cellspacing=5 cellpadding=0 border=0><tr><td width=41></TD></tr></table>
<table width=666 cellspacing=5 cellpadding=0 border=0 align=Default>
  <tr>
    <td class=ti width=455><?php if(isset($dadosboleto["identificacao"])){ echo $dadosboleto["identificacao"];} ?> <?php  isset($dadosboleto["cpf_cnpj"]) ? "<br>".$dadosboleto["cpf_cnpj"] : '' ?><br>
	<?php echo $dadosboleto["endereco"]; ?><br>
	<?php echo $dadosboleto["cidade_uf"]; ?><br>
    </td>
    <td align=RIGHT width=150 class=ti>&nbsp;</td>
  </tr>
</table>
<BR><table cellspacing=0 cellpadding=0 width=666 border=0><tr><td class=cp width=150>
  <span class="campo"><IMG
      src="imagens/logoitau.jpg" width="150" height="40"
      border=0></span></td>
<td width=3 valign=bottom><img height=22 src=imagens/3.png width=2 border=0></td><td class=cpt width=58 valign=bottom><div align=center><font class=bc><?php echo $dadosboleto["codigo_banco_com_dv"]?></font></div></td><td width=3 valign=bottom><img height=22 src=imagens/3.png width=2 border=0></td><td class=ld align=right width=453 valign=bottom><span class=ld>
<span class="campotitulo">
<?php echo $dadosboleto["linha_digitavel"]?>
</span></span></td>
</tr><tbody><tr><td colspan=5><img height=2 src=imagens/2.png width=666 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=298 height=13>Cedente</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=126 height=13>Agência/Código
do Cedente</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=34 height=13>Espécie</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=53 height=13>Quantidade</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=120 height=13>Nosso
número</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=298 height=12>
  <span class="campo"><?php echo $dadosboleto["cedente"]; ?></span></td>
<td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=126 height=12>
  <span class="campo">
  <?php echo $dadosboleto["agencia_codigo"]?>
  </span></td>
<td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=34 height=12><span class="campo">
  <?php echo $dadosboleto["especie"]?>
</span>
 </td>
<td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=53 height=12><span class="campo">
  <?php if(isset($dadosboleto["quantidade"])){ echo $dadosboleto["quantidade"];}else{ echo 1;}?>
</span>
 </td>
<td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=120 height=12>
  <span class="campo">
  <?php echo $dadosboleto["nosso_numero"]?>
  </span></td>
</tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=298 height=1><img height=1 src=imagens/2.png width=298 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=126 height=1><img height=1 src=imagens/2.png width=126 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=34 height=1><img height=1 src=imagens/2.png width=34 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=53 height=1><img height=1 src=imagens/2.png width=53 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=120 height=1><img height=1 src=imagens/2.png width=120 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top colspan=3 height=13>Número
do documento</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=132 height=13>CPF/CNPJ</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=134 height=13>Vencimento</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>Valor
documento</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top colspan=3 height=12>
  <span class="campo">
  <?php echo $dadosboleto["numero_documento"]?>
  </span></td>
<td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=132 height=12>
  <span class="campo">
  <?php echo $dadosboleto["cpf_cnpj"]?>
  </span></td>
<td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=134 height=12>
  <span class="campo">
  <?php echo $dadosboleto["data_vencimento"]?>
  </span></td>
<td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12>
  <span class="campo">
  <?php echo $dadosboleto["valor_boleto"]?>
  </span></td>
</tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=113 height=1><img height=1 src=imagens/2.png width=113 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=72 height=1><img height=1 src=imagens/2.png width=72 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=132 height=1><img height=1 src=imagens/2.png width=132 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=134 height=1><img height=1 src=imagens/2.png width=134 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=113 height=13>(-)
Desconto / Abatimentos</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=112 height=13>(-)
Outras deduções</td>
<td class=ct valign=top width=7 height=13>
<img height=13 src=imagens/1.png width=1 border=0>
</td>
<td class=ct valign=top width=113 height=13>(+)
Mora / Multa</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=113 height=13>(+)
Outros acréscimos</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>(=)
Valor cobrado</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=113 height=12></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=112 height=12></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=113 height=12></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=113 height=12></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12></td></tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=113 height=1><img height=1 src=imagens/2.png width=113 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=112 height=1><img height=1 src=imagens/2.png width=112 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=113 height=1><img height=1 src=imagens/2.png width=113 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=113 height=1><img height=1 src=imagens/2.png width=113 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=659 height=13>Sacado</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=659 height=12>
  <span class="campo">
  <?php echo $dadosboleto["sacado"]?>
  </span></td>
</tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=659 height=1><img height=1 src=imagens/2.png width=659 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct  width=7 height=12></td><td class=ct  width=564 >Demonstrativo</td><td class=ct  width=7 height=12></td><td class=ct  width=88 >Autenticação
mecânica</td></tr><tr><td  width=7 ></td><td class=cp width=564 >
<span class="campo">
  <?php echo $dadosboleto["demonstrativo1"]?><br>
  <?php echo $dadosboleto["demonstrativo2"]?><br>
  <?php echo $dadosboleto["demonstrativo3"]?><br>
  </span>
  </td><td  width=7 ></td><td  width=88 ></td></tr></tbody></table><table cellspacing=0 cellpadding=0 width=666 border=0><tbody><tr><td width=7></td><td  width=500 class=cp>
<br><br><br>
</td><td width=159></td></tr></tbody></table><table cellspacing=0 cellpadding=0 width=666 border=0><tr><td class=ct width=666></td></tr><tbody><tr><td class=ct width=666>
<div align=right>Corte na linha pontilhada</div></td></tr><tr><td class=ct width=666><img height=1 src=imagens/6.png width=665 border=0></td></tr></tbody></table><br><table cellspacing=0 cellpadding=0 width=666 border=0><tr><td class=cp width=150>
  <span class="campo"><IMG
      src="imagens/logoitau.jpg" width="150" height="40"
      border=0></span></td>
<td width=3 valign=bottom><img height=22 src=imagens/3.png width=2 border=0></td><td class=cpt width=58 valign=bottom><div align=center><font class=bc><?php echo $dadosboleto["codigo_banco_com_dv"]?></font></div></td><td width=3 valign=bottom><img height=22 src=imagens/3.png width=2 border=0></td><td class=ld align=right width=453 valign=bottom><span class=ld>
<span class="campotitulo">
<?php echo $dadosboleto["linha_digitavel"]?>
</span></span></td>
</tr><tbody><tr><td colspan=5><img height=2 src=imagens/2.png width=666 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=472 height=13>Local
de pagamento</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>Vencimento</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=472 height=12>Pagável
em qualquer Banco até o vencimento</td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12>
  <span class="campo">
  <?php echo $dadosboleto["data_vencimento"]?>
  </span></td>
</tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=472 height=1><img height=1 src=imagens/2.png width=472 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=472 height=13>Cedente</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>Agência/Código
cedente</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=472 height=12>
  <span class="campo">
  <?php echo $dadosboleto["cedente"]?>
  </span></td>
<td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12>
  <span class="campo">
  <?php echo $dadosboleto["agencia_codigo"]?>
  </span></td>
</tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=472 height=1><img height=1 src=imagens/2.png width=472 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13>
<img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=113 height=13>Data
do documento</td><td class=ct valign=top width=7 height=13> <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=153 height=13>N<u>o</u>
documento</td><td class=ct valign=top width=7 height=13> <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=62 height=13>Espécie
doc.</td><td class=ct valign=top width=7 height=13> <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=34 height=13>Aceite</td><td class=ct valign=top width=7 height=13>
<img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=82 height=13>Data
processamento</td><td class=ct valign=top width=7 height=13> <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>Nosso
número</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=113 height=12><div align=left>
  <span class="campo">
  <?php echo $dadosboleto["data_documento"]?>
  </span></div></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=153 height=12>
    <span class="campo">
    <?php echo $dadosboleto["numero_documento"]?>
    </span></td>
  <td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=62 height=12><div align=left><span class="campo">
    <?php if(isset($dadosboleto["especie_doc"])){ echo $dadosboleto["especie_doc"];}?>
  </span>
 </div></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=34 height=12><div align=left><span class="campo">
 <?php if(isset($dadosboleto["aceite"])){ echo $dadosboleto["aceite"];} ?>
 </span>
 </div></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=82 height=12><div align=left>
   <span class="campo">
   <?php if(isset($dadosboleto["data_processamento"])){ echo $dadosboleto["data_processamento"];}?>
   </span></div></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12>
     <span class="campo">
     <?php echo $dadosboleto["nosso_numero"]?>
     </span></td>
</tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=113 height=1><img height=1 src=imagens/2.png width=113 border=0></td><td valign=top width=7 height=1>
<img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=153 height=1><img height=1 src=imagens/2.png width=153 border=0></td><td valign=top width=7 height=1>
<img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=62 height=1><img height=1 src=imagens/2.png width=62 border=0></td><td valign=top width=7 height=1>
<img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=34 height=1><img height=1 src=imagens/2.png width=34 border=0></td><td valign=top width=7 height=1>
<img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=82 height=1><img height=1 src=imagens/2.png width=82 border=0></td><td valign=top width=7 height=1>
<img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1>
<img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr>
<td class=ct valign=top width=7 height=13> <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top COLSPAN="3" height=13>Uso
do banco</td><td class=ct valign=top height=13 width=7> <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=83 height=13>Carteira</td><td class=ct valign=top height=13 width=7>
<img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=53 height=13>Espécie</td><td class=ct valign=top height=13 width=7>
<img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=123 height=13>Quantidade</td><td class=ct valign=top height=13 width=7>
<img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=72 height=13>
Valor Documento</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>(=)
Valor documento</td></tr><tr> <td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td valign=top class=cp height=12 COLSPAN="3"><div align=left>
 </div></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=83>
<div align=left> <span class="campo">
  <?php echo $dadosboleto["carteira"]?>
</span></div></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=53><div align=left><span class="campo">
<?php echo $dadosboleto["especie"]?>
</span>
 </div></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=123><span class="campo">
 <?php if(isset($dadosboleto["quantidade"])){ echo $dadosboleto["quantidade"];}else{ echo 1;}?>
 </span>
 </td>
 <td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=72>
   <span class="campo">
   <?php if(isset($dadosboleto["valor_unitario"])){ echo $dadosboleto["valor_unitario"];} ?>
   </span></td>
 <td class=cp valign=top width=7 height=12> <img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12>
   <span class="campo">
   <?php echo $dadosboleto["valor_boleto"]?>
   </span></td>
</tr><tr><td valign=top width=7 height=1> <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=75 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=31 height=1><img height=1 src=imagens/2.png width=31 border=0></td><td valign=top width=7 height=1>
<img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=83 height=1><img height=1 src=imagens/2.png width=83 border=0></td><td valign=top width=7 height=1>
<img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=53 height=1><img height=1 src=imagens/2.png width=53 border=0></td><td valign=top width=7 height=1>
<img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=123 height=1><img height=1 src=imagens/2.png width=123 border=0></td><td valign=top width=7 height=1>
<img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=72 height=1><img height=1 src=imagens/2.png width=72 border=0></td><td valign=top width=7 height=1>
<img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody>
</table><table cellspacing=0 cellpadding=0 width=666 border=0><tbody><tr><td align=right width=10><table cellspacing=0 cellpadding=0 border=0 align=left><tbody>
<tr> <td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td></tr><tr>
<td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td></tr><tr>
<td valign=top width=7 height=1><img height=1 src=imagens/2.png width=1 border=0></td></tr></tbody></table></td><td valign=top width=468 rowspan=5><font class=ct>Instruções
(Texto de responsabilidade do cedente)</font><br><br><span class=cp> <FONT class=campo>
<?php echo $dadosboleto["instrucoes1"]; ?><br>
<?php echo $dadosboleto["instrucoes2"]; ?><br>
<?php echo $dadosboleto["instrucoes3"]; ?><br>
<?php echo $dadosboleto["instrucoes4"]; ?></FONT><br><br>
</span></td>
<td align=right width=188><table cellspacing=0 cellpadding=0 border=0>
 <tbody>
  <tr>
    <td class=ct valign=top width=7 height=13>
      <img height=13 src=imagens/1.png width=1 border=0>
    </td>
    <td class=ct valign=top width=180 height=13>(-) Desconto / Abatimentos</td>
  </tr>  
  <tr> 
  <td class=cp valign=top width=7 height=12>
    <img height=12 src=imagens/1.png width=1 border=0>
  </td>
  <td class=cp valign=top align=right width=180 height=12>
    0,00  <?php //descontos ?>
  </td>
  </tr>
  <tr>
    <td valign=top width=7 height=1>
      <img height=1 src=imagens/2.png width=7 border=0>
    </td>
    <td valign=top width=180 height=1>
      <img height=1 src=imagens/2.png width=180 border=0>
      
    </td>
  </tr>
  </tbody>
   </table>
   </td>
 </tr><tr><td align=right width=10>
<table cellspacing=0 cellpadding=0 border=0 align=left><tbody>
  <tr>
    <td class=ct valign=top width=7 height=13>
      <img height=13 src=imagens/1.png width=1 border=0>
    </td>
  </tr>
  <tr>
    <td class=cp valign=top width=7 height=12>
      <img height=12 src=imagens/1.png width=1 border=0>
      
    </td>
  </tr>
  <tr>
    <td valign=top width=7 height=1>
      <img height=1 src=imagens/2.png width=1 border=0>
    </td>
  </tr>
  </tbody>
</table>
</td><td align=right width=188><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>(-)
Outras deduções</td>
</tr>
<tr>
  <td class=cp valign=top width=7 height=12> 
    <img height=12 src=imagens/1.png width=1 border=0>
  </td>
  <td class=cp valign=top align=right width=180 height=12>
  0,00<?php //outras deduões ?>
  </td></tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table></td></tr><tr><td align=right width=10>
<table cellspacing=0 cellpadding=0 border=0 align=left><tbody><tr><td class=ct valign=top width=7 height=13>
<img height=13 src=imagens/1.png width=1 border=0></td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td></tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=1 border=0></td></tr></tbody></table></td><td align=right width=188>
<table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>(+)
Mora / Multa</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12> 0,00 <?php //mora_multa ?></td></tr><tr>
<td valign=top width=7 height=1> <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1>
<img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table></td></tr><tr><td align=right width=10><table cellspacing=0 cellpadding=0 border=0 align=left><tbody><tr>
<td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td></tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=1 border=0></td></tr></tbody></table></td><td align=right width=188>
<table cellspacing=0 cellpadding=0 border=0><tbody><tr> <td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>(+)
Outros acréscimos</td></tr><tr> <td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12> 0,00 <?php //outros acréscimos ?></td></tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table></td></tr><tr><td align=right width=10><table cellspacing=0 cellpadding=0 border=0 align=left><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td></tr></tbody></table></td><td align=right width=188><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>(=)
Valor cobrado</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12> <?php echo $dadosboleto["valor_boleto"] ?> </td></tr></tbody>
</table></td></tr></tbody></table><table cellspacing=0 cellpadding=0 width=666 border=0><tbody><tr><td valign=top width=666 height=1><img height=1 src=imagens/2.png width=666 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=659 height=13>Sacado</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=659 height=12><span class="campo">
<?php echo $dadosboleto["sacado"].'  '?> 
<?php echo $dadosboleto["sacadoCnpj"]?>

</span>
</td>
</tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=659 height=12><span class="campo">
<?php echo $dadosboleto["endereco1"]?>
</span>
</td>
</tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=472 height=13>
  <span class="campo">
  <?php echo $dadosboleto["endereco2"]?>
  </span></td>
<td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>Cód.
baixa</td></tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=472 height=1><img height=1 src=imagens/2.png width=472 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table><TABLE cellSpacing=0 cellPadding=0 border=0 width=666><TBODY><TR><TD class=ct  width=7 height=12></TD><TD class=ct  width=300 >Sacador/Avalista <?php echo $Avalista;?></TD><TD class=ct  width=100 >CNPJ <?php echo $AvalistaCnpj;?></TD><TD class=ct  width=250 ><div align=right>Autenticação
mecânica - <b class=cp>Ficha de Compensação</b></div></TD></TR><TR><TD class=ct  colspan=3 ></TD></tr></tbody></table><TABLE cellSpacing=0 cellPadding=0 width=666 border=0><TBODY><TR><TD vAlign=bottom align=left height=50><?php fbarcode($dadosboleto["codigo_barras"]); ?>
 </TD>
</tr></tbody></table><TABLE cellSpacing=0 cellPadding=0 width=666 border=0><TR><TD class=ct width=666></TD></TR><TBODY><TR><TD class=ct width=666><div align=right>Corte
na linha pontilhada</div></TD></TR><TR><TD class=ct width=666><img height=1 src=imagens/6.png width=665 border=0></TD></tr></tbody></table>
</BODY></HTML>
<?php 

echo "<script>window.print();</script>";