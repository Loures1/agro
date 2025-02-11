<?php

namespace app\controllers;

use app\models\User;
use app\views\ViewSignUp;

class SignUp
{
    public function __construct()
    {
        session_start(); // Inicia a sessão no construtor do controlador
    }

    public function null()
    {
        return ViewSignUp::homePage();
    }

    public function insertSupervisorInDataBase()
    {
        // Verifica se as senhas coincidem
        if ($_POST['senha'] !== $_POST['confirmar_senha']) {
            $_SESSION['senha_error'] = "As senhas não coincidem!";
            return ViewSignUp::homePage(); // Retorna para a página de cadastro
        }

        // Valida CPF
        if (!$this->validaCPF($_POST['cpf'])) {
            $_SESSION['cpf_error'] = "O CPF informado é inválido!";
            return ViewSignUp::homePage();
        }

        // Criptografa a senha antes de armazenar
        $_POST['senha'] = hash('sha256', $_POST['senha']);

        // Remove o campo de confirmação da senha para não ser salvo no banco
        unset($_POST['confirmar_senha']);

        // Insere os dados no banco
        User::registerUser('tbl_supervisor', $_POST);

        // Exibe o status de registro
        ViewSignUp::registerUserStatus();
    }
    // Função para validar o CPF
    private function validaCPF($cpf)
    {
        // Remove qualquer caractere não numérico
        $cpf = preg_replace('/\D/', '', $cpf);

        // Verifica se o CPF tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se o CPF é composto apenas por números iguais
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        // Valida o primeiro dígito
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += $cpf[$i] * (10 - $i);
        }
        $resto = $soma % 11;
        $digito1 = ($resto < 2) ? 0 : 11 - $resto;
        if ($cpf[9] != $digito1) {
            return false;
        }

        // Valida o segundo dígito
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += $cpf[$i] * (11 - $i);
        }
        $resto = $soma % 11;
        $digito2 = ($resto < 2) ? 0 : 11 - $resto;
        if ($cpf[10] != $digito2) {
            return false;
        }

        return true;
    }
}
