<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./">DaniPress CMS</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <?php

                $query = "SELECT * FROM categorias";
                $resultado = mysqli_query($conexao, $query);

                while($linha = mysqli_fetch_assoc($resultado)) {
                    $cat_id = $linha['cat_id'];
                    $cat_titulo = $linha['cat_titulo'];
                    echo "<li><a href='categoria.php?id=$cat_id'>$cat_titulo</a></li>";
                }
                if(isset($_SESSION['funcao'])) {
                    if($_SESSION['funcao'] == "Administrador") {
                ?>
                        <li>
                            <a href="admin">Painel do Administrador</a>
                        </li>
                <?php } } ?>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>