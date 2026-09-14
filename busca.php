<?php
#CONEXAO BANCO DE DADO#
require_once __DIR__ . "/conexao/conecta.php";
/** Exibe o preço de um card de produto de forma consistente no site público. */
if (!function_exists('renderizarPrecoCard')) {
    function renderizarPrecoCard(array $produto): void
    {
        $precoNormal = (float) ($produto['preco_venda'] ?? 0);
        $precoPromocional = (float) ($produto['preco_promocao'] ?? 0);
        $emPromocao = (string) ($produto['status_promocao'] ?? '0') === '1'
            && $precoPromocional > 0
            && $precoPromocional < $precoNormal;

        if ($emPromocao) {
            $percentual = (int) round((1 - ($precoPromocional / $precoNormal)) * 100);
            ?>
            <span class="produto-preco produto-preco--promocao">
                <span class="produto-preco__desconto">-<?php echo $percentual; ?>%</span>
                <span class="produto-preco__original">R$ <?php echo number_format($precoNormal, 2, ',', '.'); ?></span>
                <span class="produto-preco__promocional">R$ <?php echo number_format($precoPromocional, 2, ',', '.'); ?></span>
            </span>
            <?php
            return;
        }
        ?>
        <span class="produto-preco">
            <span class="produto-preco__normal">R$ <?php echo number_format($precoNormal, 2, ',', '.'); ?></span>
        </span>
        <?php
    }
}


session_start();

$totalCarrinho = 0;

if (isset($_SESSION['carrinho'])) {
    $totalCarrinho = array_sum($_SESSION['carrinho']);
}

    $busca = '';
    if (isset($_GET['busca']) && $_GET['busca'] != '')
    {
        $busca = mysqli_real_escape_string($conexao, $_GET['busca']);
    }

    $filtro = '';

    if (isset($_GET['genero']) && !empty($_GET['genero'])) {
        $lista = implode("','", $_GET['genero']);
        $filtro .= " AND produto.genero IN ('$lista')";
    }

    if (isset($_GET['cmarca']) && !empty($_GET['cmarca'])) {
        $lista = implode(',', $_GET['cmarca']);
        $filtro .= " AND produto.codigo_marca IN ($lista)";
    }

    if (isset($_GET['categorias']) && !empty($_GET['categorias'])) {
        $lista = implode(',', $_GET['categorias']);
        $filtro .= " AND produto.codigo_categoria IN ($lista)";
    }

    if (isset($_GET['preco_min']) && $_GET['preco_min'] != '') {
        $preco = (float) $_GET['preco_min'];
        $filtro .= " AND produto.preco_venda >= $preco";
    }

    $ordem = 'produto.codigo_produto DESC';
    if (isset($_GET['ordenar'])) {
        if ($_GET['ordenar'] == 'antigos') {
            $ordem = 'produto.codigo_produto ASC';
        }
        if ($_GET['ordenar'] == 'maior_preco') {
            $ordem = 'produto.preco_venda DESC';
        }
        if ($_GET['ordenar'] == 'menor_preco') {
            $ordem = 'produto.preco_venda ASC';
        }
    }


$sql_count = "SELECT COUNT(*) AS quantidade FROM produto WHERE status = 1 AND nome LIKE '%$busca%'$filtro" ;
$query_count = mysqli_query($conexao, $sql_count);
$linha = mysqli_fetch_assoc($query_count);
$quantidade = $linha['quantidade'];





$buscapag = "&busca=" . urlencode($busca);
if (isset($_GET['genero'])) {
    foreach ($_GET['genero'] as $genero) {
        $buscapag .= "&genero[]=" . urlencode($genero);
    }
}
if (isset($_GET['cmarca'])) {
    foreach ($_GET['cmarca'] as $marca) {
        $buscapag .= "&cmarca[]=" . urlencode($marca);
    }
}
if (isset($_GET['categorias'])) {
    foreach ($_GET['categorias'] as $categoria) {
        $buscapag .= "&categorias[]=" . urlencode($categoria);
    }
}
if (isset($_GET['preco_min'])) {
    $buscapag .= "&preco_min=" . urlencode($_GET['preco_min']);
}
if (isset($_GET['ordenar'])) {
    $buscapag .= "&ordenar=" . urlencode($_GET['ordenar']);
}


