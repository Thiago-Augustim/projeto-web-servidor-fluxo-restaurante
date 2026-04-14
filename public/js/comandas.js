let mesaSelecionada = null;

document.querySelectorAll('.card-comanda').forEach(card => {
    card.addEventListener('click', () => {

        document.querySelectorAll('.card-comanda').forEach(c => {
            c.classList.remove('border-primary', 'border-3');
        });

        card.classList.add('border-primary', 'border-3');

        const comanda = JSON.parse(card.dataset.comanda);
        mesaSelecionada = comanda.mesa;

        document.getElementById('input-mesa-fechar').value = mesaSelecionada;
    });
});