

//Animação de Seção
const secoes = document.querySelectorAll(".secao");

window.addEventListener("scroll", () => {
  secoes.forEach(secao => {
    const topo = secao.getBoundingClientRect().top;

    if (topo < window.innerHeight - 110) {
      secao.classList.add("aparecer");
    }
  });
});


// Scrol Menu
window.addEventListener('scroll', function(){
    if(window.scrollY >= 10)
    {
        document.querySelector('#topo').classList.add('fixed-scroll');
    }
    else
    {
        document.querySelector('#topo').classList.remove('fixed-scroll');
    }
})


//preço

  const rangeInput = document.getElementById('range4');
  const rangeOutput = document.getElementById('rangeValue');

  if (rangeInput && rangeOutput) {
    // Set initial value
    rangeOutput.textContent = rangeInput.value;

    rangeInput.addEventListener('input', function() {
      rangeOutput.textContent = this.value;
    });
  }




  

  



