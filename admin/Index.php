<?php 
# INICIANDO UMA SESSAO #
 if(!isset($_SESSION))
    {
        session_start();
    }
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>PAINEL ADMINISTRATIVO — LOGIN</title>

  <!-- BOOTSTRAP CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- BOOTSTRAP ICONS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <!-- CUSTOMIZAÇÃO DO TEMPLATE -->
  <link rel="stylesheet" href="../assets/css/signin.min.css">
  <link rel="stylesheet" href="../assets/css/styles.min.css">
  <link rel="stylesheet" href="../custom/admin.css?v=2">

  <!-- FAVICON -->
  <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">


</head>
<body class="admin-login d-flex align-items-center justify-content-center p-3">

  <main class="admin-login__card card p-4 p-md-5 text-center">
    <form action="login.php" method="POST">
      <h2 class="h3 mb-3">Faça seu Login</h2>

      <input type="text" class="form-control mb-2" name="usuario" placeholder="Usuário" required>

      <div class="input-group"><input id="senha" type="password" class="form-control" name="senha" placeholder="Senha" required><button class="btn btn-outline-secondary" type="button" id="mostrarSenha" aria-label="Mostrar senha"><i class="bi bi-eye"></i></button></div>

      <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>

    </form>

    <div class="pt-2">
      <?php 
        //LOGIN VAZIO
        if(isset($_SESSION['LoginVazio']))
          {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
       
            echo $_SESSION['LoginVazio'];

            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

        unset($_SESSION['LoginVazio']);
          }     

          //LOGIN COM ERRO
          if(isset($_SESSION['LoginErro']))
          {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
       
            echo $_SESSION['LoginErro'];

            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

            unset($_SESSION['LoginErro']);
          }  
          
          //APENAS PESSOA AUTORIZADO
          if(isset($_SESSION['NaoAutorizado']))
          {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
       
            echo $_SESSION['NaoAutorizado'];

            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

            unset($_SESSION['NaoAutorizado']);
          }   

          //LOGOFF REALIZADO COM SUCESSO
          if(isset($_SESSION['logOFF']))
          {
            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
       
            echo $_SESSION['logOFF'];

            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

            unset($_SESSION['logOFF']);
          }   
      ?>
    </div>

    <p class="mt-5 text-muted">&copy; <?= date('Y') ?></p>
  </main>
  
  <!-- JQUERY CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script>
    var botaoMostrarSenha = document.getElementById('mostrarSenha');
    if (botaoMostrarSenha) {
      botaoMostrarSenha.addEventListener('click', function () {
        var campoSenha = document.getElementById('senha');
        if (campoSenha.type == 'password') {
          campoSenha.type = 'text';
        } else {
          campoSenha.type = 'password';
        }
      });
    }
  </script>
</body>
</html>
