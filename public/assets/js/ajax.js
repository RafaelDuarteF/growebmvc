function validarUsuario() {
    email = document.querySelector("#emailIn").value;
    senha = document.querySelector("#senhaIn").value;
    cbConect = document.querySelector("#cbConectIn").checked;
    $.ajax({
        type: 'POST',
        url: '/logar',
        data: `email=${email}&senha=${senha}&cbConect=${cbConect}`,
        dataType: 'json',
        success: cb => {retorno(cb)},
        error: erro => {retorno('erro')}
    })
    function retorno(cb) {
        if(cb) {
            location.assign('/');
        }
        else if(cb == false) {
            swal('E-Mail ou senha incorretos', 'Endereço de E-Mail ou senha informadas são inválidas!', 'warning');
        }
        else if(cb == 'erro') {
            swal('Algo deu errado', 'Por favor, tente novamente', 'warning');
        }
        else {
            alert(cb)
        }
    }
}

function requisicaoEmailAt(email) {
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
            $(".statusEmail").text("Já existente/Inválido");
            $(".statusEmail").css('color', 'red');
        }
        else if(cb == 0) {
            $(".statusEmail").text("Válido");
            $(".statusEmail").css('color', 'green');
        }
        else {
            $(".statusEmail").text('');
        }
    }
}

function requisicaoEmail() {
    email = document.querySelector("#inputResEm").value;
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

function requisicaoUsername(tipRetorno, username) {
    $.ajax({
        type: 'POST',
        url: '/verificarUsername',
        data: `nome=${username}`,
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
        if(username.length == 0) {
            $(".statusNome").text('');
        }
        else {
            if(cb == true) {
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
            email = document.getElementById("email").value;
            $.ajax({
                type: 'POST',
                url: '/validarEmail',
                data: `email=${email}`,
                dataType: 'json',
                success: cb => { validarEmail(cb); },
                error: erro => {validarEmail('erro')},
            });
            function validarEmail(cb) {
                if(cb == 0) {
                    document.getElementById("cadFm").submit();
                }
                else {
                    swal('E-Mail inválido!', 'O seu e-mail já corresponde em nossa base de dados, tente logar com ele, ou cadastre outro.', 'error');
                }
            }
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

function requisicaoAtualizacaoDados(user, pass, passAnt, email, tel) {
    $.ajax({
        type: 'POST',
        url: '/verificarUsername',
        data: `nome=${user}`,
        dataType: 'json',
        success: cb => {
            validarUserEnviado(cb);
        },
        error: erro =>{alert('Ocorreu um erro.')}
    });
    function validarUserEnviado(cb) {
        if(cb == true) {
            swal('Nome de usuário inválido.', 'O nome de usuário informado é inválido!', 'error');
        }
        else if(cb == false || cb == 'equal') {
            $.ajax({
                type: 'POST',
                url: '/validarEmail',
                data: `email=${email}`,
                dataType: 'json',
                success: cb => {
                    validarEmail(cb);
                },
                error: erro =>{alert('Ocorreu um erro.')}
            });
            function validarEmail(cb) {
                if(cb == 1) {
                    swal('O e-mail informado é inválido.', 'E-Mail informado é já existente ou inválido!', 'error');
                }
                else if(cb == 0 || cb == 'equal') {
                    $.ajax({
                        type: 'POST',
                        url: '/validarSenha',
                        data: `senha=${passAnt}`,
                        dataType: 'json',
                        success: cb => {
                            validarSenha(cb);
                        },
                        error: erro =>{alert('Ocorreu um erro.')}
                    });
                    function validarSenha(cb) {
                        if(cb == false) {
                            swal('Senha antiga informada inválida!', 'Senha antiga informada não condizente!' ,'error');
                        }
                        else if(cb == true) {
                            $.ajax({
                                type: 'POST',
                                url: '/validarAlteracao',
                                data: `nome=${user}&senha=${pass}&senhaAnt=${passAnt}&telefone=${tel}&email=${email}`,
                                dataType: 'json',
                                success: cb => {
                                    validarAlteracao(cb);
                                },
                                error: erro =>{alert('Ocorreu um erro.')}
                            });
                            function validarAlteracao(cb) {
                                if(cb == 1) {
                                    swal({
                                        title: "Dados alterados.",
                                        text: "Os dados foram alterados com sucesso!",
                                        icon: "success",
                                        button: "Ok",
                                        })
                                    .then((confirmError) => {
                                        location.assign('/minhaConta');
                                    });
                                }
                                else {
                                    swal('Ocorreu um erro.', 'Ocorreu um erro, verifique se as informações inseridas são válidas!', 'error')
                                }
                            }
                        }
                        else {
                            swal('Senha antiga informada inválida!', 'Senha antiga informada não condizente!' ,'error');
                        }
                    }
                }
                else {
                    swal('O e-mail informado é inválido.', 'E-Mail informado é já existente ou inválido!', 'error');
                }
            }
        }
        else {
            swal('Nome de usuário inválido.', 'O nome de usuário informado é inválido!', 'error');
        }
    }
}