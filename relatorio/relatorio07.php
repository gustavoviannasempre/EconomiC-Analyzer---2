<?php
/**
 * Created by PhpStorm.
 * User: gusta
 */

ini_set('display_errors', 0);

require_once  "../vendor/autoload.php";
//require_once "../lib/mpdf/mpdf.php";
require_once "../dao/relatorioDAO.php";

$dao = new relatorioDAO();

$listObjs = $dao->relatorio07();
$dia = $dao ->dataAtual();
$hr = $dao ->horaAtual();

$html = "<h1 style='text-align: center; font-family: Arial, sans-serif'>RELATÓRIO VALOR TOTAL POR CIDADE</h1>
<table style='margin-left: 30%' border='1' cellspacing='3' cellpadding='3' >";
$html .= "<tr>
            <th style='text-align: center'>VALOR TOTAL PAGO</th>
            <th style='text-align: center'>NOME DO ESTADO</th>
        </tr>";
foreach ($listObjs as $var):
    $html.= "<tr>
                <td style='text-align: center'>R$ $var->valor</td>
                <td style='text-align: center'>$var->str_name</td>
            </tr>";
endforeach;
$html .= "</table>";
$html .= "<p>Relatório gerado no dia $dia às $hr</p>";


$mpdf = new \Mpdf\Mpdf();
//$mpdf=new mPDF();
$mpdf->SetCreator(PDF_CREATOR);
$mpdf->SetAuthor('Gustavo Rodrigues Lima Soares');
$mpdf->SetTitle('Relatório PDF com o número de beneficiário por estados e o valor total pago por cidade, por mês, ordenados por valor total decrescente');
$mpdf->SetSubject('Sistema EconomiC Analyzer');
$mpdf->SetKeywords('TCPDF, PDF, trabalho PHP');
$mpdf->SetDisplayMode('fullpage');
$mpdf->nbpgPrefix = ' de ';
$mpdf->setFooter('Página {PAGENO}{nbpg}');
$mpdf->WriteHTML($html);
$mpdf->Output('economicAnalyzer.pdf','I');

exit;