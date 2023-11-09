<script>
    function gerarPDFaviso(){
        $("#loader").show();
        $.get("<?php echo base_url('index.php/dashboard/checkImpressoesUsadas/'.$id); ?>", function(result){
            
            if(result){
                var tam = $('#tamanho').val().split('<|>');
                
                var id_tam = $('#tamanho').children(":selected").attr('id');
                var id = "A4"
                var tamanho = tam[1].split(' x ');
                var w = tamanho[1];
                var h = tamanho[0];

                if($('#avisohorizontal').prop('checked')){
                    w = tamanho[0];
                    h = tamanho[1];
                }

                var d = new Date();
                var doc = new jsPDF({
                    orientation: $("#avisohorizontal").prop("checked") ? "p" : "l",
                    format: [w,h]
                });

                var canvas = document.getElementById("aviso"+($("#avisohorizontal").prop("checked") ? "r" : "h"));
                
                const imagem = canvas.toDataURL("image/jpeg");

                doc.addImage(imagem, "JPEG", 0, 0, w, h);

                // doc.save(id_tam+'_aviso_'+d.getTime()+'.pdf');
                window.open(doc.output('bloburl'));

                $.get("<?php echo base_url('index.php/dashboard/contarImpressaoUsada/'.$id); ?>");
            } else {
                $('#texto-aviso').html("Você usou todos os créditos disponível!!<br><br>Obtenha mais créditos para continuar utilizando nossos serviços.");
                $("#modalAviso").modal('show');
            }
            $("#loader").hide();
        });
    }
</script>