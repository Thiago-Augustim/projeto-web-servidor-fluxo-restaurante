let mesaSelecionada = null;

document.querySelectorAll('.card-comanda').forEach(card => {
    card.addEventListener('click', () => {

        // remove seleção anterior
        document.querySelectorAll('.card-comanda').forEach(c => {
            c.classList.remove('border-primary', 'border-3');
        });

        // adiciona destaque
        card.classList.add('border-primary', 'border-3');

        const comanda = JSON.parse(card.dataset.comanda);
        mesaSelecionada = comanda.mesa;
    });
});

document.getElementById('btn-fechar-comanda').addEventListener('click', () => {

    if (!mesaSelecionada) {
        alert('Selecione uma comanda primeiro!');
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= BASE_URL ?>?rota=comandas&acao=fechar';

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'mesa';
    input.value = mesaSelecionada;

    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
});