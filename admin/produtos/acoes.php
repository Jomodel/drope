<?php
#CONEXAO COM O BANCO DE DADOS#
require_once __DIR__ . "/../../conexao/conecta.php";

#INICIANDO UMA SESSÃO#
if (!isset($_SESSION)) {
    session_start();
}

#================= CADASTRANDO UM NOVO PRODUTO ==================#
if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == "cadastrar_produto") {
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);

    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);

    $qtde_produto = mysqli_real_escape_string($conexao, $_POST['qtde_produto']);

    $preco_custo = str_replace(',', '.', $_POST['preco_custo']);

    $lucro = str_replace(',', '.', $_POST['lucro']);

    $preco_venda = str_replace(',', '.', $_POST['preco_venda']);

    $status_promocao = mysqli_real_escape_string($conexao, $_POST['status_desconto']);

    $desconto = str_replace(',', '.', $_POST['desconto']);

    $preco_desconto = str_replace(',', '.', $_POST['preco_desconto']);

    # ENVIANDO A FOTO PARA O SERVIDOR #
    $foto = basename($_FILES['foto']['name']);
    #  SALVANDO UM CAMINHO TEMPORARIO NA PASTA 'TMP' #
    $tmp = $_FILES['foto']['tmp_name'];
    #  CRIANDO O CAMINHO PARA PASTA FINAL #
    $final = __DIR__ . "/../../images/produto/" . $foto;
    #  MOVENDO A IMAGEM DA PASTA TMP PARA A PASTA IMAGES #
    move_uploaded_file($tmp, $final);

    # ENVIANDO A FOTO PARA O SERVIDOR #
    $galeria1 = basename($_FILES['galeria_foto1']['name']);
    #  SALVANDO UM CAMINHO TEMPORARIO NA PASTA 'TMP' #
    $tmp1 = $_FILES['galeria_foto1']['tmp_name'];
    #  CRIANDO O CAMINHO PARA PASTA FINAL #
    $final1 = __DIR__ . "/../../images/produto/" . $galeria1;
    #  MOVENDO A IMAGEM DA PASTA TMP PARA A PASTA IMAGES #
    move_uploaded_file($tmp1, $final1);

    # ENVIANDO A FOTO PARA O SERVIDOR #
    $galeria2 = basename($_FILES['galeria_foto2']['name']);
    #  SALVANDO UM CAMINHO TEMPORARIO NA PASTA 'TMP' #
    $tmp2 = $_FILES['galeria_foto2']['tmp_name'];
    #  CRIANDO O CAMINHO PARA PASTA FINAL #
    $final2 = __DIR__ . "/../../images/produto/" . $galeria2;
    #  MOVENDO A IMAGEM DA PASTA TMP PARA A PASTA IMAGES #
    move_uploaded_file($tmp2, $final2);

    # ENVIANDO A FOTO PARA O SERVIDOR #
    $galeria3 = basename($_FILES['galeria_foto3']['name']);
    #  SALVANDO UM CAMINHO TEMPORARIO NA PASTA 'TMP' #
    $tmp3 = $_FILES['galeria_foto3']['tmp_name'];
    #  CRIANDO O CAMINHO PARA PASTA FINAL #
    $final3 = __DIR__ . "/../../images/produto/" . $galeria3;
    #  MOVENDO A IMAGEM DA PASTA TMP PARA A PASTA IMAGES #
    move_uploaded_file($tmp3, $final3);

    # ENVIANDO A FOTO PARA O SERVIDOR #
    $galeria4 = basename($_FILES['galeria_foto4']['name']);
    #  SALVANDO UM CAMINHO TEMPORARIO NA PASTA 'TMP' #
    $tmp4 = $_FILES['galeria_foto4']['tmp_name'];
    #  CRIANDO O CAMINHO PARA PASTA FINAL #
    $final4 = __DIR__ . "/../../images/produto/" . $galeria4;
    #  MOVENDO A IMAGEM DA PASTA TMP PARA A PASTA IMAGES #
    move_uploaded_file($tmp4, $final4);

    $cor = mysqli_real_escape_string($conexao, $_POST['cor']);

    $tamanho = mysqli_real_escape_string($conexao, $_POST['tamanho']);

    $genero = mysqli_real_escape_string($conexao, $_POST['genero']);

    $categoria = mysqli_real_escape_string($conexao, $_POST['categoria']);

    $marca = mysqli_real_escape_string($conexao, $_POST['marca']);



    // $foto = mysqli_real_escape_string($conexao, $_POST['foto']);



    //INSERT
    $sql = "INSERT INTO produto VALUES (0, '$nome', '$descricao','$qtde_produto','$preco_custo','$lucro','$preco_venda',NOW(),1,$status_promocao,'$desconto','$preco_desconto',
    '$foto', '$galeria1', '$galeria2', '$galeria3', '$galeria4','$cor','$tamanho','$genero',$categoria,$marca)";

    try
     {
        if (mysqli_query($conexao, $sql)) 
            {
            // header('Location: index.php');       
            $_SESSION['mensagem'] = "Produto cadastrado com sucesso!";
        } 
        else
         {
            //die("Erro: " . $sql . "<br>" . mysqli_error($conexao));
            $_SESSION['mensagem'] = "Erro ao cadastrado !";
        }
    } 
    catch (mysqli_sql_exception) 
    {
        $_SESSION['mensagem'] = "Erro ao cadastrado !";
    }

    header('Location: inserir.php');
}


