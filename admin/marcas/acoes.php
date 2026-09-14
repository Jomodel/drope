<?php


#CONEXAO COM O BANCO DE DADOS#
require_once __DIR__ . "/../../conexao/conecta.php";

#INICIANDO UMA SESSÃO#
if (!isset($_SESSION))
    {
        session_start();
    }

#================= CADASTRANDO UM NOVO CARGO ==================#
if (isset($_POST ['cadastrar']) && $_POST['cadastrar'] == "cadastrar_marca")
{
    $marca = mysqli_real_escape_string($conexao, $_POST['marca']);
    $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);

    $sql = "INSERT INTO marca VALUES (0, '$marca','$observacao', 1, NOW())";

    try
    {
       if (mysqli_query($conexao, $sql)) 
       {
           // header('Location: index.php');       
          $_SESSION['mensagem'] = "Marca cadastrado com sucesso!";
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


#================= ATUALIZAR MARCA ==================#
if (isset($_POST ['editar']) && $_POST['editar'] == "editar_marca")
{
    $codigo = mysqli_real_escape_string($conexao, $_POST['codigo_marca']);

    $marca = mysqli_real_escape_string($conexao, $_POST['marca']);
    $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);
    $status = mysqli_real_escape_string($conexao, $_POST['status']);

    $sql = "UPDATE marca SET nome ='$marca', observacao ='$observacao', status =$status WHERE codigo_marca = $codigo";

    try
    {
       if (mysqli_query($conexao, $sql)) 
       {
           // header('Location: index.php');       
          $_SESSION['mensagem'] = "Marca atualizado com sucesso!";
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

#================= EXCLUINDO MARCA =================#
if(isset($_POST['deletar_marca']))
    {
        $codigo = $_POST['deletar_marca'];

        $cod_marca = "SELECT codigo_marca FROM produto WHERE codigo_marca = $codigo";
        $chave = mysqli_query($conexao,$cod_marca);
        if(mysqli_num_rows($chave) > 0)
            {
                $_SESSION['mensagem'] = "Marca não pode ser excluido!";
                header('Location: index.php');
            }
            else
                {
                    $sql = "DELETE FROM marca WHERE codigo_marca = $codigo";
                }      
        if(mysqli_query($conexao, $sql))
            {
                $_SESSION['mensagem'] = "Marca excluido com sucesso!";
                header('Location: index.php');
            }
        else{
                $_SESSION['mensagem'] = "Erro ao excluir!";
                header('Location: index.php');
            }
    }