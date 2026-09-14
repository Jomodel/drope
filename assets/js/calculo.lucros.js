function calcular() {

    var n1 = parseFloat(document.getElementById('preco_custo').value);
    var n2 = parseFloat(document.getElementById('lucro').value);

    var lucro = n1 + n1 * (n2 / 100);

    document.getElementById('preco_venda').value = lucro.toFixed(2);

}


