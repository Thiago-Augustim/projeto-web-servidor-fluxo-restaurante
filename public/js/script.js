


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


