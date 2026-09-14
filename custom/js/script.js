document.getElementById('foto').addEventListener('change', function(event){
    let arquivo = event.target.files[0];

    if(arquivo)
    {
        document.getElementById('imagem').src = URL.createObjectURL(arquivo);
    }
})