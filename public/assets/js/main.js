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
            forcaSenha = verificarForcaSenha('submit');
            if(forcaSenha == 'forte') {
                requisicaoUsername('enviado');
            }
            else if (forcaSenha == 'mCaractere') {
                swal('Senha fraca!', 'Sua senha deve possuir pelo menos 8 caracteres!', 'error');
            }
            else if (forcaSenha == 'mediaSCE') {
                swal('Senha média!', 'Sua senha deve possuir pelo menos um caractere especial!', 'error')
            }
            else if(forcaSenha == 'mediaSN') {
                swal('Senha média!', 'Sua senha deve possuir pelo menos um número!', 'error');
            }
            else if(forcaSenha == 'mediaSA') {
                swal('Senha média!', 'Sua senha deve possuir pelo menos uma letra alfabética!', 'error');
            }
            else if(forcaSenha == 'mediaSNCE') {
                swal('Senha média!', 'Sua senha deve possuir pelo menos um número e um caractere especial!', 'error');
            }
            else if(forcaSenha == 'mediaSNA') {
                swal('Senha média!', 'Sua senha deve possuir pelo menos um número e uma letra alfabética!', 'error');
            }
            else if(forcaSenha == 'mediaSACE') {
                swal('Senha média!', 'Sua senha deve possuir pelo menos um caractere especial e uma letra alfabética!', 'error');
            }
            else {
                swal('Senha inválida', 'Ocorreu um erro ao verificar essa senha. Por favor, tente outra.', 'error');
            }
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

function verificarForcaSenha(forma) {
    var numeros = /([0-9])/;
    var alfabeto = /([a-zA-Z])/;
    var chEspeciais = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
    
    if(forma == 'input') {
        if($('#password').val().length < 8) 
        {
            $('#password-status').html("<span style='color:red'>Fraco, insira no mínimo 8 caracteres</span>");
        } 
        else if ($('#password').val().match(numeros) && $('#password').val().match(alfabeto) && $('#password').val().match(chEspeciais)) {            
            $('#password-status').html("<span style='color:green'><b>Forte</b></span>");
        } 
        else if ($('#password').val().match(numeros) && $('#password').val().match(alfabeto) && !$('#password').val().match(chEspeciais)) {
            $('#password-status').html("<span style='color:orange'>Médio, insira pelo menos um caractere especial.</span>");
        }
        else if ($('#password').val().match(numeros) && !$('#password').val().match(alfabeto) && $('#password').val().match(chEspeciais)) {
            $('#password-status').html("<span style='color:orange'>Médio, insira pelo menos uma letra alfabética.</span>");
        }
        else if (!$('#password').val().match(numeros) && $('#password').val().match(alfabeto) && $('#password').val().match(chEspeciais)) {
            $('#password-status').html("<span style='color:orange'>Médio, insira pelo menos um número.</span>");
        }
        else if (!$('#password').val().match(numeros) && $('#password').val().match(alfabeto) && !$('#password').val().match(chEspeciais)) {
            $('#password-status').html("<span style='color:orange'>Médio, insira pelo menos um número e um caractere especial.</span>");
        }
        else if (!$('#password').val().match(numeros) && !$('#password').val().match(alfabeto) && $('#password').val().match(chEspeciais)) {
            $('#password-status').html("<span style='color:orange'>Médio, insira pelo menos um número e uma letra alfabética.</span>");
        }
        else if ($('#password').val().match(numeros) && !$('#password').val().match(alfabeto) && !$('#password').val().match(chEspeciais)) {
            $('#password-status').html("<span style='color:orange'>Médio, insira pelo menos um caractere especial e uma letra alfabética.</span>");
        }
    }
    else if(forma == 'submit') {
        if($('#password').val().length < 8) 
        {
            forcaSenha = 'mCaractere';
        } 
        else if ($('#password').val().match(numeros) && $('#password').val().match(alfabeto) && $('#password').val().match(chEspeciais)) {            
            forcaSenha = 'forte'
        } 
        else if ($('#password').val().match(numeros) && $('#password').val().match(alfabeto) && !$('#password').val().match(chEspeciais)) {
            forcaSenha = 'mediaSCE';
        }
        else if ($('#password').val().match(numeros) && !$('#password').val().match(alfabeto) && $('#password').val().match(chEspeciais)) {
            forcaSenha = 'mediaSA';
        }
        else if (!$('#password').val().match(numeros) && $('#password').val().match(alfabeto) && $('#password').val().match(chEspeciais)) {
            forcaSenha = 'mediaSN';
        }
        else if (!$('#password').val().match(numeros) && $('#password').val().match(alfabeto) && !$('#password').val().match(chEspeciais)) {
            forcaSenha = 'mediaSNCE'
        }
        else if (!$('#password').val().match(numeros) && !$('#password').val().match(alfabeto) && $('#password').val().match(chEspeciais)) {
            forcaSenha = 'mediaSNA';
        }
        else if ($('#password').val().match(numeros) && !$('#password').val().match(alfabeto) && !$('#password').val().match(chEspeciais)) {
            forcaSenha = 'mediaSACE'
        }
        return forcaSenha;
    }
}
