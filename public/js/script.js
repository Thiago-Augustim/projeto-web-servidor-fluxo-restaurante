// Script mesas
let idMesaSelecionada = null;

// Adiciona evento de clique a cada card de mesa
document.querySelectorAll('.card-mesa').forEach(card => {
    card.addEventListener('click', function () {

        const mesa = JSON.parse(this.dataset.mesa);
        selecionarMesa(mesa);
    });
});

// Função para atualizar o painel lateral com os detalhes da mesa selecionada
function selecionarMesa(mesa) {
    document.getElementById('painel-numero').textContent = 'Mesa ' + mesa.numero;
    document.getElementById('painel-cadeiras').textContent = mesa.cadeiras;
    document.getElementById('painel-status').textContent = mesa.status;
    idMesaSelecionada = mesa.id;

}

// Adiciona evento de clique a cada item do dropdown de status
document.querySelectorAll('.status-mesa').forEach(item => {
    item.addEventListener('click', function (event) {
        event.preventDefault();
        const novoStatus = this.textContent;
        console.log('Novo status selecionado:', novoStatus);
        
    
    });
}); 

