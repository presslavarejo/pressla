<script>
    function deletarContato(id) {
        $('#deletarContato').modal()
        $("#confirmar-exclusao").click(function() {
            $.ajax({
                url: '<?=base_url('index.php/contatos/excluir')?>',
                type: 'POST',
                data: { id },
                success: function(data) {
                    if (data != '') {
                        alert('Ocorreu um erro, contate o administrador')
                    }
                    location.reload()
                }
            })
        })
    }
</script>
