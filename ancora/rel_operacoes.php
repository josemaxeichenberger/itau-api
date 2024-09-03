<?php
require('../Class/fpdf186/fpdf.php');
function my_autoload($pClassName)
{
    include('../Class' . "/" . $pClassName . ".class.php");
}
spl_autoload_register("my_autoload");
error_reporting(E_ALL);
ini_set('display_errors', '1');

$status = isset($_GET["status"]) ? htmlspecialchars($_GET["status"]) : null;
$inicio = isset($_GET["inicio"]) ? htmlspecialchars($_GET["inicio"]) : null;
$termino = isset($_GET["termino"]) ? htmlspecialchars($_GET["termino"]) : null;

class PDF extends FPDF
{
    function Header()
    {
        global $title;
        $this->Image('../Class/fornecedores/FINTEXLOGO.png', 50, 2, 45);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Calculate width of title and position
        $w = $this->GetStringWidth($title) + 6;
        $this->SetX((210) / 2);
        // Colors of frame, background and text
        $this->SetDrawColor(255, 255, 255);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        // Thickness of frame (1 mm)
        $this->SetLineWidth(0.5);
        // Title
        $this->Cell($w, 9, iconv('UTF-8', 'ISO-8859-1', $title), 1, 1, 'C', true);
        $this->Image('../Class/fornecedores/FINTEXLOGO.png', 200, 2, 45);

        // Line break
        $this->Ln(2);
    }

    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Text color in gray
        $this->SetTextColor(000);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function ChapterTitle()
    {
        // Define as fontes
        $this->SetFont('Arial', 'B', 7);

        // Cabeçalho da tabela
        $this->Cell(87, 5, 'Fornecedor/Cliente', 1, 0, 'C');
        $this->Cell(20, 5, iconv('UTF-8', 'ISO-8859-1', 'Transação Id'), 1, 0, 'C');
        $this->Cell(20, 5, 'Tipo', 1, 0, 'C');
        $this->Cell(20, 5, 'Data', 1, 0, 'C');
        $this->Cell(25, 5, 'Valor Original', 1, 0, 'C');
        $this->Cell(30, 5, 'Valor Juros Cobrados', 1, 0, 'C');
        $this->Cell(30, 5, 'Valor Taxas Cobradas', 1, 0, 'C');
        $this->Cell(20, 5, 'Valor Liquido', 1, 0, 'C');
        $this->Cell(20, 5, 'Assinado', 1, 0, 'C');
        $this->Cell(20, 5, 'Status', 1, 1, 'C');
        // Line break
        $this->Ln(1);
    }
    function ChapterTotal($ValorOriginalT, $ValorJurosCobradosT,$ValorTaxasCobradasT,$ValorLiquidoT)
    {
        // Define as fontes
        $this->SetFont('Arial', 'B', 7);

        // Cabeçalho da tabela
        $this->Cell(87, 5, '', 0, 0, 'C');
        $this->Cell(20, 5, iconv('UTF-8', 'ISO-8859-1', ''), 0, 0, 'C');
        $this->Cell(20, 5, '', 0, 0, 'C');
        $this->Cell(20, 5, 'Total Geral', 1, 0, 'L');
        $this->Cell(25, 5, number_format($ValorOriginalT,2,',','.'), 1, 0, 'R');
        $this->Cell(30, 5, number_format($ValorJurosCobradosT,2,',','.'), 1, 0, 'R');
        $this->Cell(30, 5, number_format($ValorTaxasCobradasT,2,',','.'), 1, 0, 'R');
        $this->Cell(60, 5, number_format($ValorLiquidoT,2,',','.'), 1, 1, 'R');
    
        // Line break
        $this->Ln(1);
    }

    function ChapterBody($Fornecedor, $Transacao, $Tipo, $Data, $ValorOriginal, $ValorJuros, $ValorTaxas, $ValorLiquido, $Assinado, $Status)
    {
        $this->SetFont('Arial', '', 6);

        // Cabeçalho da tabela
        $this->Cell(87, 5, iconv('UTF-8', 'ISO-8859-1', $Fornecedor), 1, 0, 'L');
        $this->Cell(20, 5, iconv('UTF-8', 'ISO-8859-1', $Transacao), 1, 0, 'C');
        $this->Cell(20, 5, iconv('UTF-8', 'ISO-8859-1', $Tipo), 1, 0, 'C');
        $this->Cell(20, 5, iconv('UTF-8', 'ISO-8859-1', $Data), 1, 0, 'C');
        $this->Cell(25, 5, iconv('UTF-8', 'ISO-8859-1', $ValorOriginal), 1, 0, 'C');
        $this->Cell(30, 5, iconv('UTF-8', 'ISO-8859-1', $ValorJuros), 1, 0, 'C');
        $this->Cell(30, 5, iconv('UTF-8', 'ISO-8859-1', $ValorTaxas), 1, 0, 'C');
        $this->Cell(20, 5, iconv('UTF-8', 'ISO-8859-1', $ValorLiquido), 1, 0, 'C');
        $this->Cell(20, 5, iconv('UTF-8', 'ISO-8859-1', $Assinado), 1, 0, 'C');
        $this->Cell(20, 5, iconv('UTF-8', 'ISO-8859-1', $Status), 1, 1, 'C');
        // Line break
        $this->Ln(1);
    }

    function PrintChapter()
    {
        $this->AddPage('L');
        $this->ChapterTitle();
    }
}
$ValorOriginalT =0;
$ValorJurosCobradosT=0;
$ValorTaxasCobradasT=0;
$ValorLiquidoT =0;
$pdf = new PDF();
$pdf->SetMargins(2, 10);
$title = 'Relatório de Operações';
$pdf->SetTitle(iconv('UTF-8', 'ISO-8859-1', $title));
$pdf->SetAuthor('Cinque');
$pdf->PrintChapter();
$vertice = array();
$list = array();

