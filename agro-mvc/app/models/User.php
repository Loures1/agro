<?php

use config\Credentials;

class User
{
    private ?object $db;

    public function __construct()
    {
        $this->db = new mysqli;
        $this->db->connect(
            hostname: Credentials::hostname(),
            username: Credentials::username(),
            password: Credentials::password(),
            database: Credentials::database(),
        );
    }

    public function signUp($name, $cpf, $telefone, $email, $senha)
    {
        $this->db->query(
            "INSERT INTO tbl_supervisor 
            (nome, cpf, telefone, email, senha)
            VALUES
            ('{$name}', '{$cpf}', '{$telefone}, {$email}, '{$senha}')"
        );
        $this->db->kill();
    }

    public function signIn($cpf, $senha)
    {
        $fetch = $this->db->query(
            "SELECT EXISTS (
                SELECT id 
                FROM tbl_supervisor 
                WHERE cpf = '{$cpf}' and senha = '{$senha}'
            )"
        );

        return match ($fetch) {
            '1' => 'DEU BOM',
            '0' => 'DEU RUIM'
        };
        $this->db->kill();
    }
}