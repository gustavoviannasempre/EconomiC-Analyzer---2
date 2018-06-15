<?php
/**
 * Created by PhpStorm.
 * User: gusta
 */

require_once  "../vendor/autoload.php";
require_once "../db/conexao.php";

#Instancia o objeto e setando o tamanho do grafico na tela
$grafico = new \PHPlot(800,600);
#Indicamos o títul do gráfico e o título dos dados no eixo X e Y do mesmo
$grafico->SetTitle(utf8_decode("BENEFICIÁRIOS POR MÊS E ANO"));
//$grafico->SetTitle("Beneficiários por Mês e Ano");
$grafico->SetXTitle(utf8_decode("MÊS E ANO"));

$grafico->SetYTitle(utf8_decode("NÚMEROS BENEFICIÁRIOS"));

$query = "SELECT count(tb_beneficiaries_id_beneficiaries )as qtde, int_month as mes, int_year as ano
          FROM tb_payments group by int_month, int_year order by int_year asc, int_month asc;";
$statement = $pdo->prepare($query);

$statement->execute();
$rs = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($rs as $value) {
    $resultado[] = $value;
}
$data = array();
if(isset($resultado)) {
    foreach ($resultado as $r){
        $data[] = [ $r['ano'].'/'.$r['mes'], $r['qtde']];
    }
} else {
    $data[]=[null,null];
}
//$grafico->SetDefaultTTFont('assets/fonts/Timeless.ttf');
$grafico->SetDataValues($data);

$grafico->SetPlotType("lines");
#Exibimos o gráfico
$grafico->DrawGraph();



#Exibimos o gráfico
if (isset($_GET["pdf"]) && $_GET["pdf"] == 1) {
    $plot->SetPrintImage(false);
}
$plot->DrawGraph();

$pdf = new PDF_MemImage();
$pdf->AddPage();
$pdf->GDImage($plot->img,30,20,140);
$pdf->Output('generate.pdf','I');