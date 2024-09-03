<?php
 session_start();
 if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'ancora') {
    header("Location: ../pagina_de_acesso_nao_autorizado.php");
    exit();
  }
 require_once('../Class/Config.php');
 $con = new mysqli(DB_HOST, DB_USER,DB_PASS, DB_NAME);
// echo var_dump($POST);
if (isset($_FILES["arquivo"])) {
    $lines = file($_FILES['arquivo']["tmp_name"]);
} else {
    echo "Arquivo não encontrado";
    die();
}
$count = 0;
// $lines = explode('\n', $lines[0], 54);

// echo $lines[8];

function formataData($data) {
	$ano = $data[0];
	$mes = $data[1];
	$dia = $data[2];
    return(abs((_dateToDays("1997","10","07")) - (_dateToDays($ano, $mes, $dia))));
}

$total = array();
$total['error'] = array();
$total['ok'] = 0;

foreach($lines as $line) {
    // cnpj

    // vencimento

    // valor

    // operacao

    // documento

    // nosso_numero

    // $mora_multa = substr($line, 266,)
    // echo 
    // echo "<br>";
    if ($operacao != "02") {    
        $vencimento = $con->real_escape_string(substr($line, 146, 6));
        $nosso_numero = $con->real_escape_string(substr($line, 62, 8));
        // echo "<br>";
        // echo "NOSSO NUMERO : ".$nosso_numero;
        // echo "<br>";
        
    
        $ocorrencia = $con->real_escape_string(substr($line, 108, 2));
        // echo "OCORRENCIA".$ocorrencia;
        // echo "<br>";
    
        // boleto pode ter vencimento alterado - update data_vencimento ( 14 - vencimento alterado )
        $year = $con->real_escape_string("20".substr($vencimento, 4, 2));
        $month = $con->real_escape_string(substr($vencimento, 2, 2));
        $day = $con->real_escape_string(substr($vencimento, 0, 2));
        if($ocorrencia == "14") {
            // echo 
            $sql = "UPDATE boletos SET data_vencimento='$year-$month-$day' WHERE nosso_numero=$nosso_numero";
            if(mysqli_query($con, $sql)) {
                // echo "BOLETO ".$nosso_numero." ATUALIZADO DATA_VENCIMENTO";
                // echo "<br>";
                $total['ok'] = $total['ok']+1;
            } else {
                // echo "BOLETO NÃO ENCONTRADO";
                // echo "<br>";
            }
        }
        
        // boleto pode ser rejeitado 12 (entrada rejeitada 03, instruções rejeitadas 16, baixas rejeitadas 15, PROTESTO REJEITADO 24 59 SISPAG 71 ENTRADA REGISTRADA AGUARDANDo)
        if($ocorrencia == "16" || $ocorrencia == "15" || $ocorrencia == "03" || $ocorrencia == "24" || $ocorrencia == "59" || $ocorrencia == "71") {
            $sql = "UPDATE boletos SET status='12' WHERE nosso_numero=$nosso_numero";
            $oper = "select id from operacoes where id = (select operacao from boletos where nosso_numero={$nosso_numero})";
            $query = mysqli_query($con, $oper);
            $oper_row = mysqli_fetch_assoc($query);
            array_push($total['error'], $oper_row['id']);
            if(mysqli_query($con, $sql)) {
                // echo "BOLETO ".$nosso_numero." ATUALIZADO 12";
                // echo "<br>";

            } else  {
                // echo "BOLETO NÃO ENCONTRADO";
                // echo "<br>";
            }
        }
        // boleto pode ser protesto 13 ( 19 CONFIRMA RECEBIMENTO DE INSTRUÇÃO DE PROTESTO, 23 - ENVIADO A CARTORIO  )
        if($ocorrencia == "19" || $ocorrencia == "23") {
            $sql = "UPDATE boletos SET status='13' WHERE nosso_numero=$nosso_numero";
            if(mysqli_query($con, $sql)) {
                // echo "BOLETO ".$nosso_numero." ATUALIZADO 13";
                // echo "<br>";
                $total['ok'] = $total['ok']+1;
            } else  {
                // echo "BOLETO NÃO ENCONTRADO";
                // echo "<br>";
            }
        }
    
        // boleto pode ser 7 (entrada confirmada - 02)
        if($ocorrencia == "02") {
            $sql = "UPDATE boletos SET status='7' WHERE nosso_numero=$nosso_numero";
            if(mysqli_query($con, $sql)) {
                // echo "BOLETO ".$nosso_numero." ATUALIZADO 7";
                // echo "<br>";
                $total['ok'] = $total['ok']+1;
            } else  {
                // echo "BOLETO NÃO ENCONTRADO";
                // echo "<br>";
            }
        }
    
        // boleto pode ser baixado 9 (liquidação normal 06 liquidação cartorio 08 e 05 liquidação parcial 07 liquidação em cartório 08 baixa simples 09 47 BAIXA COM TRANS DESCONTO )
        if($ocorrencia == "06" || $ocorrencia == "08" || $ocorrencia == "05" || $ocorrencia == "07" || $ocorrencia == "08" || $ocorrencia == "09" || $ocorrencia == "47") {
            $sql = "UPDATE boletos SET status='9', data_ocorrencia=CURRENT_DATE WHERE nosso_numero=$nosso_numero";
            // echo $sql;
            if(mysqli_query($con, $sql)) {
                // echo "BOLETO ".$nosso_numero." ATUALIZADO 9";
                $total['ok'] = $total['ok']+1;
                // echo "<br>";
            } else  {
                // echo "BOLETO NÃO ENCONTRADO";
                // echo "<br>";
            }
            
        }
    
    }

    
    $count += 1;

    // echo $line;
    // echo '<br>';
}
 
 echo json_encode($total);
?>