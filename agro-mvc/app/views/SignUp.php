<?php
namespace app\views;

class ViewSignUp

{
    // Exibe a página de cadastro
    static function homePage()
    {
        // Inclui o arquivo HTML do formulário
        return include_once("../public/html/signUp.html");
    }

    // Exibe o status do registro
    static function registerUserStatus()
    {
        return include_once("../public/html/reportStatus.html");
    }
    public function SingUp()
{
    return ViewSignUp::homePage();
}

}
