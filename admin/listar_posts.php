<?php

global $conexao;

if(isset($_POST['selecionarArray'])) {

    $opcao = $_POST['opcoes'];

    foreach($_POST['selecionarArray'] as $post_id) {
        if($opcao == "Excluir") {
            $query = "DELETE FROM posts WHERE post_id = $post_id";
            $sucesso_texto = "Excluídos";
        } else {
            $query = "UPDATE posts SET post_estado = '$opcao' WHERE post_id = $post_id";
            $sucesso_texto = "Alterados";
        }
        $resultado_query = mysqli_query($conexao, $query);
    }

    $sucesso = "<div class=\"alert alert-success\">";
    $sucesso .= "<strong>SUCESSO:</strong> Os Posts selecionados foram $sucesso_texto";
    $sucesso .= "</div>";
    echo $sucesso;
}

$query_posts = "SELECT * FROM posts ORDER BY post_data DESC";
$resultado_posts = mysqli_query($conexao, $query_posts);

$query_carregar_categorias = "SELECT * FROM categorias";
$resultado_carregar_categorias = mysqli_query($conexao, $query_carregar_categorias);

while($linha = mysqli_fetch_assoc($resultado_carregar_categorias)) {
    $array_categorias[$linha['cat_id']] = $linha['cat_titulo'];
}


?>

<h1 class="page-header">
    Posts
    <a href="posts.php?criar"><button class="btn btn-primary">Novo Post</button></a>
</h1>

<form method="post">

    <div id="selecaoEmMassa" class="col-xs-6 col-md-4 col-lg-4">
        <select class="form-control opcoes" name="opcoes">
            <option value="">Opções</option>
            <option value="Publicado">Publicar</option>
            <option value="Rascunho">Marcar como Rascunho</option>
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
        <th>Título</th>
        <th>Categoria</th>
        <th>Estado</th>
        <th>Imagem</th>
        <th>Tags</th>
        <th>Comentários</th>
        <th>Visualizações</th>
        <th>Data</th>
        <th colspan="3">Ações</th>
    </tr>
    </thead>
    <tbody>

    <?php
    if(mysqli_num_rows($resultado_posts) == 0) {
        echo "<tr><td colspan='10' class='text-center'>Nenhum post criado</td></tr>";
    }

    while($linha = mysqli_fetch_assoc($resultado_posts)) {

        $data = date_format(date_create($linha['post_data']), 'd/m/Y');

        $id = $linha['post_id'];
        $autor = $linha['post_autor'];
        $titulo = $linha['post_titulo'];
        $categorias = $array_categorias[$linha['post_categoria_id']];
        $estado = $linha['post_estado'];
        $imagem = $linha['post_imagem'];
        $tags = $linha['post_tags'];
        $comentarios = $linha['post_comentarios_cont'];
        $visualizacoes = $linha['post_visualizacoes'];

        $query_carregar_autor = "SELECT usuario_nome, usuario_sobrenome FROM usuarios WHERE usuario_id = $autor";
        $resultado_carregar_autor = mysqli_query($conexao, $query_carregar_autor);
        verificaErroNaQuery($resultado_carregar_autor);
        $nome_autor = mysqli_fetch_row($resultado_carregar_autor);
        $nome_autor = $nome_autor[0] . " " . $nome_autor[1];
    ?>

    <tr>
        <td><input class="selecionar" type="checkbox" name="selecionarArray[]" value="<?=$id?>"></td>
        <td><?=$id?></td>
        <td><?=$nome_autor?></td>
        <td><?=$titulo?></td>
        <td><?=$categorias?></td>
        <td><?=$estado?></td>
        <td><a target='_blank' href='../uploads/<?=$imagem?>'><img height='50' src='../uploads/<?=$imagem?>'></a></td>
        <td><?=$tags?></td>
        <td><?=$comentarios?></td>
        <td><?=$visualizacoes?></td>
        <td><?=$data?></td>
        <td><a target="_blank" href='../post.php?id=<?=$id?>'>Visualizar</a></td>
        <td><a href='?editar=<?=$id?>'>Editar</a></td>
        <td><a onclick='javascript: return confirm("Você realmente deseja excluir o post selecionado?")' href='?excluir=<?=$id?>' class='text-danger'>Excluir</a></td>
    </tr>

    <?php } ?>

    </tbody>
</table>
</form>
