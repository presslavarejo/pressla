<script>
    function continuarAviso(ctx,w,h,fundo,aviso,id_tam,logo){
        var rodape = $("#rodapeaviso").val() ? $("#rodapeaviso").val() : "";
        //var linha1 = $("#linha1").val() ? $("#linha1").val() : "Primeira Linha";

        var size = $(".textoaviso").length;
        var fontsize = $("#size").val();

        for(var i = 0; i < size; i++){
            //TEXTO DO AVISO
            ctx.textAlign = "center";
            ctx.font = "bold "+(67*fontsize)+"px "+$('#fonte').val();
            ctx.fillStyle = "#333333";
            if($('#avisohorizontal').prop('checked') && id_tam != "A5"){
                ctx.fillText($(".textoaviso")[i].value, w/2, (67*(fontsize-1))+h/8+50+((83*fontsize)*i), w-67);    
            } else {
                ctx.fillText($(".textoaviso")[i].value, w/2, (67*(fontsize-1))+h/4+((83*fontsize)*i), w-67);
            }
        }
        
        //INCLUE A MENSAGEM DE RODAPÉ
        ctx.textAlign = "left";
        ctx.font = "bold "+(h/48)+"px "+$('#fonte').val();
        ctx.fillText(rodape, 33, h-17, w-33);

        <?php if($this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca){ ?>
        if($("#avisohorizontal").prop("checked")){
            if($("#incluilogo").prop("checked")){
                ctx.drawImage(logo, w-33-(w/5), h-67-((w/5)*logo.height/logo.width), (w/5), (w/5) * logo.height / logo.width);
            }
        } else {
            if($("#incluilogo").prop("checked")){
                ctx.drawImage(logo, w-33-(w/10), h-67-((w/10)*logo.height/logo.width), (w/10), (w/10) * logo.height / logo.width);
            }
        }
        <?php } ?>

        var ct = new Image();
        ct.src = document.getElementById('aviso'+($("#avisohorizontal").prop("checked") ? "r" : "h")+$("input[name='quadrante']:checked").val()).toDataURL();
        
        if(id_tam != "A5" && id_tam != "A6"){
            ct.onload = function(){
                aviso.drawImage(ct, 0, 0, ct.width, ct.height);
                var saida = "<img id='imgfinal' src='"+document.getElementById('aviso'+($("#avisohorizontal").prop("checked") ? "r" : "h")).toDataURL()+"' width='"+($("#avisohorizontal").prop("checked") ? "60%" : "80%")+"' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                $('#ver_img').html(saida);
                //MOSTRA O RESULTADO
                $('#loader-cartaz').hide();
                
                //visuPaisagem();
            }
        } else if(id_tam == 'A5'){
            ct.onload = function(){
                if($("input[name='quadrante']:checked").val() == 1){
                    aviso.rect(0, 0, w, h);
                    aviso.fillStyle = "#FFFFFF";
                    aviso.fill();
                }
                
                if($('#avisohorizontal').prop('checked')){
                    if($("input[name='quadrante']:checked").val() == 1){
                        aviso.drawImage(ct, 0, 0, ct.height, ct.width/2);
                    } else {
                        aviso.drawImage(ct, 0, ct.width/2, ct.height, ct.width/2);
                    }
                } else {
                    var margemSup = 18.0*3.78;
                    var margemDir = 10.0*3.78;
                    
                    aviso.beginPath();aviso.strokeStyle = "#cecece";
                    aviso.moveTo(-ct.height/2, margemSup);
                    aviso.lineTo(ct.height*2, margemSup);
                    aviso.lineWidth = 5;
                    aviso.setLineDash([25]);
                    aviso.stroke();

                    //linha do meio
                    aviso.beginPath();
                    aviso.moveTo(ct.width/2, margemSup);
                    aviso.lineTo(ct.width/2, ct.width*2);
                    aviso.lineWidth = 5;
                    aviso.setLineDash([25]);
                    aviso.stroke();

                    if($("input[name='quadrante']:checked").val() == 1){
                        aviso.drawImage(ct, 0, margemSup, (ct.width/2)-margemDir, (ct.height)-margemSup);
                    } else {
                        aviso.drawImage(ct, (ct.width/2)+margemDir, margemSup, (ct.width/2)-margemDir, (ct.height)-margemSup);
                    }
                    // if($("input[name='quadrante']:checked").val() == 1){
                    //     aviso.drawImage(ct, 0, 0, ct.height/2, ct.width/2);
                    // } else {
                    //     aviso.drawImage(ct, 0, ct.width/2, ct.height, ct.width/2);
                    // }
                }
                
                var saida = "<img id='imgfinal' src='"+document.getElementById('aviso'+($("#avisohorizontal").prop("checked") ? "r" : "h")).toDataURL()+"' width='"+($("#avisohorizontal").prop("checked") ? "60%" : "80%")+"' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                $('#ver_img').html(saida);
                //MOSTRA O RESULTADO
                $('#loader-cartaz').hide();
                
                //visuPaisagem();
            }
        } else if(id_tam == 'A6'){
            ct.onload = function(){
                
                if($("input[name='quadrante']:checked").val() == 1){
                    aviso.drawImage(ct, 0, 0, ct.width/2, ct.height/2);
                } else if($("input[name='quadrante']:checked").val() == 2){
                    aviso.drawImage(ct, ct.width/2, 0, ct.width/2, ct.height/2);
                } else if($("input[name='quadrante']:checked").val() == 3){
                    aviso.drawImage(ct, 0, ct.height/2, ct.width/2, ct.height/2);
                } else {
                    aviso.drawImage(ct, ct.width/2, ct.height/2, ct.width/2, ct.height/2);
                }
                
                var saida = "<img id='imgfinal' src='"+document.getElementById('aviso'+($("#avisohorizontal").prop("checked") ? "r" : "h")).toDataURL()+"' width='80%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                $('#ver_img').html(saida);

                //MOSTRA O RESULTADO
                $('#loader-cartaz').hide();
                
                //visuPaisagem();
            }
        }
    }
</script>