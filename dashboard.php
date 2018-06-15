<?php
/**
 * Created by PhpStorm.
 * User: gusta
 */

require_once "classes/template.php";
require_once "dao/dashboardDAO.php";

$template = new Template();
$template->header();
$template->sidebar();
$template->mainpanel();

$dao = new dashboardDAO();

$objTotPag = $dao->totalPagamento();
$objPag = $dao->pagUltimoMes();

?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-warning text-center">
                                    <i class="ti-server"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Total de Pagamentos</p>
                                    <small><?php echo 'R$' . number_format($objTotPag["soma"],2,".","") ?></small> 
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr/>
                            <div class="stats">
                                <i class="ti-reload"></i> Pagamentos até o momento
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-success text-center">
                                    <i class="ti-wallet"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Soma de Pagamentos</p>
                                    <small><?php echo 'R$'. number_format($objPag["soma"],2,".",""); ?></small> 
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr/>
                            <div class="stats">
                                <i class="ti-calendar"></i> Último mês <?php echo $objPag["mes"].' / '. $objPag["ano"];?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-danger text-center">
                                    <i class="ti-pulse"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Pagamentos Médios de</p>
                                    <small><?php echo 'R$'. number_format($objPag["soma"]  /  $objPag["qtde"], 2, ',', ' '); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr/>
                            <div class="stats">
                                <i class="ti-calendar"></i> Último mês <?php echo $objPag["mes"] .' / '. $objPag["ano"];?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-info text-center">
                                    <i class="ti-twitter-alt"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Total de Beneficiários</p>
                                    <small> <?php echo $dao->totalBeneficiarios(); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr/>
                            <div class="stats">
                                <i class="ti-reload"></i> Total
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Beneficiários</h4>
                        <p class="category">Total de Beneficiários</p>
                    </div>
                    <div class="content">
                        <img id="totalbenefmes" src="grafico/graficoTotalBenefMes.php">
                        <div class="footer">
                            <div class="chart-legend">
                                <i class="fa fa-circle text-info"> <a href="grafico/graficoTotalBenefMes.php?pdf=1.pdf" target="_blank">Export PDF</a> </i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Beneficiários</h4>
                        <p class="category">Total de beneficiário por mês e estado</p>
                    </div>
                    <div class="content">
                        <img id="totalPagEstado" src="grafico/graficoTotalBenefEstado.php">
                        <div class="footer">
                            <div class="chart-legend">
                                <i class="fa fa-circle text-info"> <a href="grafico/graficoTotalBenefEstado.php?pdf=1.pdf" target="_blank">Export PDF</a> </i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card ">
                    <div class="header">
                        <h4 class="title">Valores</h4>
                        <p class="category">Total de valores pagos por estado</p>
                    </div>
                    <div class="content">
                         <img id="totalPagEstado" src="grafico/graficoTotalPagEstado.php">
                        <div class="footer">
                            <div class="chart-legend">
                                <i class="fa fa-circle text-info"> <a href="grafico/graficoTotalPagEstado.php?pdf=1.pdf" target="_blank">Export PDF</a> </i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$template->footer();

?>

