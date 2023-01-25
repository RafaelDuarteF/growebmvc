<?php

    namespace App\Controllers;
    use MF\Controller\Action;
    use MF\Model\Conteiner;
    
    class AuthController extends Action {
        function logar() {
            $usuario = Conteiner::getModel('User');
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
            $cbConect = isset($_POST['cbConect']) ? $_POST['cbConect'] : false;
            $cbConect = $cbConect === 'true' ? true : false;
            $usuario->__set('email', $email);
            $usuario->__set('senha', $senha);
            $usuario->__set('cbConect', $cbConect);
            $usuario->validarUsuario();
            if($usuario->__get('userValido')) {
                session_start();
                $_SESSION['nome'] = $usuario->__get('nome');
                $_SESSION['telefone'] = $usuario->__get('telefone');
                $_SESSION['email'] = $usuario->__get('email');
                $_SESSION['cookiesLogin'] = $usuario->__get('cbConect');
                $_SESSION['id'] = $usuario->__get('id');
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
            header("Location: ".$_SERVER['HTTP_REFERER']."");
        }
        function logarRes() {
            session_start();
            $codDigitado = isset($_POST['cod']) ? $_POST['cod'] : '';
            if($codDigitado == $_SESSION['cod']) {
                if(!empty($_SESSION['emailRec'])) {
                    $usuario = Conteiner::getModel('User');
                    $usuario->__set("email", $_SESSION['emailRec']); 
                    $usuario->restaurarConta();
                    $_SESSION['nome'] = $usuario->__get("nome");
                    $_SESSION['email'] = $usuario->__get("email");
                    $_SESSION['telefone'] = $usuario->__get("telefone");
                    $_SESSION['id'] = $usuario->__get('id');
                    $_SESSION['emailRec'] = '';
                    echo json_encode(true);
                }
                else{
                    echo json_encode('emailInv');
                }
            }
            else {
                echo json_encode('codInv');
            }
        }
    }

?>