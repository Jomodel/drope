//Troca de imagem
document.addEventListener('DOMContentLoaded', function () {

    const imagemPrincipal = document.getElementById('imagem');

    document.querySelectorAll('.miniatura').forEach(function(miniatura) {
        miniatura.addEventListener('mouseover', function() {
            imagemPrincipal.src = this.src;
        });
    });

});

