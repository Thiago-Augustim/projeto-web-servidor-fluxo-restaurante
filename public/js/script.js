// Script mesas
let mesaSelecionada =[
    { id: null, numero: null, cadeiras: null, status: null },
]

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
    mesaSelecionada = mesa;

}

// Adiciona evento de clique a cada item do dropdown de status
document.querySelectorAll('.status-mesa').forEach(item => {
    item.addEventListener('click', function (event) {
        event.preventDefault();
        const novoStatus = this.textContent;

        console.log('Mesa selecionada Antes:', mesaSelecionada);
        mesaSelecionada.status = novoStatus;

        console.log('Status atualizado na mesa selecionada:', mesaSelecionada);

        // Atualiza o texto do botão de status no painel lateral
        document.getElementById('painel-status').textContent = novoStatus;  

        //Aqui encaminhará um put para o servidor para atualizar o status da mesa no backend,
        // mas por enquanto, vamos apenas atualizar a cor do card da mesa no frontend
        //se o backend retornar sucesso, atualizamos a cor do card da mesa

        atualizarCorMesa(mesaSelecionada, novoStatus);
        
    });
}); 

function atualizarCorMesa(mesa, novoStatus) {
    const card = [...document.querySelectorAll('.card-mesa')]
        .find(c => JSON.parse(c.dataset.mesa).numero === mesa.numero);

    if (card) {
        card.style.backgroundColor = `var(--mesa${novoStatus}Color)`;
        mesa.status = novoStatus.toLowerCase();
        card.dataset.mesa = JSON.stringify(mesa);
    }
}


document.querySelectorAll('.card-funcionario').forEach(card => {
    card.addEventListener('click', () => {
        const dados = JSON.parse(card.dataset.funcionario);

        document.getElementById('painel-nome').innerText = dados.nome;
        document.getElementById('painel-id').innerHTML = "<b>" + dados.id + "</b>";
        document.getElementById('painel-especialidade').innerHTML = "<b>" + dados.especialidade + "</b>";
    });
});



