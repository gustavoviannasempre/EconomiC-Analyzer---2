<?php
/**
 * Created by PhpStorm.
 * User: gusta
 */

require_once "../db/conexao.php";
require_once "../classes/beneficiaries.php";

class relatorioDAO
{

    public function relatorio01()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT * FROM tb_beneficiaries ORDER BY str_name_person');
            if ($statement->execute()) {
                $lista = $statement->fetchAll(PDO::FETCH_OBJ);
                return $lista;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }
    
    public function relatorio02()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT id_beneficiaries, str_name_person, str_nis, id_city, str_name_city, str_cod_siafi_city, tb_state_id_state FROM db_eca.tb_payments, db_eca.tb_city, db_eca.tb_beneficiaries WHERE tb_beneficiaries.id_beneficiaries = tb_payments.tb_beneficiaries_id_beneficiaries and tb_payments.tb_city_id_city = tb_city.id_city order by tb_city.str_name_city, tb_beneficiaries.str_name_person;');
            if ($statement->execute()) {
                $lista = $statement->fetchAll(PDO::FETCH_OBJ);
                return $lista;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }
    
    public function relatorio03()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT tb_payments.id_payment a1, tb_city.str_name_city a2, db_eca.tb_functions.str_name_function a3, tb_subfunctions.str_name_subfunction a4, tb_program.str_name_program a5, tb_action.str_name_action a6, tb_beneficiaries.str_name_person a7, tb_source.str_goal a8, tb_files.str_name_file a9 FROM db_eca.tb_payments, tb_city, db_eca.tb_functions, tb_beneficiaries, tb_action, tb_program, tb_subfunctions, tb_source, tb_files where tb_payments.tb_city_id_city = tb_city.id_city and tb_payments.tb_beneficiaries_id_beneficiaries = tb_beneficiaries.id_beneficiaries and tb_payments.tb_action_id_action = tb_action.id_action and tb_payments.tb_program_id_program = tb_program.id_program and tb_payments.tb_subfunctions_id_subfunction = tb_subfunctions.id_subfunction and tb_payments.tb_source_id_source = tb_source.id_source and tb_payments.tb_functions_id_function = db_eca.tb_functions.id_function and tb_payments.tb_files_id_file = tb_files.id_file;');
            if ($statement->execute()) {
                $lista = $statement->fetchAll(PDO::FETCH_OBJ);
                return $lista;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }
    public function relatorio04()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT sum(db_value) soma, tb_city.str_name_city nome, Count(Distinct db_eca.tb_payments.tb_beneficiaries_id_beneficiaries) contador FROM db_eca.tb_payments, tb_city where tb_payments.id_payment = tb_city.id_city group by tb_payments.tb_city_id_city order by sum(db_value) DESC;');
            if ($statement->execute()) {
                $lista = $statement->fetchAll(PDO::FETCH_OBJ);
                return $lista;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }
    
    public function relatorio05()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT distinct(B.str_name_person) as tb_beneficiaries, count(P.tb_beneficiaries_id_beneficiaries) AS QTD,sum(P.db_value) AS SOMA,P.int_month,P.int_year  FROM tb_payments P INNER JOIN tb_beneficiaries B ON tb_beneficiaries_id_beneficiaries = id_beneficiaries GROUP BY P.tb_beneficiaries_id_beneficiaries,P.int_month,P.int_year");
            if ($statement->execute()) {
                $lista = $statement->fetchAll(PDO::FETCH_OBJ);
                return $lista;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }
    
    public function relatorio06()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT sum(db_value) valor, str_name_region nome FROM db_eca.tb_payments, tb_city, tb_state, tb_region where tb_payments.id_payment = tb_city.id_city and tb_city.tb_state_id_state = tb_state.id_state and tb_state.tb_region_id_region = tb_region.id_region group by tb_region.id_region order by tb_state.str_name;');
            if ($statement->execute()) {
                $lista = $statement->fetchAll(PDO::FETCH_OBJ);
                return $lista;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }
    
    public function relatorio07()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT sum(db_value) valor, str_name FROM db_eca.tb_payments, tb_city, tb_state where tb_payments.id_payment = tb_city.id_city and tb_city.tb_state_id_state = tb_state.id_state group by tb_state.id_state order by tb_state.str_name;');
            if ($statement->execute()) {
                $lista = $statement->fetchAll(PDO::FETCH_OBJ);
                return $lista;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }
    
    public function dataAtual(){
        date_default_timezone_set('America/Sao_Paulo');
        $obj = date('d-m-Y');
        return $obj;
    }   
    
    public function horaAtual(){
        date_default_timezone_set('America/Sao_Paulo');
        $horaAtual = date('H:i');
        return $horaAtual;
    }  
}