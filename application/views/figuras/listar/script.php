<script>
    function deletarFigura(id) {
        $('#deletarFigura').modal()
        $("#confirmar-exclusao").click(function() {
            $.post('<?=base_url('index.php/figuras/excluir/')?>'+id, function(data){
                if (data != '') {
                    alert('Ocorreu um erro, contate o administrador')
                }
                location.reload()
            });
            /*$.ajax({
                url: ''+id,
                type: 'POST',
                data: { id },
                success: function(data) {
                    if (data != '') {
                        alert('Ocorreu um erro, contate o administrador')
                    }
                    location.reload()
                }
            })*/
        })
    }
</script>
