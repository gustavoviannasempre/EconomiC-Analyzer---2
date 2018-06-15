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

$listObjs = $dao->relatorio03();
$dia = $dao ->dataAtual();
$hr = $dao ->horaAtual();

$html = "
<h1 style='text-align: center; font-family: Arial, sans-serif'>RELATÓRIO DE PAGAMENTOS</h1>
<table border='1' cellspacing='3' cellpadding='4' >";
$html .= "<tr>
            <th style='text-align: center'>ID PAGAMENTO</th>
            <th style='text-align: center'>CIDADE</th>
            <th style='text-align: center'>FUNÇÃO</th>
            <th style='text-align: center'>SUB-FUNCAO</th>
            <th style='text-align: center'>PROGRAMA</th>
            <th style='text-align: center'>AÇÃO</th>
            <th style='text-align: center'>BENEFICIARIES</th>
            <th style='text-align: center'>NIS</th>
            <th style='text-align: center'>ARQUIVO</th>
        </tr>";
foreach ($listObjs as $var):
    $html.= "<tr>
                <td style='text-align: center'>$var->a1</td>
                <td style='text-align: center'>$var->a2</td>
                <td style='text-align: center'>$var->a3</td>
                <td style='text-align: center'>$var->a4</td>
                <td style='text-align: center'>$var->a5</td>
                <td style='text-align: center'>$var->a6</td>
                <td style='text-align: center'>$var->a7</td>
                <td style='text-align: center'>$var->a8</td>
                <td style='text-align: center'>$var->a9</td>
          </tr>";
endforeach;
$html .= "</table>";
$html .= "<p>Relatório gerado no dia $dia às $hr</p>";

$mpdf=new \Mpdf\Mpdf();
//$mpdf=new mPDF();
$mpdf->SetCreator(PDF_CREATOR);
$mpdf->SetAuthor('Gustavo Rodrigues Lima Soares');
$mpdf->SetTitle('Relatório PDF com a lista de os pagamentos, incluindo seus respectivos dados');
$mpdf->SetSubject('Sistema EconomiC Analyzer');
$mpdf->SetKeywords('TCPDF, PDF, trabalho PHP');
$mpdf->SetDisplayMode('fullpage');
$mpdf->nbpgPrefix = ' de ';
$mpdf->setFooter('Página {PAGENO}{nbpg}');
$mpdf->WriteHTML($html);
$mpdf->Output('economicAnalyzer.pdf','I');

exit;