<script>
    $('#frm-usuario').submit(function(ev) {
        ev.preventDefault();
        $('#enviar').prop('disabled', true)
        let usuario = new Object()
        usuario.nome = $('#nome').val()
        usuario.login = $('#login').val()
        usuario.senha = $('#senha').val()
        usuario.tipo = $('#tipo').val()
        usuario = JSON.stringify(usuario)
        $.ajax({
            url: "<?=base_url('index.php/login/add')?>",
            type: 'POST',
            data: {usuario},
            success: function(data) {
				$('#enviar').prop('disabled', false)
                if (data == 'erro-500') {
                    $('#alerta-erro').removeClass('hide')
                    setTimeout(() => {
                        $('#alerta-erro').addClass('hide')
                    }, 2500)
                } else if (data == 'erro-409') {
					$('#texto-aviso').text('Este e-mail já existe! Por favor, escolha outro');
					$('#modalAviso').modal();
					return;
				} else {
                    $('#usuario-link').attr("href", `<?=base_url('index.php/login/gerenciar/')?>${data}`)
                    $(window).scrollTop(0)
                    $('#alerta-sucesso').removeClass('hide')
                    $('#frm-usuario')[0].reset()
                    setTimeout(() => {
                        $('#alerta-sucesso').addClass('hide')
                    }, 2500)
                }
            }
        })
    })
</script>
