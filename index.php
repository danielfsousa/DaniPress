<?php

include_once "includes/db.php";
include "includes/header.php";

$posts_por_pag = 5;
$pagina = 0;
$pagina_get = 1;

if(isset($_GET['pagina'])) {

    $pagina_get = $_GET['pagina'];

    if(empty($pagina_get) || $pagina_get == 1) {
        $pagina = 0;
    } else {
        $pagina = ($pagina_get * $posts_por_pag) - $posts_por_pag;
    }

}

$query_posts = "SELECT * FROM posts WHERE post_estado = 'Publicado' ORDER BY post_data DESC LIMIT $pagina, $posts_por_pag";

if(isset($_SESSION['funcao'])) {
    if($_SESSION['funcao'] == "Administrador") {
        $query_posts = "SELECT * FROM posts ORDER BY post_data DESC LIMIT $pagina, $posts_por_pag";
    }
}

$query_posts_cont = "SELECT COUNT(*) FROM posts";

?>

    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Blog
                </h1>

                <?php

                $resultado_posts_cont = mysqli_query($conexao, $query_posts_cont);
                $posts_cont = mysqli_fetch_row($resultado_posts_cont)[0];

                $paginas = $posts_cont / $posts_por_pag;

                if($pagina_get > $paginas) {
                    header("Location: index.php?pagina=$paginas");
                }

                $resultado_posts = mysqli_query($conexao, $query_posts);

                setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

                while ($linha = mysqli_fetch_assoc($resultado_posts)) {
                    $post_id = $linha['post_id'];
                    $post_titulo = $linha['post_titulo'];
                    $post_autor = $linha['post_autor'];
                    $post_data = strftime('%d de %B de %Y', strtotime($linha['post_data']));
                    $post_imagem = $linha['post_imagem'];
                    $post_conteudo = substr($linha['post_conteudo'], 0, 300);
                    $post_estado = $linha['post_estado'];

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
                        <a href="post.php?id=<?=$post_id?>"><?php echo $post_titulo; if($post_estado == "Rascunho") { echo " (Rascunho)"; }?></a>
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
                <?php if($paginas > 1) { ?>
                    <ul class="pager">
                        <?php

                        for($i = 1; $i <= $paginas; $i++) {

                            if($pagina_get == $i) {
                                echo "<li style='margin-right: 5px'><a class=\"active\" href='index.php?pagina=$i'>$i</a></li>";
                            } else {
                                echo "<li style='margin-right: 5px'><a href='index.php?pagina=$i'>$i</a></li>";
                            }
                        }

                        if($pagina_get > 1) {
                            $pg = $pagina_get - 1;
                            echo "<li class='previous'><a href='index.php?pagina=$pg'>&larr; Anteriores</a></li>";
                        }

                        if($pagina_get < $paginas) {
                            $pg = $pagina_get + 1;
                            echo "<li class='next'><a href='index.php?pagina=$pg'>Próximos &rarr;</a></li>";
                        }

                        ?>

                    </ul>
                <?php } ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php" ?>