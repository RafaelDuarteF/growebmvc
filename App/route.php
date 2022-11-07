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

            $this->setRoutes($routes);
        }
    }

?>