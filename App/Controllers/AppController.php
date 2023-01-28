<?php

    namespace App\Controllers;
    use MF\Controller\Action;
    use MF\Model\Conteiner;
    
    class AppController extends Action {
        public function meuProjeto() {
            $this->viewUsuario();
            if($this->view->logado == true) {
                $projeto = Conteiner::getModel('plano_user');
                $projeto->__set('idUser', $this->view->usuario['id']);
                $meuProjeto = $projeto->verificarProjetos();
                if($meuProjeto != false) {
                    $this->view->projeto = array(
                        'nomePlano' => $meuProjeto['nomePlano'],
                        'valorInicial' => $meuProjeto['valorIni'],
                        'valorAdicional' => $meuProjeto['valorAd'],
                        'descricaoPlano' => $meuProjeto['descricaoPlano']
                    );
                    $proj = Conteiner::getModel('projeto');
                    $proj->__set('idUser', $this->view->usuario['id']);
                    $dadosProj = $proj->retornarProjeto();
                    $this->view->dadosProj = array(
                        'situacao' => $dadosProj['situacao'],
                        'previsao' => $dadosProj['previsaoEntrega'],
                        'atualizacao' => $dadosProj['atualizacao'],
                        'imagens' => $dadosProj['pastaImagens'],
                        'dataAt' => $dadosProj['dataAtualizacao']
                    );
                }
                else {
                    $this->view->projeto = false;
                }
                $this->render('meuProjeto');
            }
            else {
                header('Location: /?erroAutenticacao=true');
            }
        }
        public function minhaConta() {
            $this->viewUsuario();
            if($this->view->logado == true) {
                $this->render('minhaConta');
            }
            else {
                header('location: /?erroAutenticacao=true');
            }
        }
        public function alterarDados() {
            $this->viewUsuario();
            if($this->view->logado == true) {
                $this->render('alterarDados', 'layoutNHeader');
            }
            else {
                header('location: /?erroAutenticacao=true');
            }
        }
        public function validarSenha() {
            session_start();
            $senhaANT = false;
            $senha = $_POST['senha'];
            if(isset($_SESSION['cod'])) {
                if($senha == $_SESSION['cod']) {
                    $senhaANT = true;
                }
            }
            if($senhaANT != true) {
                $usuario = Conteiner::getModel('user');
                $usuario->__set('senha', md5($senha));
                $usuario->__set('id', $_SESSION['id']);
                $retorno = $usuario->validarSenha();
                if($retorno == $usuario->__get('senha')) {
                    $senhaANT = true;
                }
                else {
                    $senhaANT = false;
                } 
            }
            echo json_encode($senhaANT);
        }
        public function validarAlteracao() {
            session_start();
            $novoNome = $_POST['nome'];
            $novaSenha = $_POST['senha'];
            $antigaSenha = $_POST['senhaAnt'];
            $novoTelefone = $_POST['telefone'];
            $novoEmail = $_POST['email'];
            $usuario = Conteiner::getModel('user');
            $usuario->__set('senha', md5($antigaSenha));
            $usuario->__set('id', $_SESSION['id']);
            if(strlen($novoNome) > 4 && strlen($novaSenha) > 8 || strlen($novoTelefone) > 13) {
                $senha = $usuario->validarSenha();                
                if($senha == md5($antigaSenha) || $antigaSenha == $_SESSION['cod']) {
                    $usuario->__set('nome', $novoNome);
                    $usuario->__set('email', $novoEmail);
                    $usuario->__set('senha', md5($novaSenha));
                    $usuario->__set('telefone', $novoTelefone);
                    $retorno = $usuario->alterarDados();
                    if($retorno == 1) {
                        $_SESSION['nome'] = $novoNome;
                        $_SESSION['email'] = $novoEmail;
                        $_SESSION['telefone'] = $novoTelefone;
                        $_SESSION['cod'] = '';
                    }
                }
                else {
                    $retorno = 0;
                }
            }
            else {
                $retorno = 0;
            }
            echo json_encode($retorno);
        }
    }
?>