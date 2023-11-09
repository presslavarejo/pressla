<script>
    function layout13(ctx,w,h,fundo,cartaz,logo,figura,i=0){
        var celula = $("input[name='quadrante']:checked").val();

        var dados = false;

        var tamanho_fonte = $("#tamanho_fonte").val()/100;

        if(typeof dadosdafila != "undefined" && dadosdafila.length > i){
            var context = ctx[1];
            ctx = ctx[0];
            
            var preco = dadosdafila[i][5].replace(".",",");

            var unidade = dadosdafila[i][6];
            var rodape = dadosdafila[i][7];

            var desc = separaTexto(dadosdafila[i][1]);

            var produtol1 = desc.shift();
            var produtol2 = desc.length > 0 ? desc.shift() : "";
            var produtol3 = desc.length > 0 ? desc.join(" ") : "";    
        
        } else if(typeof dadosdafila != "undefined"){
            return;
        } else {

            var preco = $("#preco").val() ? $("#preco").val() : "0,99";
            
            var unidade = $("#unidade").val() ? $("#unidade").val() : "Un";
            var rodape = $("#rodape").val() ? $("#rodape").val() : "";

            var produtol1 = descproduto[0][0].replace("&nbsp;","");
            var produtol2 = descproduto.length > 1 && descproduto[1][0] != "&nbsp;" ? descproduto[1][0].replace("&nbsp;","") : "";
            var produtol3 = descproduto.length > 2 && descproduto[2][0] != "&nbsp;" ? descproduto[2][0].replace("&nbsp;","") : "";

            var cor_produtol1 = descproduto[0][1];
            var cor_produtol2 = descproduto.length > 1 ? descproduto[1][1] : "";
            var cor_produtol3 = descproduto.length > 2 ? descproduto[2][1] : "";

            if(isPrimeiro()){
                if(dados_quadrante[celula]){
                    dados = dados_quadrante[celula];
                    
                    preco = dados[0];
                    $("#preco").val(dados[0])
                    
                    produtol1 = dados[1][0];
                    cor_produtol1 = dados[1][1];
                    produtol2 = dados[2][0];
                    cor_produtol2 = dados[2][1];
                    produtol3 = dados[3][0];
                    cor_produtol3 = dados[3][1];
                    if(produtol1 && produtol2 && produtol3){
                        Editor_master.setData('<p><span style="color:'+(cor_produtol1 ? cor_produtol1 : "hsl(0, 0, 0);")+'">'+produtol1+'</span></p><p><span style="color:'+(cor_produtol2 ? cor_produtol2 : "hsl(0, 0, 0);")+'">'+produtol2+'</span></p><p><span style="color:'+(cor_produtol3 ? cor_produtol3 : "hsl(0, 0, 0);")+'">'+produtol3+'</span></p>');
                    } else if(produtol1 && produtol2){
                        Editor_master.setData('<p><span style="color:'+(cor_produtol1 ? cor_produtol1 : "hsl(0, 0, 0);")+'">'+produtol1+'</span></p><p><span style="color:'+(cor_produtol2 ? cor_produtol2 : "hsl(0, 0, 0);")+'">'+produtol2+'</span></p>');
                    } else if(produtol1){
                        Editor_master.setData('<p><span style="color:'+(cor_produtol1 ? cor_produtol1 : "hsl(0, 0, 0);")+'">'+produtol1+'</span></p>');
                    } else {
                        Editor_master.setData('');
                    }
                    unidade = dados[5];
                    $("#unidade").val(dados[5]);
                } else {
                    preco = "";
                    $("#preco").val("")
                    
                    produtol1 = "";
                    cor_produtol1 = "#000000";
                    produtol2 = "";
                    cor_produtol2 = "#000000";
                    produtol3 = "";
                    cor_produtol3 = "#000000";
                    Editor_master.setData('');
                    unidade = "";
                    $("#unidade").val("");
                }

                if(dados && dados[6]){
                    $("#imagematual").attr("src", dados[6][0].src);
                    figura = dados[6];
                    $("#controles").show("fast");
                } else {
                    $("#controles").hide("fast");
                    $("#imagematual").attr("src", "");
                    figura = false;
                }

                setPrimeiro(false);
            }

            var idCartaz = $("#id_cartaz").val();
        }

        if(!dados){
            dados = [preco, [produtol1, cor_produtol1], [produtol2, cor_produtol2], [produtol3, cor_produtol3], $('#src_template').val(), $("#unidade").val(), figura];
            dados_quadrante[celula] = dados;
        }

        if(figura){
            dados[6] = figura;
            dados_quadrante[celula] = dados;
            // ctx.drawImage(figura, eixoX, h-25-altfigura + (parseInt($('#cima').val())*50), largfigura, altfigura);
            ctx.drawImage(dados[6][0], dados[6][1], dados[6][2], dados[6][3], dados[6][4]);
        }


        //INCLUE O NOME DO PRODUTO
        ctx.textAlign = "left";
        ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#000000";
        ctx.font = ""+(55*1.3*tamanho_fonte)+"px "+$('#fonte').val(); 
        ctx.fillText(produtol1, 35, 55 + (h/4), w-75);
        
        ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#000000";
        ctx.font = ""+(55*1.3*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol2, 35, 125 + (h/4), w-75);

        ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#000000";
        ctx.font = ""+(37*1.3*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol3, 35, 175 + (h/4), w-75);

        //CÓDIGO DO PRODUTO
        // ctx.textAlign = "left";
        // ctx.font = "20px "+$('#fonte').val();
        // ctx.fillText(codigo, 25, 315, 200);

        //INCLUE A MENSAGEM DE RODAPÉ
        ctx.fillStyle = "#ffffff";
        ctx.textAlign = "left";
        ctx.font = "bold "+(20*1.5)+"px "+$('#fonte').val();
        ctx.fillText(rodape, 15, h-10, w-30);

        //INCLUE O R$
        ctx.fillStyle = $("#cor_preco").val();
        ctx.textAlign = "left";
        ctx.font = "bold 33px "+$('#fonte').val();
        ctx.fillText("R$", 2*w/3, h-(h/3)-10, 100);

        //INCLUE O PREÇO GRANDE
        ctx.textAlign = "center";
        ctx.font = "bold 165px "+$('#fonte').val();
        ctx.fillText(preco, (4*w/5)+7, h-100, (w/3)-25);

        //INCLUE A UNIDADE
        ctx.fillStyle = "#ffffff";
        ctx.textAlign = "right";
        ctx.font = "bold "+(25)+"px "+$('#fonte').val();
        ctx.fillText(unidade, w-30, h-75, ((w/3)-25)/2);

        //A LOGOMARCA SE INCLUI AQUI
        if(logo){
            if($("#incluilogo").prop("checked")){
                var propLogo = logo.width/logo.height;
                var altLogo = 90, contLogo = 90, largLogo = propLogo*altLogo;
                
                if(largLogo > (w/3)-50){
                    largLogo = (w/3)-50;
                    altLogo = largLogo/propLogo;
                }

                if($("#layout").val() == 22){
                    ctx.drawImage(logo, w - 18 - ((w/3)/2) - (largLogo/2), (h/2)-(altLogo/2)+8, largLogo, altLogo);
                } else {
                    ctx.drawImage(logo, 25, h-60-altLogo, largLogo, altLogo);
                }
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
            
            ct.onload = function(){
                if($("input[name='quadrante']:checked").val() == 1){
                    cartaz.drawImage(ct, 0, 0, w, h);
                } else if($("input[name='quadrante']:checked").val() == 2){
                    cartaz.drawImage(ct, 0, h + 1, w, h);
                }
                
                var saida = "<img id='imgfinal' src='"+document.getElementById('cartaz').toDataURL()+"' width='60%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                $('#ver_img').html(saida);

                //MOSTRA O RESULTADO
                $('#loader-cartaz').hide();
                
                visuPaisagem();
            }
        }
    }
</script>