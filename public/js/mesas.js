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




//codigo de mesa kayo ============================


// ── Pedidos e Modal ────────────────────────────
document.getElementById('btn-abrir-pedido').addEventListener('click', () => {
    if (!mesaSelecionada || !mesaSelecionada.numero) {
        alert('Selecione uma mesa primeiro');
        return;
    }
    const modal = new bootstrap.Modal(document.getElementById('modalNovoPedido'));
    modal.show();
    document.getElementById('label-mesa-produtos').textContent = 'Mesa ' + mesaSelecionada.numero;
});

function renderizarPedidosDaMesa() {
    const painel = document.getElementById('painel-pedidos');
    const lista  = pedidos.filter(p => p.mesa_id === mesaSelecionada.numero);

    if (!lista.length) {
        painel.innerHTML = '<p>Nenhum pedido para esta mesa.</p>';
        return;
    }

    painel.innerHTML = lista.map(p => `
        <div class="border rounded-3 p-2 mb-2 bg-white">
            <div class="d-flex justify-content-between mb-1">
                <strong class="small">Pedido #${String(p.id).padStart(3, '0')}</strong>
                <span class="badge bg-${p.status === 'aberto' ? 'success' : 'secondary'}">${p.status}</span>
            </div>
            <div class="small text-muted mb-1">${p.data_abertura} · ${p.itens.length} item(ns)</div>
            ${p.itens.map(i => `
                <div class="d-flex justify-content-between small">
                    <span>${i.nome_item} x${i.quantidade}</span>
                    <span class="text-muted">${i.status}</span>
                </div>
            `).join('')}
        </div>
    `).join('');
}

// ── Modal filtros, +/-, confirmar, reset ───────
const qtds = {};
const fmt  = v => 'R$ ' + Number(v).toFixed(2).replace('.', ',');
const agora = () => new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

document.querySelectorAll('.btn-filtro-cat').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.btn-filtro-cat').forEach(b => {
            b.classList.remove('btn-secondary', 'ativo');
            b.classList.add('btn-outline-secondary');
        });
        btn.classList.add('btn-secondary', 'ativo');
        btn.classList.remove('btn-outline-secondary');
        const cat = btn.dataset.cat;
        document.querySelectorAll('.produto-item').forEach(item => {
            item.style.display = (cat === 'todos' || item.dataset.cat === cat) ? '' : 'none';
        });
    });
});

function recalc() {
    let total = 0, qtdT = 0;
    document.querySelectorAll('#grid-produtos [data-id]').forEach(c => {
        const q = qtds[c.dataset.id] || 0;
        total += parseFloat(c.dataset.preco) * q;
        qtdT  += q;
    });
    document.getElementById('resumo-total').textContent = fmt(total);
    document.getElementById('resumo-qtd').textContent   = qtdT + ' item(ns)';
    document.getElementById('btn-confirmar-pedido').classList.toggle('disabled', qtdT === 0);
}

document.querySelectorAll('.btn-mais').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        qtds[id] = (qtds[id] || 0) + 1;
        document.getElementById('qty-' + id).textContent = qtds[id];
        recalc();
    });
});

document.querySelectorAll('.btn-menos').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        if ((qtds[id] || 0) > 0) {
            qtds[id]--;
            document.getElementById('qty-' + id).textContent = qtds[id];
            recalc();
        }
    });
});

document.getElementById('btn-confirmar-pedido').addEventListener('click', () => {
    if (!mesaSelecionada || !mesaSelecionada.numero) return;
    const itens = [];
    document.querySelectorAll('#grid-produtos [data-id]').forEach(c => {
        const q = qtds[c.dataset.id] || 0;
        if (q > 0) itens.push({
            nome_item:  c.dataset.nome,
            tipo:       c.dataset.tipo,
            quantidade: q,
            status:     'pendente',
            hora:       agora(),
            subtotal:   parseFloat(c.dataset.preco) * q
        });
    });
    pedidos.push({
        id:            pedidos.length + 1,
        mesa_id:       mesaSelecionada.numero,
        status:        'aberto',
        data_abertura: agora(),
        itens
    });
    renderizarPedidosDaMesa();
    bootstrap.Modal.getInstance(document.getElementById('modalNovoPedido')).hide();
});

document.getElementById('modalNovoPedido').addEventListener('hidden.bs.modal', () => {
    Object.keys(qtds).forEach(k => {
        qtds[k] = 0;
        const el = document.getElementById('qty-' + k);
        if (el) el.textContent = '0';
    });
    document.getElementById('resumo-total').textContent = 'R$ 0,00';
    document.getElementById('resumo-qtd').textContent   = '0 item(ns)';
    document.getElementById('btn-confirmar-pedido').classList.add('disabled');
});


