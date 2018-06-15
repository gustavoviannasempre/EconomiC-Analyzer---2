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

$listObjs = $dao->relatorio04();
$dia = $dao ->dataAtual();
$hr = $dao ->horaAtual();

$html = "<h1 style='text-align: center; font-family: Arial, sans-serif'>RELATÓRIO VALOR TOTAL</h1>
<table border='1' cellspacing='3' cellpadding='3' >";
$html .= "<tr>
            <th style='text-align: center'>VALOR TOTAL PAGO</th>
            <th style='text-align: center'>NOME DA CIDADE</th>
            <th style='text-align: center'>NÚMERO DE BENEFICIARIES</th>
        </tr>";
foreach ($listObjs as $var):
    $html.= "<tr>
                <td style='text-align: center'>R$ $var->soma,00</td>
                <td style='text-align: center'>$var->nome</td>
                <td style='text-align: center'>$var->contador</td>
            </tr>";
endforeach;
$html .= "</table>";
$html .= "<p>Relatório gerado no dia $dia às $hr</p>";

$mpdf=new \Mpdf\Mpdf();
//$mpdf=new mPDF();
$mpdf->SetCreator(PDF_CREATOR);
$mpdf->SetAuthor('Gustavo Rodrigues Lima Soares');
$mpdf->SetTitle('Relatório PDF com o número de beneficiário por cidade e o valor total pago por cidade, por mês, ordenados por valor total decrescente');
$mpdf->SetSubject('Sistema EconomiC Analyzer');
$mpdf->SetKeywords('TCPDF, PDF, trabalho PHP');
$mpdf->SetDisplayMode('fullpage');
$mpdf->nbpgPrefix = ' de ';
$mpdf->setFooter('Página {PAGENO}{nbpg}');
$mpdf->WriteHTML($html);
$mpdf->Output('economicAnalyzer.pdf','I');

exit;