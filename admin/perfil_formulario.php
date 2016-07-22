<?php
global $conexao;

$login = $_SESSION['usuario'];

$query_carregar_usuario = "SELECT * FROM usuarios WHERE usuario_login = '$login'";
$resultado_carregar_usuario = mysqli_query($conexao, $query_carregar_usuario);
verificaErroNaQuery($resultado_carregar_usuario);

while($linha = mysqli_fetch_assoc($resultado_carregar_usuario)) {
    $id = $linha['usuario_id'];
    $login = $linha['usuario_login'];
    $funcao = $linha['usuario_funcao'];
    $nome = $linha['usuario_nome'];
    $sobrenome = $linha['usuario_sobrenome'];
    $email = $linha['usuario_email'];
}

if(isset($_POST['atualizar_usuario'])) {

    $login = mysqli_real_escape_string($conexao, $_POST['login']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $sobrenome = mysqli_real_escape_string($conexao, $_POST['sobrenome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);

    if(!empty($login) && !empty($senha) && !empty($email)) {

        $query_atualizar_usuario = "UPDATE usuarios SET usuario_login='$login', usuario_senha='$senha',
                                  usuario_funcao='$funcao', usuario_nome='$nome', usuario_sobrenome='$sobrenome',
                                  usuario_email='$email' WHERE usuario_id = $id";

        $resultado_atualizar_usuario = mysqli_query($conexao, $query_atualizar_usuario);
        verificaErroNaQuery($resultado_atualizar_usuario);
    } else {
        //TODO
    }
}

?>

<h1 class="page-header">
    Meu Perfil
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