if (isset($_GET['page']) && !empty($_GET['page'])) {
    $paginaAtual = $_GET['page'];
} else {
    $paginaAtual = 1;
}

$url = "?page=";

// QUANTIDADE DE PRODUTOS EXBIDOS POR PAGINA
$paginaQtde = 12;
//  VALOR INICIAL PARA CLAUSULA LIMIT
$valorInicial = ($paginaAtual * $paginaQtde) - $paginaQtde;

$paginaFinal = ceil($quantidade / $paginaQtde);

$paginaInicial = 1;

$paginaProxima = $paginaAtual + 1;

$paginaAnterior = $paginaAtual - 1;



// SELECT
$sql_geral = "SELECT produto.codigo_produto, produto.nome, produto.qtde_estoque, produto.preco_venda,produto.preco_promocao,produto.status_promocao, produto.status, produto.foto, marca.nome 'marca', categoria.nome 'categoria' FROM produto JOIN marca on produto.codigo_marca = marca.codigo_marca JOIN categoria on categoria.codigo_categoria = produto.codigo_categoria WHERE produto.status = 1 AND produto.nome LIKE '%$busca%' $filtro ORDER BY $ordem";
  
    $sql_geral .= " LIMIT $valorInicial, $paginaQtde";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Route 52</title>


    <!-- FontAwesome icones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- css boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- css -->
    <link rel="stylesheet" href="custom/css/style-produtos.css?v=2">
    <link rel="stylesheet" href="custom/css/style.css?v=22">

    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">

</head>

<body>
<?php
/* Cabeçalho público compartilhado. Requer $totalCarrinho e $conexao quando disponíveis. */
$headerVariant = 'internal';
$paginaAtual = basename($_SERVER['PHP_SELF'] ?? '');
$totalCarrinho = $totalCarrinho ?? 0;
?>
<header id="site-header" class="site-header site-header--<?php echo $headerVariant; ?>">
    <nav class="navbar navbar-expand-md py-2" aria-label="Navegação principal">
        <div class="container site-header__container">
            <a class="navbar-brand site-header__brand" href="index.php" aria-label="Route 52 - página inicial">
                <img class="rua52-symbol" src="assets/img/home/rua52-simbolo.png" alt="">
                <img class="rua52-wordmark" src="assets/img/home/route52-nome.png" alt="Route 52">
            </a>

            <button class="navbar-toggler site-header__toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-label="Abrir menu">
                <i class="fa-solid fa-bars" aria-hidden="true"></i>
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>

            <div class="collapse navbar-collapse order-md-2" id="menuDesktop">
                <ul class="navbar-nav mx-md-auto site-header__links">
                    <li class="nav-item"><a class="nav-link <?php echo $paginaAtual === 'index.php' ? 'active' : ''; ?>" href="index.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $paginaAtual === 'produtos.php' ? 'active' : ''; ?>" href="produtos.php">Calçados</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $paginaAtual === 'produtos_geral.php' ? 'active' : ''; ?>" href="produtos_geral.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $paginaAtual === 'produtos_roupas.php' ? 'active' : ''; ?>" href="produtos_roupas.php">Roupas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#rodape">Contato</a></li>
                </ul>
            </div>

            <div class="site-header__actions order-md-3">
                <button class="btn site-header__icon-button" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#buscaProdutos" aria-controls="buscaProdutos" aria-label="Buscar produtos">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                </button>
                <a class="site-header__icon-button" href="#" aria-label="Minha conta"><i class="fa-regular fa-user" aria-hidden="true"></i></a>
                <button class="btn site-header__icon-button site-header__cart" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#carrinhoProdutos" aria-controls="carrinhoProdutos" aria-label="Abrir carrinho">
                    <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
                    <span class="site-header__cart-count"><?php echo (int) $totalCarrinho; ?></span>
                </button>
            </div>
        </div>
    </nav>