#================= ATUALIZAR PRODUTO ==================#
if (isset($_POST['editar']) && $_POST['editar'] == "editar_produto") {

    $codigo = mysqli_real_escape_string($conexao, $_POST['codigo_produto']);

    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);

    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);

    $qtde_produto = mysqli_real_escape_string($conexao, $_POST['qtde_produto']);

    $preco_custo = str_replace(',', '.', $_POST['preco_custo']);

    $lucro = str_replace(',', '.', $_POST['lucro']);

    $preco_venda = str_replace(',', '.', $_POST['preco_venda']);

    $status_promocao = mysqli_real_escape_string($conexao, $_POST['status_desconto']);

    $desconto = str_replace(',', '.', $_POST['desconto']);

    $preco_desconto = str_replace(',', '.', $_POST['preco_desconto']);

    # ENVIANDO A FOTO PARA O SERVIDOR #
    $foto = basename($_FILES['foto']['name']);
    #  SALVANDO UM CAMINHO TEMPORARIO NA PASTA 'TMP' #
    $tmp = $_FILES['foto']['tmp_name'];
    #  CRIANDO O CAMINHO PARA PASTA FINAL #
    $final = __DIR__ . "/../../images/produto/" . $foto;
    #  MOVENDO A IMAGEM DA PASTA TMP PARA A PASTA IMAGES #
    move_uploaded_file($tmp, $final);

    # ENVIANDO A FOTO PARA O SERVIDOR #
    $galeria1 = basename($_FILES['galeria_foto1']['name']);
    #  SALVANDO UM CAMINHO TEMPORARIO NA PASTA 'TMP' #
    $tmp1 = $_FILES['galeria_foto1']['tmp_name'];
    #  CRIANDO O CAMINHO PARA PASTA FINAL #
    $final1 = __DIR__ . "/../../images/produto/" . $galeria1;
    #  MOVENDO A IMAGEM DA PASTA TMP PARA A PASTA IMAGES #
    move_uploaded_file($tmp1, $final1);

    # ENVIANDO A FOTO PARA O SERVIDOR #
    $galeria2 = basename($_FILES['galeria_foto2']['name']);
    #  SALVANDO UM CAMINHO TEMPORARIO NA PASTA 'TMP' #
    $tmp2 = $_FILES['galeria_foto2']['tmp_name'];
    #  CRIANDO O CAMINHO PARA PASTA FINAL #
    $final2 = __DIR__ . "/../../images/produto/" . $galeria2;
    #  MOVENDO A IMAGEM DA PASTA TMP PARA A PASTA IMAGES #
    move_uploaded_file($tmp2, $final2);

    # ENVIANDO A FOTO PARA O SERVIDOR #
    $galeria3 = basename($_FILES['galeria_foto3']['name']);
    #  SALVANDO UM CAMINHO TEMPORARIO NA PASTA 'TMP' #
    $tmp3 = $_FILES['galeria_foto3']['tmp_name'];
    #  CRIANDO O CAMINHO PARA PASTA FINAL #
    $final3 = __DIR__ . "/../../images/produto/" . $galeria3;
    #  MOVENDO A IMAGEM DA PASTA TMP PARA A PASTA IMAGES #
    move_uploaded_file($tmp3, $final3);

    # ENVIANDO A FOTO PARA O SERVIDOR #
    $galeria4 = basename($_FILES['galeria_foto4']['name']);
    #  SALVANDO UM CAMINHO TEMPORARIO NA PASTA 'TMP' #
    $tmp4 = $_FILES['galeria_foto4']['tmp_name'];
    #  CRIANDO O CAMINHO PARA PASTA FINAL #
    $final4 = __DIR__ . "/../../images/produto/" . $galeria4;
    #  MOVENDO A IMAGEM DA PASTA TMP PARA A PASTA IMAGES #
    move_uploaded_file($tmp4, $final4);

    $cor = mysqli_real_escape_string($conexao, $_POST['cor']);

    $tamanho = mysqli_real_escape_string($conexao, $_POST['tamanho']);

    $genero = mysqli_real_escape_string($conexao, $_POST['genero']);

    $categoria = mysqli_real_escape_string($conexao, $_POST['categoria']);

    $marca = mysqli_real_escape_string($conexao, $_POST['marca']);

    $status = mysqli_real_escape_string($conexao, $_POST['status']);

    // $foto = mysqli_real_escape_string($conexao, $_POST['foto']);



    //INSERT
    $sql = "UPDATE produto SET  nome ='$nome', descricao ='$descricao', qtde_estoque ='$qtde_produto', preco_custo ='$preco_custo', lucro ='$lucro', preco_venda ='$preco_venda', status = $status, status_promocao =$status_promocao, desconto_promocao ='$desconto', preco_promocao ='$preco_desconto', cor ='$cor', tamanho ='$tamanho', genero ='$genero', codigo_categoria =$categoria, codigo_marca =$marca ";

        //VERIFICAR O CAMPO DE FOTO ESTA VAZIO OU NAO PARA SUBSTITUIR FOTO EXISTENTE
         if(!empty($foto))
         {
            $sql .= ", foto = '$foto'";
         }

         if(!empty($galeria1))
         {
            $sql .= ", galeria_foto1 ='$galeria1'";
         }

         if(!empty($galeria2))
         {
            $sql .= ", galeria_foto2 ='$galeria2'";
         }

         if(!empty($galeria3))
         {
            $sql .= ", galeria_foto3 ='$galeria3'";
         }

         if(!empty($galeria4))
         {
            $sql .= ", galeria_foto4 ='$galeria4'";
         }

        //COMPLETANDO O UPDATE COM CLASULA WHERE
        $sql .= " WHERE codigo_produto = $codigo";

    try
     {
        if (mysqli_query($conexao, $sql)) 
            {
            // header('Location: index.php');       
            $_SESSION['mensagem'] = "Produto atualizado com sucesso!";
        } 
        else
         {
            //die("Erro: " . $sql . "<br>" . mysqli_error($conexao));
            $_SESSION['mensagem'] = "Erro ao cadastrado !";
        }
    } 
    catch (mysqli_sql_exception) 
    {
        $_SESSION['mensagem'] = "Erro ao cadastrado !";
    }

    header('Location: index.php');
}

#================= EXCLUINDO PRODUTO =================#
if(isset($_POST['deletar_produto']))
    {
        $codigo = $_POST['deletar_produto'];

        $sql = "DELETE FROM produto WHERE codigo_produto = $codigo";

        if(mysqli_query($conexao, $sql))
            {
                $_SESSION['mensagem'] = "Produto excluido com sucesso!";
                header('Location: index.php');
            }
        else{
                $_SESSION['mensagem'] = "Erro ao excluir!";
                header('Location: index.php');
            }
    }
