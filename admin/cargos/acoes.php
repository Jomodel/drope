<?php


#CONEXAO COM O BANCO DE DADOS#
require_once __DIR__ . "/../../conexao/conecta.php";

#INICIANDO UMA SESSÃO#
if (!isset($_SESSION))
    {
        session_start();
    }

#================= CADASTRANDO UM NOVO CARGO ==================#
if (isset($_POST ['cadastrar']) && $_POST['cadastrar'] == "cadastrar_cargo")
{
    $cargo = mysqli_real_escape_string($conexao, $_POST['cargo']);
    $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);

    $sql = "INSERT INTO cargo VALUES (0, '$cargo','$observacao', 1, NOW())";

    try
    {
       if (mysqli_query($conexao, $sql)) 
       {
           // header('Location: index.php');       
          $_SESSION['mensagem'] = "Cargo cadastrado com sucesso!";
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



#================= UPDATE CARGO ==================#
if (isset($_POST ['editar']) && $_POST['editar'] == "editar_cargo")
{
    $codigo = mysqli_real_escape_string($conexao, $_POST['codigo_cargo']);

    $cargo = mysqli_real_escape_string($conexao, $_POST['cargo']);
    $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);
    $status = mysqli_real_escape_string($conexao, $_POST['status']);

    $sql = "UPDATE cargo SET nome ='$cargo', observacao ='$observacao', status = $status WHERE codigo_cargo = $codigo";

    try
    {
       if (mysqli_query($conexao, $sql)) 
       {
           // header('Location: index.php');       
          $_SESSION['mensagem'] = "Cargo atualizado sucesso!";
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
if(isset($_POST['deletar_cargo']))
    {
        $codigo = $_POST['deletar_cargo'];

        $cod_cargo = "SELECT codigo_cargo FROM funcionario WHERE codigo_cargo = $codigo";
        $chave = mysqli_query($conexao,$cod_cargo);
        if(mysqli_num_rows($chave) > 0)
            {
                $_SESSION['mensagem'] = "Cargo não pode ser excluido !";
                header('Location: index.php');
            }
            else
                {
                    $sql = "DELETE FROM cargo WHERE codigo_cargo = $codigo";
                }      
        if(mysqli_query($conexao, $sql))
            {
                $_SESSION['mensagem'] = "Cargo excluido com sucesso!";
                header('Location: index.php');
            }
        else{
                $_SESSION['mensagem'] = "Erro ao excluir!";
                header('Location: index.php');
            }
    }
