<?php

    namespace App\Controllers;
    use MF\Controller\Action;
    use MF\Model\Conteiner;
    
    class AppController extends Action {
        public function meuProjeto() {
            $this->viewUsuario();
            if($this->view->logado == true) {
                $projeto = Conteiner::getModel('plano_user');
                $projeto->__set('nomeUser', $this->view->usuario['nome']);
                $meuProjeto = $projeto->verificarProjetos();
                if($meuProjeto != false) {
                    $this->view->projeto = array(
                        'nomePlano' => $meuProjeto['nomePlano'],
                        'valorInicial' => $meuProjeto['valorIni'],
                        'valorAdicional' => $meuProjeto['valorAd'],
                        'descricaoPlano' => $meuProjeto['descricaoPlano']
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
    }
?>