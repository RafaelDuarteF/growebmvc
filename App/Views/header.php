<header>
    <div class="logotipo-header" onclick="redirect('/')">GROWEB</div>
    <nav class="navb">
        <ul class="navl">
            <li>Planos</li>
            <li>Nossos métodos</li>
            <li>Documentação</li>
            <li>Contatos</li>
        </ul>
    </nav>
    <?php
    if($this->view->logado){
    ?>
        <div class="perfilUser">
            <img class="imgPerfil" src="assets/img/default.png" />
            <div class="menuUser">
            <ul>
                <li>Minha Conta</li>
                <li onclick="redirect('/meuProjeto')">Meu Projeto</li>
                <li id="sairPerfil" onclick="redirect('/sair')">SAIR</li>
            </ul>
        </div>
    <?php
    }
    else{
    ?>
    <div class="btnLoginDiv">
        <button class="btnLogin" onclick="redirect('/login')">Entrar</button>
    </div>
    <?php
    } 
    ?>
</header>