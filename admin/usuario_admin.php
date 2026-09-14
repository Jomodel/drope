<?php 

 # CONEXAO COM O BANCO DE DADOS#
 require_once __DIR__ . '/../conexao/conecta.php';

 # INICIANDO UMA SESSAO #
 if(!isset($_SESSION))
    {
        session_start();
    }

 # VERICANDO SE O USUARIO LOGADO È ADMINSTRADOR #
 if($_SESSION['TYPE'] != '1')
  {
    $_SESSION['NaoAdm'] = "Apenas usuários administradores podem acessar essa área.";
    header("Location: ../Admin.php");
  }   

?>