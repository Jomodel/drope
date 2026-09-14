<?php 

// Retorna o caminho da URL após o nome do host
$url_parcial = $_SERVER['REQUEST_URI'];

// 0 => "", 1 => "info_52", 2 => "pi", 3 => "admin"
$caminho = explode("/", $url_parcial);

// é o que faz o caminho completo da URL do caminho do site
$url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $caminho[1] . "/" . $caminho[2];
$perfil = (($_SESSION['TYPE'] ?? '') === '1') ? 'Admin' : 'Comum';

?>



<link rel="stylesheet" href="<?php echo $url; ?>/custom/admin.css?v=12">
<header class="navbar navbar-dark admin-topbar sticky-top px-3 shadow-sm">
  <a class="navbar-brand" href="<?php echo $url?>/admin/Admin.php">ROUTE 52 <span class="fw-normal small"><?php echo $perfil; ?></span></a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="navbar-nav ms-auto">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="<?php echo $url?>/admin/LogOff.php">Sair</a>
    </div>
  </div>
</header>
