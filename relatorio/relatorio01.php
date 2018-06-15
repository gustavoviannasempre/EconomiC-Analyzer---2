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

$listObjs = $dao->relatorio01();
$dia = $dao ->dataAtual();
$hr = $dao ->horaAtual();



$html = "
<h1 style='text-align: center; font-family: Arial, sans-serif'>RELATÓRIO DE BENEFICIÁRIOS</h1>
<table border='1' cellspacing='3' cellpadding='4' >";
$html .= "<tr>
            <th style='text-align: center'>ID BENEFICIARIES</th>
            <th style='text-align: center'>CODIGO NIS</th>
            <th style='text-align: center'>NOME DO BENEFICIARIES</th>
        </tr>";
foreach ($listObjs as $var):
    $html.= "<tr>
                <td style='text-align: center'>$var->id_beneficiaries</td>
                <td style='text-align: center'>$var->str_nis</td>
                <td style='text-align: center'>$var->str_name_person</td>
          </tr>";
endforeach;
$html .= "</table>";
$html .= "<p>Relatório gerado no dia $dia às $hr</p>";

$mpdf=new \Mpdf\Mpdf();
//$mpdf=new mPDF();
$mpdf->SetCreator(PDF_CREATOR);
$mpdf->SetAuthor('Gustavo Rodrigues Lima Soares');
$mpdf->SetTitle('Relatório PDF com a lista de todos os beneficiários e seus respectivos dados em ordem alfabética');
$mpdf->SetSubject('Sistema EconomiC Analyzer');
$mpdf->SetKeywords('TCPDF, PDF, trabalho PHP');
$mpdf->SetDisplayMode('fullpage');
$mpdf->nbpgPrefix = ' de ';
$mpdf->setFooter('Página {PAGENO}{nbpg}');
$mpdf->WriteHTML($html);
$mpdf->Output('economicAnalyzer.pdf','I');

exit;