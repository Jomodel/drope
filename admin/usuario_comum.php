<?php 

# CONEXAO COM O BANCO DE DADOS#
 require_once __DIR__ . '/../conexao/conecta.php';

 # INICIANDO UMA SESSAO #
 if(!isset($_SESSION))
    {
        session_start();
    }

    #  VERIFICANDO SE EXISTE USUARIO LOGADO PARA PERMITIR ACESSO #
    if(!$_SESSION['USER'])
    {
      $_SESSION['NaoAutorizado'] = "Apenas usuários cadastros podem acessar esta área!";
      header("Location: ../Index.php");
    }  
 ?> 