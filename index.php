<?php
#CONEXAO BANCO DE DADO#
require_once __DIR__ . "/conexao/conecta.php";

session_start();

$totalCarrinho = 0;

if (isset($_SESSION['carrinho'])) {
    $totalCarrinho = array_sum($_SESSION['carrinho']);
}

/**
 * Renderiza o bloco de preço de um produto: preço original riscado +
 * preço promocional em destaque (com badge de desconto) quando o
 * produto está em promoção, ou o preço único quando não está.
 * Centralizado aqui para não duplicar a lógica em cada seção.
 */
function renderizarPreco($produto)
{
    if ($produto['status_promocao'] == '1') {
        $desconto = 0;
        if ($produto['preco_venda'] > 0) {
            $desconto = round((1 - ($produto['preco_promocao'] / $produto['preco_venda'])) * 100);
        }
?>
        <div class="preco-wrapper">
            <span class="badge-desconto">-<?php echo $desconto; ?>%</span>
            <span class="preco-original">R$<?php echo number_format($produto['preco_venda'], 2, ',', '.'); ?></span>
            <span class="preco-promocional">R$<?php echo number_format($produto['preco_promocao'], 2, ',', '.'); ?></span>
        </div>
<?php
    } else {
?>
        <div class="preco-wrapper">
            <span class="preco-atual">R$<?php echo number_format($produto['preco_venda'], 2, ',', '.'); ?></span>
        </div>
<?php
    }
}
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
<link rel="stylesheet" href="custom/css/style-inicio.css?v=14">
<link rel="stylesheet" href="custom/css/style.css?v=22">

    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">

</head>

