<script>
    <?php 
    if(isset($res)){
        if($res==1){
    ?>
        $(window).scrollTop(0);
        $('#alerta-sucesso').show('fast');
        $('#frm-cliente')[0].reset();
        setTimeout(() => {
            $('#alerta-sucesso').hide('fast');
        }, 2500);
    <?php 
        } else {
    ?>
        $('#alerta-erro').show('fast');
        setTimeout(() => {
            $('#alerta-erro').hide('fast')
        }, 2500);
    <?php 
        }
    }
    ?>

    $('.cnpj').on('blur', function(){
        checarCnpj(this);
    });

    function validarCNPJ(cnpj) { 
        cnpj = cnpj.replace(/[^\d]+/g,'');
        
        if(cnpj == '') return false;

        if (cnpj.length != 14)
            return false;

        // Elimina CNPJs invalidos conhecidos
        if (cnpj == "00000000000000" || 
            cnpj == "11111111111111" || 
            cnpj == "22222222222222" || 
            cnpj == "33333333333333" || 
            cnpj == "44444444444444" || 
            cnpj == "55555555555555" || 
            cnpj == "66666666666666" || 
            cnpj == "77777777777777" || 
            cnpj == "88888888888888" || 
            cnpj == "99999999999999")
            return false;
            
        // Valida DVs
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;
            
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;
                
        return true;
        
    }

    function checarCnpj(dado){
        if(!validarCNPJ(dado.value)){
            $('.cnpj').addClass("is-invalid");
            $('.cnpj').val("");
        } else {
            verificaCliente(dado.value);
        }
    }
    
    function construirContatos() {
        let resposta = []
        $('.contato-grupo').each(function() {
            contato = new Object();
            contato.nome = $('.nome-contato', this).val();
            contato.telefone = $('.telefone-contato', this).val();
            contato.email = $('.email-contato', this).val();
            contato.cargo = $('.cargo-contato', this).val();
            resposta.push(contato);
        })
        return resposta;
    }
    
    $('#adicionar-contato').click(function() {
        let contato = $('.nome-contato:last').val();
        let telefone = $('.telefone-contato:last').val();
        let email = $('.email-contato:last').val();
        if ((contato == '') || (telefone == '' && email == '')) {
            $('#texto-aviso').text(`
                Preencha pelo menos um nome e um telefone e/ou e-mail antes de criar outro contato.
            `);
            $('#modalAviso').modal();
            return false;
        }
        $('#fieldset-contatos').append(`
            <div class="contato-grupo">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Contato</span>
                    </div>
                    <input name="contato[nome][]" type="text" class="form-control nome-contato" />
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Telefone</span>
                            </div>
                            <input name="contato[telefone][]" type="text" class="form-control telefone-contato" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">E-mail</span>
                            </div>
                            <input name="contato[email][]" type="email" class="form-control email-contato" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Cargo / Função</span>
                            </div>
                            <input name="contato[cargo][]" type="text" class="form-control cargo-contato" />
                        </div>
                    </div>
                </div>
            </div>
        `);
    });

    function verificaCliente(dado){
        dado = dado.replace("/", "barra");
        $.get("<?=base_url("dadoscliente/verificaClienteCnpj/$cliente->id/")?>"+dado, function(result){
            if(result && result == "200"){
                $('.cnpj').removeClass("is-invalid");
            } else {
                $('.cnpj').addClass("is-invalid");
                $('#cnpj').val("");
                alert("Já existe uma conta com este CNPJ");
            }
        });
    }
</script>
