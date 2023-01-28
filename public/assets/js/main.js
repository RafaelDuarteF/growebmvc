$(document).ready(function(){
    menuUser = $(".menuUser"); menuUser.hide();
    $(function(){
        $(".sw").css("width", screen.width);
        $(".sh").css("height", screen.height);
        $(".rCardPerfil").css("height", screen.height);
    });

    $(".imgPerfil").hover(() => {
        menuUser.fadeIn(300);
        $(".imgPerfil").css({
            opacity: '70%'
        });
    }, () => {
        menuUser.hide();
        $(".imgPerfil").css({
            opacity: '100%'
        });
    });

    $(".menuUser").hover(() => {
        menuUser.show();
        $(".imgPerfil").css({
            opacity: '70%'
        });
    }, () => {
        menuUser.hide();
        $(".imgPerfil").css({
            opacity: '100%'
        });
    });

    visMenuUser = false;
    $(".imgPerfil").click(() => {
        if(visMenuUser == false){
            $(".imgPerfil").css({
                opacity: '70%'
            });
            menuUser.fadeIn(300);
            visMenuUser = true;
        }
        else{
            menuUser.hide();
            $(".imgPerfil").css({
                opacity: '100%'
            });
            visMenuUser = false;
        }
    });
    
    // REQUISIÇÕES AJAX

    $('.btn-login').on('click', (e) => { // Verificar se usuário é valido no momento do login
        e.preventDefault();
        validarUsuario();
    });

    $('#username').on('input', () => { // Valida o username de usuário ao digitá-lo no formulário de cadastro
        nome = document.getElementById('username').value;
        requisicaoUsername('digitado', nome);
    });

    $(".btnCad").click(() => { // Valida o username de usuário ao enviá-lo no formulário de cadastro
        user = document.getElementById("username").value;
        pass = document.getElementById("password").value;
        tel = document.getElementById("telefone").value;
        email = document.getElementById("email").value;
        ckTerm = document.getElementById("termsCk").checked;
        if(user.length == 0 || pass == 0 || tel == 0 || email == 0){
            swal("Faltam informações!", "Há informações não preenchidas.", "error");
        }
        else if(user.length < 4){
            swal("Nome de usuário inválido!", "O seu nome de usuário é muito pequeno. Por favor, informe outro.", "error");
        }
        else if(pass.length < 8){
            swal("Senha inválida!", "Insira uma senha com mais de 8 caracteres.", "error");
        }
        else if((tel.length < 13 || tel.length > 14) || tel.substring(0, 1) != '(' || tel.substring(3, 4) != ')'){
            swal("Telefone inválido!", "Insira um telefone válido.", "error");
        }
        else if(ckTerm != true){
            swal("Termo não marcado.", "Para se cadastrar, assine o termo de serviço e política de privacidade.", "error");
        }
        else{
            requisicaoUsername('enviado');
        }
    });
    $("#envResSenhaEm").click(() => {
        emailRes = document.getElementById("inputResEm").value;
        if(emailRes.length == 0) {
            swal("Campo vazio!", "Preencha o campo com o seu e-mail.", "error");
        }
        else {
            requisicaoEmail();
        }
    });
    $("#envResSenhaCod").click(() => {
        codRes1 = document.getElementById("inputResSenhaCod1").value;
        codRes2 = document.getElementById("inputResSenhaCod2").value;
        codRes3 = document.getElementById("inputResSenhaCod3").value;
        codRes4 = document.getElementById("inputResSenhaCod4").value;
        codRes5 = document.getElementById("inputResSenhaCod5").value;
        if(codRes1.length < 1 || codRes2.length < 1 || codRes3.length < 1 || codRes4.length < 1 || codRes5.length < 1) {
            swal("Código inválido.", "O código deve possuir cinco dígitos!", "warning");
        }
        else {
            codRes = '' + codRes1 + codRes2 + codRes3 + codRes4 + codRes5;
            logarComCodigo(codRes);
        }
    });
    $("#nomeAt").on('input', () => {
        nome = document.getElementById('nomeAt').value;
        requisicaoUsername('digitado', nome)
    });
    $("#emailAt").on('input', () => {
        email = document.getElementById('emailAt').value;
        requisicaoEmailAt(email);
    });
    $(".btnAtDados").on('click', () => {
        user = document.getElementById("nomeAt").value;
        pass = document.getElementById("senhaAt").value;
        tel = document.getElementById("telAt").value;
        email = document.getElementById("emailAt").value;
        passAnt = document.getElementById("senhaAtAnt").value;
        if(user.length == 0 || pass.length == 0 || tel.length == 0 || email.length == 0 || passAnt.length == 0){
            swal("Faltam informações!", "Há informações não preenchidas.", "error");
        }
        else if(user.length < 4){
            swal("Nome de usuário inválido!", "O seu nome de usuário é muito pequeno. Por favor, informe outro.", "error");
        }
        else if(pass.length < 8){
            swal("Senha inválida!", "Insira uma senha com mais de 8 caracteres.", "error");
        }
        else if((tel.length < 13 || tel.length > 14) || tel.substring(0, 1) != '(' || tel.substring(3, 4) != ')'){
            swal("Telefone inválido!", "Insira um telefone válido.", "error");
        }
        else{
            requisicaoAtualizacaoDados(user, pass, passAnt, email, tel);
        }
    }); 
});
