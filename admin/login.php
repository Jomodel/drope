<?php 

# CONEXAO COM O BANCO DE DADOS#
 require_once __DIR__ . '/../conexao/conecta.php';

 # INICIANDO UMA SESSAO #
 if(!isset($_SESSION))
    {
        session_start();
    }

    # VERIFICANDO SE CHEGOU USUARIO E SENHA PARA COMPARAR COM AS INFORMACOES DO BANCO #
    if(isset($_POST['usuario']) && $_POST['usuario'] != '' && isset($_POST['senha']) && $_POST['senha'] != '')
        {
            $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
            $senha = mysqli_real_escape_string($conexao, $_POST['senha']);

            $sql = "SELECT * FROM funcionario WHERE status = 1 AND usuario = '$usuario' AND senha = '$senha'";

            $query = mysqli_query($conexao,$sql);
            $funcionario = mysqli_fetch_assoc($query);

            // echo $funcionario['usuario'];

            if (isset($funcionario))
                {
                    $_SESSION['ID'] = $funcionario['codigo_funcionario'];
                    $_SESSION['USER'] = $funcionario['usuario'];
                    $_SESSION['TYPE'] = $funcionario['tipo_acesso'];
                    $_SESSION['NAME'] = $funcionario['nome'];

                    header('Location: Admin.php');
                }
            else
                {
                    $_SESSION['LoginErro'] = "Usuário ou senha inválidos";
                     header('Location: index.php');
                }
        }

    else
     {
            $_SESSION['LoginVazio'] = "Informe usuário e senha";
            header('Location: index.php');
     }




?>