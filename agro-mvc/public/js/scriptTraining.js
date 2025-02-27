document.addEventListener('DOMContentLoaded', function() {
    const hoje = new Date();
    const linhasCursos = document.querySelectorAll('table:first-of-type tr:not(:first-child)');
    
    linhasCursos.forEach(linha => {
        const dataCell = linha.querySelector('td:last-child');
        if (dataCell) {
            const [dia, mes, ano] = dataCell.textContent.split('-').map(Number);
            const dataValidade = new Date(ano, mes - 1, dia);
            
            if (dataValidade < hoje) {
                linha.classList.add('expired');
            }
        }
    });
});