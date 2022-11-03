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
