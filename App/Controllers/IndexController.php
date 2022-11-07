<?php

    namespace App\Controllers;
    use MF\Controller\Action;
    use MF\Model\Conteiner;

    class IndexController extends Action{
        public function index() {
            $getErroCadastroUrl = isset($_GET['erroCadastro']) ? $_GET['erroCadastro'] : '';
            $getErroAutenticacao = isset($_GET['erroAutenticacao']) ? $_GET['erroAutenticacao'] : '';
            if(!empty($getErroAutenticacao)) {
                $this->view->erroAutenticacao = $getErroAutenticacao;
            }
            $this->view->erroCadastro = $getErroCadastroUrl;
            $this->viewUsuario();
            if(isset($this->view->usuario['cookiesLogin'])) {
                if($this->view->usuario['cookiesLogin'] == true) {
                    $this->setCookieLogin('set');
                }
                else {
                    $this->setCookieLogin('unset');
                }
            }
            
            $this->render('index');
        }
        public function login() {
            $this->render('login', 'layoutNHeader');
        }
        public function cadastro() {
            $getErroCadastroUrl = isset($_GET['erroCadastro']) ? $_GET['erroCadastro'] : '';
            $getNomeCadastroErro = isset($_GET['nomeus']) ? $_GET['nomeus'] : '';
            $getTelefoneCadastroErro = isset($_GET['telin']) ? $_GET['telin'] : '';
            $getEmailCadastroErro = isset($_GET['emailin']) ? $_GET['emailin'] : '';
            $this->view->erroCadastro = $getErroCadastroUrl;
            $this->view->insertsErroCadastro = array(
                'nome' => $getNomeCadastroErro,
                'email' => $getEmailCadastroErro,
                'telefone' => $getTelefoneCadastroErro,
            );
            $this->render('cadastro', 'layoutNHeader');
        }
        public function verificarUsername() {
            $username = isset($_POST['nome']) ? $_POST['nome'] : '';
            if(!empty($username)) {
                $usuario = Conteiner::getModel('User');
                $usuario->__set('nome', $username);
                $countUsername = $usuario->existsUsername();
                echo json_encode($countUsername);
            }
        }
        public function cadastrarUsuario() {
            $nome = isset($_POST['username']) ? $_POST['username'] : '';
            $senha = isset($_POST['username']) ? $_POST['password'] : '';
            $telefone = isset($_POST['username']) ? $_POST['telefone'] : '';
            $email = isset($_POST['username']) ? $_POST['email'] : '';
            if(!empty($nome) && !empty($senha) && !empty($telefone) && !empty($email)) {
                $usuario = Conteiner::getModel('User');
                $usuario->__set('nome', $nome);
                $usuario->__set('senha', $senha);
                $usuario->__set('telefone', $telefone);
                $usuario->__set('email', $email);
                $validarCadastro = $usuario->validarCadastro();
                if($validarCadastro) {
                    $statusEmail = $this->enviarEmail($usuario->__get('nome'), $usuario->__get('email'));
                    if($statusEmail) {  
                        $usuario->salvar();
                    }
                    else {
                        header("Location: /cadastro?erroCadastro=emailInvalido&nomeus={$usuario->__get('nome')}&telin={$usuario->__get('telefone')}&emailin={$usuario->__get('email')}");
                    }
                }
                else {
                    header('Location: /?erroCadastro=true');
                }
            }
        }
    }

?>