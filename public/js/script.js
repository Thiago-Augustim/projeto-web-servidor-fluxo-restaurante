document.querySelectorAll('.card-mesa').forEach(card => {
    card.addEventListener('click', function() {
        
        const mesa = JSON.parse(this.dataset.mesa);
        selecionarMesa(mesa);
    });
});




    function selecionarMesa(mesa) {
        document.getElementById('painel-numero').textContent = 'Mesa ' + mesa.numero;
        document.getElementById('painel-cadeiras').textContent = mesa.cadeiras;
        document.getElementById('painel-status').textContent = mesa.status;
    }