<script>
    //Atacado e Varejo - Vertical
    function layout9(ctx,w,h,fundo,cartaz,logo=false,i=0){

        var tamanho_fonte = $("#tamanho_fonte").val() / 100;

        if(typeof dadosdafila != "undefined" && dadosdafila.length > i){
            var context = ctx[1];
            ctx = ctx[0];
            
            var preco = dadosdafila[i][5].replace(".",",");
            var precoant = dadosdafila[i][4].replace(".",",");

            var unidade = dadosdafila[i][6];
            var rodape = dadosdafila[i][7];
            var codigo = "";

            var desc = separaTexto(dadosdafila[i][1]);

            var produtol1 = desc.shift();
            var produtol2 = desc.length > 0 ? desc.shift() : "";
            var produtol3 = desc.length > 0 ? desc.join(" ") : "";    
        
        } else if(typeof dadosdafila != "undefined"){
            return;
        } else {
            var preco = $("#preco").val() ? $("#preco").val() : "0,99";
            var precoant = $("#precoant").val() ? $("#precoant").val() : "0,99";
            
            var unidade = $("#unidade").val() ? $("#unidade").val() : "Un";
            var rodape = $("#rodape").val() ? $("#rodape").val() : "";
            var codigo = $("#codigo").val() ? "Cod.: "+$("#codigo").val() : "";

            var produtol1 = descproduto[0][0].replace("&nbsp;","");
            var produtol2 = descproduto.length > 1 && descproduto[1][0] != "&nbsp;" ? descproduto[1][0].replace("&nbsp;","") : "";
            var produtol3 = descproduto.length > 2 && descproduto[2][0] != "&nbsp;" ? descproduto[2][0].replace("&nbsp;","") : "";

            var cor_produtol1 = descproduto[0][1];
            var cor_produtol2 = descproduto.length > 1 ? descproduto[1][1] : "";
            var cor_produtol3 = descproduto.length > 2 ? descproduto[2][1] : "";

            var idCartaz = $("#id_cartaz").val();
        }
        
        //INCLUE O NOME DO PRODUTO
        ctx.textAlign = "center";
        ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#000000";
        ctx.font = ""+(120*tamanho_fonte)+"px "+$('#fonte').val(); 
        ctx.fillText(produtol1, w/2, 100 + (h/4), w-100);
        
        ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#000000";
        ctx.font = ""+(120*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol2, w/2, 230 + (h/4), w-100);

        ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#000000";
        ctx.font = ""+(120*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol3, w/2, 360 + (h/4), w-100);
        

        //INCLUE A MENSAGEM DE RODAPÉ
        ctx.fillStyle = "#FFFFFF";
        ctx.textAlign = "left";
        ctx.fillStyle = "#333333";
        ctx.font = ""+(30)+"px "+$('#fonte').val();
        ctx.fillText(rodape, 33, h-20, w-33);

        //Preço Atacado
        //INCLUE O R$
        ctx.fillStyle = $("#cor_preco").val();
        ctx.textAlign = "left";
        ctx.font = "bold 75px "+$('#fonte').val();
        ctx.fillText("R$", 65, h-220-225, 100);

        //INCLUE O PREÇO ATACADO
        ctx.textAlign = "center";
        ctx.font = "bold 250px "+$('#fonte').val();
        ctx.fillText(preco, w/4+10, h-230, (w/2)-80);

        //INCLUE A FRASE ACIMA DE ATACADO
        ctx.textAlign = "left";
        ctx.font = "35px "+$('#fonte').val();
        ctx.fillText($("#acimade").val(), 65, h-135, (w/2)-100);

        //Preço Varejo
        //INCLUE O R$
        ctx.fillStyle = $("#cor_preco_anterior").val();
        ctx.textAlign = "left";
        ctx.font = "bold 75px "+$('#fonte').val();
        ctx.fillText("R$", (w/2)+25, h-220-225, 100);

        //INCLUE O PREÇO VAREJO
        ctx.textAlign = "center";
        ctx.font = "bold 250px "+$('#fonte').val();
        ctx.fillText(precoant, 3*(w/4)-10, h-230, (w/2)-80);

        //INCLUE A FRASE ACIMA DE ATACADO
        ctx.textAlign = "left";
        ctx.font = "35px "+$('#fonte').val();
        ctx.fillText($("#acimadevarejo").val(), (w/2)+25, h-135, (w/2)-100);

        //A LOGOMARCA SE INCLUI AQUI
        if(logo){
            if($("#incluilogo").prop("checked")){
                var propLogo = logo.width/logo.height;
                var altLogo = 125, contLogo = 370, largLogo = propLogo*altLogo;
                var eixoY = h/2 + (altLogo/2);
                if(largLogo > 340){
                    largLogo = 340;
                    altLogo = largLogo/propLogo;
                    eixoY = h/2 + (altLogo/2);
                    eixoY = eixoY + ((125-altLogo)/2);
                }
                
                ctx.drawImage(logo, 33, eixoY, largLogo, altLogo);
            }
        }

        if(typeof dadosdafila != "undefined" && dadosdafila.length > i){
            if(i < context.length-1){
                continuarCartazFila(context, w, h, fundo, cartaz, null, ++i);
            } else {
                mostrarPrototipos();
            }
        } else {

            var ct = new Image();
            ct.src = document.getElementById('cartaz'+$("input[name='quadrante']:checked").val()).toDataURL();
            var id_tam = $('#tamanho').children(":selected").attr('id');

            if(id_tam != "A5" && id_tam != "A6"){
                ct.onload = function(){
                    cartaz.drawImage(ct, 0, 0, ct.width, ct.height);
                    var saida = "<img id='imgfinal' src='"+document.getElementById('cartaz').toDataURL()+"' width='60%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                    $('#ver_img').html(saida);
                    //MOSTRA O RESULTADO
                    $('#loader-cartaz').hide();
                    visuPaisagem();
                }
            } else if(id_tam == 'A5'){
                ct.onload = function(){
                    var margemSup = 18.0*3.78;
                    var margemDir = 10.0*3.78;
                    
                    cartaz.beginPath();
                    cartaz.strokeStyle = "#cecece";
                    cartaz.moveTo(-ct.height/2, margemSup);
                    cartaz.lineTo(ct.height*2, margemSup);
                    cartaz.lineWidth = 5;
                    cartaz.setLineDash([25]);
                    cartaz.stroke();

                    //linha do meio
                    cartaz.beginPath();
                    cartaz.moveTo(0, margemSup);
                    cartaz.lineTo(0, ct.width*2);
                    cartaz.lineWidth = 5;
                    cartaz.setLineDash([25]);
                    cartaz.stroke();

                    if($("input[name='quadrante']:checked").val() == 1){
                        cartaz.drawImage(ct, -ct.height/2, margemSup, (ct.height/2)-margemDir, ct.width-margemSup);
                    } else {
                        cartaz.drawImage(ct, margemDir, margemSup, (ct.height/2)-margemDir, ct.width-margemSup);
                    }
                    
                    var saida = "<img id='imgfinal' src='"+document.getElementById('cartaz').toDataURL()+"' width='60%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                    $('#ver_img').html(saida);
                    //MOSTRA O RESULTADO
                    $('#loader-cartaz').hide();
                    
                    visuPaisagem();
                }
            } else if(id_tam == 'A6'){
                ct.onload = function(){
                    
                    if($("input[name='quadrante']:checked").val() == 1){
                        cartaz.drawImage(ct, 0, 0, ct.width/2, ct.height/2);
                    } else if($("input[name='quadrante']:checked").val() == 2){
                        cartaz.drawImage(ct, ct.width/2, 0, ct.width/2, ct.height/2);
                    } else if($("input[name='quadrante']:checked").val() == 3){
                        cartaz.drawImage(ct, 0, ct.height/2, ct.width/2, ct.height/2);
                    } else {
                        cartaz.drawImage(ct, ct.width/2, ct.height/2, ct.width/2, ct.height/2);
                    }
                    
                    var saida = "<img id='imgfinal' src='"+document.getElementById('cartaz').toDataURL()+"' width='60%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                    $('#ver_img').html(saida);

                    //MOSTRA O RESULTADO
                    $('#loader-cartaz').hide();
                    
                    visuPaisagem();
                }
            }
        }
    }
</script>