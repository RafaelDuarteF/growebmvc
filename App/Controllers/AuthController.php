<?php

    namespace App\Controllers;
    use MF\Controller\Action;
    use MF\Model\Conteiner;
    
    class AuthController extends Action {
        function logar() {
            $usuario = Conteiner::getModel('User');
            $nome = isset($_POST['usuario']) ? $_POST['usuario'] : '';
            $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
            $cbConect = isset($_POST['cbConect']) ? $_POST['cbConect'] : false;
            $cbConect = $cbConect === 'true' ? true : false;
            $usuario->__set('nome', $nome);
            $usuario->__set('senha', $senha);
            $usuario->__set('cbConect', $cbConect);
            $usuario->validarUsuario();
            if($usuario->__get('userValido')) {
                session_start();
                $_SESSION['nome'] = $usuario->__get('nome');
                $_SESSION['telefone'] = $usuario->__get('telefone');
                $_SESSION['email'] = $usuario->__get('email');
                $_SESSION['cookiesLogin'] = $usuario->__get('cbConect');
                echo json_encode(true);
            }
            else {
                echo json_encode(false);
            }
        }
        function sair() {
            session_start();
            session_destroy();
            $this->setCookieLogin('unset');
            header('Location: /');
        }
    }

?>