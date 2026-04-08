document.addEventListener('click', function (e) {
    const card = e.target.closest('.card-funcionario');

    if (card) {
        const dados = JSON.parse(card.dataset.funcionario);

        document.getElementById('painel-nome').innerText = dados.nome;
        document.getElementById('painel-id').innerHTML = "<b>" + dados.id + "</b>";
        document.getElementById('painel-especialidade').innerHTML = "<b>" + dados.especialidade + "</b>";
    }
});

document.addEventListener('click', function (e) {
    const card = e.target.closest('.card-funcionario');

    if (card) {
        const dados = JSON.parse(card.dataset.funcionario);

        document.getElementById('painel-nome').innerText = dados.nome;
        document.getElementById('painel-id').innerHTML = "<b>" + dados.id + "</b>";
        document.getElementById('painel-especialidade').innerHTML = "<b>" + dados.especialidade + "</b>";

        // 🔥 aqui o pulo do gato
        document.getElementById('input-excluir-id').value = dados.id;
    }
});