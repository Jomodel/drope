<?php 

   if (isset($_SESSION['mensagem']))
    {
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
       
        echo $_SESSION['mensagem'];

        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';

        unset($_SESSION['mensagem']);
    }

?>