<script>
    function layout4(ctx,w,h,fundo,cartaz,logo=false,i=0){
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
            
            var precoant = $("#precoant").val();

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
        ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#333333";
        ctx.font = "bold "+(140*tamanho_fonte)+"px "+$('#fonte').val(); 
        ctx.fillText(produtol1, 795, 140, 1562);
        
        ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#333333";
        ctx.font = ""+(100*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol2, 795, 240, 1562);

        ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#333333";
        ctx.font = ""+(80*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol3, 795, 320, 1562);

        //CÓDIGO DO PRODUTO
        ctx.textAlign = "left";
        ctx.font = "20px "+$('#fonte').val();
        ctx.fillText(codigo, 25, 315, 200);

        //INCLUE A MENSAGEM DE RODAPÉ
        ctx.fillStyle = "#ffffff";
        ctx.textAlign = "left";
        ctx.font = "bold "+(45)+"px "+$('#fonte').val();
        ctx.fillText(rodape, 25, h-20, w-50);

        //Preço anterior
        if(precoant != "" && precoant != "0,00"){
            //INCLUE O R$
            ctx.fillStyle = $("#cor_preco_anterior").val();
            ctx.textAlign = "left";
            ctx.font = "bold 50px "+$('#fonte').val();
            ctx.fillText("R$", 1165, h-500, 50);

            //INCLUE O PREÇO GRANDE
            ctx.textAlign = "left";
            ctx.font = "bold 200px "+$('#fonte').val();
            ctx.fillText(precoant, 1240, h-405, (w/4)-120);

            //INCLUE A MEDIDA
            ctx.textAlign = "right";
            ctx.font = "30px "+$('#fonte').val();
            ctx.fillText(unidade, w-55, h-365, (w/4)-90);
        }

        //INCLUE O R$
        ctx.fillStyle = $("#cor_preco").val();
        ctx.textAlign = "left";
        ctx.font = "bold 50px "+$('#fonte').val();
        ctx.fillText("R$", 1125, h-250, 50);

        //INCLUE O PREÇO GRANDE
        ctx.textAlign = "left";
        ctx.font = "bold 225px "+$('#fonte').val();
        ctx.fillText(preco, 1225, h-135, (w/4)-90);

        //INCLUE A MEDIDA
        ctx.textAlign = "right";
        ctx.font = "30px "+$('#fonte').val();
        ctx.fillText(unidade, w - 50, h-90, (w/4)-75);

        //A LOGOMARCA SE INCLUI AQUI
        if(logo){
            if($("#incluilogo").prop("checked")){
                var propLogo = logo.width/logo.height;
                var altLogo = 203, contLogo = 203, largLogo = propLogo*altLogo;
                var eixoY = 320;
                if(largLogo > 260){
                    largLogo = 203;
                    altLogo = largLogo/propLogo;
                    eixoY = eixoY + ((203-altLogo)/2);
                }
                ctx.drawImage(logo, 1255 + ((contLogo-largLogo)/2), eixoY, largLogo, altLogo);
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
                    var saida = "<img id='imgfinal' src='"+document.getElementById('cartaz').toDataURL()+"' width='80%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                    $('#ver_img').html(saida);
                    //MOSTRA O RESULTADO
                    $('#loader-cartaz').hide();
                    visuPaisagem();
                }
            } else if(id_tam == 'A5'){
                ct.onload = function(){
                    var margemDir = 18.0*3.78;
                    var margemSup = 10.0*3.78;
                    
                    cartaz.beginPath();
                    cartaz.strokeStyle = "#cecece";
                    cartaz.moveTo(-ct.height/2, margemSup);
                    cartaz.lineTo(ct.height*2, margemSup);
                    cartaz.lineWidth = 5;
                    cartaz.setLineDash([25]);
                    cartaz.stroke();

                    //linha do meio
                    cartaz.beginPath();
                    cartaz.moveTo(-ct.height/2, ((ct.width+margemDir)/2));
                    cartaz.lineTo(ct.height*2, ((ct.width+margemDir)/2));
                    cartaz.lineWidth = 5;
                    cartaz.setLineDash([25]);
                    cartaz.stroke();

                    if($("input[name='quadrante']:checked").val() == 1){
                        cartaz.drawImage(ct, -ct.height/2, ((ct.width+margemDir)/2), (ct.height)-margemDir, (ct.width/2)-margemSup);
                    } else {
                        cartaz.drawImage(ct, -ct.height/2, margemSup, (ct.height)-margemDir, (ct.width/2)-margemSup);
                    }
                    
                    var saida = "<img id='imgfinal' src='"+document.getElementById('cartaz').toDataURL()+"' width='80%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
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
                    
                    var saida = "<img id='imgfinal' src='"+document.getElementById('cartaz').toDataURL()+"' width='80%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                    $('#ver_img').html(saida);

                    //MOSTRA O RESULTADO
                    $('#loader-cartaz').hide();
                    
                    visuPaisagem();
                }
            }
        }
    }
</script>