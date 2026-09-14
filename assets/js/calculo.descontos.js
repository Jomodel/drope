function alternarDesconto() {
    // 1. Seleciona os elementos
    const Status = document.getElementById('status_desconto');
    const Desconto = document.getElementById('desconto');
    const vendaDesconto = document.getElementById('preco_desconto');

        

    // 2. Verifica o valor selecionado
    // value "2" é Ativado
    if (Status.value === "1") {
        Desconto.disabled = false; 
        Desconto.focus();         
                                       
    } else {
        Desconto.disabled = true;  
        Desconto.value = "";   
        vendaDesconto.value = "";    
    }
    
}

function calculoDesconto(){
     var n1 = parseFloat(document.getElementById('desconto').value);
        var n2 = document.getElementById('preco_venda').value;
        var lucro = parseFloat(document.getElementById('lucro').value);
        

        if (n2 === "")
        {
             alert("Por favor, preencha todos os campos.");
             return;
        }
        
            var n2 = parseFloat(n2);
            if(n1 > lucro){
                document.getElementById('preco_desconto').value = 0;
                 alert("Desconto inválido! O valor do desconto excede o lucro ");
                 
            }
            else{
                var desconto = n2 - n2 * (n1/100);
                document.getElementById('preco_desconto').value = desconto.toFixed(2);
                
            }
                
            
                    
}