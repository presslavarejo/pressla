<script>
    function criaAviso(){
        var path = "assets/images/templates/";
        $('#loader-cartaz').show();
        if($('#src_template').val() != null){
            var tam = $('#A3').val().split('<|>');
            var tamanho = tam[1].split(' x ');
            var w = parseFloat(tamanho[1])*3.78;
            var h = parseFloat(tamanho[0])*3.78;
            
            var fator = tam[0];
            var id_tam = $('#tamanho').children(":selected").attr('id');

            if($('#avisohorizontal').prop('checked') && id_tam != "A5"){
                w = parseFloat(tamanho[0])*3.78;
                h = parseFloat(tamanho[1])*3.78;
            }
            
            var canvasHTML = "<canvas id='aviso"+($("#avisohorizontal").prop("checked") ? "r" : "h")+$("input[name='quadrante']:checked").val()+"' width='"+w+"' height='"+h+"'></canvas>";
            $('#container_aviso'+($("#avisohorizontal").prop("checked") ? "r" : "h")+$("input[name='quadrante']:checked").val()).html(canvasHTML);
            
            //Recebemos o elemento canvas
            var ctx = carregarContextoCanvas('aviso'+($("#avisohorizontal").prop("checked") ? "r" : "h")+$("input[name='quadrante']:checked").val());
            var aviso = carregarContextoCanvas('aviso'+($("#avisohorizontal").prop("checked") ? "r" : "h"));
            if(ctx && aviso){
                //Crio uma imagem com um objeto Image de Javascript
                var fundo = new Image();
                //indico a URL da imagem
                fundo.src = "<?php echo base_url(); ?>"+path+$('#src_template').val();
                //defino o evento onload do objeto imagen
                fundo.onload = function(){
                    //INCLUE O FUNDO
                    ctx.beginPath();
                    ctx.rect(0, 0, w, h);
                    ctx.fillStyle = "#FFFFFF";
                    ctx.fill();
                    ctx.drawImage(fundo, 0, 0, w, w * fundo.height / fundo.width);

                    var logo = new Image();
                    logo.src = "<?php echo base_url().'assets/images/logomarcas/'.$this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca; ?>";
                    <?php if($this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca){ ?>
                    logo.onload = function(){
                        continuarAviso(ctx,w,h,fundo,aviso,id_tam,logo);
                    }
                    <?php } else { ?>
                        continuarAviso(ctx,w,h,fundo,aviso,id_tam,logo);
                    <?php } ?>
                }
            }
        }
    }
</script>