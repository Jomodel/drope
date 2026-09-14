(function () {
    'use strict';

    function atualizarEstadoDoScroll() {
        var topo = document.getElementById('topo');
        if (topo) topo.classList.toggle('fixed-scroll', window.scrollY > 10);
    }

    function definirBotaoDoMenu(botao, aberto) {
        if (!botao) return;
        botao.classList.toggle('is-open', aberto);
        botao.setAttribute('aria-expanded', aberto ? 'true' : 'false');
        botao.setAttribute('aria-label', aberto ? 'Fechar menu de navegação' : 'Abrir menu de navegação');
    }

    atualizarEstadoDoScroll();
    window.addEventListener('scroll', atualizarEstadoDoScroll, { passive: true });

    var paineis = document.querySelectorAll('#topo .offcanvas[id]');
    for (var i = 0; i < paineis.length; i++) {
        var painel = paineis[i];
        var seletor = '[data-bs-target="#' + painel.id + '"]';
        var botao = document.querySelector('#topo ' + seletor);
        if (botao && botao.classList.contains('navbar-toggler')) {
            painel.addEventListener('show.bs.offcanvas', function () { definirBotaoDoMenu(document.getElementById('btn-menu-mobile'), true); });
            painel.addEventListener('hidden.bs.offcanvas', function () { definirBotaoDoMenu(document.getElementById('btn-menu-mobile'), false); });
        }
    }

    document.addEventListener('click', function (evento) {
        if (evento.target.classList.contains('linkmenu')) {
            var botao = document.getElementById('btn-menu-mobile');
            if (botao) definirBotaoDoMenu(botao, false);
        }
    });

    window.headerMenu = { definirBotaoDoMenu: definirBotaoDoMenu };

    var siteHeader = document.getElementById('site-header');
    if (siteHeader && siteHeader.classList.contains('site-header--home')) {
        var atualizarCabecalhoHome = function () {
            siteHeader.classList.toggle('is-scrolled', window.scrollY > 10);
        };
        atualizarCabecalhoHome();
        window.addEventListener('scroll', atualizarCabecalhoHome, { passive: true });
    }

    var menuPrincipal = document.getElementById('menuPrincipal');
    var acionadorMenu = document.querySelector('[data-bs-target="#menuPrincipal"]');
    if (menuPrincipal && acionadorMenu) {
        menuPrincipal.addEventListener('show.bs.offcanvas', function () { definirBotaoDoMenu(acionadorMenu, true); });
        menuPrincipal.addEventListener('hidden.bs.offcanvas', function () { definirBotaoDoMenu(acionadorMenu, false); });
    }
}());
