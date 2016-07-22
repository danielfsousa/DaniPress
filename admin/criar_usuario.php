<?php
global $conexao;

if(isset($_POST['criar_usuario'])) {
    global $conexao;

    $login = mysqli_real_escape_string($conexao, $_POST['login']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $funcao = mysqli_real_escape_string($conexao, $_POST['funcao']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $sobrenome = mysqli_real_escape_string($conexao, $_POST['sobrenome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);

    $query_verifica_ususario = "SELECT * FROM usuarios WHERE usuario_login = '$login'";
    $query_verifica_email = "SELECT * FROM usuarios WHERE usuario_email = '$email'";
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
    } else {

        $senhaEncriptada = password_hash($senha, PASSWORD_BCRYPT);

        $query = "INSERT INTO usuarios(usuario_login, usuario_senha, usuario_nome, usuario_sobrenome,
                usuario_email, usuario_funcao) ";
        $query .= "VALUES('$login', '$senhaEncriptada', '$nome', '$sobrenome', '$email', '$funcao')";

        $resultado_criar_usuario = mysqli_query($conexao, $query);

        $sucesso = "<div class=\"alert alert-success\">";
        $sucesso .= "<strong>SUCESSO:</strong> O usuário '$login' foi criado com sucesso.";
        $sucesso .= "</div>";
        echo $sucesso;

    }

}

?>

<h1 class="page-header">
    Criar Usuário
</h1>

<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label for="login">Usuário</label>
    <input type="text" class="form-control" name="login" required>
</div>

<div class="form-group">
    <label for="senha">Senha</label>
    <input type="password" class="form-control" name="senha" required>
</div>

<div class="form-group">
    <label for="funcao">Função</label>
    <select class="form-control" name="funcao">
        <option value='Administrador'>Administrador</option>
        <option value='Inscrito'>Inscrito</option>
    </select>
</div>

<div class="form-group">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome">
</div>

<div class="form-group">
    <label for="sobrenome">Sobrenome</label>
    <input type="text" class="form-control" name="sobrenome">
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" name="email">
</div>

<div class="form-group">
    <button type="submit" name="criar_usuario" class="btn btn-primary">Salvar</button>
</div>

</form>