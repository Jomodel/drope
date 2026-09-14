<?php
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

#CONEXAO BANCO DE DADO#
require_once __DIR__ . "/conexao/conecta.php";

$genero    = $_POST['genero']  ?? [];
$marca = $_POST['marca'] ?? [];
$categoria = $_POST['categoria'] ?? [];


$sql_count = "SELECT COUNT(*) AS quantidade FROM produto";
$query_count = mysqli_query($conexao, $sql_count);
$linha = mysqli_fetch_assoc($query_count);
$quantidade = $linha['quantidade'];

if (isset($_GET['page']) && !empty($_GET['page'])) {
    $paginaAtual = $_GET['page'];
} else {
    $paginaAtual = 1;
}

$url = "?page=";

// QUANTIDADE DE PRODUTOS EXBIDOS POR PAGINA
$paginaQtde = 3;
//  VALOR INICIAL PARA CLAUSULA LIMIT
$valorInicial = ($paginaAtual * $paginaQtde) - $paginaQtde;

$paginaFinal = ceil($quantidade / $paginaQtde);

$paginaInicial = 1;

$paginaProxima = $paginaAtual + 1;

$paginaAnterior = $paginaAtual - 1;


?>

<div id="produto_oferta">
    <?php
    $sql_geral = "SELECT produto.codigo_produto, produto.nome, produto.qtde_estoque, produto.preco_venda,produto.preco_promocao,produto.status_promocao, produto.status, produto.foto, marca.nome 'marca', categoria.nome 'categoria' FROM produto JOIN marca on produto.codigo_marca = marca.codigo_marca JOIN categoria on categoria.codigo_categoria = produto.codigo_categoria WHERE 1=1 AND produto.status = 1 ";

    //FILTRO POR CARGO    
    if (!empty($genero)) {
        $lista = implode("','", $genero);
        $sql_geral .= " AND produto.genero IN ('$lista')";
    }

    if (!empty($marca)) {
        $lista = implode(',', $marca);
        $sql_geral .= " AND produto.codigo_marca IN ($lista)";
    }

    if (!empty($categoria)) {
        $lista = implode(',', $categoria);
        $sql_geral .= " AND produto.codigo_categoria IN ($lista) ";
    }

    $sql_geral .= " LIMIT $valorInicial, $paginaQtde";

    $query_geral = mysqli_query($conexao, $sql_geral);

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
                <a class="page-link" href="<?php echo $url . $paginaInicial ?>">Início</a>
            </li>
        <?php } ?>

        <?php if ($paginaAtual >= 2) { ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $url . $paginaAnterior ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php } ?>

        <?php if ($paginaAtual != $paginaFinal) { ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $url . $paginaProxima ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="<?php echo $url . $paginaFinal ?>">Final</a>
            </li>
        <?php } ?>
    </ul>
