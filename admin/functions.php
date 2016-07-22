<?php

function verificaErroNaQuery($resultado) {
    global $conexao;
    if(!$resultado) {
        die("ERRO NA QUERY: " . mysqli_error($conexao));
    }
}

/*
   _____       _______ ______ _____  ____  _____  _____           _____
  / ____|   /\|__   __|  ____/ ____|/ __ \|  __ \|_   _|   /\    / ____|
 | |       /  \  | |  | |__ | |  __| |  | | |__) | | |    /  \  | (___
 | |      / /\ \ | |  |  __|| | |_ | |  | |  _  /  | |   / /\ \  \___ \
 | |____ / ____ \| |  | |___| |__| | |__| | | \ \ _| |_ / ____ \ ____) |
  \_____/_/    \_\_|  |______\_____|\____/|_|  \_\_____/_/    \_\_____/

 */

function listarCategorias() {
    global $conexao;
    $query_categorias = "SELECT * FROM categorias";
    $resultado_categorias = mysqli_query($conexao, $query_categorias);

    if(mysqli_num_rows($resultado_categorias) == 0) {
        echo "<tr><td colspan='2' class='text-center'>Nenhuma categoria criada</td></tr>";
    }

    while($linha = mysqli_fetch_assoc($resultado_categorias)) {
    $cat_id = $linha['cat_id'];
    $cat_titulo = $linha['cat_titulo'];
    ?>

    <tr>
        <td><?=$cat_id?></td>
        <td><?=$cat_titulo?></td>
        <td><a href="categorias.php?editar=<?=$cat_id?>">Editar</a></td>
        <td><a class="text-danger" onclick='javascript: return confirm("Você realmente deseja excluir a categoria selecionada?")' href="categorias.php?excluir=<?=$cat_id?>">Excluir</a></td>
    </tr>

<?php }
}

function criarCategoria() {
    global $conexao;
    if(isset($_POST['criar_categoria'])) {
        $cat_titulo = mysqli_real_escape_string($conexao, $_POST['cat_titulo']);

        if($cat_titulo == "" || empty($cat_titulo)) {
            $erro = "<div class=\"alert alert-danger\">";
            $erro.= "<strong>ERRO:</strong> Por favor, digite um nome para a Categoria";
            $erro.= "</div>";
            echo $erro;
        } else {
            $query_verifica_categoria = "SELECT * FROM categorias WHERE cat_titulo = '$cat_titulo'";
            $resultado_verifica_categoria = mysqli_query($conexao, $query_verifica_categoria);
            if(mysqli_num_rows($resultado_verifica_categoria) !== 0) {
                $erro = "<div class=\"alert alert-danger\">";
                $erro.= "<strong>ERRO:</strong> A Categoria '$cat_titulo' já existe. Por favor, escolha outro nome para a categoria.";
                $erro.= "</div>";
                echo $erro;
            } else {

                $query_criar_categoria = "INSERT INTO categorias(cat_titulo)";
                $query_criar_categoria .= "VALUE('$cat_titulo')";

                $resultado_criar_categoria = mysqli_query($conexao, $query_criar_categoria);

                $sucesso = "<div class=\"alert alert-success\">";
                $sucesso .= "<strong>SUCESSO:</strong> A Categoria '$cat_titulo' foi criada com sucesso.";
                $sucesso .= "</div>";
                echo $sucesso;
            }
        }
    }
}

function editarCategoria() {
    global $conexao;
    if(isset($_POST['atualizar_categoria'])) {
        $editar_id = mysqli_real_escape_string($conexao, $_GET['editar']);
        $cat_titulo = mysqli_real_escape_string($conexao, $_POST['cat_titulo']);

        if($cat_titulo == "" || empty($cat_titulo)) {
            $erro = "<div class=\"alert alert-danger\">";
            $erro.= "<strong>ERRO:</strong> Por favor, digite um nome para a Categoria";
            $erro.= "</div>";
            echo $erro;
        } else {
            $query_verifica_categoria = "SELECT * FROM categorias WHERE cat_titulo = '$cat_titulo'";
            $resultado_verifica_categoria = mysqli_query($conexao, $query_verifica_categoria);
            if(mysqli_num_rows($resultado_verifica_categoria) !== 0) {
                $erro = "<div class=\"alert alert-danger\">";
                $erro.= "<strong>ERRO:</strong> A Categoria '$cat_titulo' já existe. Por favor, escolha outro nome para a categoria.";
                $erro.= "</div>";
                echo $erro;
            } else {

                $query_editar_categoria = "UPDATE categorias SET cat_titulo='$cat_titulo' WHERE cat_id=$editar_id";
                $resultado_editar_categoria = mysqli_query($conexao, $query_editar_categoria);

                $sucesso = "<div class=\"alert alert-success\">";
                $sucesso .= "<strong>SUCESSO:</strong> A Categoria '$cat_titulo' foi atualizada com sucesso. <a href='categorias.php'>Criar outra Categoria</a>";
                $sucesso .= "</div>";
                echo $sucesso;
            }

        }
    }
}