$multiple_ids = new operacoes();
$multiple_ids = $multiple_ids->UltimasOperacoesRealizadas_ancora($status, $inicio, $termino);
foreach ($multiple_ids as $multiple_row) {

    $vertice[$multiple_row['id']] = explode(',', $multiple_row['multiple_ids']);
    for ($i = 0; $i < count($vertice[$multiple_row['id']]); $i++) {
        array_push($list, $vertice[$multiple_row['id']][$i]);
    }
}
foreach ($vertice as $key => $value) {
    $values = implode(',', $value);

    $antecipadas_agrupadas =  new operacoes();
    $antecipadas_agrupadas = $antecipadas_agrupadas->Antecipadas_Agrupadas($value);

    foreach ($antecipadas_agrupadas as $row) {
        $fornecedor = new fornecedores();
        $fornecedor->setCnpj($row['cnpj']);
        $fornecedor = $fornecedor->SelectCnpj();
        $postergacoesDetalhes = new postergacoes();
        $postergacoesDetalhes->setId($key);
        $postergacoesDetalhes = $postergacoesDetalhes->SelectId();

        $valorRow = floatval($row['valor']) - ($postergacoesDetalhes['juros'] + $postergacoesDetalhes['taxas']);

        $Fornecedor = $fornecedor["razao"];
        $Transacao  = '0000' . $key;
        if ($row['tipo'] != 'cliente') {
            $Data = date('d/m/Y', strtotime($row["dataOPE"]));
        } else {
            $Data = date('d/m/Y', strtotime($row["vencimento"]));
        }


        $ValorOriginal = number_format($row['valor'], 2, ',', '.');
        $ValorOriginalT +=$ValorOriginal;
        $ValorJuros =  number_format($juros, 2, ',', '.');
        $ValorJurosT += $ValorJuros;
        $ValorTaxas = number_format($postergacoesDetalhes['taxas'], 2, ',', '.');
        $ValorTaxasT += $ValorTaxas;
        $ValorLiquido =  number_format($valorRow, 2, ',', '.');
        $ValorLiquidoT +=$ValorLiquido;
        if ($row["confirmada"] == 1) {
            $Status = 'Confirmada';
        } else {
            $Status = 'Não Confirmada';
        }
        if ($row['statusReal'] == 5) {
            $Assinado = 'Assinado';
        } else {
            $Assinado = 'Não Assinado';
        }


        if ($row['status'] == 4) {
            $Tipo  = "Antecipação";
        } else {
            $Tipo  = "Postergação";
        }
        $pdf->ChapterBody($Fornecedor, $Transacao, $Tipo, $Data, $ValorOriginal, $ValorJuros, $ValorTaxas, $ValorLiquido, $Assinado, $Status);
    }
}
$antecipadas_query = new operacoes();
$antecipadas = $antecipadas_query->getAntecipadasQuery($status, $inicio, $termino);
foreach ($antecipadas as $row) {
    // $quantidade = mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT count(*) as totaldupli FROM antecipadas as a, antecipadasDetalhes as ad WHERE a.fornecedor = '{$_SESSION["id"]}' AND ad.antecipada = '{$row['id']}'")) or die(mysqli_error());
    $ant = new antecipadas();
    $ant->setId($row['antec_id']);
    $ant = $ant->Select();
    $fornecedor = new fornecedores();
    $fornecedor->setCnpj($row['cnpj']);
    $fornecedor = $fornecedor->SelectCnpj();
    if (in_array($row['id_oper'], $list) == 1) {
        continue;
    } else {
        $Fornecedor = $fornecedor["razao"];
        $Transacao  = '0000' . $row["id"];
        if ($row['tipo'] != 'cliente') {
            $Data = date('d/m/Y', strtotime($row["dataOPE"]));
        } else {
            $Data = date('d/m/Y', strtotime($row["vencimento"]));
        }


        $ValorOriginal = number_format($row['valor'], 2, ',', '.');
        $ValorOriginalT = $ValorOriginalT +number_format($row['valor'], 2,'.','');
        $ValorJuros = number_format($ant['descontoJuros'], 2, ',', '.');
        $ValorJurosCobradosT  = $ValorJurosCobradosT + number_format($ant['descontoJuros'], 2, '.', '');
        $ValorTaxas =  number_format($ant['descontoTaxas'], 2, ',', '.');
        $ValorTaxasCobradasT = $ValorTaxasCobradasT + number_format($ant['descontoTaxas'], 2, '.', '');
        $ValorLiquido =   number_format($ant['valor'], 2, ',', '.');
        $ValorLiquidoT = $ValorLiquidoT + number_format($ant['valor'], 2, '.', '');

       
        if ($row["confirmada"] == 1) {
            $Status = 'Confirmada';
        } else {
            $Status = 'Não Confirmada';
        }
        if ($row["confirmada"] == 1 || $row["confirmada_sec"] == 1) {
            $Assinado = 'Assinado';
        } else {
            $Assinado = 'Não Assinado';
        }


        if ($row['statusReal'] == 4) {
            $Tipo  = "Antecipação";
        } else {
            $Tipo  = "Postergação";
        }
        $pdf->ChapterBody($Fornecedor, $Transacao, $Tipo, $Data, $ValorOriginal, $ValorJuros, $ValorTaxas, $ValorLiquido, $Assinado, $Status);
    }
}


$pdf->ChapterTotal($ValorOriginalT, $ValorJurosCobradosT,$ValorTaxasCobradasT,$ValorLiquidoT);
$pdf->Output();
