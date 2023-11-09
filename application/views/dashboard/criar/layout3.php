<script>
    //CARTÃO DA LOJA / CLUBE FIDELIDADE
    function layout3(ctx,w,h,fundo,cartaz,logo=false,i=0){
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
        if($("#layout").val() != 15){
            ctx.textAlign = "left";
            ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#333333";
            ctx.font = "bold "+(75*tamanho_fonte)+"px "+$('#fonte').val(); 
            ctx.fillText(produtol1, 50, h-475, 650);
            
            ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#333333";
            ctx.font = ""+(50*tamanho_fonte)+"px "+$('#fonte').val();
            ctx.fillText(produtol2, 50, h-400, 650);

            ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#333333";
            ctx.font = ""+(45*tamanho_fonte)+"px "+$('#fonte').val();
            ctx.fillText(produtol3, 50, h-350, 650);
        } else {
            ctx.textAlign = "center";
            ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#333333";
            ctx.font = ""+(120*tamanho_fonte)+"px "+$('#fonte').val(); 
            ctx.fillText(produtol1, w/2, 100 + (h/4), w-100);
            
            ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#333333";
            ctx.font = ""+(120*tamanho_fonte)+"px "+$('#fonte').val();
            ctx.fillText(produtol2, w/2, 230 + (h/4), w-100);

            ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#333333";
            ctx.font = ""+(120*tamanho_fonte)+"px "+$('#fonte').val();
            ctx.fillText(produtol3, w/2, 360 + (h/4), w-100);    
        }

        //CÓDIGO DO PRODUTO
        ctx.textAlign = "right";
        ctx.font = "20px "+$('#fonte').val();
        ctx.fillText(codigo, 590, h-275, 100);

        //INCLUE A MENSAGEM DE RODAPÉ
        ctx.fillStyle = "#ffffff";
        ctx.textAlign = "left";
        ctx.font = "bold 33px "+$('#fonte').val();
        ctx.fillText(rodape, 33, h-17, w-33);

        if(precoant != "" && precoant != "0,00"){
            //INCLUE O R$
            ctx.fillStyle = $("#cor_preco_anterior").val();
            ctx.textAlign = "left";
            ctx.font = "bold 40px "+$('#fonte').val();
            ctx.fillText("R$", 750, h-500, 45);

            //INCLUE O PREÇO GRANDE
            ctx.textAlign = "left";
            ctx.font = "bold 175px "+$('#fonte').val();
            ctx.fillText(precoant, 800, h-405, (w/4)-40);

            //INCLUE A MEDIDA
            ctx.font = "25px "+$('#fonte').val();
            ctx.textAlign = "right";
            ctx.fillText(unidade, w-70, h-365, w/4);
        }

        //INCLUE O R$
        ctx.fillStyle = $("#cor_preco").val();
        ctx.textAlign = "left";
        ctx.font = "bold 50px "+$('#fonte').val();
        ctx.fillText("R$", 700, h-250, 50);

        //INCLUE O PREÇO GRANDE
        ctx.textAlign = "left";
        ctx.font = "bold 225px "+$('#fonte').val();
        ctx.fillText(preco, 780, h-130, (w/4));

        //INCLUE A MEDIDA
        ctx.textAlign = "right";
        ctx.font = "30px "+$('#fonte').val();
        ctx.fillText(unidade, w-60, h-80, w/4);

        //A LOGOMARCA SE INCLUI AQUI
        if(logo){
            if($("#incluilogo").prop("checked")){
                var propLogo = logo.width/logo.height;
                var altLogo = 125, contLogo = 370, largLogo = propLogo*altLogo;
                var eixoY = h-altLogo-85;
                if(largLogo > 340){
                    largLogo = 340;
                    altLogo = largLogo/propLogo;
                    eixoY = eixoY + ((125-altLogo)/2);
                }
                ctx.drawImage(logo, (contLogo-largLogo)/2, eixoY, largLogo, altLogo);
            }
        }

        //TEXTO LATERAL
        ctx.fillStyle = "#333333";
        ctx.rotate(-90*Math.PI/180);
        ctx.textAlign = "left";
        ctx.font = "bold 20px Arial";
        ctx.fillText("www.pressla.com.br", -h+275, 25, w-33);

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