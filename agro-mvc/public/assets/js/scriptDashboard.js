// Navegação entre páginas
document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', function(e) {
        if (!this.classList.contains('logout')) {
            e.preventDefault();
            const pageId = this.dataset.page;
            showPage(pageId);
        }
    });
});

// Funções do Modal
function showModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Gerenciamento de Funcionários
document.getElementById('form-funcionario').addEventListener('submit', function(e) {
    e.preventDefault();
    // Lógica para salvar funcionário
    closeModal('add-funcionario');
});
