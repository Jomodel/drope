<?php
require_once __DIR__ . '/../conexao/conecta.php';

if (!isset($_SESSION)) {
    session_start();
}

if (empty($_SESSION['USER'])) {
    $_SESSION['NaoAutorizado'] = "Apenas usuários cadastrados podem acessar esta área!";
    header("Location: Index.php");
    exit;
}

$query = mysqli_query($conexao, "SELECT COUNT(*) AS total FROM produto WHERE status = 1");
$linha = mysqli_fetch_assoc($query);
$totalProdutos = (int) $linha['total'];

$query = mysqli_query($conexao, "SELECT COUNT(*) AS total FROM cliente WHERE status = 1");
$linha = mysqli_fetch_assoc($query);
$totalClientes = (int) $linha['total'];

$query = mysqli_query($conexao, "SELECT SUM(qtde_estoque) AS total, SUM(qtde_estoque * preco_venda) AS valor FROM produto WHERE status = 1");
$linha = mysqli_fetch_assoc($query);
$totalEstoque = (int) $linha['total'];
$valorTotalEstoque = (float) $linha['valor'];

$query = mysqli_query($conexao, "SELECT COUNT(*) AS total FROM produto WHERE status = 1 AND qtde_estoque <= 10");
$linha = mysqli_fetch_assoc($query);
$produtosEstoqueBaixo = (int) $linha['total'];

$inicioMes = date('Y-m-01 00:00:00');
$query = mysqli_query($conexao, "SELECT COUNT(*) AS quantidade, SUM(valor_total) AS faturamento, AVG(valor_total) AS ticket_medio FROM venda WHERE data_venda >= '$inicioMes'");
$resumoMes = mysqli_fetch_assoc($query);

$inicioSemana = date('Y-m-d', strtotime('-6 days'));
$queryVendasSemana = mysqli_query($conexao, "SELECT DATE(data_venda) AS data, SUM(valor_total) AS total FROM venda WHERE data_venda >= '$inicioSemana' GROUP BY DATE(data_venda) ORDER BY data");
$queryFormasPagamento = mysqli_query($conexao, "SELECT forma_pagamento AS nome, COUNT(*) AS quantidade FROM venda GROUP BY forma_pagamento ORDER BY quantidade DESC");
$queryProdutosVendidos = mysqli_query($conexao, "SELECT produto.nome, SUM(item_produto.quantidade) AS quantidade FROM item_produto INNER JOIN produto ON produto.codigo_produto = item_produto.codigo_produto GROUP BY produto.codigo_produto, produto.nome ORDER BY quantidade DESC LIMIT 5");
$queryUltimasVendas = mysqli_query($conexao, "SELECT venda.codigo_venda, venda.data_venda, venda.forma_pagamento, venda.valor_total, cliente.nome AS cliente, funcionario.nome AS funcionario FROM venda LEFT JOIN cliente ON cliente.codigo_cliente = venda.codigo_cliente LEFT JOIN funcionario ON funcionario.codigo_funcionario = venda.codigo_funcionario ORDER BY venda.data_venda DESC LIMIT 6");

$ultimasVendas = [];
while ($venda = mysqli_fetch_assoc($queryUltimasVendas)) {
    $ultimasVendas[] = $venda;
}

$nomesMeses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
$mesAtual = $nomesMeses[(int) date('n')] . ' de ' . date('Y');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | EstiloMix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../assets/css/dashboard.min.css">
  <link rel="stylesheet" href="../assets/css/styles.min.css">
  <link rel="stylesheet" href="../custom/admin.css?v=6">
  <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">
