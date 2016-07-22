<?php

global $conexao;

if(isset($_POST['selecionarArray'])) {

    $opcao = $_POST['opcoes'];

    foreach($_POST['selecionarArray'] as $comentario_id) {
        if($opcao == "Excluir") {
            $query = "DELETE FROM comentarios WHERE comentario_id = $comentario_id";
            $sucesso_texto = "Excluídos";
        } else if($opcao == "Aprovar") {
            $query = "UPDATE comentarios SET comentario_estado = 'Aprovado' WHERE comentario_id = $comentario_id";
            $sucesso_texto = "Aprovados";
        } else if($opcao == "Rejeitar") {
            $query = "UPDATE comentarios SET comentario_estado = 'Rejeitado' WHERE comentario_id = $comentario_id";
            $sucesso_texto = "Rejeitados";
        }
        $resultado_query = mysqli_query($conexao, $query);
    }

    $sucesso = "<div class=\"alert alert-success\">";
    $sucesso .= "<strong>SUCESSO:</strong> Os Comentários selecionados foram $sucesso_texto";
    $sucesso .= "</div>";
    echo $sucesso;
}

$query_comentarios = "SELECT * FROM comentarios ORDER BY comentario_data DESC";
$resultado_comentarios = mysqli_query($conexao, $query_comentarios);

$query_posts_titulo = "SELECT * FROM posts";
$resultado_posts_titulo = mysqli_query($conexao, $query_posts_titulo);

verificaErroNaQuery($resultado_comentarios);
verificaErroNaQuery($resultado_posts_titulo);

$array_posts = array();

while($linha = mysqli_fetch_assoc($resultado_posts_titulo)) {
    $array_posts[$linha['post_id']] = $linha['post_titulo'];
}

?>

<h1 class="page-header">
    Comentários
</h1>

<form method="post">

    <div id="selecaoEmMassa" class="col-xs-6 col-md-4 col-lg-4">
        <select class="form-control opcoes" name="opcoes">
            <option value="">Opções</option>
            <option value="Aprovar">Aprovar</option>
            <option value="Rejeitar">Rejeitar</option>
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
        <th>Autor</th>
        <th>Comentário</th>
        <th>Email</th>
        <th>Estado</th>
        <th>Post</th>
        <th>Data</th>
        <th colspan="3">Ações</th>
    </tr>
    </thead>
    <tbody>

    <?php

    if(mysqli_num_rows($resultado_comentarios) == 0) {
        echo "<tr><td colspan='7' class='text-center'>Nenhum comentário criado</td></tr>";
    }

    while($linha = mysqli_fetch_assoc($resultado_comentarios)) {

        $id = $linha['comentario_post_id'];
        $titulo = $array_posts[$linha['comentario_post_id']];
        $data = date_format(date_create($linha['comentario_data']), 'd/m/Y');

        $tabela = "<tr>";
        $tabela.= "<td><input class=\"selecionar\" type=\"checkbox\" name=\"selecionarArray[]\" value=\"{$linha['comentario_id']}\"></td>";
        $tabela.= "<td>{$linha['comentario_id']}</td>";
        $tabela.= "<td>{$linha['comentario_autor']}</td>";
        $tabela.= "<td>{$linha['comentario_conteudo']}</td>";
        $tabela.= "<td>{$linha['comentario_email']}</td>";
        $tabela.= "<td>{$linha['comentario_estado']}</td>";
        $tabela.= "<td><a target='_blank' href='../post.php?id=$id#comentarios'>$titulo</a></td>";
        $tabela.= "<td>$data</td>";
        $tabela.= "<td><a href='?aprovar={$linha['comentario_id']}' class='text-success'>Aprovar</a></td>";
        $tabela.= "<td><a href='?rejeitar={$linha['comentario_id']}' class='text-warning'>Rejeitar</a></td>";
        $tabela.= "<td><a onclick='javascript: return confirm(\"Você realmente deseja excluir o comentário selecionado?\")' href='?excluir={$linha['comentario_id']}' class='text-danger'>Excluir</a></td>";
        $tabela.= "</tr>";

        echo $tabela;
    } ?>

    </tbody>
</table>
</form>