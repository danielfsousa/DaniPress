<?php
global $conexao;

$id = mysqli_real_escape_string($conexao, $_GET['editar']);
$query_carregar_usuario = "SELECT * FROM usuarios WHERE usuario_id = $id";
$resultado_carregar_usuario = mysqli_query($conexao, $query_carregar_usuario);

while($linha = mysqli_fetch_assoc($resultado_carregar_usuario)) {
    $login = $linha['usuario_login'];
    $funcao = $linha['usuario_funcao'];
    $nome = $linha['usuario_nome'];
    $sobrenome = $linha['usuario_sobrenome'];
    $email = $linha['usuario_email'];
}

if(isset($_POST['atualizar_usuario'])) {

    $login = mysqli_real_escape_string($conexao, $_POST['login']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $funcao = mysqli_real_escape_string($conexao, $_POST['funcao']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $sobrenome = mysqli_real_escape_string($conexao, $_POST['sobrenome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);

    $query_verifica_ususario = "SELECT * FROM usuarios WHERE usuario_login = '$login' AND usuario_id != $id";
    $query_verifica_email = "SELECT * FROM usuarios WHERE usuario_email = '$email' AND usuario_id != $id";
    $resultado_verifica_usuario = mysqli_query($conexao, $query_verifica_ususario);
    $resultado_verifica_email = mysqli_query($conexao, $query_verifica_email);

if(mysqli_num_rows($resultado_verifica_usuario) !== 0) {
    $erro = "<div class=\"alert alert-danger\">";
    $erro.= "<strong>ERRO:</strong> O usuário '$login' já existe. Por favor, escolha outro nome de usuário.";
    $erro.= "</div>";
    echo $erro;
} else if(mysqli_num_rows($resultado_verifica_email) !== 0) {
    $erro = "<div class=\"alert alert-danger\">";
    $erro.= "<strong>ERRO:</strong> O email '$email' está associado a outra conta. Por favor, escolha outro email.";
    $erro.= "</div>";
    echo $erro;
} else if (!empty($login) && !empty($senha) && !empty($email)) {

    $senhaEncriptada = password_hash($senha, PASSWORD_BCRYPT);

    $query_atualizar_usuario = "UPDATE usuarios SET usuario_login='$login', usuario_senha='$senhaEncriptada',
                              usuario_funcao='$funcao', usuario_nome='$nome', usuario_sobrenome='$sobrenome',
                              usuario_email='$email' WHERE usuario_id = $id";
    $resultado_criar_usuario = mysqli_query($conexao, $query_atualizar_usuario);

    $sucesso = "<div class=\"alert alert-success\">";
    $sucesso .= "<strong>SUCESSO:</strong> O usuário '$login' foi modificado com sucesso.";
    $sucesso .= "</div>";
    echo $sucesso;
    }
}

?>

<h1 class="page-header">
    Editar Usuário
</h1>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="login">Usuário</label>
        <input type="text" class="form-control" name="login" value="<?=$login?>" required>
    </div>

    <div class="form-group">
        <label for="senha">Senha</label>
        <input type="password" class="form-control" name="senha" required>
    </div>

    <div class="form-group">
        <label for="funcao">Função</label>
        <select class="form-control" name="funcao">
            <?php

            switch($funcao) {
                case "Administrador":
                    echo "<option value='Administrador' selected>Administrador</option>";
                    echo "<option value='Inscrito'>Inscrito</option>";
                    break;
                case "Inscrito":
                    echo "<option value='Administrador'>Administrador</option>";
                    echo "<option value='Inscrito' selected>Inscrito</option>";
                    break;
                default:
                    echo "Erro no arquivo editar_usuario.php";
            }

            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" value="<?=$nome?>">
    </div>

    <div class="form-group">
        <label for="sobrenome">Sobrenome</label>
        <input type="text" class="form-control" name="sobrenome" value="<?=$sobrenome?>">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" value="<?=$email?>">
    </div>

    <div class="form-group">
        <button type="submit" name="atualizar_usuario" class="btn btn-primary">Salvar</button>
    </div>

</form>