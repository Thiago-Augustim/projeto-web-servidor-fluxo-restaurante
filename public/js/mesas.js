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
    document.getElementById('painel-status').value = mesa.status;

    mesaSelecionada = mesa;

    document.querySelectorAll('.input-mesa-id').forEach(input => {
        input.value = mesa.id;
    });

    renderizarPedidos(mesa.id);
}

function renderizarPedidos(mesaId) {
    const pedidosDaMesa = todosPedidos.filter(p => p.mesa_id == mesaId);
    const lista = document.getElementById('lista-pedidos');

    if (pedidosDaMesa.length === 0) {
        lista.innerHTML = '<p class="text-muted">Nenhum pedido ainda.</p>';
        document.getElementById('total-pedidos').textContent = '0,00';
        return;
    }

    let total = 0;
    let html = '<ul class="list-group">';

    pedidosDaMesa.forEach(p => {
        const itens = p.itens ?? [{ nome: p.item ?? '?', preco: p.preco ?? 0, qtd: 1 }];
        
        itens.forEach(item => {
            total += parseFloat(item.preco) * item.qtd;
            html += `<li class="list-group-item d-flex justify-content-between">
                <span>${item.qtd}x ${item.nome}</span>
                <span>R$ ${(parseFloat(item.preco) * item.qtd).toFixed(2).replace('.', ',')}</span>
            </li>`;
        });
    });

    html += '</ul>';
    lista.innerHTML = html;
    document.getElementById('total-pedidos').textContent = total.toFixed(2).replace('.', ',');
}

// Adiciona evento de clique a cada item do dropdown de status
document.querySelectorAll('.status-mesa').forEach(item => {
    item.addEventListener('click', function (event) {
        event.preventDefault();

        const novoStatus = this.dataset.status; // ← correção aqui

        // Atualiza o texto do botão de status no painel lateral
        atualizarCorMesa(mesaSelecionada, novoStatus);

    });
});

/*function atualizarCorMesa(mesa, novoStatus) {
    const card = [...document.querySelectorAll('.card-mesa')]
        .find(c => JSON.parse(c.dataset.mesa).numero === mesa.numero);

    if (card) {
        card.style.backgroundColor = `var(--mesa${novoStatus}Color)`;
        mesa.status = ucfirst(novoStatus);
        card.dataset.mesa = JSON.stringify(mesa);
    }
}*/


/*function cadastrarMesa() {
    const numero = document.getElementById('numero').value;
    const cadeiras = document.getElementById('cadeiras').value;
    const status = ucfirst(document.getElementById('status').value);

    adicionarCardMesa({ numero, cadeiras, status });

    bootstrap.Modal.getInstance(document.getElementById('modalMesa')).hide();
}*/

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