<div class="col-md-4">

    <!-- Procurar -->
    <div class="well">
        <h4>Procurar</h4>
        <form action="procurar.php" method="post">
            <div class="input-group">
                <input name="procurar_texto" type="text" class="form-control">
                    <span class="input-group-btn">
                        <button name="procurar" class="btn btn-default" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- Login -->
    <div class="well" id="login">
        <h4>Login</h4>
        <?php if(empty($_SESSION['funcao'])) { ?>
            <form method="post">
                <div class="form-group">
                    <input name="usuario" type="text" class="form-control" placeholder="Usuário">
                </div>
                <div class="form-group">
                    <input name="senha" type="password" class="form-control" placeholder="Senha">
                </div>
                <div class="form-group">
                    <button name="login" class="btn btn-primary" type="submit">Entrar</button>
                </div>

            </form>
        <?php
            include "entrar.php";
        } else {
            echo "<p>Você está logado como: <span class='text-info'>$_SESSION[nome] $_SESSION[sobrenome]</span></p>";
            echo "<a href='admin/index.php'><button style='margin-right: 10px' class='btn btn-default'>Ir para o Painel do Administrador</button></a>";
            echo "<a href='includes/sair.php'><button class='btn btn-danger'>Sair</button></a>";
        }

        ?>
        <!-- /.input-group -->
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Categorias</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php

                    $query = "SELECT * FROM categorias ORDER BY cat_titulo";
                    $resultado = mysqli_query($conexao, $query);

                    while($linha = mysqli_fetch_assoc($resultado)) {
                        $cat_id = $linha['cat_id'];
                        $cat_titulo = $linha['cat_titulo'];
                        echo "<li><a href='categoria.php?id=$cat_id'>$cat_titulo</a></li>";
                    }

                    ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "widget.php" ?>

</div>