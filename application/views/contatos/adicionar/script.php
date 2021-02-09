<script>
    $('#frm-contato').submit(function(ev) {
        ev.preventDefault()
        $('#enviar').prop('disabled', true)
        let contato = new Object()
        contato.nome = $('#nome').val()
        contato.valor = $('#valor').val()
        contato = JSON.stringify(contato)
        $.ajax({
            url: "<?=base_url('index.php/contatos/add')?>",
            type: 'POST',
            data: {contato},
            success: function(data) {
                if (data == 'erro-500') {
                    $('#alerta-erro').show('fast')
                    setTimeout(() => {
                        $('#alerta-erro').hide('fast')
                        $('#enviar').prop('disabled', false)
                    }, 2500)
                } else {
                    $(window).scrollTop(0)
                    $('#alerta-sucesso').show('fast')
                    $('#frm-contato')[0].reset()
                    setTimeout(() => {
                        $('#alerta-sucesso').hide('fast')
                        $('#enviar').prop('disabled', false)
                    }, 2500)
                }
            }
        })
    })
</script>
