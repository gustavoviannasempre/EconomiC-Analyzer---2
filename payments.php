<?php
/**
 * Created by PhpStorm.
 * User: gusta
 */
require_once "classes/template.php";

require_once "dao/paymentsDAO.php";
require_once "classes/payments.php";

$object = new paymentsDAO();

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $tb_city_id_city = (isset($_POST["tb_city_id_city"]) && $_POST["tb_city_id_city"] != null) ? $_POST["tb_city_id_city"] : "";
    $tb_functions_id_function = (isset($_POST["tb_functions_id_function"]) && $_POST["tb_functions_id_function"] != null) ? $_POST["tb_functions_id_function"] : "";
    $tb_subfunctions_id_subfunction = (isset($_POST["tb_subfunctions_id_subfunction"]) && $_POST["tb_subfunctions_id_subfunction"] != null) ? $_POST["tb_subfunctions_id_subfunction"] : "";
    $tb_program_id_program = (isset($_POST["tb_program_id_program"]) && $_POST["tb_program_id_program"] != null) ? $_POST["tb_program_id_program"] : "";
    $tb_action_id_action = (isset($_POST["tb_action_id_action"]) && $_POST["tb_action_id_action"] != null) ? $_POST["tb_action_id_action"] : "";
    $tb_beneficiaries_id_beneficiaries = (isset($_POST["tb_beneficiaries_id_beneficiaries"]) && $_POST["tb_beneficiaries_id_beneficiaries"] != null) ? $_POST["tb_beneficiaries_id_beneficiaries"] : "";
    $tb_source_id_source = (isset($_POST["tb_source_id_source"]) && $_POST["tb_source_id_source"] != null) ? $_POST["tb_source_id_source"] : "";
    $tb_files_id_file = (isset($_POST["tb_files_id_file"]) && $_POST["tb_files_id_file"] != null) ? $_POST["tb_files_id_file"] : "";
    $int_month = (isset($_POST["int_month"]) && $_POST["int_month"] != null) ? $_POST["int_month"] : "";
    $int_year = (isset($_POST["int_year"]) && $_POST["int_year"] != null) ? $_POST["int_year"] : "";
    $db_value = (isset($_POST["db_value"]) && $_POST["db_value"] != null) ? $_POST["db_value"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $tb_city_id_city = NULL;
    $tb_functions_id_function = NULL;
    $tb_subfunctions_id_subfunction = NULL;
    $tb_program_id_program = NULL;
    $tb_action_id_action = NULL;
    $tb_beneficiaries_id_beneficiaries = NULL;
    $tb_source_id_source = NULL;
    $tb_files_id_file = NULL;
    $int_month = NULL;
    $int_year = NULL;
    $db_value = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $payments = new payments($id, '', '', '', '','', '','','','', '', '');

    $resultado = $object->atualizar($payments);
    $tb_city_id_city = $resultado->getTbCityIdCity();
    $tb_functions_id_function = $resultado->getTbFunctionsIdFunction();
    $tb_subfunctions_id_subfunction = $resultado->getTbSubfunctionsIdSubfunction();
    $tb_program_id_program = $resultado->getTbProgramIdProgram();
    $tb_action_id_action = $resultado->getTbActionIdAction();
    $tb_beneficiaries_id_beneficiaries = $resultado->getTbBeneficiariesIdBeneficiaries();
    $tb_source_id_source = $resultado->getTbSourceIdSource();
    $tb_files_id_file = $resultado->getTbFilesIdFile();
    $int_month = $resultado->getIntMonth();
    $int_year = $resultado->getIntYear();
    $db_value = $resultado->getDbValue();

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $tb_city_id_city != "" && $tb_functions_id_function != "") {

    $payments = new payments($id, $tb_city_id_city, $tb_functions_id_function, $tb_subfunctions_id_subfunction, $tb_program_id_program, $tb_action_id_action, $tb_beneficiaries_id_beneficiaries, $tb_source_id_source, $tb_files_id_file, $int_month, $int_year, $db_value);

    $msg = $object->salvar($payments);
    $id = NULL;
    $tb_city_id_city = NULL;
    $tb_functions_id_function = NULL;
    $tb_subfunctions_id_subfunction = NULL;
    $tb_program_id_program = NULL;
    $tb_action_id_action = NULL;
    $tb_beneficiaries_id_beneficiaries = NULL;
    $tb_source_id_source = NULL;
    $tb_files_id_file = NULL;
    $int_month = NULL;
    $int_year = NULL;
    $db_value = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $payments = new payments($id, '', '', '', '', '', '','','','', '', '');

    $msg = $object->remover($payments);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Pagamentos</h4>
                        <p class='category'>Lista de pagamentos do sistema</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            City:
                            <select class="form-control" name="tb_city_id_city">
                                <?php
                                $query = "SELECT * FROM tb_city order by str_name_city;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_city == $tb_city_id_city) {
                                            echo "<option value='$rs->id_city' selected>$rs->str_name_city</option>";
                                        } else {
                                            echo "<option value='$rs->id_city'>$rs->str_name_city</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
                            <br/>

                            Function:
                            <select class="form-control" name="tb_functions_id_function">
                                <?php
                                $query = "SELECT * FROM tb_functions order by str_name_function;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_function == $tb_functions_id_function) {
                                            echo "<option value='$rs->id_function' selected>$rs->str_name_function</option>";
                                        } else {
                                            echo "<option value='$rs->id_function'>$rs->str_name_function</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
                            <br/>

                            Sub-Function:
                            <select class="form-control" name="tb_subfunctions_id_subfunction">
                                <?php
                                $query = "SELECT * FROM tb_subfunctions order by str_name_subfunction;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_subfunction == $tb_subfunctions_id_subfunction) {
                                            echo "<option value='$rs->id_subfunction' selected>$rs->str_name_subfunction</option>";
                                        } else {
                                            echo "<option value='$rs->id_subfunction'>$rs->str_name_subfunction</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
                            <br/>

                            Program:
                            <select class="form-control" name="tb_program_id_program">
                                <?php
                                $query = "SELECT * FROM tb_program order by str_name_program;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_program == $tb_program_id_program) {
                                            echo "<option value='$rs->id_program' selected>$rs->str_name_program</option>";
                                        } else {
                                            echo "<option value='$rs->id_program'>$rs->str_name_program</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
                            <br/>

                            Action:
                            <select class="form-control" name="tb_action_id_action">
                                <?php
                                $query = "SELECT * FROM tb_action order by str_name_action;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_action == $tb_action_id_action) {
                                            echo "<option value='$rs->id_action' selected>$rs->str_name_action</option>";
                                        } else {
                                            echo "<option value='$rs->id_action'>$rs->str_name_action</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
                            <br/>

                            Beneficiares:
                            <select class="form-control" name="tb_beneficiaries_id_beneficiaries">
                                <?php
                                $query = "SELECT * FROM tb_beneficiaries order by str_name_person;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_beneficiaries == $tb_beneficiaries_id_beneficiaries) {
                                            echo "<option value='$rs->id_beneficiaries' selected>$rs->str_name_person</option>";
                                        } else {
                                            echo "<option value='$rs->id_beneficiaries'>$rs->str_name_person</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
                            <br/>

                            Source:
                            <select class="form-control" name="tb_source_id_source">
                                <?php
                                $query = "SELECT * FROM tb_source order by str_goal;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_source == $tb_source_id_source) {
                                            echo "<option value='$rs->id_source' selected>$rs->str_goal</option>";
                                        } else {
                                            echo "<option value='$rs->id_source'>$rs->str_goal</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
                            <br/>

                            File:
                            <select class="form-control" name="tb_files_id_file">
                                <?php
                                $query = "SELECT * FROM tb_files order by str_name_file;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_file == $tb_files_id_file) {
                                            echo "<option value='$rs->id_file' selected>$rs->str_name_file</option>";
                                        } else {
                                            echo "<option value='$rs->id_file'>$rs->str_name_file</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
                            <br/>

                            Mês:
                            <input class="form-control" type="text" name="int_month" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($int_month) && ($int_month != null || $int_month != "")) ? $int_month : '';
                            ?>"/>
                            <br/>

                            Ano:
                            <input class="form-control" type="text" name="int_year" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($int_year) && ($int_year != null || $int_year != "")) ? $int_year : '';
                            ?>"/>
                            <br/>

                            Value:
                            <input class="form-control" type="text" name="db_value" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($db_value) && ($db_value != null || $db_value != "")) ? $db_value : '';
                            ?>"/>
                            <br/>

                            <input class="btn btn-success" type="submit" value="CADASTRAR">
                            <hr>
                        </form>


                        <?php

                        echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';

                        //chamada a paginação
                        $object->tabelapaginada();

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