function getCategoriaTitulo() {
    global $conexao;
    if(isset($_GET['editar'])){
        $editar_id = mysqli_real_escape_string($conexao, $_GET['editar']);
        $resultado = mysqli_query($conexao, "SELECT cat_titulo FROM categorias WHERE cat_id = $editar_id");
        echo mysqli_fetch_row($resultado)[0];
    }
}

function getCategoriaBotao() {
    if(isset($_GET['editar'])) {
        echo "<button class=\"btn btn-primary\" type=\"submit\" name=\"atualizar_categoria\">Atualizar Categoria</button>";
    } else {
        echo "<button class=\"btn btn-primary\" type=\"submit\" name=\"criar_categoria\">Criar Categoria</button>";
    }
}

function excluirCategoria() {
    global $conexao;
    if(isset($_GET['excluir'])) {
        $cat_id_excluir = mysqli_real_escape_string($conexao, $_GET['excluir']);
        $quer_excluir_categoria = "DELETE FROM categorias WHERE cat_id = $cat_id_excluir";
        $resultado_excluir_categoria = mysqli_query($conexao, $quer_excluir_categoria);
        if (!$resultado_excluir_categoria) {
            die("ERRO NA QUERY: " . mysqli_error($conexao));
        }
        header("Location: categorias.php");
    }
}

/*
  _____   ____   _____ _______ _____
 |  __ \ / __ \ / ____|__   __/ ____|
 | |__) | |  | | (___    | | | (___
 |  ___/| |  | |\___ \   | |  \___ \
 | |    | |__| |____) |  | |  ____) |
 |_|     \____/|_____/   |_| |_____/

 */

function getImagemPost($imagem) {
    if(empty($imagem)) {
        echo "<strong class='text-warning'>Esse post não possui nenhuma imagem</strong>";
    } else {
        echo "<a target='_blank' href=\"../uploads/$imagem\"><img src=\"../uploads/$imagem\" height=\"100\" alt=\"\"></a>";
    }
}

function listarPosts() {
    include "listar_posts.php";
}

function criarPost() {
    include "criar_post.php";
}

function editarPost() {
    include "editar_post.php";

}

function excluirPost() {
    global $conexao;
    $id = mysqli_real_escape_string($conexao, $_GET['excluir']);
    $query_excluir_post = "DELETE FROM posts WHERE post_id = $id";
    $resultado_excluir_post = mysqli_query($conexao, $query_excluir_post);
    verificaErroNaQuery($resultado_excluir_post);
    header("Location: posts.php");

}

function postsCRUD() {

    if(isset($_GET['criar'])) {
        criarPost();
    }

    elseif(isset($_GET['editar']) && !empty($_GET['editar'])) {
        editarPost();
    }

    elseif(isset($_GET['excluir']) && !empty($_GET['excluir'])) {
        excluirPost();
    }

    else {
        listarPosts();
    }
}

/*
   _____ ____  __  __ ______ _   _ _______       _____  _____ ____   _____
  / ____/ __ \|  \/  |  ____| \ | |__   __|/\   |  __ \|_   _/ __ \ / ____|
 | |   | |  | | \  / | |__  |  \| |  | |  /  \  | |__) | | || |  | | (___
 | |   | |  | | |\/| |  __| | . ` |  | | / /\ \ |  _  /  | || |  | |\___ \
 | |___| |__| | |  | | |____| |\  |  | |/ ____ \| | \ \ _| || |__| |____) |
  \_____\____/|_|  |_|______|_| \_|  |_/_/    \_\_|  \_\_____\____/|_____/

 */

function listarComentarios() {
    include "listar_comentarios.php";
}

function aprovarComentario() {
    global $conexao;
    $id = mysqli_real_escape_string($conexao, $_GET['aprovar']);
    $query_rejeitar_comentario = "UPDATE comentarios SET comentario_estado = 'Aprovado' WHERE comentario_id = $id";
    $resultado_rejeitar_comentario = mysqli_query($conexao, $query_rejeitar_comentario);
    verificaErroNaQuery($resultado_rejeitar_comentario);
    listarComentarios();
}

