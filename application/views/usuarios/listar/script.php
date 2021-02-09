<script>
    $(document).ready(function() {
		if ($(window).width() <= 400) {
			$('#tabela-usuarios').dataTable({
				'order': [0, 'desc'],
				"language": idioma,
				"scrollX": true,
				"searching": false,
				"bLengthChange": false
			})
		} else {
			$('#tabela-usuarios').dataTable({
				'order': [0, 'desc'],
				"language": idioma
			})
		}
	})
	

    function deletarUsuario(id) {
        $('#deletarUsuario').modal()
        $("#confirmar-exclusao").click(function() {
            $.ajax({
                url: '<?=base_url('index.php/login/delete')?>',
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
