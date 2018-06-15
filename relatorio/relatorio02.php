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

$listObjs = $dao->relatorio02();
$dia = $dao ->dataAtual();
$hr = $dao ->horaAtual();

$html = "
<h1 style='text-align: center; font-family: Arial, sans-serif'>RELATÓRIO DE BENEFICIÁRIOS E CIDADES</h1>
<table border='1' cellspacing='3' cellpadding='3' >";
$html .= "<tr>
            <th style='text-align: center'>ID BENEFICIARIES</th>
            <th style='text-align: center'>NOME DO BENEFICIARIES</th>
            <th style='text-align: center'>CODIGO NIS</th>
            <th style='text-align: center'>ID CIDADE</th>
            <th style='text-align: center'>NOME CIDADE</th>
            <th style='text-align: center'>CODIGO SIAFI</th>
            <th style='text-align: center'>ID ESTADO</th>
        </tr>";
foreach ($listObjs as $var):
    $html.= "<tr>
                <td style='text-align: center'>$var->id_beneficiaries</td>
                <td style='text-align: center'>$var->str_name_person</td>
                <td style='text-align: center'>$var->str_nis</td>
                <td style='text-align: center'>$var->id_city</td>
                <td style='text-align: center'>$var->str_name_city</td>
                <td style='text-align: center'>$var->str_cod_siafi_city</td>
                <td style='text-align: center'>$var->tb_state_id_state</td>
          </tr>";
endforeach;
$html .= "</table>";
$html .= "<p>Relatório gerado no dia $dia às $hr</p>";

$mpdf=new \Mpdf\Mpdf();
//$mpdf=new mPDF();
$mpdf->SetCreator(PDF_CREATOR);
$mpdf->SetAuthor('Gustavo Rodrigues Lima Soares');
$mpdf->SetTitle('Relatório PDF com a lista de todos os beneficiários e a cidade a qual pertencem, com todos os dados do benefiário e da cidada, ordenados por cidade e posteriormente por nome do beneficário');
$mpdf->SetSubject('Sistema EconomiC Analyzer');
$mpdf->SetKeywords('TCPDF, PDF, trabalho PHP');
$mpdf->SetDisplayMode('fullpage');
$mpdf->nbpgPrefix = ' de ';
$mpdf->setFooter('Página {PAGENO}{nbpg}');
$mpdf->WriteHTML($html);
$mpdf->Output('economicAnalyzer.pdf','I');

exit;