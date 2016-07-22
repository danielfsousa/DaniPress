<?php
global $conexao;

$id = mysqli_real_escape_string($conexao, $_GET['editar']);
$query_carregar_post = "SELECT * FROM posts WHERE post_id = $id";
$resultado_carregar_post = mysqli_query($conexao, $query_carregar_post);
verificaErroNaQuery($resultado_carregar_post);

$query_carregar_categorias = "SELECT * FROM categorias";
$resultado_carregar_categorias = mysqli_query($conexao, $query_carregar_categorias);
verificaErroNaQuery($resultado_carregar_categorias);

$query_carregar_usuarios = "SELECT * FROM usuarios";
$resultado_carregar_usuarios = mysqli_query($conexao, $query_carregar_usuarios);
verificaErroNaQuery($resultado_carregar_usuarios);

while($linha = mysqli_fetch_assoc($resultado_carregar_post)) {
    $titulo = $linha['post_titulo'];
    $categoria = $linha['post_categoria_id'];
    $autor = $linha['post_autor'];
    $estado = $linha['post_estado'];
    $imagem = $linha['post_imagem'];
    $tags = $linha['post_tags'];
    $conteudo = $linha['post_conteudo'];
}

if(isset($_POST['atualizar_post'])) {

    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
    $autor = mysqli_real_escape_string($conexao, $_POST['autor']);
    $categoria = mysqli_real_escape_string($conexao, $_POST['categoria']);
    $estado = mysqli_real_escape_string($conexao, $_POST['estado']);
    $tags = mysqli_real_escape_string($conexao, $_POST['tags']);
    $conteudo = mysqli_real_escape_string($conexao, $_POST['conteudo']);

    if(!empty($_FILES['imagem']['name'])) {
        $imagem = $_FILES['imagem']['name'];
        $imagem_tmp = $_FILES['imagem']['tmp_name'];
        move_uploaded_file($imagem_tmp, "../uploads/$imagem");

        $query_atualizar_post = "UPDATE posts SET post_categoria_id=$categoria, post_titulo='$titulo',
                                  post_autor='$autor', post_imagem='$imagem', post_conteudo='$conteudo',
                                  post_tags='$tags', post_estado='$estado' WHERE post_id = $id";
    } else {
        $query_atualizar_post = "UPDATE posts SET post_categoria_id=$categoria, post_titulo='$titulo',
                                  post_autor='$autor', post_conteudo='$conteudo',
                                  post_tags='$tags', post_estado='$estado' WHERE post_id = $id";
    }

    $resultado_criar_post = mysqli_query($conexao, $query_atualizar_post);
    verificaErroNaQuery($resultado_criar_post);

    $sucesso = "<div class=\"alert alert-success\">";
    $sucesso .= "<strong>SUCESSO:</strong> O post '<a target='_blank' href='../post.php?id=$id'>$titulo</a>' foi alterado com sucesso.";
    $sucesso .= "</div>";
    echo $sucesso;

}

?>

<h1 class="page-header">
    Editar Post
</h1>

<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label for="titulo">Título</label>
    <input type="text" class="form-control" name="titulo" value="<?=$titulo?>" required>
</div>

<div class="form-group">
    <label for="categoria">Categoria</label>
    <select class="form-control" name="categoria">
        <?php
        while($linha = mysqli_fetch_assoc($resultado_carregar_categorias)) {
            $cat_id = $linha['cat_id'];
            $cat_titulo = $linha['cat_titulo'];

            if($cat_id == $categoria) {
                echo "<option value='$cat_id' selected>$cat_titulo</option>";
            } else {
                echo "<option value='$cat_id'>$cat_titulo</option>";
            }

        }
        ?>
    </select>
</div>

<div class="form-group">
    <label for="autor">Autor</label>
    <select class="form-control" name="autor">
        <?php
        while($linha = mysqli_fetch_assoc($resultado_carregar_usuarios)) {
            $usuario_id = $linha['usuario_id'];
            $usuario_nome = $linha['usuario_nome'];
            $usuario_sobrenome = $linha['usuario_sobrenome'];

            if($usuario_id == $autor) {
                echo "<option value='$usuario_id' selected>$usuario_nome $usuario_sobrenome</option>";
            } else {
                echo "<option value='$usuario_id'>$usuario_nome $usuario_sobrenome</option>";
            }

        }
        ?>
    </select>
</div>

<div class="form-group">
    <label for="imagem">Imagem</label>
    <br>
    <?php getImagemPost($imagem) ?>
    <input type="file" name="imagem" value="<?=$imagem?>">
</div>

<div class="form-group">
    <label for="autor">Tags</label>
    <input type="text" class="form-control" name="tags" value="<?=$tags?>">
</div>

<div class="form-group">
    <label for="autor">Descrição</label>
    <textarea cols="30" rows="10" class="form-control" name="conteudo"><?=$conteudo?></textarea>
</div>

<div class="form-group">
    <label for="estado">Estado</label>
    <select class="form-control" name="estado">
        <option value='Publicado'>Publicado</option>
        <option value='Rascunho'>Rascunho</option>
    </select>
</div>

<div class="form-group">
    <button type="submit" name="atualizar_post" class="btn btn-primary">Salvar</button>
</div>

</form>