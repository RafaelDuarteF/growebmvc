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
    }
?>