<?php

if(isset($_POST['login'])) {
    if (!empty($_POST['usuario']) && !empty($_POST['senha'])) {

        $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
        $senha = mysqli_real_escape_string($conexao, $_POST['senha']);

        $db_usuario = "";
        $db_senha = "";

        $query_usuarios = "SELECT * FROM usuarios WHERE usuario_login = '$usuario'";
        $resultado_query_usuarios = mysqli_query($conexao, $query_usuarios);

        if (!$resultado_query_usuarios) {
            die("ERRO NA QUERY" . mysqli_error($conexao));
        }

        while ($linha = mysqli_fetch_assoc($resultado_query_usuarios)) {
            $db_id = $linha['usuario_id'];
            $db_usuario = $linha['usuario_login'];
            $db_senha = $linha['usuario_senha'];
            $db_nome = $linha['usuario_nome'];
            $db_sobrenome = $linha['usuario_sobrenome'];
            $db_funcao = $linha['usuario_funcao'];
        }

        if ($usuario === $db_usuario && password_verify($senha, $db_senha)) {
            $_SESSION['id'] = $db_id;
            $_SESSION['usuario'] = $db_usuario;
            $_SESSION['nome'] = $db_nome;
            $_SESSION['sobrenome'] = $db_sobrenome;
            $_SESSION['funcao'] = $db_funcao;
            header("Location: ./admin/index.php");
        } else {
            $erro = "<div class=\"alert alert-danger\">";
            $erro.= "<strong>ERRO:</strong> Usuário ou Senha incorreto(a).";
            $erro.= "</div>";
            echo $erro;
        }
    } else {
        $erro = "<div class=\"alert alert-danger\">";
        $erro.= "<strong>ERRO:</strong> Por favor, preencha os campos de Usuário e Senha.";
        $erro.= "</div>";
        echo $erro;
    }
}
