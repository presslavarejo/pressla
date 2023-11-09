<script>
    function deletarTemplate(id) {
        $('#deletarTemplate').modal()
        $("#confirmar-exclusao").click(function() {
            $.post('<?=base_url('index.php/templates/excluir/')?>'+id, function(data){
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

    $('#tabela-templates').DataTable( {
        dom:"lBfrtip",
        // buttons: ['excel', 'pdf'],
        buttons: [
            {
                extend: 'pdfHtml5',
                download: 'open',
                orientation: 'portrait',
                title: 'Pressla - <?=date("d/m/Y")?>'
            },
            {
                extend: ['excelHtml5'],
                messageTop: 'Pressla - <?=date("d/m/Y")?>'
            }
        ],
        language: {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "Não há registros para os parâmetros informados",
            "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "infoEmpty": "A tabela está vazia",
            "infoFiltered": "(filtrado de _MAX_ registros)",
            "emptyTable": "Nenhum registro encontrado",
            "infoThousands": ".",
            "loadingRecords": "Carregando...",
            "processing": "Processando...",
            "search": "Pesquisar",
            "paginate": {
                "next": "Próximo",
                "previous": "Anterior",
                "first": "Primeiro",
                "last": "Último"
            }
        }
    });
</script>
