<script>
    function deletarTemplateTipo(id) {
        $('#deletarTemplateTipo').modal()
        $("#confirmar-exclusao").click(function() {
            $.post('<?=base_url('index.php/templates/excluirtipo/')?>'+id, function(data){
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
