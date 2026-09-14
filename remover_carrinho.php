<?php
session_start();

if(isset($_GET['codigo_produto'])){

    $codigo = (int)$_GET['codigo_produto'];

    if(isset($_SESSION['carrinho'][$codigo])){

        $_SESSION['carrinho'][$codigo]--;

        if($_SESSION['carrinho'][$codigo] <= 0){
            unset($_SESSION['carrinho'][$codigo]);
        }
    }
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;