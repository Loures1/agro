function validaCPF(cpf) {
    cpf = cpf.replace(/[^\d]/g, ''); // Remove caracteres não numéricos

    if (cpf.length !== 11) return false;

    // Verifica CPFs com números iguais
    if (/^(\d)\1{10}$/.test(cpf)) return false;

    // Validação dos dígitos verificadores
    let soma = 0;
    let resto;

    for (let i = 1; i <= 9; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    }

    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(9, 10))) return false;

    soma = 0;
    for (let i = 1; i <= 10; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
    }

    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(10, 11))) return false;

    return true;
}

// Função para formatar CPF
function formataCPF(cpf) {
    return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
}

// Validação do CPF em tempo real
const cpfInput = document.getElementById('cpf');
const cpfError = document.getElementById('cpf-error');
const cpfSuccess = document.getElementById('cpf-success');

cpfInput.addEventListener('input', function(e) {
    // Permite apenas números
    this.value = this.value.replace(/\D/g, '');
    
    const cpf = this.value;

    // Verifica se tem 11 dígitos
    if (cpf.length !== 11) {
        mostrarErro(this, cpfError, cpfSuccess, 'CPF deve ter 11 dígitos');
        return;
    }

    // Validação do CPF
    if (!validaCPF(cpf)) {
        mostrarErro(this, cpfError, cpfSuccess, 'CPF inválido');
        return;
    }

    // CPF válido
    mostrarSucesso(this, cpfError, cpfSuccess, 'CPF válido');
});

// Validação da senha
const senhaInput = document.getElementById('senha');
const senhaError = document.getElementById('senha-error');
const senhaSuccess = document.getElementById('senha-success');
const confirmarSenhaInput = document.getElementById('confirmar-senha');
const confirmarSenhaError = document.getElementById('confirmar-senha-error');

function validaSenha(senha) {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
    return regex.test(senha);
}

senhaInput.addEventListener('input', function() {
    const senha = this.value;

    // Requisitos da senha
    const temMinimo = senha.length >= 8;
    const temMaiuscula = /[A-Z]/.test(senha);
    const temMinuscula = /[a-z]/.test(senha);
    const temNumero = /[0-9]/.test(senha);

    if (!temMinimo || !temMaiuscula || !temMinuscula || !temNumero) {
        let mensagem = 'A senha deve conter:';
        if (!temMinimo) mensagem += '\n- Mínimo de 8 caracteres';
        if (!temMaiuscula) mensagem += '\n- Uma letra maiúscula';
        if (!temMinuscula) mensagem += '\n- Uma letra minúscula';
        if (!temNumero) mensagem += '\n- Um número';

        mostrarErro(this, senhaError, senhaSuccess, mensagem);
        return;
    }

    mostrarSucesso(this, senhaError, senhaSuccess, 'Senha válida');
});

confirmarSenhaInput.addEventListener('input', function() {
    if (this.value === senhaInput.value) {
        confirmarSenhaInput.classList.remove('input-error');
        confirmarSenhaInput.classList.add('input-success');
        confirmarSenhaError.style.display = 'none';
    } else {
        confirmarSenhaInput.classList.remove('input-success');
        confirmarSenhaInput.classList.add('input-error');
        confirmarSenhaError.style.display = 'block';
    }
});

// Validação do formulário antes do envio
document.getElementById('signupForm').addEventListener('submit', function(e) {
    const cpf = cpfInput.value;
    const senha = senhaInput.value;
    const confirmarSenha = confirmarSenhaInput.value;

    if (!validaCPF(cpf)) {
        e.preventDefault();
        alert('Por favor, insira um CPF válido.');
        return;
    }

    if (senha.length < 8 || !/[A-Z]/.test(senha) || !/[a-z]/.test(senha) || !/[0-9]/.test(senha)) {
        e.preventDefault();
        alert('Por favor, insira uma senha válida.');
        return;
    }

    if (senha !== confirmarSenha) {
        e.preventDefault();
        alert('As senhas não coincidem.');
        return;
    }
});

// Função para mostrar erro
function mostrarErro(input, errorElement, successElement, mensagem) {
    input.classList.add('input-error');
    input.classList.remove('input-success');
    errorElement.textContent = mensagem;
    errorElement.style.display = 'block';
    successElement.style.display = 'none';
}

// Função para mostrar sucesso
function mostrarSucesso(input, errorElement, successElement, mensagem) {
    input.classList.remove('input-error');
    input.classList.add('input-success');
    successElement.textContent = mensagem;
    errorElement.style.display = 'none';
    successElement.style.display = 'block';
}