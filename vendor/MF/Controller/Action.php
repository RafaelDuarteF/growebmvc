<?php

    namespace MF\Controller;
    use MF\Model\Conteiner;
    use MF\phpmailer\Mensagem;
    use MF\phpmailer\MensagemRec;
    abstract class Action {
        protected $view;
        public function __construct() {
            $this->view = new \stdClass();
        }
        protected function render($view, $layout = 'layout') {
            $this->view->page = $view;
            $path = '../App/Views/'. $layout . '.phtml';
            if(file_exists($path)) {
                require_once $path;
            }
            else {
                $this->content();
            }
        }
        protected function content() {
            $classeAtual = get_class($this);
            $dirView = str_replace('App\\Controllers\\', '', $classeAtual);
            $dirView = strtolower(str_replace('Controller', '', $dirView));
            require_once "../App/Views/" . $dirView . "/" . $this->view->page . ".phtml";
        }
        protected function verificarAutenticacao() {
            session_start();
            if(isset($_SESSION['nome']) && !empty($_SESSION['nome'])){
                return true;
            }
            else if(isset($_COOKIE['user'])) {
                $usuario = Conteiner::getModel('User');
                $usuario->__set('nome', $_COOKIE['user']);
                return $usuario->logWithCookies();;
            }
            return false;
        }
        protected function viewUsuario() {
            $verificacao = $this->verificarAutenticacao();
            if($verificacao) {
                $this->view->logado = true;
                $this->view->usuario = array(
                    'nome' => $_SESSION['nome'],
                    'email' => $_SESSION['email'],
                    'telefone' => $_SESSION['telefone'],
                    'cookiesLogin' => $_SESSION['cookiesLogin']
                );
            }
            else {
                $this->view->logado = false;
            }
        }
        protected function setCookieLogin($s) {
            if($s == 'set') {
                setcookie('user', $this->view->usuario['nome'], time()+360000, httponly:true, secure:false);
            }
            else if($s == 'unset') {
                setcookie('user');
            }
        }
        protected function enviarEmail($para, $email) {
            $mensagem = new Mensagem();
            $mensagem->__set('nome', $para);
            $mensagem->__set('destino', $email);
            $statusEnvio = $mensagem->enviarEmail();
            return $statusEnvio;
        }
        protected function enviarEmailRec($email, $cod) {
            $mensagem = new MensagemRec();
            $mensagem->__set('destino', $email);
            $mensagem->__set('cod', $cod);
            $statusEnvio = $mensagem->enviarEmail();
            return $statusEnvio;
        }
    }
?> 