function rejeitarComentario() {
    global $conexao;
    $id = mysqli_real_escape_string($conexao, $_GET['rejeitar']);
    $query_rejeitar_comentario = "UPDATE comentarios SET comentario_estado = 'Rejeitado' WHERE comentario_id = $id";
    $resultado_rejeitar_comentario = mysqli_query($conexao, $query_rejeitar_comentario);
    verificaErroNaQuery($resultado_rejeitar_comentario);
    listarComentarios();
}

function excluirComentario() {
    global $conexao;
    $id = mysqli_real_escape_string($conexao, $_GET['excluir']);
    $resultado_post_id = mysqli_query($conexao, "SELECT comentario_post_id FROM comentarios WHERE comentario_id = $id");
    $query_excluir_comentario = "DELETE FROM comentarios WHERE comentario_id = $id";
    mysqli_query($conexao, $query_excluir_comentario);
    $id_post = mysqli_fetch_row($resultado_post_id)[0];
    $query_diminuir_cont = "UPDATE posts SET post_comentarios_cont = post_comentarios_cont - 1 ";
    $query_diminuir_cont.= "WHERE post_id = $id_post";
    $resultado_diminuir_cont = mysqli_query($conexao, $query_diminuir_cont);
    verificaErroNaQuery($resultado_diminuir_cont);
    listarComentarios();
}

function comentariosCRUD() {

    if(isset($_GET['aprovar']) && !empty($_GET['aprovar'])) {
        aprovarComentario();
    }

    elseif(isset($_GET['rejeitar']) && !empty($_GET['rejeitar'])) {
        rejeitarComentario();
    }

    elseif(isset($_GET['excluir']) && !empty($_GET['excluir'])) {
        excluirComentario();
    }

    else {
        listarComentarios();
    }
}

/*
  _    _  _____ _    _         _____  _____ ____   _____
 | |  | |/ ____| |  | |  /\   |  __ \|_   _/ __ \ / ____|
 | |  | | (___ | |  | | /  \  | |__) | | || |  | | (___
 | |  | |\___ \| |  | |/ /\ \ |  _  /  | || |  | |\___ \
 | |__| |____) | |__| / ____ \| | \ \ _| || |__| |____) |
  \____/|_____/ \____/_/    \_\_|  \_\_____\____/|_____/

 */

function listarUsuarios() {
    include "listar_usuarios.php";
}

function criarUsuario() {
    include "criar_usuario.php";
}

function editarUsuario() {
    include "editar_usuario.php";

}

function excluirUsuario() {
    global $conexao;
    $id = mysqli_real_escape_string($conexao, $_GET['excluir']);
    $query_excluir_usuario = "DELETE FROM usuarios WHERE usuario_id = $id";
    $resultado_excluir_usuario = mysqli_query($conexao, $query_excluir_usuario);
    verificaErroNaQuery($resultado_excluir_usuario);
    header("Location: usuarios.php");

}

function alterarFuncao($id, $funcao) {
    global $conexao;
    $query_alterar_funcao = "UPDATE usuarios SET usuario_funcao = '$funcao' WHERE usuario_id = $id";
    $resultado_alterar_fucnao = mysqli_query($conexao, $query_alterar_funcao);
    verificaErroNaQuery($resultado_alterar_fucnao);
    header("Location: usuarios.php");
}

function usuariosCRUD() {
    global $conexao;

    if(isset($_GET['criar'])) {
        criarUsuario();
    }

    elseif(isset($_GET['editar']) && !empty($_GET['editar'])) {
        editarUsuario();
    }

    elseif(isset($_GET['excluir']) && !empty($_GET['excluir'])) {
        excluirUsuario();
    }

    elseif(isset($_GET['admin']) && !empty($_GET['admin'])) {
        alterarFuncao(mysqli_real_escape_string($conexao, $_GET['admin']), "Administrador");
    }

    elseif(isset($_GET['inscrito']) && !empty($_GET['inscrito'])) {
        alterarFuncao(mysqli_real_escape_string($conexao, $_GET['inscrito']), "Inscrito");
    }

    else {
        listarUsuarios();
    }
}

/*
  _____  ______ _____  ______ _____ _
 |  __ \|  ____|  __ \|  ____|_   _| |
 | |__) | |__  | |__) | |__    | | | |
 |  ___/|  __| |  _  /|  __|   | | | |
 | |    | |____| | \ \| |     _| |_| |____
 |_|    |______|_|  \_\_|    |_____|______|

 */

function carregarPerfil() {
    include "perfil_formulario.php";
}