document.querySelectorAll('.card-funcionario').forEach(card => {
    card.addEventListener('click', () => {
        const dados = JSON.parse(card.dataset.funcionario);

        document.getElementById('painel-nome').innerText = dados.nome;
        document.getElementById('painel-id').innerHTML = "<b>" + dados.id + "</b>";
        document.getElementById('painel-especialidade').innerHTML = "<b>" + dados.especialidade + "</b>";
    });
});