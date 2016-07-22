<?php

global $conexao;

if(isset($_POST['selecionarArray'])) {

    $opcao = $_POST['opcoes'];

    foreach($_POST['selecionarArray'] as $usuario_id) {
        if($opcao == "Excluir") {
            $query = "DELETE FROM usuarios WHERE usuario_id = $usuario_id";
            $sucesso_texto = "Excluídos";
        } else {
            $query = "UPDATE usuarios SET usuario_funcao = '$opcao' WHERE usuario_id = $usuario_id";
            $sucesso_texto = "Alterados";
        }
        $resultado_query = mysqli_query($conexao, $query);
    }

    $sucesso = "<div class=\"alert alert-success\">";
    $sucesso .= "<strong>SUCESSO:</strong> Os Usuários selecionados foram $sucesso_texto";
    $sucesso .= "</div>";
    echo $sucesso;
}

$query_usuarios = "SELECT * FROM usuarios";
$resultado_usuarios = mysqli_query($conexao, $query_usuarios);

?>

<h1 class="page-header">
    Usuários
    <a href="usuarios.php?criar"><button class="btn btn-primary">Novo Usuário</button></a>
</h1>

<form method="post">

    <div id="selecaoEmMassa" class="col-xs-6 col-md-4 col-lg-4">
        <select class="form-control opcoes" name="opcoes">
            <option value="">Opções</option>
            <option value="Administrador">Administrador</option>
            <option value="Inscrito">Inscrito</option>
            <option value="Excluir">Excluir</option>
        </select>
        <button class="btn btn-success" type="submit">Aplicar</button>
        <button class="btn btn-default" type="reset">Cancelar</button>
    </div>

<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th><input id="selecionarTodos" type="checkbox"></th>
        <th>ID</th>
        <th>Login</th>
        <th>Nome</th>
        <th>Sobrenome</th>
        <th>Email</th>
        <th>Função</th>
        <th colspan="4">Ações</th>
    </tr>
    </thead>
    <tbody>

    <?php

    if(mysqli_num_rows($resultado_usuarios) == 0) {
        echo "<tr><td colspan='7' class='text-center'>Nenhum usuário criado</td></tr>";
    }

    while($linha = mysqli_fetch_assoc($resultado_usuarios)) {

        $tabela = "<tr>";
        $tabela.= "<td><input class=\"selecionar\" type=\"checkbox\" name=\"selecionarArray[]\" value=\"{$linha['usuario_id']}\"></td>";
        $tabela.= "<td>{$linha['usuario_id']}</td>";
        $tabela.= "<td>{$linha['usuario_login']}</td>";
        $tabela.= "<td>{$linha['usuario_nome']}</td>";
        $tabela.= "<td>{$linha['usuario_sobrenome']}</td>";
        $tabela.= "<td>{$linha['usuario_email']}</td>";
        $tabela.= "<td>{$linha['usuario_funcao']}</td>";
        $tabela.= "<td><a href='?admin={$linha['usuario_id']}' class='text-warning'>Administrador</a></td>";
        $tabela.= "<td><a href='?inscrito={$linha['usuario_id']}' class='text-warning'>Inscrito</a></td>";
        $tabela.= "<td><a href='?editar={$linha['usuario_id']}'>Editar</a></td>";
        $tabela.= "<td><a onclick='javascript: return confirm(\"Você realmente deseja excluir o usuário selecionado?\")' href='?excluir={$linha['usuario_id']}' class='text-danger'>Excluir</a></td>";
        $tabela.= "</tr>";

        echo $tabela;
    } ?>

    </tbody>
</table>
</form>