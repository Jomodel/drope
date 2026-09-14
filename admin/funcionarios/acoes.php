<?php

#CONEXAO COM O BANCO DE DADOS#
require_once __DIR__ . "/../../conexao/conecta.php";

#INICIANDO UMA SESSÃO#
if (!isset($_SESSION)) {
    session_start();
}
#================= CADASTRANDO UM NOVO FUNCIONARIO ==================#
if (isset($_POST ['cadastrar']) && $_POST['cadastrar'] == "cadastrar_funcionario")
{
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);

    $nome_social = mysqli_real_escape_string($conexao, $_POST['nome_social']);  

    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);

    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);

    $estado_civil = mysqli_real_escape_string($conexao, $_POST['estado_civil']);

    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);

    $rg = mysqli_real_escape_string($conexao, $_POST['rg']);

    $salario = str_replace(',','.', $_POST['salario']);

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

   // $status = mysqli_real_escape_string($conexao, $_POST['status']);

    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);

    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);  

    $tipo_acesso = mysqli_real_escape_string($conexao, $_POST['tipo_acesso']);
    
    $cargo = mysqli_real_escape_string($conexao, $_POST['cargo']);

   // $foto = mysqli_real_escape_string($conexao, $_POST['foto']);


   # ENVIANDO A FOTO PARA O SERVIDOR #
   $foto = basename($_FILES['foto']['name']);
   #  SALVANDO UM CAMINHO TEMPORARIO NA PASTA 'TMP' #
   $tmp = $_FILES['foto']['tmp_name'];
   #  CRIANDO O CAMINHO PARA PASTA FINAL #
   $final = __DIR__ . "/../../images/funcionario/" . $foto;
    move_uploaded_file($tmp, $final);
   #  MOVENDO A IMAGEM DA PASTA TMP PARA A PASTA IMAGES #
   


   //INSERT
    $sql = "INSERT INTO funcionario VALUES (0, '$nome','$nome_social','$data_nascimento','$sexo','$estado_civil','$cpf','$rg','$salario',
    '$endereco','$numero','$complemento','$bairro','$cidade','$estado','$cep','$telefone_residencial','$telefone_celular','$email',
    1,now(),'$usuario','$senha', $tipo_acesso ,'$foto','$cargo')";

    try
    {
       if (mysqli_query($conexao, $sql)) 
       {
           // header('Location: index.php');       
          $_SESSION['mensagem'] = "Funcionario cadastrado com sucesso!";
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

#================= ATUALIZAR FUNCIONARIO ==================#

if (isset($_POST ['editar']) && $_POST['editar'] == "editar_funcionario")
{
    $codigo = mysqli_real_escape_string($conexao, $_POST['codigo_funcionario']);
    
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);

    $nome_social = mysqli_real_escape_string($conexao, $_POST['nome_social']);  

    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);

    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);

    $estado_civil = mysqli_real_escape_string($conexao, $_POST['estado_civil']);

    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);

    $rg = mysqli_real_escape_string($conexao, $_POST['rg']);

    $salario = str_replace(',','.', $_POST['salario']);

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

    $tipo_acesso = mysqli_real_escape_string($conexao, $_POST['tipo_acesso']);
    
    $cargo = mysqli_real_escape_string($conexao, $_POST['cargo']);

   // $foto = mysqli_real_escape_string($conexao, $_POST['foto']);


   # ENVIANDO A FOTO PARA O SERVIDOR #
   $foto = basename($_FILES['foto']['name']);
   #  SALVANDO UM CAMINHO TEMPORARIO NA PASTA 'TMP' #
   $tmp = $_FILES['foto']['tmp_name'];
   #  CRIANDO O CAMINHO PARA PASTA FINAL #
   $final = __DIR__ . "/../../images/funcionario/" . $foto;
    move_uploaded_file($tmp, $final);
   #  MOVENDO A IMAGEM DA PASTA TMP PARA A PASTA IMAGES #
   


   //UPDATE
    $sql = "UPDATE funcionario SET  nome ='$nome', nome_social ='$nome_social', data_nascimento ='$data_nascimento', sexo ='$sexo', estado_civil ='$estado_civil', cpf ='$cpf', rg ='$rg', salario ='$salario',
    endereco ='$endereco',numero ='$numero',complemento ='$complemento',bairro ='$bairro',cidade ='$cidade', estado ='$estado',cep ='$cep', telefone_residencial ='$telefone_residencial', telefone_celular ='$telefone_celular', email ='$email',
    status =$status, usuario ='$usuario', senha ='$senha', tipo_acesso =$tipo_acesso , codigo_cargo ='$cargo' ";

    //VERIFICAR O CAMPO DE FOTO ESTA VAZIO OU NAO PARA SUBSTITUIR FOTO EXISTENTE
    if(!empty($foto))
        {
            $sql .= ", foto = '$foto'";
        }

        //COMPLETANDO O UPDATE COM CLASULA WHERE
        $sql .= " WHERE codigo_funcionario = $codigo";

    try
    {
       if (mysqli_query($conexao, $sql)) 
       {
           // header('Location: index.php');       
          $_SESSION['mensagem'] = "Funcionario atualizado com sucesso!";
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

#================= EXCLUINDO FUNCIONARIO =================#
if(isset($_POST['deletar_funcionario']))
    {
        $codigo = $_POST['deletar_funcionario'];

        $sql = "DELETE FROM funcionario WHERE codigo_funcionario = $codigo";

        if(mysqli_query($conexao, $sql))
            {
                $_SESSION['mensagem'] = "Funcionario excluido com sucesso!";
                header('Location: index.php');
            }
        else{
                $_SESSION['mensagem'] = "Erro ao excluir!";
                header('Location: index.php');
            }
    }