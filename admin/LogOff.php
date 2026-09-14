<?php 


 # INICIANDO UMA SESSAO #
 if(!isset($_SESSION))
    {
        session_start();
    }


    unset($_SESSION['USER'], $_SESSION['TYPE']);
    $_SESSION['logOFF'] = "LogOFF realizado com sucesso";
    header('Location: index.php');
                    

?>