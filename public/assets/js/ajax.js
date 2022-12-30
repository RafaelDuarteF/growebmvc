function validarUsuario() {
    nome = document.querySelector("#usuarioIn").value;
    senha = document.querySelector("#senhaIn").value;
    cbConect = document.querySelector("#cbConectIn").checked;
    $.ajax({
        type: 'POST',
        url: '/logar',
        data: `usuario=${nome}&senha=${senha}&cbConect=${cbConect}`,
        dataType: 'json',
        success: cb => {retorno(cb)},
        error: erro => {retorno('erro')}
    })
    function retorno(cb) {
        if(cb) {
            location.assign('/');
        }
        else if(cb == false) {
            swal('Usuário ou senha incorretos', 'Nome de usuário ou senha informadas são inválidas!', 'warning');
        }
        else if(cb == 'erro') {
            swal('Algo deu errado', 'Por favor, tente novamente', 'warning');
        }
        else {
            alert(cb)
        }
    }
}

function requisicaoEmail() {
    email = document.querySelector("#inputResSenha").value;
    $.ajax({
        type: 'POST',
        url: '/validarEmail',
        data: `email=${email}`,
        dataType: 'json',
        success: cb => {validarEmail(cb)},
        error: error => {validarEmail('erro')}
    });
    function validarEmail(cb) {
        if(cb == 1) {
            document.getElementById("formResSenha").submit();
        }
        else {
            swal('E-Mail inválido!', 'O seu e-mail não corresponde em nossa base de dados, verifique novamente.', 'error');
        }
    }
}

function requisicaoUsername(tipRetorno) {
    userDigitado = document.querySelector("#username").value;
    $.ajax({
        type: 'POST',
        url: '/verificarUsername',
        data: `nome=${userDigitado}`,
        dataType: 'json',
        success: cb => {
            if(tipRetorno == 'digitado') {
                validarUserDigitado(cb);
            }
            else if(tipRetorno == 'enviado') {
                validarUserEnviado(cb);
            }
        },
        error: erro => {validarUserDigitado('erro')}
    });
    function validarUserDigitado(cb) {
        if(userDigitado.length == 0) {
            $(".statusNome").text('');
        }
        else {
            if(cb) {
                $(".statusNome").text("Inválido");
                $(".statusNome").css("color", "red");
            }
            else if(cb == false) {
                $(".statusNome").text("Válido");
                $(".statusNome").css("color", "green");
            }
            else {
                $(".statusNome").text('');
            }
        }
    }
    function validarUserEnviado(cb) {
        if(cb == false){
            document.getElementById("cadFm").submit();
        }
        else if(cb){
            swal("Usuário inválido!", "O nome de usuário inserido já existe. Por favor, informe outro.", "warning");
        }
        else if(cb == 'erro'){
            swal("Erro", "Ocorreu um erro, tente novamente mais tarde.", "error");
        }
    }
}
function logarComCodigo(codRes) {
    $.ajax({
        type: 'POST',
        url: '/logarRes',
        data: `cod=${codRes}`,
        dataType: 'json',
        success: cb => {
            verificarLogin(cb);
        },
        error: erro => {verificarLogin('erro')}
    });
    function verificarLogin(cb) {
        if(cb == true) {
            location.assign("/");
        }
        else if(cb == 'emailInv') {
            swal("Ocorreu um erro.", "O e-mail informado é inválido!", "error");
        }
        else if(cb == 'codInv') {
            swal("Ocorreu um erro.", "O código informado é inválido!", "error");
        }
        else{
            swal("Ocorreu um erro.", "Ocorreu um erro ao tentar logar, tente novamente mais tarde.", "error");
        }
    }
}
