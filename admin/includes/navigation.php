<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">DaniPress CMS</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li><a href="#">Usuários Online: <?=$usuarios_online?></a></li>

        <li><a target="_blank" href="../index.php">Visualizar Site</a></li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$_SESSION['nome']?> <?=$_SESSION['sobrenome']?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="perfil.php"><i class="fa fa-fw fa-user"></i> Perfil</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../includes/sair.php"><i class="fa fa-fw fa-power-off"></i> Sair</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li class="<?php echo ($pag == "painel" ? "active" : "")?>">
                <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Painel</a>
            </li>
            <li class="<?php echo ($pag == "posts" ? "active" : "")?>">
                <a href="javascript:;" data-toggle="collapse" data-target="#posts"><i class="fa fa-fw fa-pencil-square-o"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts" class="collapse">
                    <li>
                        <a href="./posts.php">Todos os Posts</a>
                    </li>
                    <li>
                        <a href="./posts.php?criar">Novo Post</a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo ($pag == "categorias" ? "active" : "")?>">
                <a href="./categorias.php"><i class="fa fa-fw fa-list"></i> Categorias</a>
            </li>
            <li class="<?php echo ($pag == "comentarios" ? "active" : "")?>">
                <a href="./comentarios.php"><i class="fa fa-fw fa-comments"></i> Comentários</a>
            </li>
            <li class="<?php echo ($pag == "usuarios" ? "active" : "")?>">
                <a href="javascript:;" data-toggle="collapse" data-target="#usuarios"><i class="fa fa-fw fa-users"></i> Usuários <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="usuarios" class="collapse">
                    <li>
                        <a href="./usuarios.php">Todos os Usuários</a>
                    </li>
                    <li>
                        <a href="./usuarios.php?criar">Novo Usuário</a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo ($pag == "perfil" ? "active" : "")?>">
                <a href="perfil.php"><i class="fa fa-fw fa-user"></i> Perfil</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>