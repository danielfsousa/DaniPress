<?php

include "includes/header.php";
$pag = "categorias";

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
                        Categorias
                    </h1>

                    <?php

                    criarCategoria();
                    editarCategoria();

                    ?>

                    <div class="col-xs-6">
                        <form method="post">
                            <div class="form-group">
                                <label for="cat_titulo">Categoria</label>
                                <input class="form-control" type="text" name="cat_titulo" value="<?php getCategoriaTitulo() ?>">
                            </div>
                            <div class="form-group">
                                <?php getCategoriaBotao() ?>
                            </div>
                        </form>
                    </div>
                    <!-- /Criar Categoria -->

                    <!-- Tabela Categorias -->
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th colspan="3">Categoria</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            listarCategorias();
                            excluirCategoria();
                            ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- /Tabela Categorias -->
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
<?php include "includes/footer.php" ?>