<?php


#CONEXAO COM O BANCO DE DADOS#
require_once __DIR__ . "/../../conexao/conecta.php";

#INICIANDO UMA SESSÃO#
if (!isset($_SESSION))
    {
        session_start();
    }

#================= CADASTRANDO UM NOVO CLIENTE ==================#
if (isset($_POST ['cadastrar']) && $_POST['cadastrar'] == "cadastrar_cliente")
{
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);

    $nome_social = mysqli_real_escape_string($conexao, $_POST['nome_social']);  

    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);

    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);

    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);

    $endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);

    $numero = mysqli_real_escape_string($conexao, $_POST['numero']);

    $complemento = mysqli_real_escape_string($conexao, $_POST['complemento']);

    $bairro = mysqli_real_escape_string($conexao, $_POST['bairro']);

    $cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);

    $estado = mysqli_real_escape_string($conexao, $_POST['estado']);

    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);

    $telefone_residencial = mysqli_real_escape_string($conexao, $_POST['telefone_residencial']);

    $telefone_celular = mysqli_real_escape_string($conexao, $_POST['telefone_celular']);

    $email = mysqli_real_escape_string($conexao, $_POST['email']);

    //$status = mysqli_real_escape_string($conexao, $_POST['status']);

    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);

    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);  


   //INSERT
    $sql = "INSERT INTO cliente VALUES (0, '$nome','$nome_social','$data_nascimento','$sexo','$cpf',
    '$endereco','$numero','$complemento','$bairro','$cidade','$estado','$cep','$telefone_residencial','$telefone_celular','$email',
    1,now(),'$usuario','$senha')";

     try
    {
       if (mysqli_query($conexao, $sql)) 
       {
          // header('Location: index.php');       
          $_SESSION['mensagem'] = "Cliente cadastrado com sucesso!";
        } 
       else 
       {
          //die("Erro: " . $sql . "<br>" . mysqli_error($conexao));
          $_SESSION['mensagem'] = "Erro ao cadastrado !";
        } 
    }
    catch(mysqli_sql_exception)
    {
        $_SESSION['mensagem'] = "Erro ao cadastrado !";
    }
    
       header('Location: inserir.php');
}


#================= ATUALIZAR CLIENTE ==================#
if (isset($_POST ['editar']) && $_POST['editar'] == "editar_cliente")
{
    $codigo = mysqli_real_escape_string($conexao, $_POST['codigo_cliente']);

    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);

    $nome_social = mysqli_real_escape_string($conexao, $_POST['nome_social']);  

    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);

    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);

    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);

    $endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);

    $numero = mysqli_real_escape_string($conexao, $_POST['numero']);

    $complemento = mysqli_real_escape_string($conexao, $_POST['complemento']);

    $bairro = mysqli_real_escape_string($conexao, $_POST['bairro']);

    $cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);

    $estado = mysqli_real_escape_string($conexao, $_POST['estado']);

    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);

    $telefone_residencial = mysqli_real_escape_string($conexao, $_POST['telefone_residencial']);

    $telefone_celular = mysqli_real_escape_string($conexao, $_POST['telefone_celular']);

    $email = mysqli_real_escape_string($conexao, $_POST['email']);

    $status = mysqli_real_escape_string($conexao, $_POST['status']);

    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);

    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);  


   //INSERT
    $sql = "UPDATE cliente SET nome ='$nome', nome_social ='$nome_social', data_nascimento ='$data_nascimento', sexo ='$sexo', cpf ='$cpf',
     endereco ='$endereco', numero ='$numero', complemento ='$complemento', bairro ='$bairro', cidade ='$cidade', estado ='$estado', cep ='$cep', telefone_residencial ='$telefone_residencial', telefone_celular ='$telefone_celular', email ='$email',
    status = $status, usuario ='$usuario', senha ='$senha'  WHERE codigo_cliente = $codigo ";

     try
    {
       if (mysqli_query($conexao, $sql)) 
       {
          // header('Location: index.php');       
          $_SESSION['mensagem'] = "Cliente atualizado com sucesso!";
        } 
       else 
       {
          //die("Erro: " . $sql . "<br>" . mysqli_error($conexao));
          $_SESSION['mensagem'] = "Erro ao atualizar !";
        } 
    }
    catch(mysqli_sql_exception)
    {
        $_SESSION['mensagem'] = "Erro ao atualizar !";
    }
    
       header('Location: index.php');
}

#================= EXCLUINDO FUNCIONÁRIO =================#
if(isset($_POST['deletar_cliente']))
    {
        $codigo = $_POST['deletar_cliente'];

        $sql = "DELETE FROM cliente WHERE codigo_cliente = $codigo";

        if(mysqli_query($conexao, $sql))
            {
                $_SESSION['mensagem'] = "Cliente excluido com sucesso!";
                header('Location: index.php');
            }
        else{
                $_SESSION['mensagem'] = "Erro ao excluir!";
                header('Location: index.php');
            }
    }