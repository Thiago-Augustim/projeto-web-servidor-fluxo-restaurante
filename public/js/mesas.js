// Script mesas
let mesaSelecionada = [
    { id: null, numero: null, cadeiras: null, status: null },
]

// Adiciona evento de clique a cada card de mesa
document.getElementById('listaMesas').addEventListener('click', function (e) {
    const card = e.target.closest('.card-mesa');
    if (!card) return;

    const mesa = JSON.parse(card.dataset.mesa);
    console.log('Mesa selecionada:', mesa);
    selecionarMesa(mesa);
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


function cadastrarMesa() {
    const numero = document.getElementById('numero').value;
    const cadeiras = document.getElementById('cadeiras').value;
    const status = document.getElementById('status').value;

    if (!numero || !cadeiras) return alert('Preencha todos os campos.');

    adicionarCardMesa({ numero, cadeiras, status });

    bootstrap.Modal.getInstance(document.getElementById('modalMesa')).hide();
}

function adicionarCardMesa(mesa) {
    const col = document.createElement('div');
    col.className = 'col-6 col-sm-4 col-md-3 col-lg-3';
    col.innerHTML = `
        <div class="card text-center p-3 rounded card-mesa"
            style="background-color: var(--mesa${ucfirst(mesa.status)}Color);"
            data-mesa='${JSON.stringify(mesa)}'>
            <strong>Mesa ${mesa.numero}</strong>
            <span>Cadeiras: ${mesa.cadeiras}</span>
        </div>
    `;
    document.getElementById('listaMesas').appendChild(col);
}

function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}