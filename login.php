<?php

include_once "includes/db.php";
include "includes/header.php";

global $conexao;

if(isset($_SESSION['funcao'])) {
    header("Location: admin/perfil.php");
}

if(isset($_POST['entrar'])) {

    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);

    if(!empty($usuario) && !empty($senha)) {

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

?>

<!-- Navigation -->
<?php include "includes/navigation.php" ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-md-8">

            <h1 class="page-header">
                Entrar
            </h1>

            <form method="post" id="form">

                <div class="form-group">
                    <label for="usuario">Usuário</label>
                    <input type="text" name="usuario" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary" name="entrar">Entrar</button>
                <a href="registrar.php" class="text-info">Não possui uma conta? Registrar</a>

            </form>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php" ?>
