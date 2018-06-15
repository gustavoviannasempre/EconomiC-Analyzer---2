<?php
/**
 * Created by PhpStorm.
 * User: gusta
 */

set_time_limit(60);
require_once  "vendor/autoload.php";
//require "vendor/PHPMailer/PHPMailer/src/PHPMailer.php";
//require "vendor/PHPMailer/PHPMailer/src/SMTP.php";
//require "vendor/PHPMailer/PHPMailer/src/Exception.php";
require_once 'dao/userDAO.php';

//use PHPMailer\PHPMailer\PHPMailer;

$object = new userDAO();
$mail = new \PHPMailer\PHPMailer\PHPMailer();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = (isset($_POST["login"]) && $_POST["login"] != null) ? $_POST["login"] : "";
    $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";

    if($object->recuperaSenha($login, $email)) {


        $mail->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 1;

        $mail->Host = 'smtp.gmail.com';

        $mail->Port = 587;

        $mail->SMTPSecure = 'tls';

        $mail->SMTPAuth = true;

        $mail->Username = "gustavo.soares@viannasempre.com.br";
        $mail->Password = "senha";


        $mail->setFrom('gustavo.soares@viannasempre.com.br', 'Gustavo Rodrigues');

        //$mail->addReplyTo('tassio@tassio.eti.br', 'Tassio Sirqueira');

        $mail->addAddress($email, $login);

        $mail->Subject = 'Recuperacao de login ECA';

        $mail->msgHTML("Sua senha temporária é <strong>123456</strong> <br> Não perca novamente!");

        //$mail->addAttachment('phpmailer.png');

        if (!$mail->send()) {
            echo "Erro ao enviar o E-mail: " . $mail->ErrorInfo;
        } else {
            echo "E-mail enviado com sucesso!";
        }
        header('Location:login.php');
    }else {
        echo 'Logim ou senha não encontrados!';
        //var_dump($login);
        //var_dump($email);
        //header('Location: recuperar.php');
    }
} else {
    echo 'Dados não preenchidos';
    header('location:recuperar.php');
}
