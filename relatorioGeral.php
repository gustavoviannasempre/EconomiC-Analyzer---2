<?php
/**
 * Created by PhpStorm.
 * User: gusta
 */

require_once "classes/template.php";

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Relatorio</h4>
                        <p class='category'>Lista de relatorios do sistema</p>
                    </div>

                    <div class='content table-responsive'>
                        <form method="POST" name="form">                          
                            Tipo de relatorio:
                            <select class="form-control" name="relatoriosDisponiveis">
                                <option value="relatorioNulo">Selecione um relatorio</option>
                                <option value="relatorio01">Lista de todos os beneficiários</option>
                                <option value="relatorio02">Lista de todos os beneficiários juntamente com a cidade</option>
                                <option value="relatorio03">Lista com todos os pagamentos</option>
                                <option value="relatorio04">Lista com o número de beneficiários jutamente com cidade e o valor pago por mês</option>
                                <option value="relatorio05">Lista com a soma de vezes que o beneficiário ganhou auxiloi juntamente com os meses e os valores</option>
                                <option value="relatorio06">Lista com o total de pagamentos por região</option>
                                <option value="relatorio07">Lista com o total de pagamentos por estado</option>
                            </select>
                            <br/>

                            <input class="btn btn-success" type="submit" value="GERAR RELATORIO">
                            <hr>
                        </form>
                        
                        <?php
                        if (isset($_POST['relatoriosDisponiveis'])){
                            $relatorioselecionado = $_POST['relatoriosDisponiveis'];
                            
                            if ($relatorioselecionado=="relatorioNulo"){ 
                                echo "Por favor selecione um relatorio da lista a cima!";
                            }else { 
                                echo "<script>script:window.open('relatorio/".$relatorioselecionado.".php', '_blank');</script>";
                            }                        
                        }
                        ?>
                  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$template->footer();
?>
