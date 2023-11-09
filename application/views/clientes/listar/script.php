<script>
    function deletarCliente(id) {
        $('#deletarCliente').modal()
        $("#confirmar-exclusao").click(function() {
            $.ajax({
                url: '<?=base_url('index.php/clientes/excluir')?>',
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

    $('#tabela-clientes').DataTable( {
        dom:"lBfrtip",
        // buttons: ['excel', 'pdf'],
        buttons: [
            {
                extend: 'pdfHtml5',
                download: 'open',
                orientation: 'landscape',
                title: 'Pressla - <?=date("d/m/Y")?>',
                exportOptions: {
                    columns: "thead th:not(.noExport)"
                }
            },
            {
                extend: ['excelHtml5'],
                messageTop: 'Pressla - <?=date("d/m/Y")?>',
                exportOptions: {
                    columns: "thead th:not(.noExport)"
                }
            }
        ],
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 6 ] }
        ],
        "aaSorting": [[1, "asc"]],
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
