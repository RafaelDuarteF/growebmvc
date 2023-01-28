<?php

    namespace App;
    use MF\Init\Bootstrap;
    class Route extends Bootstrap {
        protected function initRoutes () {
            $routes['home'] = array(
                'route' => '/',
                'controller' => 'indexController',
                'action' => 'index'
            );
            $routes['login'] = array(
                'route' => '/login',
                'controller' => 'indexController',
                'action' => 'login'
            );
            $routes['cadastro'] = array(
                'route' => '/cadastro',
                'controller' => 'indexController',
                'action' => 'cadastro'
            );
            $routes['logar'] = array(
                'route' => '/logar',
                'controller' => 'authController',
                'action' => 'logar'
            );
            $routes['sair'] = array(
                'route' => '/sair',
                'controller' => 'authController',
                'action' => 'sair'
            );
            $routes['verificarUsername'] = array(
                'route' => '/verificarUsername',
                'controller' => 'indexController',
                'action' => 'verificarUsername'
            );
            $routes['cadastrar'] = array(
                'route' => '/cadastrar',
                'controller' => 'indexController',
                'action' => 'cadastrarUsuario'
            );
            $routes['verificarEmail'] = array(
                'route' => '/verificarEmail',
                'controller' => 'indexController',
                'action' => 'verificarEmail'
            );
            $routes['meuProjeto'] = array(
                'route' => '/meuProjeto',
                'controller' => 'appController',
                'action' => 'meuProjeto'
            );
            $routes['urlinvalida'] = array(
                'route' => '/urlInvalida',
                'controller' => 'indexController',
                'action' => 'urlInvalida'
            );
            $routes['restaurar'] = array(
                'route' => '/restaurar',
                'controller' => 'indexController',
                'action' => 'restaurarSenha'
            );
            $routes['validarEmail'] = array(
                'route' => '/validarEmail',
                'controller' => 'indexController',
                'action' => 'validarEmail'
            );
            $routes['enviarRestauracao'] = array(
                'route' => '/enviarRestauracao',
                'controller' => 'indexController',
                'action' => 'enviarRestauracao'
            );
            $routes['logarRes'] = array(
                'route' => '/logarRes',
                'controller' => 'authController',
                'action' => 'logarRes'
            );
            $routes['minhaConta'] = array(
                'route' => '/minhaConta',
                'controller' => 'appController',
                'action' => 'minhaConta'
            );
            $routes['alterarDados'] = array(
                'route' => '/alterarDados',
                'controller' => 'appController',
                'action' => 'alterarDados'
            );
            $routes['validarSenha'] = array(
                'route' => '/validarSenha',
                'controller' => 'appController',
                'action' => 'validarSenha'
            );
            $routes['validarAlteracao'] = array(
                'route' => '/validarAlteracao',
                'controller' => 'appController',
                'action' => 'validarAlteracao'
            );
            $this->setRoutes($routes);
        }
    }

?>