<body>
<?php
/* Cabeçalho público compartilhado. Requer $totalCarrinho e $conexao quando disponíveis. */
$headerVariant = $headerVariant ?? 'home';
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

                <!-- Bloco mobile: logo pequeno + botão hamburguer (único acionador do menu) -->
                <div class="hamburger_menu">
                    <div id="img-logo">
                        <a href="index.php">
                            <img src="assets/img/home/logo.png" alt="EstiloMix">
                        </a>
                    </div>

                    <button class="navbar-toggler" type="button" id="btn-menu-mobile"
                        aria-controls="navegacao" aria-expanded="false" aria-label="Abrir menu de navegação">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <!-- logotipo (desktop) -->
                <div id="logo">
                    <a href="index.php">
                        <img src="assets/img/home/logo.png" alt="EstiloMix">
                    </a>
                </div>

                <!-- Navegação: única lista de links, também usada como painel mobile -->
                <ul id="navegacao">
                    <li>
                        <a href="index.php" class="linkmenu active">Inicio</a>
                    </li>
                    <li>
                        <a href="produtos.php" class="linkmenu">Calçados</a>
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

                <!-- Pesquisa / Perfil / Carrinho (instância única) -->
                <div id="pesquisar">
                    <button class="btn pesquisar" id="btn-seahc1" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasTop" aria-controls="offcanvasTop" aria-label="Buscar produtos">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>

                    <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop"
                        aria-labelledby="offcanvasTopLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasTopLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <nav class="navbar bg-body-tertiary">
                                <div class="container-fluid" id="pesquisar-fluid">
                                    <form class="d-flex" role="search" action="busca.php" method="GET">
                                        <button class="btn border border-secondary" type="submit"
                                            aria-label="Enviar busca">
                                            <i class="fa-solid fa-magnifying-glass" id="icon-sea"></i>
                                        </button>
                                        <input class="form-control me-2" type="search" name="busca"
                                            placeholder="Search" aria-label="Search" />
                                    </form>
                                </div>
                            </nav>
                        </div>
                    </div>

                    <!--Perfil -->
                    <div id="perfil">
                        <a href="#" aria-label="Minha conta">
                            <i class="fa-regular fa-user"></i>
                        </a>

                        <button class="btn" id="icone-carrinho" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"
                            aria-label="Abrir carrinho">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="contador-carrinho"><?php echo $totalCarrinho; ?></span>
                        </button>
                    </div>

                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                        aria-labelledby="offcanvasRightLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasRightLabel">Carrinho
                                <span class="contador-carrinho"><?php echo $totalCarrinho; ?></span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
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
                </div>
            </nav>
        </div>
    </header>
    <?php endif; ?>
    <!-- fim cabeçalho -->

    <!-- Inicio do Banner -->
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" id="banner1">
                <img src="assets/img/home/banner2.png" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h4>Chegue Diferente</h4>
                    <p>Nova coleção com atitude, conforto e presença em cada passo.</p>
                    <a class="btn btn-primary btn-banner" href="#" role="button">Ver coleção</a>
                </div>
            </div>
            <div class="carousel-item" id="banner2">
                <img src="assets/img/home/banner3.png" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Nova coleção no ar</h3>
                    <p>estilo que chama atenção, conforto que acompanha seu ritmo — escolha seu par e pisa com atitude
                    </p>
                    <a class="btn btn-primary btn-banner" href="#" role="button">Ver coleção</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/img/home/banner4.png" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h4>Lançamento Exclusivo</h4>
                    <p>Chegue chegando — estilo que fala por você</p>
                    <a class="btn btn-primary btn-banner" href="#" role="button">Ver coleção</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev" aria-label="Banner anterior">
            <span class="banner-navegacao" aria-hidden="true"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="visually-hidden">Banner anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next" aria-label="Próximo banner">
            <span class="banner-navegacao" aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
            <span class="visually-hidden">Próximo banner</span>
        </button>
    </div>
    <!-- Fim do Banner -->

    <!-- Inicio Ofertas -->
    <?php
    $sql = "SELECT codigo_produto,nome, preco_venda, foto, status_promocao,preco_promocao FROM produto WHERE status_promocao = 1 LIMIT 4";

    $query = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($query) > 0) {
    ?>
        <section id="ofertas">
            <div class="container">
                <h2>Principais Ofertas</h2>
                <div id="produto_oferta">
                    <?php foreach ($query as $produto) { ?>
                        <a href="produto.php?codigo_produto=<?php echo $produto['codigo_produto']; ?>" class='servico-ofertas'>
                            <?php
                            if (empty($produto['foto'])) {
                                echo '<img src="/info_52/pi/assets/img/placeholder-produto.png" class="w-100" alt="" loading="lazy" style="width: 45px; aspect-ratio: 1/1; object-fit: cover;">';
                            } else {
                                echo '<img src="/info_52/pi/images/produto/' . htmlspecialchars($produto['foto']) . '"  alt="" loading="lazy" style="width: 270px;  aspect-ratio: 1/1; object-fit: cover; ">';
                            }
                            ?>
                            <p><?php echo $produto['nome']; ?></p>
                            <?php renderizarPreco($produto); ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } ?>
    <!-- Fim Ofertas -->

    <!-- Inicio Temporada -->
    <section class="secao">
        <section id="temporada">
            <div class="container">

                <div id="texto_temp">
                    <span class="temporada-selo">DROP 01 &bull; ROUTE 52</span>
                    <h2>Nova Temporada</h2>

                    <p style="color: #fff;">Chegou a nova coleção que combina performance e estilo para o seu dia a dia. <br><br>
                        Explore os modelos exclusivos das marcas que você confia e vista-se para impressionar.</p>
                </div>

                <div id="imagem_temp">

                    <h2>Nova <br> Temporada <br> Disponivel</h2>

                    <a class="btn btn-primary btn-temporada" href="produtos_geral.php" role="button">Explore o estilo</a>
                </div>
            </div>
        </section>
    </section>
    <!-- Fim Temporada -->

    <!-- Inicio Propaganda -->
    <section id="propaganda">
        <div class="container">
            <img src="assets/img/home/imagem1.jpg" alt="" loading="lazy">
            <img src="assets/img/home/imagem2.jpg" alt="" loading="lazy">
        </div>
    </section>
    <!-- Fim Propaganda -->

    <!-- Inico Marca -->
    <section id="marca">
        <div class="container">
            <h2>Principais Marcas</h2>
            <div id="cards_marc">
                <div class="card_marca">
                    <img class="img-base" src="assets/img/home/marca1.jpg" alt="Puma" loading="lazy">
                    <img class="img-hover" src="assets/img/home/marca1-hover.jpg" alt="Puma" loading="lazy">
                    <h3 class="texto-marca">Puma</h3>
                </div>

                <div class="card_marca">
                    <img class="img-base" src="assets/img/home/marca2.jpg" alt="Vans" loading="lazy">
                    <img class="img-hover" src="assets/img/home/marca2-hover.jpg" alt="Vans" loading="lazy">
                    <h3 class="texto-marca">Vans</h3>
                </div>

                <div class="card_marca">
                    <img class="img-base" src="assets/img/home/marca3.jpg" alt="Nike" loading="lazy">
                    <img class="img-hover" src="assets/img/home/marca3-hover.jpg" alt="Nike" loading="lazy">
                    <h3 class="texto-marca">Nike</h3>
                </div>

                <div class="card_marca">
                    <img class="img-base" src="assets/img/home/marca4.jpg" alt="Adidas" loading="lazy">
                    <img class="img-hover" src="assets/img/home/marca4-hover.jpg" alt="Adidas" loading="lazy">
                    <h3 class="texto-marca">Adidas</h3>
                </div>
            </div>
        </div>
    </section>
    <!-- fim  Marca -->

    <!-- Inicio populares -->
    <?php
    $sql = "SELECT codigo_produto,nome, preco_venda, foto, status_promocao,preco_promocao FROM produto LIMIT 8";

    $query = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($query) > 0) {
    ?>
        <section id="populares">
            <div class="container">
                <h2>populares</h2>
                <div id="produto_populares">
                    <?php foreach ($query as $produto) { ?>
                        <a href="produto.php?codigo_produto=<?php echo $produto['codigo_produto']; ?>" class='servico-populares'>
                            <?php
                            if (empty($produto['foto'])) {
                                echo '<img src="/info_52/pi/assets/img/placeholder-produto.png" class="w-100" alt="" loading="lazy" style="width: 45px; aspect-ratio: 1/1; object-fit: cover;">';
                            } else {
                                echo '<img src="/info_52/pi/images/produto/' . htmlspecialchars($produto['foto']) . '"  alt="" loading="lazy" style="width: 257px;  aspect-ratio: 1/1; object-fit: cover; ">';
                            }
                            ?>
                            <p><?php echo $produto['nome']; ?></p>
                            <?php renderizarPreco($produto); ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } ?>
    <!-- fim populares -->

    <!-- Inicio Propaganda-2 -->
    <section id="propaganda2">
        <div class="container">
            <div id="img-propaganda2">
                <img src="assets/img/home/rectangle1.jpg" alt="" loading="lazy">
            </div>

            <div id="imagem-propagandas2">
                <img style="margin-bottom: 7px;" src="assets/img/home/rectangle2.jpg" alt="" loading="lazy">
                <img style="margin-bottom: 7px;" src="assets/img/home/rectangle3.jpg" alt="" loading="lazy">
                <img src="assets/img/home/rectangle4.jpg" alt="" loading="lazy">
                <img src="assets/img/home/rectangle5.jpg" alt="" loading="lazy">
            </div>

        </div>
    </section>
    <!-- Fim Propaganda-2 -->

    <!-- Inico Sobre nos -->
    <section class="secao">
        <section id="sobre-nos">
            <div class="container">
                <div class="sobre-texto">
                <h2>Sobre Nós</h2>

                <p>A Route 52 nasceu com um objetivo claro: reunir as principais marcas de roupas, calçados e
                    acessórios em um só lugar, tornando a experiência de compra prática, rápida e confiável. <br>
                    Percebemos que muitos buscam qualidade, estilo e autenticidade, mas acabam perdendo tempo procurando
                    produtos originais em diferentes lojas. Por isso, criamos um espaço onde você encontra as marcas
                    mais desejadas, como Nike, Adidas, Puma, Vans e muitas outras marcas, tudo garantido e pronto para
                    chegar até você. <br></p>
                <p>Na Route 52, você encontra desde conjuntos esportivo até o casual, sempre com produtos que combinam
                    performance, conforto e atitude. Com o intuito de oferecer praticidade e estilo, conectando às
                    marcas. <br></p>
                <p>Mais do que uma loja, somos o ponto de encontro para quem valoriza autenticidade e bom gosto.
                    Trabalhamos para entregar uma experiência completa — do primeiro clique à chegada do pedido — com
                    segurança, transparência e dedicação. <br></p>
                <p>Porque acreditamos que se vestir bem é se sentir confiante, e queremos estar ao seu lado em cada
                    passo da sua rotina.</p>
                <div class="sobre-conteudo">
                    <p class="sobre-resumo">Mais que uma loja, a Route 52 &eacute; o ponto de encontro de quem busca marcas, conforto e atitude. Criada para acompanhar sua rotina, sua identidade e o seu caminho.</p>
                    <p class="sobre-origem"><strong>Route</strong> representa rota, movimento e a energia das ruas, com uma refer&ecirc;ncia ao universo dos carros. O <strong>52</strong> carrega nossa origem: a turma que deu vida a essa ideia.</p>

                </div>
                </div>
                <div class="sobre-pilares">
                        <div class="sobre-pilar">
                            <i class="fa-regular fa-compass"></i>
                            <h3>Estilo</h3>
                            <p>Sua identidade em cada escolha.</p>
                        </div>
                        <div class="sobre-pilar">
                            <i class="fa-regular fa-gem"></i>
                            <h3>Qualidade</h3>
                            <p>Marcas que inspiram confian&ccedil;a.</p>
                        </div>
                        <div class="sobre-pilar">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <h3>Praticidade</h3>
                            <p>Encontre tudo em um s&oacute; lugar.</p>
                        </div>
                    </div>
            </div>
        </section>
    </section>
    <!-- fim Sobre nos -->

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
                    <i class="fa-brands fa-facebook-f"></i>
                    <i class="fa-brands fa-x-twitter"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-linkedin-in"></i>
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
                    contato@route52.com.br
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

    <!-- Js Boostrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <!-- Js -->
    <script src="custom/js/script-site.js"></script>
    <script src="custom/js/header.js?v=3"></script>

    <!-- Toggle do menu mobile único (#navegacao) -->
    <script>
        (function () {
            var toggleBtn = document.getElementById('btn-menu-mobile');
            var nav = document.getElementById('navegacao');
            if (!toggleBtn || !nav) return;

            function fecharMenu() {
                nav.classList.remove('open');
                window.headerMenu.definirBotaoDoMenu(toggleBtn, false);
            }

            toggleBtn.addEventListener('click', function () {
                var aberto = nav.classList.toggle('open');
                window.headerMenu.definirBotaoDoMenu(toggleBtn, aberto);
            });

            nav.querySelectorAll('.linkmenu').forEach(function (link) {
                link.addEventListener('click', fecharMenu);
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') fecharMenu();
            });
        })();
    </script>
</body>

</html>
