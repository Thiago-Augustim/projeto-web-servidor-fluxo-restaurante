// Clique em card de pedido
document.getElementById('listaPedidos').addEventListener('click', function (e) {
    const card = e.target.closest('.card-pedido');
    if (!card) return;

    document.querySelectorAll('.card-pedido').forEach(c => c.style.outline = 'none');
    card.style.outline = '2px solid var(--buttonsColor)';

    const pedido = JSON.parse(card.dataset.pedido);
    atualizarPainel(pedido);
});

function atualizarPainel(pedido) {
    document.getElementById('painel-titulo').innerHTML = 'PEDIDO<br>#' + pedido.id;
    document.getElementById('painel-mesa').textContent  = (pedido.numeroMesa).padStart(2, '0');
    document.getElementById('input-pedido-id').value    = pedido.id;

    const container = document.getElementById('painel-itens');
    if (!pedido.itens|| pedido.itens.length === 0) {
        container.innerHTML = '<p class="text-muted">Sem itens.</p>';
        return;
    }
    const itensPedido = pedido.itens;
    console.log(itensPedido);

   let html = '';
    Object.values(pedido.itens).forEach(item => {
       
        
        const nome = item.nome || 'Item';
        const quantidade  = item.quantidade;
        const preco = item.preco ? `R$ ${parseFloat(item.preco).toFixed(2)}` : '';
        console.log(nome);
        console.log(quantidade);
        console.log(preco);

        html += `
        <div class="bg-light border rounded-3 p-2 mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <strong>${nome}</strong>
                <span class="badge bg-primary rounded-pill">${quantidade}x</span>
            </div>
            
        </div>`;
    });

    // 4. Injeta o HTML construído no container
    container.innerHTML = html;
}

// Filtros por status
document.querySelectorAll('.btn-filtro').forEach(btn => {
    btn.addEventListener('click', function () {
        const status = this.dataset.status;
        document.querySelectorAll('.card-pedido').forEach(card => {
            if (status === 'todos' || card.dataset.status === status) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
});