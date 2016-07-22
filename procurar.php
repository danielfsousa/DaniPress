<?php

include_once "includes/db.php";
include "includes/header.php";

if(isset($_POST['procurar'])) {
    $procurar_texto = mysqli_real_escape_string($conexao, $_POST['procurar_texto']);
} else {
    header("Location: index.php");
}

$query_procurar = "SELECT * FROM posts WHERE post_tags ";
$query_procurar.= "LIKE '%$procurar_texto%' OR post_titulo LIKE '%$procurar_texto%' ORDER BY post_data DESC";
$resultado_procurar = mysqli_query($conexao, $query_procurar);


?>

<!-- Navigation -->
<?php include "includes/navigation.php" ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                Procurar: '<?=$procurar_texto?>'
            </h1>

            <?php

            if(mysqli_num_rows($resultado_procurar) == 0) {
                echo "<h3>Nenhum resultado para '$procurar_texto' encontrado.</h3>";
            }

            setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

            while ($linha = mysqli_fetch_assoc($resultado_procurar)) {
                $post_id = $linha['post_id'];
                $post_titulo = $linha['post_titulo'];
                $post_autor = $linha['post_autor'];
                $post_data = strftime('%d de %B de %Y', strtotime($linha['post_data']));
                $post_imagem = $linha['post_imagem'];
                $post_conteudo = substr($linha['post_conteudo'], 0, 300);

                if(strlen($post_conteudo) == 300) {
                    $post_conteudo.= "...";
                }

                $query_autor = "SELECT usuario_nome, usuario_sobrenome FROM usuarios WHERE usuario_id = $post_autor";
                $resultado_autor = mysqli_query($conexao, $query_autor);
                $nome_autor = mysqli_fetch_row($resultado_autor);
                $nome_autor = $nome_autor[0] . " " . $nome_autor[1];

                ?>

                <!-- Blog Post -->
                <h2>
                    <a href="post.php?id=<?=$post_id?>"><?=$post_titulo?></a>
                </h2>
                <p class="lead">
                    por <a href="autor.php?id=<?=$post_autor?>"><?=$nome_autor?></a>
                </p>

                <p>
                    <span class="glyphicon glyphicon-time"></span> Publicado em: <?=$post_data?>
                    <?php if($_SESSION['funcao'] == "Administrador") { echo "- <a href=\"admin/posts.php?editar=$post_id\">Editar Post</a>"; } ?>
                </p>
                <hr>

                <a href="post.php?id=<?=$post_id?>"><img class="img-responsive" src="uploads/<?=$post_imagem?>" alt=""></a>
                <hr>
                <p><?=$post_conteudo?></p>
                <a class="btn btn-primary" href="post.php?id=<?=$post_id?>">Leia Mais <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php
            }

            ?>


            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Anteriores</a>
                </li>
                <li class="next">
                    <a href="#">Próximos &rarr;</a>
                </li>
            </ul>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php" ?>
