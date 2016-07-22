<?php

define("DB_SERVIDOR", "localhost");
define("DB_LOGIN", "daniel");
define("DB_SENHA", "1010");
define("DB_NOME", "danipress");

$conexao = mysqli_connect(DB_SERVIDOR, DB_LOGIN, DB_SENHA, DB_NOME);

if(!$conexao) {
    die("Não foi possível conectar ao Banco de Dados.");
}