</header>

<div class="offcanvas offcanvas-start site-menu" tabindex="-1" id="menuPrincipal" aria-labelledby="menuPrincipalTitulo">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title h5" id="menuPrincipalTitulo">Menu</h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar menu"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav gap-2">
            <li><a class="nav-link" href="index.php">Início</a></li>
            <li><a class="nav-link" href="produtos.php">Calçados</a></li>
            <li><a class="nav-link" href="produtos_geral.php">Produtos</a></li>
            <li><a class="nav-link" href="produtos_roupas.php">Roupas</a></li>
            <li><a class="nav-link" href="#rodape" data-bs-dismiss="offcanvas">Contato</a></li>
        </ul>
    </div>
</div>

<div class="offcanvas offcanvas-top site-search" tabindex="-1" id="buscaProdutos" aria-labelledby="buscaProdutosTitulo">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title h5" id="buscaProdutosTitulo">Buscar produtos</h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar busca"></button>
    </div>
    <div class="offcanvas-body pt-0">
        <form class="d-flex gap-2 mx-auto site-search__form" role="search" action="busca.php" method="GET">
            <label class="visually-hidden" for="campoBusca">Produto desejado</label>
            <input id="campoBusca" class="form-control" type="search" name="busca" placeholder="O que você procura?" required>
            <button class="btn btn-dark" type="submit">Buscar</button>
        </form>
    </div>
</div>

<div class="offcanvas offcanvas-end site-cart" tabindex="-1" id="carrinhoProdutos" aria-labelledby="carrinhoProdutosTitulo">
    <div class="offcanvas-header border-bottom">
        <h2 class="offcanvas-title h5 mb-0" id="carrinhoProdutosTitulo">Carrinho <span class="badge text-bg-dark"><?php echo (int) $totalCarrinho; ?></span></h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar carrinho"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
        <?php if (empty($_SESSION['carrinho'])): ?>
            <p class="text-secondary">Seu carrinho está vazio.</p>
        <?php else: ?>
            <?php foreach ($_SESSION['carrinho'] as $codigo => $quantidade): ?>
                <?php
                $codigo = (int) $codigo;
                $produtoCarrinho = null;
                if (isset($conexao)) {
                    $resultadoCarrinho = mysqli_query($conexao, "SELECT nome, preco_venda, foto, status_promocao, preco_promocao FROM produto WHERE codigo_produto = $codigo");
                    $produtoCarrinho = $resultadoCarrinho ? mysqli_fetch_assoc($resultadoCarrinho) : null;
                }
                ?>
                <?php if ($produtoCarrinho): ?>
                    <article class="d-flex gap-3 mb-3">
                        <img class="site-cart__image" src="images/produto/<?php echo htmlspecialchars($produtoCarrinho['foto']); ?>" alt="">
                        <div class="flex-grow-1">
                            <h3 class="h6 mb-1"><?php echo htmlspecialchars($produtoCarrinho['nome']); ?></h3>
                            <p class="small mb-2">Quantidade: <?php echo (int) $quantidade; ?></p>
                            <?php if ($produtoCarrinho['status_promocao'] == 1){
                                $precoPromocao = $produtoCarrinho['preco_promocao'];
                                $precoVendaD = $quantidade * $precoPromocao; 
                                ?>
                            <strong>R$ <?php echo number_format($precoVendaD, 2, ',', '.'); ?></strong>
                            <?php }else
                            {
                                $precoVenda = $produtoCarrinho['preco_venda'];
                                $precoVenda = $quantidade * $precoVenda; 
                                ?>
                                          <strong>R$ <?php echo number_format($precoVenda, 2, ',', '.'); ?></strong>
                                <?php }?>
                            <a class="d-block small text-danger mt-2" href="remover_carrinho.php?codigo_produto=<?php echo $codigo; ?>">Remover</a>
                        </div>
                    </article>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <a class="btn btn-dark mt-auto" href="#">Comprar</a>
    </div>