</head>
<body class="admin-body">
  <?php include('Topo.php'); ?>

  <div class="container-fluid">
    <div class="row">
      <?php include('Navegacao.php'); ?>

      <main class="admin-main ms-auto col-lg-10 px-md-4">
        <?php include('Log.php'); ?>

        <?php if (isset($_SESSION['NaoAdm'])): ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['NaoAdm']); unset($_SESSION['NaoAdm']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
          </div>
        <?php endif; ?>

        <header class="dashboard-heading">
          <div>
            <span class="dashboard-eyebrow">Visão geral da loja</span>
            <h1>Olá, <?php echo htmlspecialchars($_SESSION['NAME'] ?? 'Administrador'); ?>!</h1>
            <p>Acompanhe vendas, estoque e desempenho em um só lugar.</p>
          </div>
          <div class="dashboard-date"><i class="bi bi-calendar3"></i> <?php echo htmlspecialchars($mesAtual); ?></div>
        </header>

        <section class="dashboard-kpis" aria-label="Indicadores principais">
          <article class="dashboard-kpi dashboard-kpi--red">
            <div class="dashboard-kpi__icon"><i class="bi bi-graph-up-arrow"></i></div>
            <div><span>Faturamento no mês</span><strong>R$ <?php echo number_format((float) $resumoMes['faturamento'], 2, ',', '.'); ?></strong><small><?php echo (int) $resumoMes['quantidade']; ?> vendas realizadas</small></div>
          </article>
          <article class="dashboard-kpi">
            <div class="dashboard-kpi__icon"><i class="bi bi-receipt"></i></div>
            <div><span>Ticket médio</span><strong>R$ <?php echo number_format((float) $resumoMes['ticket_medio'], 2, ',', '.'); ?></strong><small>Valor médio por venda</small></div>
          </article>
          <article class="dashboard-kpi">
            <div class="dashboard-kpi__icon"><i class="bi bi-box-seam"></i></div>
            <div><span>Itens no estoque</span><strong><?php echo number_format($totalEstoque, 0, ',', '.'); ?></strong><small><?php echo $totalProdutos; ?> produtos ativos</small></div>
          </article>
          <article class="dashboard-kpi <?php echo $produtosEstoqueBaixo > 0 ? 'dashboard-kpi--warning' : ''; ?>">
            <div class="dashboard-kpi__icon"><i class="bi bi-exclamation-triangle"></i></div>
            <div><span>Estoque baixo</span><strong><?php echo $produtosEstoqueBaixo; ?></strong><small>Produtos com até 10 unidades</small></div>
          </article>
        </section>

        <section class="dashboard-secondary">
          <div><i class="bi bi-people"></i><span>Clientes ativos</span><strong><?php echo $totalClientes; ?></strong></div>
          <div><i class="bi bi-tags"></i><span>Produtos ativos</span><strong><?php echo $totalProdutos; ?></strong></div>
          <div><i class="bi bi-boxes"></i><span>Valor do estoque</span><strong>R$ <?php echo number_format($valorTotalEstoque, 2, ',', '.'); ?></strong></div>
        </section>

        <div class="row g-4 mt-1">
          <div class="col-12 col-xl-8">
            <section class="dashboard-panel h-100">
              <div class="dashboard-panel__heading"><div><span>Desempenho</span><h2>Vendas dos últimos 7 dias</h2></div><i class="bi bi-bar-chart-line"></i></div>
              <div class="dashboard-chart dashboard-chart--wide"><canvas id="vendasSemana"></canvas></div>
            </section>
          </div>
          <div class="col-12 col-xl-4">
            <section class="dashboard-panel h-100">
              <div class="dashboard-panel__heading"><div><span>Preferência</span><h2>Formas de pagamento</h2></div><i class="bi bi-credit-card"></i></div>
              <div class="dashboard-chart"><canvas id="formasPagamento"></canvas></div>
            </section>
          </div>
        </div>

        <div class="row g-4 mt-1 mb-4">
          <div class="col-12 col-xl-5">
            <section class="dashboard-panel h-100">
              <div class="dashboard-panel__heading"><div><span>Ranking</span><h2>Produtos mais vendidos</h2></div><i class="bi bi-trophy"></i></div>
              <div class="dashboard-chart"><canvas id="produtosVendidos"></canvas></div>
            </section>
          </div>
          <div class="col-12 col-xl-7">
            <section class="dashboard-panel h-100">
              <div class="dashboard-panel__heading"><div><span>Movimentação</span><h2>Últimas vendas</h2></div><i class="bi bi-clock-history"></i></div>
              <div class="table-responsive">
                <table class="table dashboard-table align-middle">
                  <thead><tr><th>Venda</th><th>Cliente</th><th>Pagamento</th><th>Data</th><th class="text-end">Total</th></tr></thead>
                  <tbody>
                    <?php if (empty($ultimasVendas)): ?>
                      <tr><td colspan="5" class="text-center text-muted py-5">Nenhuma venda registrada.</td></tr>
                    <?php else: ?>
                      <?php foreach ($ultimasVendas as $venda): ?>
                        <tr>
                          <td><span class="dashboard-sale-id">#<?php echo (int) $venda['codigo_venda']; ?></span></td>
                          <td><strong><?php echo htmlspecialchars($venda['cliente'] ?: 'Não informado'); ?></strong><small><?php echo htmlspecialchars($venda['funcionario'] ?: 'Sem funcionário'); ?></small></td>
                          <td><span class="dashboard-payment"><?php echo htmlspecialchars($venda['forma_pagamento']); ?></span></td>
                          <td><?php echo date('d/m/Y H:i', strtotime($venda['data_venda'])); ?></td>
                          <td class="text-end fw-bold">R$ <?php echo number_format((float) $venda['valor_total'], 2, ',', '.'); ?></td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </section>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    var datasVendas = [];
    var valoresVendas = [];
    <?php while ($vendaDia = mysqli_fetch_assoc($queryVendasSemana)): ?>
      datasVendas.push('<?php echo date('d/m', strtotime($vendaDia['data'])); ?>');
      valoresVendas.push(<?php echo (float) $vendaDia['total']; ?>);
    <?php endwhile; ?>

    var nomesPagamento = [];
    var quantidadesPagamento = [];
    <?php while ($pagamento = mysqli_fetch_assoc($queryFormasPagamento)): ?>
      nomesPagamento.push('<?php echo addslashes($pagamento['nome']); ?>');
      quantidadesPagamento.push(<?php echo (int) $pagamento['quantidade']; ?>);
    <?php endwhile; ?>

    var nomesProdutos = [];
    var quantidadesProdutos = [];
    <?php while ($produtoVendido = mysqli_fetch_assoc($queryProdutosVendidos)): ?>
      nomesProdutos.push('<?php echo addslashes($produtoVendido['nome']); ?>');
      quantidadesProdutos.push(<?php echo (int) $produtoVendido['quantidade']; ?>);
    <?php endwhile; ?>
  </script>
  <script src="../assets/js/graficos.js?v=6"></script>
</body>
</html>
