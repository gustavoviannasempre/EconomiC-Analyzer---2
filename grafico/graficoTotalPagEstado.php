<?php
/**
 * Created by PhpStorm.
 * User: gusta
 */

require_once  "../vendor/autoload.php";
//require_once "../lib/PHPlot/phplot.php";
require_once "../db/conexao.php";

$query = "SELECT s.str_name estado, sum(p.db_value) valor
FROM tb_payments p 
inner join tb_city c 
inner join tb_state s 
where p.tb_city_id_city = c.id_city and c.tb_state_id_state = s.id_state
group by s.id_state;";

$statement = $pdo->prepare($query);
$statement->execute();
$rs = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($rs as $value) {
    $resultado[] = $value;
}

$data = array();

if(isset($resultado)) {
    foreach ($resultado as $r){
        $data[] = [$r['estado'], $r['valor'] ];
        //var_dump($r); 
        //echo '<br>';
    }
} else {
    $data[]=[null,null,null];
}

$grafico = new \PHPlot(1000,600);
$grafico->SetImageBorderType('plain');

$grafico->SetPlotType('pie');
$grafico->SetDataType('text-data-single');
$grafico->SetDataValues($data);

# Set enough different colors;
$grafico->SetDataColors(
        array(
            '#F0F8FF', '#FAEBD7', '#7FFFD4', '#D2691E',
            '#FF7F50', '#6495ED', '#FFF8DC', '#DC143C', 
            '#00FFFF', '#00008B', '#F0F8FF', '#FAEBD7', 
            '#008B8B', '#B8860B', '#A9A9A9', '#006400', 
            '#BDB76B', '#8B008B', '#556B2F', '#FF8C00', 
            '#9932CC', '#8B0000', '#E9967A', '#8FBC8F',
            '#483D8B')
        );

# Main plot title:
$grafico->SetTitle("Total de valores pagos por estado");

# Build a legend from our data array.
# Each call to SetLegend makes one line as "label: value".
foreach ($data as $row)
  $grafico->SetLegend(utf8_decode(implode(': ', $row)));
# Place the legend in the upper left corner:
$grafico->SetLegendPixels(5, 5);

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