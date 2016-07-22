<?php
global $conexao;

$query_carregar_categorias = "SELECT * FROM categorias";
$resultado_carregar_categorias = mysqli_query($conexao, $query_carregar_categorias);
verificaErroNaQuery($resultado_carregar_categorias);

if(isset($_POST['criar_post'])) {
    global $conexao;

    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
    $autor = $_SESSION['id'];
    $categoria = mysqli_real_escape_string($conexao, $_POST['categoria']);
    $estado = mysqli_real_escape_string($conexao, $_POST['estado']);

    $imagem = $_FILES['imagem']['name'];
    $imagem_tmp = $_FILES['imagem']['tmp_name'];

    $tags = mysqli_real_escape_string($conexao, $_POST['tags']);
    $conteudo = mysqli_real_escape_string($conexao, $_POST['conteudo']);
    $data = date("Y-m-d H:i:s");

    move_uploaded_file($imagem_tmp, "../uploads/$imagem");

    $query = "INSERT INTO posts(post_categoria_id, post_titulo, post_autor, post_data,
                post_imagem, post_conteudo, post_tags, post_comentarios_cont, post_estado) ";
    $query.= "VALUES($categoria, '$titulo', '$autor', '$data', '$imagem', '$conteudo', '$tags',
                '0', '$estado')";

    $resultado_criar_post = mysqli_query($conexao, $query);
    $id_novo_post = mysqli_insert_id($conexao);

    $sucesso = "<div class=\"alert alert-success\">";
    $sucesso .= "<strong>SUCESSO:</strong> O post '<a target='_blank' href='../post.php?id=$id_novo_post'>$titulo</a>' foi criado com sucesso.";
    $sucesso .= "</div>";
    echo $sucesso;
}

?>

<h1 class="page-header">
    Criar Post
</h1>

<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label for="titulo">Título</label>
    <input type="text" class="form-control" name="titulo" required>
</div>

<div class="form-group">
    <label for="categoria">Categoria</label>
    <select class="form-control" name="categoria">
        <?php
        while($linha = mysqli_fetch_assoc($resultado_carregar_categorias)) {
            $cat_id = $linha['cat_id'];
            $cat_titulo = $linha['cat_titulo'];

            echo "<option value='$cat_id'>$cat_titulo</option>";
        }
        ?>
    </select>
</div>

<div class="form-group">
    <label for="imagem">Imagem</label>
    <input type="file" name="imagem">
</div>

<div class="form-group">
    <label for="autor">Tags</label>
    <input type="text" class="form-control" name="tags">
</div>

<div class="form-group">
    <label for="autor">Descrição</label>
    <textarea cols="30" rows="10" class="form-control" name="conteudo"></textarea>
</div>

<div class="form-group">
    <label for="estado">Estado</label>
    <select class="form-control" name="estado">
        <option value='Publicado'>Publicado</option>
        <option value='Rascunho'>Rascunho</option>
    </select>
</div>

<div class="form-group">
    <button type="submit" name="criar_post" class="btn btn-primary">Salvar</button>
</div>

</form>