</div>

    <?php if (false): ?>
    <!-- Inicio cabeçalho -->
    <header id="topo">
        <div class="container">
            <nav>

                <!-- Menu Hamburger -->
                <div class="hamburger_menu">
                    <nav class="navbar bg-body-tertiary fixed-top">
                        <div class="container-fluid">
                            <div id="img-logo">
                                <a href="index.php">
                                    <img src="assets/img/home/logo.png" alt="">
                                </a>
                            </div>

                            <a class="navbar-brand" href="#">

                                <div id="logo">

                                    <div id="pesquisar">
                                        <i class="fa-solid fa-magnifying-glass"></i>

                                        <!--Perfil -->

                                        <a href="#">
                                            <i class="fa-regular fa-user"></i>
                                        </a>

                                        <a href="#">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </a>
                                    </div>
                            </a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                                aria-labelledby="offcanvasNavbarLabel">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><a href="index.php">
                                            <img src="assets/img/home/logo.png" alt="">
                                        </a></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="produtos.php">Calçados</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="produtos_geral.php">Produtos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="produtos_roupas.php">Roupas</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Contato</a>
                                        </li>

                                    </ul>

                                </div>
                            </div>
                        </div>
                    </nav>
                </div>

                <!-- logotipo -->
                <div id="logo">
                    <a href="index.php">
                        <img src="assets/img/home/logo.png" alt="">

                    </a>
                </div>

                <!-- Navegação -->
                <ul id="navegacao">
                    <li>
                        <a href="index.php" class="linkmenu">Inicio</a>
                    </li>
                    <li>
                        <a href="produtos.php" class="linkmenu">calçados</a>
                    </li>
                    <li>
                        <a href="produtos_geral.php" class="linkmenu">Produtos</a>
                    </li>
                    <li>
                        <a href="produtos_roupas.php" class="linkmenu">Roupas</a>
                    </li>
                    <li>
                        <a href="#" class="linkmenu">Contato</a>
                    </li>
                </ul>

                <!-- Pesquisa -->
                <div id="pesquisar">
                    <button class="btn pesquisar" id="btn-seahc1" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasTop" aria-controls="offcanvasTop"><i
                            class="fa-solid fa-magnifying-glass"></i></button>

                    <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop"
                        aria-labelledby="offcanvasTopLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasTopLabel">
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <nav class="navbar bg-body-tertiary">
                                <div class="container-fluid" id="pesquisar-fluid">
                                    <form class="d-flex" role="search" action="busca.php" method="GET">
                                        <button class="btn border border-secondary" type="submit"><i
                                                class="fa-solid fa-magnifying-glass" id="icon-sea"></i></button>
                                        <input class="form-control me-2" type="search"  name="busca" placeholder="Search"
                                            aria-label="Search" />

                                    </form>
                                </div>
                            </nav>
                        </div>
                    </div>

                    <!--Perfil -->
                    <div id="perfil">
                        <a href="#">
                            <i class="fa-regular fa-user"></i>
                        </a>

                        <a href="#" id="icone-carrinho">
                            <button class="btn" style="padding: 0;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="fa-solid fa-cart-shopping" style="margin: 0;"></i></button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasRightLabel">Carrinho <span id="contador-carrinho" style="font-size: 16px;"><?php echo $totalCarrinho; ?></span></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <?php

                                    if (empty($_SESSION['carrinho'])) {
                                        echo "<p>Seu carrinho está vazio</p>";
                                    } else {

                                        foreach ($_SESSION['carrinho'] as $codigo => $quantidade) {

                                            $sql = "SELECT * FROM produto WHERE codigo_produto = $codigo";
                                            $query = mysqli_query($conexao, $sql);

                                            if ($produto = mysqli_fetch_assoc($query)) {
                                    ?>

                                                <div class="produto-carrinho mb-3 d-flex gap-3">

                                                    <img style="width: 120px; aspect-ratio: 1/1; object-fit: cover;"
                                                        src="/info_52/pi/images/produto/<?php echo $produto['foto']; ?>">

                                                    <div class="flex-grow-1">

                                                        <h6 style="font-size: 16px;">
                                                            <?php echo $produto['nome']; ?>
                                                        </h6>

                                                        <p style="font-size: 14px;">
                                                            Quantidade: <?php echo $quantidade; ?>
                                                        </p>

                                                        <p style="font-size: 14px;">
                                                            R$ <?php echo number_format($produto['preco_venda'], 2, ',', '.'); ?>
                                                        </p>

                                                        <a href="remover_carrinho.php?codigo_produto=<?php echo $codigo; ?>"
                                                            style="color:#000;text-decoration:none;">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="container position-absolute bottom-0 start-50 translate-middle-x">
                                        <a class="btn btn-dark" href="#" role="button" style="color: #ffff;">Comprar</a>
                                    </div>
                                </div>
                            </div>
                            <span id="contador-carrinho" style="font-size: 14px;"><?php echo $totalCarrinho; ?></span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <?php endif; ?>
    <!-- fim cabeçalho -->

    <!-- Inico Banner -->

    <section id="banner">
        <img src="assets/img/produtos/Buscar.png" alt="">
    </section>
    <!-- Fim banner -->
   
    

    <!-- Inicio Ofertas -->
    <section id="ofertas">
        <div class="container">
            <div id="text-off">
                <?php 
                    $query_geral = mysqli_query($conexao, $sql_geral);
                    if(mysqli_num_rows($query_geral) > 0){                
                ?>
                <h5>Produto encontrando: <?php echo $busca;?></h5>
                <?php }else  {?>
                <h5>Nenhum produto encontrado para "<?php echo $busca; ?>"</h5>
                <?php }?>
                
                <p></p>
            </div>

            <div id="volt-btn">
                <div id="voltar">
                    <a href="index.php" class="volt-ini">Inicio</a>
                    /
                    <a href="#">Busca</a>
                </div>
               <?php
                    $sql = "SELECT codigo_produto FROM produto";

                    $query = mysqli_query($conexao, $sql);

                    if (mysqli_num_rows($query) > 0) {


                    ?>
                <div id="btn-off">
                    <button class="btn btn-light border border-secondary btn-filtro" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Mostrar
                        Filtro</button>

                    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1"
                        id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Filtro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>

                        <div class="offcanvas-body">
                            <form action="busca.php" method="GET">
                                <input type="hidden" name="busca" value="<?php echo htmlspecialchars($busca); ?>">
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <div class="linha"></div>
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapseOne">
                                            Genero
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" onchange="buscar()">
                                        <div class="accordion-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="genero[]" value="Masculino" id="gen_m">
                                                <label class="form-check-label" for="checkDefault">
                                                    Masculino
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="genero[]" value="Feminino"
                                                    id="gen_f">
                                                <label class="form-check-label" for="checkChecked">
                                                    Feminino
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"  name="genero[]" value="Unissex"
                                                    id="gen_u">
                                                <label class="form-check-label" for="checkChecked">
                                                    Unissex
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item" onchange="buscar()">
                                    <h2 class="accordion-header">
                                        <div class="linha"></div>
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo"
                                            aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                            Tamanho
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" >
                                        <div class="accordion-body">
                                            <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                                                
                                                <?php
                                            $sql_tamanho = "SELECT tamanho FROM produto ";

                                            $query_tamanho= mysqli_query($conexao, $sql_tamanho);

                                            foreach ($query_tamanho as $tamanho) {                                      
                                            
                                            ?>
                                                <div class="btns-passar"><a href="#"><?php echo $tamanho['tamanho']?></a></div>
                                                
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item" onchange="buscar()">
                                    <h2 class="accordion-header">
                                        <div class="linha"></div>
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree"
                                            aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                            Marca
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" >
                                        <div class="accordion-body">
                                            <?php
                                            $sql_marca = "SELECT codigo_marca, nome FROM marca ";

                                            $query_marca = mysqli_query($conexao, $sql_marca);

                                            foreach ($query_marca as $marca) {
                                                echo '<div class="form-check">
                                                          <input 
                                                              class="form-check-input" 
                                                              type="checkbox" 
                                                              name="cmarca[]" 
                                                              value="' . $marca['codigo_marca'] . '" 
                                                              id="cat_' . $marca['codigo_marca'] . '"
                                                          >
                                                          <label class="form-check-label" for="cat_' . $marca['codigo_marca'] . '">
                                                              ' . $marca['nome'] . '
                                                          </label>
                                                      </div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item" onchange="buscar()">
                                    <h2 class="accordion-header">
                                        <div class="linha"></div>
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsefour"
                                            aria-expanded="false" aria-controls="panelsStayOpen-collapsefour">
                                            Categoria
                                        </button>
                                    </h2>

                                    <div id="panelsStayOpen-collapsefour" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <?php
                                            $sql_categoria = "SELECT codigo_categoria, nome FROM categoria";
                                            $query_categoria = mysqli_query($conexao, $sql_categoria);

                                            foreach ($query_categoria as $categoria) {
                                                echo '
                                                      <div class="form-check">
                                                          <input 
                                                              class="form-check-input" 
                                                              type="checkbox" 
                                                              name="categorias[]" 
                                                              value="' . $categoria['codigo_categoria'] . '" 
                                                              id="cat_' . $categoria['codigo_categoria'] . '"
                                                          >
                                                          <label class="form-check-label" for="cat_' . $categoria['codigo_categoria'] . '">
                                                              ' . $categoria['nome'] . '
                                                          </label>
                                                      </div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item" onchange="buscar()">
                                    <h2 class="accordion-header">
                                        <div class="linha"></div>
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsefive"
                                            aria-expanded="false" aria-controls="panelsStayOpen-collapsefive">
                                            Preço
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapsefive" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <div class="form-check">
                                                <label for="range4" class="form-label">A partir de</label>
                                                <input type="range" class="form-range" min="100" max="1000" value="<?php echo isset($_GET['preco_min']) ? $_GET['preco_min'] : 500; ?>"
                                                    id="range4" name="preco_min">
                                                <output for="range4" id="rangeValue" aria-hidden="true"></output>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 mt-4">
                                <button class="btn btn-dark" type="submit">Aplicar filtro</button>
                                <a class="btn btn-outline-secondary" href="busca.php?busca=<?php echo urlencode($busca); ?>">Limpar filtro</a>
                            </div>
                            </form>
                        </div>
                    </div>


                    <form id="form-ordenar" action="busca.php" method="GET">
                        <input type="hidden" name="busca" value="<?php echo htmlspecialchars($busca); ?>">
                        <?php
                        if (isset($_GET['genero'])) {
                            foreach ($_GET['genero'] as $genero) {
                                echo '<input type="hidden" name="genero[]" value="' . htmlspecialchars($genero) . '">';
                            }
                        }
                        if (isset($_GET['cmarca'])) {
                            foreach ($_GET['cmarca'] as $marca) {
                                echo '<input type="hidden" name="cmarca[]" value="' . htmlspecialchars($marca) . '">';
                            }
                        }
                        if (isset($_GET['categorias'])) {
                            foreach ($_GET['categorias'] as $categoria) {
                                echo '<input type="hidden" name="categorias[]" value="' . htmlspecialchars($categoria) . '">';
                            }
                        }
                        if (isset($_GET['preco_min'])) {
                            echo '<input type="hidden" name="preco_min" value="' . htmlspecialchars($_GET['preco_min']) . '">';
                        }
                        ?>
                        <select class="form-select" name="ordenar" onchange="this.form.submit()" aria-label="Ordenar produtos">
                            <option value="recentes" <?php if (!isset($_GET['ordenar']) || $_GET['ordenar'] == 'recentes') echo 'selected'; ?>>Mais Recentes</option>
                            <option value="antigos" <?php if (isset($_GET['ordenar']) && $_GET['ordenar'] == 'antigos') echo 'selected'; ?>>Mais Antigos</option>
                            <option value="maior_preco" <?php if (isset($_GET['ordenar']) && $_GET['ordenar'] == 'maior_preco') echo 'selected'; ?>>Maior Preço</option>
                            <option value="menor_preco" <?php if (isset($_GET['ordenar']) && $_GET['ordenar'] == 'menor_preco') echo 'selected'; ?>>Menor Preço</option>
                        </select>
                    </form>
                </div>
            </div>

            
            <!-- TABELA -->
            <div id="produto_oferta">
    <?php
    

    

    if (mysqli_num_rows($query_geral) > 0) {
    ?>

        <?php foreach ($query_geral as $produto) { ?>
            <!-- Item 1 -->
            <a href="produto.php?codigo_produto=<?php echo $produto['codigo_produto']; ?>" class='servico-lancamento'>
                <?php
                if (empty($produto['foto'])) {
                    echo '<img src="/info_52/pi/assets/img/placeholder-produto.png" class="w-100" alt="" name="imagem" id="imagem" style="width: 45px; aspect-ratio: 1/1; object-fit: cover;">';
                } else {
                    echo '<img src="/info_52/pi/images/produto/' . htmlspecialchars($produto['foto']) . '"  alt="" name="imagem" id="imagem" style="width: 100%; max-width: 380px;  aspect-ratio: 1/1; object-fit: cover; ">';
                }
                ?>
                <p>
                    <?php renderizarPrecoCard($produto); ?>
                    <?php echo $produto['nome']; ?>
                </p>
                </p>
            </a>




        <?php } ?>
    <?php } ?>
</div>

<!-- PAGINAÇÂO -->
<nav aria-label="paginacao">
    <ul class="pagination justify-content-center">
        <?php if ($paginaAtual != $paginaInicial) { ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $url . $paginaInicial . $buscapag ?>">Início</a>
            </li>
        <?php } ?>

        <?php if ($paginaAtual >= 2) { ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $url . $paginaAnterior . $buscapag ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php } ?>

        <?php if ($paginaAtual != $paginaFinal) { ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $url . $paginaProxima . $buscapag ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="<?php echo $url . $paginaFinal . $buscapag ?>">Final</a>
            </li>
        <?php } ?>
    </ul>
            <?php }?>
              
        </nav>
        </div>
    </section>
    <!-- Fim Ofertas -->

    <!-- Inicio Lançamento -->
    <div id="lancamento">
        <div class="container">

            <div id="texto_lanca">
                <h2>Lançamentos</h2>

                <p>Os lançamentos não são apenas sobre estilo, mas também sobre inovação, tecnologia e a forma
                    como
                    a moda se conecta com a cultura urbana.</p>
            </div>


            <?php
            $sql_lancamento = "SELECT  codigo_produto,nome, preco_venda, foto, status_promocao,preco_promocao FROM produto WHERE codigo_categoria != 1 AND status = 1 LIMIT 3";

            $query_lancamento = mysqli_query($conexao, $sql_lancamento);

            if (mysqli_num_rows($query_lancamento) > 0) {
            ?>
                <div id="produto-lancamento">
                    <?php foreach ($query_lancamento as $produto) { ?>
                        <!-- Item 1 -->
                        <a href="produto.php?codigo_produto=<?php echo $produto['codigo_produto']; ?>" class='servico-lancamento'>
                            <?php
                            if (empty($produto['foto'])) {
                                echo '<img src="/info_52/pi/assets/img/placeholder-produto.png" class="w-100" alt="" name="imagem" id="imagem" style="width: 45px; aspect-ratio: 1/1; object-fit: cover;">';
                            } else {
                                echo '<img src="/info_52/pi/images/produto/' . htmlspecialchars($produto['foto']) . '"  alt="" name="imagem" id="imagem" style="width: 100%; max-width: 380px;  aspect-ratio: 1/1; object-fit: cover; ">';
                            }
                            ?>
                            <p>
                                <?php renderizarPrecoCard($produto); ?>
                                <?php echo $produto['nome']; ?>
                            </p>
                        </a>


                    <?php } ?>


                </div>
            <?php } ?>

        </div>
    </div>
    <!-- Fim Lançamento -->

    <!-- Inicio do Rodapé -->
    <footer id="rodape">
        <div class="container">

            <div id="rede-rodape">
                <a href="index.php">
                    <img src="assets/img/home/rua52-simbolo.png" alt="Route 52">
                </a>

                <h3>Nossa Missão</h3>
                <p>Conectar você às grandes marcas que representam conforto, estilo e atitude.</p>

                <div id="redes">

                    <i class="fa-brands fa-facebook-f  "></i>


                    <i class="fa-brands fa-x-twitter  "></i>


                    <i class="fa-brands fa-instagram  "></i>


                    <i class="fa-brands fa-linkedin-in  "></i>

                </div>
            </div>



            <div id="links-rapidos">
                <h3>Links Rapidos</h3>
                <li><a href="index.php" class="linkmenu">Início</a></li>
                <li><a href="produtos.php" class="linkmenu">Calçados</a></li>
                <li><a href="produtos_geral.php" class="linkmenu">Produtos</a></li>
                <li><a href="produtos_roupas.php" class="linkmenu">Roupas</a></li>
                <li><a href="#Contato-rodape" class="linkmenu">Contato</a></li>
            </div>

            <div id="duvida-rodape">
                <h3>Duvidas</h3>
                <p>Política de Privacidade </p>
                <p>Termos e Condições de Uso</p>
                <p>Política de Entrega</p>
                <p>Trocas e Devoluções</p>
                <p>Ajuda / FAQ</p>
            </div>
            <div id="Contato-rodape">
                <h3>Entre em Contato</h3>
                <div id="forma-contato">

                    <i class="fa-solid fa-phone"></i>
                    (19) 2105-0199
                    <br>
                    <i class="fa-solid fa-envelope"></i>
                    contato@anchor.com.br
                    <br>
                    <i class="fa-solid fa-location-dot"></i>
                    Rua Santa Cruz,1148 - Alto
                    <br>
                    <i class="fa-solid fa-clock"></i>
                    Seg. á Sex. das 8H á 17H
                </div>
            </div>
            <div id="rodape-email">
                <p>Ganhe 15% na priemira compra e descubra as novidades antes:</p>
                <div id="form">
                    <input type="text" placeholder="E-mail">
                </div>

                <a class="btn btn-primary" id="btn-email" href="#" role="button">Cadastrar</a>
            </div>
        </div>
        <div id="todos-diretos">
            <p>© 2026 Route 52. Todos os direitos reservados.</p>
            <p>Desenvolvido por João</p>
        </div>

    </footer>

    <!-- Fim do Rodapé -->
     <!-- JQUERY CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Js Boostrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <!-- Js -->
    <script src="custom/js/script-site.js"></script>
    <script src="custom/js/header.js?v=3"></script>



    
</body>

</html>
