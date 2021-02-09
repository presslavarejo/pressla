<script>
    $('#frm-contato').submit(function(ev) {
        ev.preventDefault()
        $('#enviar').prop('disabled', true)
        let contato = new Object()
        contato.id = $('#id').val()
        contato.nome = $('#nome').val()
        contato.valor = $('#valor').val()
        contato = JSON.stringify(contato)
        $.ajax({
            url: "<?=base_url('index.php/contatos/update')?>",
            type: 'POST',
            data: {contato},
            success: function(data) {
                if (data == '200') {
                    $(window).scrollTop(0)
                    $('#alerta-sucesso').show('fast')
                    setTimeout(() => {
                        $('#alerta-sucesso').hide('fast')
                        $('#enviar').prop('disabled', false)
                    }, 2500)
                } else {
                    $('#alerta-erro').show('fast')
                    setTimeout(() => {
                        $('#alerta-erro').hide('fast')
                        $('#enviar').prop('disabled', false)
                    }, 2500)
                }
            }
        })
    })
</script>
