<?php 

#CONEXAO BANCO DE DADO#
require_once __DIR__ . "/../../conexao/conecta.php";

# VERIFICANDO SE EXISTE USUARIO LOGADO PARA PERMITIR ACESSO #
include_once '../usuario_comum.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>PAINEL ADMINISTRATIVO</title>

  <!-- BOOTSTRAP CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- BOOTSTRAP ICONS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <!-- CUSTOMIZAÇÃO DO TEMPLATE -->
  <link rel="stylesheet" href="../../assets/css/dashboard.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.min.css">
    <link rel="stylesheet" href="../../custom/admin.css?v=6">

  <!-- FAVICON -->
  <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">


</head>
<body class="admin-body">

  <?php
    #Início TOPO
    include('../Topo.php');
    #Final TOPO
  ?>

  <div class="container-fluid">
    <div class="row">
      <?php
        #Início MENU
        include('../Navegacao.php');
        #Final MENU
      ?>

      <main class="admin-main ms-auto col-lg-10 px-md-4">
        <?php
          include('../Log.php');
          include('../mensagem.php');

          if (isset($_GET['codigo_categoria']) && $_GET['codigo_categoria'] != '') {
                    $codigo = $_GET['codigo_categoria'];

                    $sql = "SELECT * FROM categoria  WHERE codigo_categoria  = $codigo";

                    $query = mysqli_query($conexao, $sql);

                    $categoria = mysqli_fetch_assoc($query);
        ?>

       <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h4 class="m-0">Editar Categoria</h4>
               <!-- btn = cria o botao btn-primary= da cor para botao btn-sm= diminui o botao -->
          <a href="index.php" class="btn btn-dark btn-sm"> 
            <i class="bi bi-arrow-left-short"></i>

            Voltar
          </a>
        </div>
     
        <div class="card-body">
          <form action="acoes.php" method="post">
            <div class="row">
                <div class="col-6">
                    <label for="categoria"><strong class="text-danger">*</strong>Categoria:</label>
                    <input type="text" name="categoria" id="categoria" class="form-control" maxlength="40" value="<?php echo $categoria['nome'] ?>"  required>
                </div>

                <div class="col-6">
                    <label for="status">Status:</label>
                    <select name="status" id="status" class="form-control" >
                        <option value="1" <?php if ($categoria['status'] == '1') echo 'Selected' ?>>Ativo</option>
                        <option value="0" <?php if ($categoria['status'] == '0') echo 'Selected' ?>>Inativo</option>
                    </select>
                </div>

                <div class="col-12 mt-2">
                    <label for="observacao">Observação:</label>
                    <textarea name="observacao" id="observacao" class="form-control" maxlength="100" value="<?php echo $categoria['observacao'] ?>"><?php echo $categoria['observacao'] ?></textarea>

                    <input type="hidden" name="editar" value="editar_categoria">
                    <input type="hidden" name="codigo_categoria" value="<?php echo $codigo ?>">
                    <input type="submit" value="Atualizar" class="btn btn-primary mt-3">
                </div>
            </div>
          </form>
        </div>

       </div>

       <?php
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                    Nenhum categoria encontrado
                   </div>';
                }
                ?>
      </main>
    </div>
  </div>
  
  <!-- JQUERY CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
