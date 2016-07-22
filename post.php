<?php

include_once "includes/db.php";
include "includes/header.php";
global $conexao;

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conexao, $_GET['id']);
    $query_post = "SELECT * FROM posts WHERE post_id = $id";
} else {
    header("Location: index.php");
}

$query_visualizacoes = "UPDATE posts SET post_visualizacoes = post_visualizacoes + 1 WHERE post_id = $id";
mysqli_query($conexao, $query_visualizacoes);
?>

    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->
                <?php

                $resultado_post = mysqli_query($conexao, $query_post);

                setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

                while($linha = mysqli_fetch_assoc($resultado_post)) {
                    $post_id = $linha['post_id'];
                    $post_titulo = $linha['post_titulo'];
                    $post_autor = $linha['post_autor'];
                    $post_data = strftime('%d de %B de %Y', strtotime($linha['post_data']));
                    $post_imagem = $linha['post_imagem'];
                    $post_conteudo = $linha['post_conteudo'];
                }

                $query_autor = "SELECT usuario_nome, usuario_sobrenome FROM usuarios WHERE usuario_id = $post_autor";
                $resultado_autor = mysqli_query($conexao, $query_autor);
                $nome_autor = mysqli_fetch_row($resultado_autor);
                $nome_autor = $nome_autor[0] . " " . $nome_autor[1];

                ?>

                <!-- Title -->
                <h1><?=$post_titulo?></h1>

                <!-- Author -->
                <p class="lead">
                    por <a href="autor.php?id=<?=$post_autor?>"><?=$nome_autor?></a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p>
                    <span class="glyphicon glyphicon-time"></span> Publicado em <?=$post_data?>
                    <?php if($_SESSION['funcao'] == "Administrador") { echo "- <a href=\"admin/posts.php?editar=$post_id\">Editar Post</a>"; } ?>

                </p>

                <hr>

                <!-- Preview Image -->
                <a target="_blank" href="uploads/<?=$post_imagem?>"><img class="img-responsive" src="uploads/<?=$post_imagem?>" alt=""></a>

                <hr>

                <!-- Post Content -->
                <p><?=$post_conteudo?></p>

                <hr>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4 id="comentar">Deixe um Comentário:</h4>
                    <form role="form" action="#comentar" method="post">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input class="form-control" type="text" name="nome">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="comentario">Comentário</label>
                            <textarea class="form-control" rows="3" name="comentario"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="enviar_comentario">Enviar</button>
                        <?php
                        global $conexao;
                        if(isset($_POST['enviar_comentario'])) {
                            if(!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['comentario'])) {
                                $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
                                $email = mysqli_real_escape_string($conexao, $_POST['email']);
                                $comentario = mysqli_real_escape_string($conexao, $_POST['comentario']);

                                $query_enviar_comentario = "INSERT INTO comentarios(comentario_autor, comentario_email,
                                comentario_conteudo, comentario_post_id, comentario_estado, comentario_data)";
                                $query_enviar_comentario .= "VALUES('$nome', '$email', '$comentario', $id, 'Aguardando Aprovação', now())";

                                $query_incrementar_cont = "UPDATE posts SET post_comentarios_cont = post_comentarios_cont + 1 ";
                                $query_incrementar_cont.= "WHERE post_id = $id";
                                mysqli_query($conexao, $query_incrementar_cont);

                                $rslt = mysqli_query($conexao, $query_enviar_comentario);

                                $sucesso = "<div style=\"margin-bottom: 0; margin-top: 20px\" class=\"alert alert-success\">";
                                $sucesso.= "<strong>SUCESSO:</strong> Comentário aguardando aprovação.";
                                $sucesso.= "</div>";
                                echo $sucesso;
                            } else {
                                $erro = "<div style=\"margin-bottom: 0; margin-top: 20px\" class=\"alert alert-danger\">";
                                $erro.= "<strong>ERRO:</strong> Por favor, preencha todos os campos.";
                                $erro.= "</div>";
                                echo $erro;
                            }
                        }
                        ?>
                    </form>
                </div>

                <hr id="comentarios">

                <!-- Posted Comments -->

                <!-- Comment -->
                <?php

                $query_listar_comentarios = "SELECT comentario_autor, comentario_data, comentario_conteudo
                                              FROM comentarios WHERE comentario_estado = 'Aprovado' AND comentario_post_id = $id";

                $resultado_listar_comentarios = mysqli_query($conexao, $query_listar_comentarios);

                setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

                while($linha = mysqli_fetch_assoc($resultado_listar_comentarios)) {
                    $nome = $linha['comentario_autor'];
                    $data = strftime('%d de %B de %Y', strtotime($linha['comentario_data']));
                    $comentario = $linha['comentario_conteudo'];

                ?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?=$nome?>
                            <small><?=$data?></small>
                        </h4>
                        <?=$comentario?>
                    </div>
                </div>
                <?php
                }
                ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>


        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php include "includes/footer.php" ?>