<script>
    <?php 
    if(isset($id)){
        if($id==1){
    ?>
        $(window).scrollTop(0);
        $('#alerta-sucesso').show('fast');
        $('#frm-cliente')[0].reset();
        setTimeout(() => {
            $('#alerta-sucesso').hide('fast')
        }, 2500);
    <?php 
        } else {
    ?>
        $('#alerta-erro').show('fast');
        setTimeout(() => {
            $('#alerta-erro').hide('fast')
        }, 2500);
    }
    <?php 
        }
    }
    ?>

    function construirContatos() {
        let resposta = []
        $('.contato-grupo').each(function() {
            contato = new Object()
            contato.nome = $('.nome-contato', this).val()
            contato.telefone = $('.telefone-contato', this).val()
            contato.email = $('.email-contato', this).val()
            contato.cargo = $('.cargo-contato', this).val()
            resposta.push(contato)
        })
        return resposta
    }

    $('#adicionar-contato').click(function() {
        let contato = $('.nome-contato:last').val()
        let telefone = $('.telefone-contato:last').val()
        let email = $('.email-contato:last').val()
        if ((contato == '') || (telefone == '' && email == '')) {
            $('#texto-aviso').text(`
                Preencha pelo menos um nome e um telefone e/ou e-mail antes de criar outro contato.
            `)
            $('#modalAviso').modal()
            return false
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
        `)
    })
</script>
