<?php

include "includes/header.php";
$pag = "painel";

// Quatidade do Posts
$query_num_posts = "SELECT COUNT(*) FROM posts";
$resultado_num_posts = mysqli_query($conexao, $query_num_posts);
verificaErroNaQuery($resultado_num_posts);
$num_posts = mysqli_fetch_row($resultado_num_posts)[0];

// Quatidade do Comentários
$query_num_comentarios = "SELECT COUNT(*) FROM comentarios";
$resultado_num_comentarios = mysqli_query($conexao, $query_num_comentarios);
verificaErroNaQuery($resultado_num_comentarios);
$num_comentarios = mysqli_fetch_row($resultado_num_comentarios)[0];

// Quatidade do Usuários
$query_num_usuarios = "SELECT COUNT(*) FROM usuarios";
$resultado_num_usuarios = mysqli_query($conexao, $query_num_usuarios);
verificaErroNaQuery($resultado_num_usuarios);
$num_usuarios = mysqli_fetch_row($resultado_num_usuarios)[0];

// Quatidade do Categorias
$query_num_categorias = "SELECT COUNT(*) FROM categorias";
$resultado_num_categorias = mysqli_query($conexao, $query_num_categorias);
verificaErroNaQuery($resultado_num_categorias);
$num_categorias = mysqli_fetch_row($resultado_num_categorias)[0];

?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Bem-Vindo
                            <small><?=$_SESSION['nome']?> <?=$_SESSION['sobrenome']?></small>
                        </h1>

                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-file-text fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">
                                                    <?=$num_posts?>
                                                </div>
                                                <div>
                                                    Posts
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="posts.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">
                                                Mais Detalhes
                                            </span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-green">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-comments fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">
                                                    <?=$num_comentarios?>
                                                </div>
                                                <div>
                                                    Comentários
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="comentarios.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">
                                                Mais Detalhes
                                            </span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-yellow">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-users fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">
                                                    <?=$num_usuarios?>
                                                </div>
                                                <div>
                                                    Usuários
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="usuarios.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">
                                                Mais Detalhes
                                            </span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-red">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-list fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">
                                                    <?=$num_categorias?>
                                                </div>
                                                <div>
                                                    Categorias
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="categorias.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">
                                                Mais Detalhes
                                            </span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
        <?php include "includes/footer.php" ?>