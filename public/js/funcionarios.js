document.addEventListener('click', function (e) {
    const card = e.target.closest('.card-funcionario');

    if (card) {
        const dados = JSON.parse(card.dataset.funcionario);

        document.getElementById('painel-nome').innerText = dados.nome;
        document.getElementById('painel-id').innerHTML = "<b>" + dados.id + "</b>";
        document.getElementById('painel-especialidade').innerHTML = "<b>" + dados.especialidade + "</b>";
        document.getElementById('input-excluir-id').value = dados.id;
    }
});

document.getElementById('nome').addEventListener('input', function() {
    let nome = this.value.trim().toLowerCase();

    // remove acentos
    nome = nome.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

    // separa palavras
    let partes = nome.split(" ");

    if (partes.length >= 2) {
        let usuario = partes[0] + "." + partes[partes.length - 1];
        document.getElementById('usuario').value = usuario;
    } else {
        document.getElementById('usuario').value = partes[0] || '';
    }
});