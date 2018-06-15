<?php
/**
 * Created by PhpStorm.
 * User: gusta
 */

session_start();
unset ($_SESSION['iduser']);
unset ($_SESSION['login']);
unset ($_SESSION['password']);
unset ($_SESSION['name']);
unset ($_SESSION['perfil']);
session_destroy();
header('location:index.php');

?>