<?php
session_start();

$codigo = $_GET['codigo_produto'];

if(isset($_SESSION['carrinho'][$codigo])){
    $_SESSION['carrinho'][$codigo]++;
}else{
    $_SESSION['carrinho'][$codigo] = 1;
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;