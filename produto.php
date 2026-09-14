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
<link rel="stylesheet" href="custom/css/style-produto.css?v=9">
    <link rel="stylesheet" href="custom/css/style.css?v=20">

    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">

</head>

<body class="produto-page">
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
                            <?php if ($produtoCarrinho['status_promocao'] == 0){
                                 $precoVenda = $produtoCarrinho['preco_venda'];
                                $precoVendaC = $quantidade * $precoVenda; 
                                ?>
                                          <strong>R$ <?php echo number_format($precoVendaC, 2, ',', '.'); ?></strong>
                            
                            <?php }else
                            {
                                $precoPromocao = $produtoCarrinho['preco_promocao'];
                                $precoVendaD = $quantidade * $precoPromocao; 
                                ?>
                                          <strong>R$ <?php echo number_format($precoVendaD, 2, ',', '.'); ?></strong>
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

                <div class="hamburger_menu">
                    <nav class="navbar bg-body-tertiary fixed-top">
                        <div class="container-fluid">
                            <div id="img-logo">
                                <a href="index.php">
                                    <img src="assets/img/home/logo.png" alt="">
                                </a>
                            </div>

                            <a class="navbar-brand" href="#">

                                

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
                                        <input class="form-control me-2" type="search" name="busca" placeholder="Search"
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

    <!-- Inicio Produto -->
    <div id="produto">
        <div class="container">
            <div id="volt-btn">
                <div id="voltar">
                    <a href="index.php" class="volt-ini">Inicio</a>
                    <p>/</p>
                    <a href="produtos.php" class="volt-ini">Calçados</a>
                    <p>/</p>
                    <a href="#">Tenis</a>
                </div>
                <?php if (isset($_GET['codigo_produto']) && $_GET['codigo_produto'] != '' ) {
                    $codigo = $_GET['codigo_produto'];
                    

                    $sql = "SELECT  * FROM produto WHERE codigo_produto = $codigo";

                    $query = mysqli_query($conexao, $sql);

                    $produto = mysqli_fetch_assoc($query);

                    $categoria = $produto['codigo_categoria'];
                ?>
                    <div id="venda-produto">
                        <div class="galeria d-flex flex-column gap-4">
                            <?php

                            if (empty($produto['foto'])) {
                                echo '<img src="/info_52/pi/assets/img/placeholder-produto.png" class="w-100" alt="" name="imagem" class="miniatura" style="width: 90px; height:90px; aspect-ratio: 1/1; object-fit: cover; margin-right: 10px;">';
                            } else {
                                echo '<img src="/info_52/pi/images/produto/' . htmlspecialchars($produto['foto']) . '"  alt="" name="imagem" class="miniatura border border-secondary" style="width: 90px; height:90px; aspect-ratio: 1/1; object-fit: cover; margin-right: 10px; ">';
                            }

                            if (empty($produto['galeria_foto1'])) {
                                echo '<img src="/info_52/pi/assets/img/placeholder-produto.png" alt="" name="imagem" class="miniatura border border-secondary" style="width: 90px; height:90px; aspect-ratio: 1/1; object-fit: cover; margin-right: 10px;">';
                            } else {
                                echo '<img src="/info_52/pi/images/produto/' . htmlspecialchars($produto['galeria_foto1']) . '"  alt="" name="imagem" class="miniatura border border-secondary" style="width: 90px; height:90px; aspect-ratio: 1/1; object-fit: cover; margin-right: 10px; ">';
                            }

                            if (empty($produto['galeria_foto2'])) {
                                echo '<img src="/info_52/pi/assets/img/placeholder-produto.png" alt="" name="imagem" class="miniatura border border-secondary" style="width: 90px; height:90px; aspect-ratio: 1/1; object-fit: cover; margin-right: 10px;">';
                            } else {
                                echo '<img src="/info_52/pi/images/produto/' . htmlspecialchars($produto['galeria_foto2']) . '"  alt="" name="imagem" class="miniatura border border-secondary" style="width: 90px; height:90px; aspect-ratio: 1/1; object-fit: cover; margin-right: 10px; ">';
                            }

                            if (empty($produto['galeria_foto3'])) {
                                echo '<img src="/info_52/pi/assets/img/placeholder-produto.png" alt="" name="imagem" class="miniatura border border-secondary" style="width: 90px; height:90px; aspect-ratio: 1/1; object-fit: cover; margin-right: 10px;">';
                            } else {
                                echo '<img src="/info_52/pi/images/produto/' . htmlspecialchars($produto['galeria_foto3']) . '"  alt="" name="imagem" class="miniatura border border-secondary" style="width: 90px; height:90px; aspect-ratio: 1/1; object-fit: cover; margin-right: 10px; ">';
                            }

                            if (empty($produto['galeria_foto4'])) {
                                echo '<img src="/info_52/pi/assets/img/placeholder-produto.png" alt="" name="imagem" class="miniatura border border-secondary" style="width: 90px; height:90px; aspect-ratio: 1/1; object-fit: cover; margin-right: 10px;">';
                            }
                             else {
                                echo '<img src="/info_52/pi/images/produto/' . htmlspecialchars($produto['galeria_foto4']) . '"  alt="" name="imagem" class="miniatura border border-secondary" style="width: 90px; height:90px; aspect-ratio: 1/1; object-fit: cover; margin-right: 10px; ">';
                            }
                            ?>
                        </div>

                        <?php
                        if (empty($produto['foto'])) {
                            echo '<img src="/info_52/pi/assets/img/placeholder-produto.png" class="w-100" alt="" name="imagem" id="imagem" style="width: 600px; aspect-ratio: 1/1; object-fit: cover;">';
                        } else {
                            echo '<img src="/info_52/pi/images/produto/' . htmlspecialchars($produto['foto']) . '"  alt="" name="imagem" id="imagem" class="border border-secondary" style="width: 100%; max-width: 546px; aspect-ratio: 1/1; object-fit: cover; ">';
                        }
                        ?>
                        <div id="metodo-compra">
                            <div id="nome">
                                <h2> <?php echo $produto['nome'] ?></h2>
                                <div id="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <p>4,5</p>
                                </div>
                            </div>


                            <div class="produto-preco-detalhe">
                                <?php renderizarPrecoCard($produto); ?>
                            </div>

                            <div id="tamanho">
                                <h2>Tamanho:</h2>
                                <div id="btns">
                                    <div class="btns-passar"><a href="#"><?php echo $produto['tamanho'] ?></a></div>
                                </div>
                            </div>

                            <div id="cores">
                                <h2>Cores:</h2>
                                <div id="cor-tenis">
                                    <div class="tenis">
                                        <?php echo '<img src="/info_52/pi/images/produto/' . htmlspecialchars($produto['foto']) . '"  alt="" name="imagem" id="imagem" style="width: 100%; max-width: 60px; max-height: 60px;  aspect-ratio: 1/1; object-fit: cover; ">'; ?>
                                        <p><?php echo $produto['cor'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <div id="compra">
                                <div id="btn-compra">
                                    <a href="adicionar_carrinho.php?codigo_produto=<?php echo $produto['codigo_produto']; ?>" >
                                        Adicionar ao Carrinho
                                    </a>
                                </div>
                                <div id="btn-desejo">
                                    <a href="#" id="btn-favoritar" onclick="return toggleFavorito(this)">
                                        <i class="fa-regular fa-heart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

            </div>
            <div id="importante">
                <div class="container mt-5">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <div class="linha"></div>
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Avaliações [10]
                                    <div id="star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star-half-stroke"></i>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div id="star-comenta">

                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star-half-stroke"></i>

                                        <div id="btn-comentar">
                                            <a href="#">Escrever um comentario</a>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <div class="linha"></div>
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Descrição
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body" id="descricao">
                                    <p><?php echo $produto['descricao'] ?></p>
                                    <?php echo '<img src="/info_52/pi/images/produto/' . htmlspecialchars($produto['foto']) . '"  alt="" name="imagem" id="imagem" style="width: 100%; max-width: 230px;  aspect-ratio: 1/1; object-fit: cover; ">'; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
    </div>
    <!-- fim Produto -->

    <!-- Inico Gostar -->
    <?php
   
    $sql = "SELECT codigo_produto,nome, preco_venda, foto, status_promocao,preco_promocao FROM produto WHERE codigo_produto != $codigo AND codigo_categoria = $categoria LIMIT 3";

    $query = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($query) > 0) {
    ?>
        <div id="gostar">
            <div class="container">
                <h2>Você tambem pode gostar</h2>
                <div class="linha"></div>

                <div id="gostar-produto">
                    <?php foreach ($query as $produto) { ?>
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
            </div>
        </div>
    <?php } ?>
    <!-- Fim Gostar -->
    <div id="propaganda">
        <img src="assets/img/produto/propaganda.jpg" alt="">
    </div>

    <!-- Inico outros -->
    <?php
    $sql = "SELECT  codigo_produto,nome, preco_venda, foto, status_promocao,preco_promocao FROM produto WHERE codigo_produto != $codigo AND codigo_categoria != $categoria LIMIT 3";

    $query = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($query) > 0) {
    ?>
        <div id="outros">
            <div class="container">
                <h2>Outros tambem compraram</h2>
                <div class="linha"></div>

                <div id="outros-produto">
                    <?php foreach ($query as $produto) { ?>
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
            </div>
        </div>
    <?php } ?>
    <!-- Fim outros -->

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


                    <i class="fa-brands fa-linkedin-in "></i>

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
                <p>Ganhe 15% na primeira compra e descubra as novidades antes:</p>
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

    <style>
        @media (max-width: 767.98px) {
            #produto > .container,
            #produto #volt-btn,
            #produto #venda-produto {
                display: flex !important;
                flex-direction: column !important;
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
            }

            #produto #venda-produto > img#imagem,
            #produto #metodo-compra {
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
                margin-left: 0 !important;
            }

            #produto #venda-produto > img#imagem { object-fit: contain !important; }
            #produto #venda-produto > .galeria { gap: 10px !important; }
            #produto #venda-produto > .galeria img { width: 86px !important; height: 86px !important; margin-right: 0 !important; }
            #produto #btns { width: auto !important; }
            #produto .btns-passar { width: 60px !important; height: 60px !important; }
            #produto #compra { display: flex !important; width: 100% !important; }
            #produto #btn-compra { flex: 1 !important; width: auto !important; }
            #produto #btn-desejo { flex: 0 0 58px !important; width: 58px !important; }
        }
    </style>

    <!-- Js Boostrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <!-- Js -->
    <script src="custom/js/script-site.js"></script>
    <script src="custom/js/header.js?v=3"></script>
    <!-- Js imagem -->
    <script src="custom/js/script-imagem.js"></script>
    <!-- Js favorito -->
    <script>
        function toggleFavorito(el) {
            const icone = el.querySelector('i');
            icone.classList.toggle('fa-regular');
            icone.classList.toggle('fa-solid');
            icone.classList.toggle('favoritado');
            return false;
        }
    </script>
</body>

</html>
