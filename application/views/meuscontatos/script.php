<script>
    function deletarcontato(id) {
        $('#deletarcontato').modal()
        $("#confirmar-exclusao").click(function() {
            $.ajax({
                url: '<?=base_url('index.php/meuscontatos/excluir')?>',
                type: 'POST',
                data: { id },
                success: function(data) {
                    if (data != '') {
                        alert('Ocorreu um erro, contate o administrador')
                    }
                    window.location.href = "<?= base_url("index.php/meuscontatos") ?>"
                }
            })
        })
    }
    function deletarcontatosmassa() {
        $('#deletarcontatosmassa').modal();
    }
    function alterarlistacontatosmassa(valor) {
        $('[name=categoria_modal]').val(valor);
        $('#altcategoriamassa').modal();
    }
</script>
