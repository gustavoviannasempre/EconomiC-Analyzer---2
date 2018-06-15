<?php
/**
 * Created by PhpStorm.
 * User: gusta
 */

//So funciona se desativar os erros!
ini_set('display_errors', 0);

require_once  "../vendor/autoload.php";
//include("../libs/mpdf/mpdf.php");
//require_once "../lib/mpdf/mpdf.php";
require_once "../dao/relatorioDAO.php";

$dao = new relatorioDAO();

$listObjs = $dao->relatorio05();
$dia = $dao ->dataAtual();
$hr = $dao ->horaAtual();

$html = "<h1 style='text-align: center; font-family: Arial, sans-serif'>RELATÓRIO BENEFICIÁRIOS COM AUXÍLIO</h1>
<table border='1' cellspacing='3' cellpadding='4' >";
$html .= "<tr>
            <th style='text-align: center'>NOME DO BENEFICIARIES</th>
            <th style='text-align: center'>QUANTIDADE DE PAGAMENTOS</th>
            <th style='text-align: center'>VALOR TOTAL PAGO</th>
            <th style='text-align: center'>MÊS</th>
            <th style='text-align: center'>ANO</th>
        </tr>";
foreach ($listObjs as $var):
    $html.= "<tr>
                <td style='text-align: center'>$var->tb_beneficiaries</td>
                <td style='text-align: center'>$var->QTD</td>
                <td style='text-align: center'>R$ $var->SOMA</td>
                <td style='text-align: center'>$var->int_month</td>
                <td style='text-align: center'>$var->int_year</td>
          </tr>";
endforeach;
$html .= "</table>";
$html .= "<p>Relatório gerado no dia $dia às $hr</p>";


$mpdf=new \Mpdf\Mpdf();
//$mpdf=new mPDF();
$mpdf->SetCreator(PDF_CREATOR);
$mpdf->SetAuthor('Gustavo Rodrigues Lima Soares');
$mpdf->SetTitle('Relatório PDF com a soma de vezes que o benefiário ganhou auxilio, os meses que foram e os valores de cada mês');
$mpdf->SetSubject('Sistema EconomiC Analyzer');
$mpdf->SetKeywords('TCPDF, PDF, trabalho PHP');
$mpdf->SetDisplayMode('fullpage');
$mpdf->nbpgPrefix = ' de ';
$mpdf->setFooter('Página {PAGENO}{nbpg}');
$mpdf->WriteHTML($html);
$mpdf->Output('economicAnalyzer.pdf','I');

exit;