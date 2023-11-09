<script>
    function deletarproduto(id) {
        $('#deletarproduto').modal()
        $("#confirmar-exclusao").click(function() {
            $.ajax({
                url: '<?=base_url('index.php/produtos/excluir')?>',
                type: 'POST',
                data: { id },
                success: function(data) {
                    if (data != '') {
                        alert('Ocorreu um erro, contate o administrador')
                    }
                    window.location.href = "<?= base_url("index.php/produtos") ?>"
                }
            })
        })
    }
    function deletarprodutosmassa() {
        $('#deletarprodutosmassa').modal();
    }
    function alterarcategoriaprodutosmassa(valor) {
        $('[name=categoria_modal]').val(valor);
        $('#altcategoriamassa').modal();
    }
</script>
