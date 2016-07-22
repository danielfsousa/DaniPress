<?php

include_once "db.php";

session_start();

$_SESSION['usuario'] = null;
$_SESSION['nome'] = null;
$_SESSION['sobrenome'] = null;
$_SESSION['funcao'] = null;

$tempo = time();
$timeout_segundos = 60 * 5;
$timeout = $tempo - $timeout_segundos;

$res = mysqli_query($conexao, "DELETE FROM usuarios_online WHERE tempo < '$timeout'");

header("Location: ../index.php");