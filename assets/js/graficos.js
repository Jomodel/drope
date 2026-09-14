var cores = ['#202124', '#667085', '#9f3a3a', '#98a2b3', '#475467'];

var graficoVendas = document.getElementById('vendasSemana');
if (graficoVendas) {
    new Chart(graficoVendas, {
        type: 'line',
        data: {
            labels: datasVendas,
            datasets: [{
                label: 'Faturamento em R$',
                data: valoresVendas,
                borderColor: '#202124',
                backgroundColor: 'rgba(32, 33, 36, 0.10)',
                fill: true,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

var graficoPagamento = document.getElementById('formasPagamento');
if (graficoPagamento) {
    new Chart(graficoPagamento, {
        type: 'doughnut',
        data: {
            labels: nomesPagamento,
            datasets: [{
                data: quantidadesPagamento,
                backgroundColor: cores
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

var graficoProdutos = document.getElementById('produtosVendidos');
if (graficoProdutos) {
    new Chart(graficoProdutos, {
        type: 'bar',
        data: {
            labels: nomesProdutos,
            datasets: [{
                label: 'Quantidade vendida',
                data: quantidadesProdutos,
                backgroundColor: cores
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false
        }
    });
}
