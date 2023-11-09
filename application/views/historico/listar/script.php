<script>
    $('#tabela-historico').DataTable( {
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
