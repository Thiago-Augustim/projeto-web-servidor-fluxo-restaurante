// Script mesas
let mesaSelecionada =
    { id: null, numero: null, cadeiras: null, status: null };


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


    console.log('Atualizando painel lateral com a mesa:', mesa);
    mesaSelecionada = mesa;

    document.querySelectorAll('.input-mesa-id').forEach(input => {
        input.value = mesa.id;
    });

    document.getElementById('input-mesa-id-pedido').value = mesa.id;
    document.getElementById('input-mesa-status-pedido').value = mesa.status;

}

// Adiciona evento de clique a cada item do dropdown de status
document.querySelectorAll('.status-mesa').forEach(item => {
    item.addEventListener('click', function (event) {
        event.preventDefault();

        // Atualiza o texto do botão de status no painel lateral
        atualizarCorMesa(mesaSelecionada, novoStatus);

    });
});

function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

document.addEventListener("DOMContentLoaded", function () {
    const modalElement = document.getElementById('modalCardapio');
    const btnAdicionar = document.getElementById('btn-adicionar-pedido');

    let modalCardapio = null;
    if (modalElement && typeof bootstrap !== 'undefined') {
        modalCardapio = new bootstrap.Modal(modalElement);
    }

    //Validação da mesa
    btnAdicionar.addEventListener('click', function (e) {
        e.preventDefault();
        const inputMesaId = document.getElementById('input-mesa-id-pedido');
        const inputMesaStatus = document.getElementById('input-mesa-status-pedido');

        if (inputMesaId.value === "" || inputMesaStatus.value !== 'ocupada') {
            exibirErro("Selecione uma mesa ocupada!");
            return;
        }

        modalCardapio.show();
    });

    //Preenche os dados nos inputs no modal somente quando estiver carregado
    modalElement.addEventListener('shown.bs.modal', function () {
        const idDaMesa = document.getElementById('input-mesa-id-pedido').value;
        
        console.log("Modal aberto! Sincronizando mesa agora: " + idDaMesa);

        // Preenche o input 
        const inputModal = document.getElementById('input-mesa-pedido');
        if (inputModal) inputModal.value = idDaMesa;

        // Preenche o texto visual
        const divExibirMesa = document.getElementById('display-numero-mesa');
        if (divExibirMesa) {

            // Se mesaSelecionada.numero falhar, usamos o ID que está no log
            divExibirMesa.innerText = "Mesa: " + (mesaSelecionada.numero || idDaMesa);
        }
    });
});



function exibirErro(mensagem) {
    const container = document.getElementById('container-erros');
    const htmlErro = `<div class="toast-container position-fixed top-0 end-0 p-3">
        <div class="toast show" role="alert">
            <div class="toast-header bg-danger text-white">
                <strong class="me-auto">Erro</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">              
                    <p class="mb-1">${mensagem}</p>
            </div>
        </div>
    </div>`

    container.innerHTML = htmlErro;
}


function adicionarAoPedido(id, nome, preco, inputQtdId) {
    const qtd = document.getElementById(inputQtdId).value;
    const containerInputs = document.getElementById('lista-inputs-hidden');
    const listaVisual = document.getElementById('lista-visual-pedido');


    // Remove a mensagem de "Nenhum item" se for o primeiro item
    if (containerInputs.innerHTML === "") {
        listaVisual.innerHTML = "";
    }

    //Criando inputs hidden no formato de array para o PHP: itens[id][campo]
    containerInputs.innerHTML += `
        <input type="hidden" name="itens[${id}][id]" value="${id}">
        <input type="hidden" name="itens[${id}][nome]" value="${nome}">
        <input type="hidden" name="itens[${id}][quantidade]" value="${qtd}">
        <input type="hidden" name="itens[${id}][preco]" value="${preco}">
        <input type="hidden" name="itens[${id}][valorTotal]" value="${(preco*qtd)}">

    `;

    //Atualizando a lista visual
    const li = document.createElement('li');
    li.className = "list-group-item d-flex justify-content-between align-items-center";
    li.innerHTML = `${nome} (x${qtd}) <span>R$ ${(preco * qtd).toFixed(2)}</span>`;
    listaVisual.appendChild(li);

}
