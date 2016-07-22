<?php
ob_start();
session_start();

include "../includes/db.php";
include "./functions.php";

if($_SESSION['funcao'] !== "Administrador") {
    header("Location: ../login.php");
    exit;
}

$sessao = session_id();
$tempo = time();
$timeout_segundos = 60 * 5;
$timeout = $tempo - $timeout_segundos;

$query_online = "SELECT COUNT(*) FROM usuarios_online WHERE sessao = '$sessao'";
$resultado_query_online = mysqli_query($conexao, $query_online);
$online = mysqli_fetch_row($resultado_query_online)[0];

if($online == 0) {
    $res1 = mysqli_query($conexao, "INSERT INTO usuarios_online(sessao, tempo)
                                    VALUES('$sessao', '$tempo')");
} else {
    $res2 = mysqli_query($conexao, "UPDATE usuarios_online SET tempo = '$tempo' WHERE sessao = '$sessao'");
}

$resultado_usuarios_online = mysqli_query($conexao, "SELECT COUNT(*) FROM usuarios_online WHERE tempo > '$timeout'");
$usuarios_online = mysqli_fetch_row($resultado_usuarios_online)[0];

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DaniPress CMS Administração">
    <meta name="author" content="Daniel Sousa">

    <title>DaniPress CMS</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- TinyMCE WYSIWYG Editor -->
    <script src="assets/js/tinymce/tinymce.min.js"></script>
    <script>tinymce.init({
            selector:'textarea',
            language: 'pt_BR'
        });</script>

</head>

<body>