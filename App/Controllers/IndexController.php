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
            $getCEPCadastroErro = isset($_GET['cepin']) ? $_GET['cepin'] : '';
            $getLogradouroCadastroErro = isset($_GET['logradouroin']) ? $_GET['logradouroin'] : '';
            $getCidadeCadastroErro = isset($_GET['cidadein']) ? $_GET['cidadein'] : '';
            $getBairroCadastroErro = isset($_GET['bairroin']) ? $_GET['bairroin'] : '';
            $this->view->erroCadastro = $getErroCadastroUrl;
            $this->view->insertsErroCadastro = array(
                'nome' => $getNomeCadastroErro,
                'email' => $getEmailCadastroErro,
                'telefone' => $getTelefoneCadastroErro,
                'cep' => $getCEPCadastroErro,
                'logradouro' => $getLogradouroCadastroErro,
                'bairro' => $getBairroCadastroErro,
                'cidade' => $getCidadeCadastroErro,
            );
            $this->render('cadastro', 'layoutNHeader');
        }
        public function verificarUsername() {
            session_start();
            $username = isset($_POST['nome']) ? $_POST['nome'] : '';
            if(!empty($username)) {
                if(isset($_SESSION['nome'])) {
                    if($username == $_SESSION['nome']) { 
                        echo json_encode('equal');
                    }
                    else {
                        $usuario = Conteiner::getModel('User');
                        $usuario->__set('nome', $username);
                        $countUsername = $usuario->existsUsername();
                        echo json_encode($countUsername);
                    }
                }
                else {
                    $usuario = Conteiner::getModel('User');
                    $usuario->__set('nome', $username);
                    $countUsername = $usuario->existsUsername();
                    echo json_encode($countUsername);
                }
            }
        }
        public function cadastrarUsuario() {
            $nome = isset($_POST['username']) ? $_POST['username'] : '';
            $senha = isset($_POST['username']) ? $_POST['password'] : '';
            $telefone = isset($_POST['username']) ? $_POST['telefone'] : '';
            $email = isset($_POST['username']) ? $_POST['email'] : '';
            $cep = isset($_POST['cep']) ? $_POST['cep'] : '';
            $cidade = isset($_POST['cidade']) ? $_POST['cidade'] : '';
            $bairro = isset($_POST['bairro']) ? $_POST['bairro'] : '';
            $logradouro = isset($_POST['logradouro']) ? $_POST['logradouro'] : '';
            if(!empty($nome) && !empty($senha) && !empty($telefone) && !empty($email) && !empty($cep) && !empty($cidade) && !empty($bairro) && !empty($logradouro)) {
                $usuario = Conteiner::getModel('User');
                $usuario->__set('nome', $nome);
                $usuario->__set('senha', $senha);
                $usuario->__set('telefone', $telefone);
                $usuario->__set('email', $email);
                $usuario->__set('cep', $cep);
                $usuario->__set('cidade', $cidade);
                $usuario->__set('bairro', $bairro);
                $usuario->__set('logradouro', $logradouro);
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
        public function restaurarSenha() {
            $this->render('restaurarSenha', 'layoutNHeader');
        }
        public function urlInvalida() {
            $this->viewUsuario();
            $this->render('urlInvalida');
        }
        public function validarEmail() {
            session_start();
            $email = $_POST['email'];
            if(!empty($email)) {
                if(isset($_SESSION['email'])) {
                    if($email == $_SESSION['email']) {
                        $retorno = 'equal';
                    }
                    else {
                        $usuario = Conteiner::getModel('User');
                        $usuario->__set('email', $email);
                        $validar = $usuario->validarEmail();
                        if($validar == true) {
                            $retorno = 1;
                        }
                        else {
                            $retorno = 0;
                        }
                    }
                }
                else {
                    $usuario = Conteiner::getModel('User');
                    $usuario->__set('email', $email);
                    $validar = $usuario->validarEmail();
                    if($validar == true) {
                        $retorno = 1;
                    }
                    else {
                        $retorno = 0;
                    }
                }
            }
            else {
                $retorno = 0;
            }
            echo json_encode($retorno);
        }
        public function enviarRestauracao() {
            session_start();
            $email = isset($_POST['emailRes']) ? $_POST['emailRes'] : '';
            if(!empty($email)) {
                if(isset($_SESSION['cod'])) {
                    $cod = $_SESSION['cod'];
                }
                else {
                    $cod = rand(10000, 99999);
                    $_SESSION['cod'] = $cod;
                }
                $_SESSION['emailRec'] = $email;
                $usuario = Conteiner::getModel('User');
                $usuario->__set('email', $email);
                $vEmail = $usuario->validarEmail();
                if($vEmail == true) {
                    $statusEmail = $this->enviarEmailRec($usuario->__get('email'), $cod);
                    if($statusEmail == true) {
                        $this->view->emailRec = $email;
                    }
                    else {
                        header("location:/restaurarSenha?erroEmailIn");
                    }
                }
                else {
                    header("location:/restaurarSenha?erroEmailInBD");
                }
            }
            else {
                header('location:/restaurar');
            }
            $this->render("enviarRestauracao", "layoutNHeader");
        }
    }

?> 