<?php


#CONEXAO COM O BANCO DE DADOS#
require_once __DIR__ . "/../../conexao/conecta.php";

#INICIANDO UMA SESSÃO#
if (!isset($_SESSION))
    {
        session_start();
    }

#================= CADASTRANDO UM NOVO CARGO ==================#
if (isset($_POST ['cadastrar']) && $_POST['cadastrar'] == "cadastrar_categoria")
{
    $categoria = mysqli_real_escape_string($conexao, $_POST['categoria']);
    $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);

    $sql = "INSERT INTO categoria VALUES (0, '$categoria','$observacao', 1, NOW())";

    try
    {
       if (mysqli_query($conexao, $sql)) 
       {
           // header('Location: index.php');       
          $_SESSION['mensagem'] = "Categoria cadastrado com sucesso!";
        } 
       else 
       {
          // die("Erro: " . $sql . "<br>" . mysqli_error($conexao));
          $_SESSION['mensagem'] = "Erro ao cadastrado !";
        } 
    }
    catch(mysqli_sql_exception)
    {
        $_SESSION['mensagem'] = "Erro ao cadastrado !";
    }
    
    header('Location: inserir.php');
}



#================= ATUALIZAR CATEGORIA ==================#
if (isset($_POST ['editar']) && $_POST['editar'] == "editar_categoria")
{
    $codigo = mysqli_real_escape_string($conexao, $_POST['codigo_categoria']);
 
    $categoria = mysqli_real_escape_string($conexao, $_POST['categoria']);
    $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);
    $status = mysqli_real_escape_string($conexao, $_POST['status']);

    $sql = "UPDATE categoria SET  nome ='$categoria', observacao ='$observacao', status = $status WHERE codigo_categoria = $codigo";

    try
    {
       if (mysqli_query($conexao, $sql)) 
       {
           // header('Location: index.php');       
          $_SESSION['mensagem'] = "Categoria atualizada com sucesso!";
        } 
       else 
       {
          // die("Erro: " . $sql . "<br>" . mysqli_error($conexao));
          $_SESSION['mensagem'] = "Erro ao atualizar !";
        } 
    }
    catch(mysqli_sql_exception)
    {
        $_SESSION['mensagem'] = "Erro ao atualizar !";
    }
    
    header('Location: index.php');
}

#================= EXCLUINDO CARGO =================#
if(isset($_POST['deletar_categoria']))
    {
        $codigo = $_POST['deletar_categoria'];

        $cod_categoria = "SELECT codigo_categoria FROM produto WHERE codigo_categoria = $codigo";
        $chave = mysqli_query($conexao,$cod_categoria);
        if(mysqli_num_rows($chave) > 0)
            {
                $_SESSION['mensagem'] = "Categoria não pode ser excluido !";
                header('Location: index.php');
            }
            else
                {
                    $sql = "DELETE FROM categoria WHERE codigo_categoria = $codigo";
                }      
        if(mysqli_query($conexao, $sql))
            {
                $_SESSION['mensagem'] = "Categoria excluido com sucesso!";
                header('Location: index.php');
            }
        else{
                $_SESSION['mensagem'] = "Erro ao excluir!";
                header('Location: index.php');
            }
    }