<?php

include_once "includes/db.php";
include "includes/header.php";

global $conexao;

if(isset($_SESSION['funcao'])) {
    header("Location: admin/perfil.php");
}

if(isset($_POST['registrar'])) {

    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $senha2 = mysqli_real_escape_string($conexao, $_POST['senha2']);

    if(!empty($usuario) && !empty($email) && !empty($senha) && !empty($senha2)) {

        if($senha == $senha2) {

            $senhaEncriptada = pasword_hash($senha, PASSWORD_BCRYPT);

            $query_registrar = "INSERT INTO usuarios(usuario_login, usuario_email, usuario_senha, usuario_funcao)
                                VALUES ('$usuario', '$email', '$senhaEncriptada', 'Inscrito')";
            $resultado_registrar = mysqli_query($conexao, $query_registrar);
            if(!$resultado_registrar) {
                echo "ERRO NA QUERY" . mysqli_error($conexao);
            }

            $sucesso = "<div class=\"alert alert-success\">";
            $sucesso.= "<strong>SUCESSO:</strong> Conta criada com sucesso! <a href='login.php'>Entrar</a>.";
            $sucesso.= "</div>";
            echo $sucesso;
        } else {
            $erro = "<div class=\"alert alert-danger\">";
            $erro.= "<strong>ERRO:</strong> As senhas preenchidas não são iguais. Digite novamente.";
            $erro.= "</div>";
            echo $erro;
        }

    } else {
        $erro = "<div class=\"alert alert-danger\">";
        $erro.= "<strong>ERRO:</strong> Por favor, preencha todos os campos.";
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
                Registrar
            </h1>

            <form method="post" id="form">

                <div class="form-group">
                    <label for="usuario">Usuário</label>
                    <input type="text" name="usuario" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="senha2">Digite a Senha Novamente</label>
                    <input type="password" name="senha2" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary" name="registrar">Registrar</button>
                <a href="login.php" class="text-info">Já possui uma conta? Entrar</a>

            </form>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php" ?>
