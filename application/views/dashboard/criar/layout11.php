<script>
    //LAYOUT DAS FAIXAS DAS GÔNDOLAS
    function layout11(ctx,w,h,fundo,cartaz,logo=false,i=0){ 
        var celula = $("input[name='faixa']:checked").val();

        var dados = false;

        var tamanho_fonte = $("#tamanho_fonte").val()/100;

        if(typeof dadosdafila != "undefined" && dadosdafila.length > i){
            var context = ctx[1];
            ctx = ctx[0];
            
            var preco = dadosdafila[i][5].replace(".",",");
            var precoant = dadosdafila[i][4].replace(".",",");

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
            
            var precoant = $("#precoant").val();
            
            var unidade = $("#unidade").val() ? $("#unidade").val() : "Un";
            var rodape = $("#rodape").val() ? $("#rodape").val() : "";

            var produtol1 = descproduto[0][0].replace("&nbsp;","");
            var produtol2 = descproduto.length > 1 && descproduto[1][0] != "&nbsp;" ? descproduto[1][0].replace("&nbsp;","") : "";
            var produtol3 = descproduto.length > 2 && descproduto[2][0] != "&nbsp;" ? descproduto[2][0].replace("&nbsp;","") : "";

            var cor_produtol1 = descproduto[0][1];
            var cor_produtol2 = descproduto.length > 1 ? descproduto[1][1] : "";
            var cor_produtol3 = descproduto.length > 2 ? descproduto[2][1] : "";

            if (isPrimeiro()) {
                if (dados_faixa[celula]) {
                    dados = dados_faixa[celula];

                    preco = dados[0][0];
                    $("#preco").val(dados[0][0])
                    precoant = dados[0][1];
                    $("#precoant").val(dados[0][1])
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
                    unidade = dados[5][0];
                    $("#unidade").val(dados[5][0]);
                    $("#acimade").val(dados[5][1]);
                    $("#acimadevarejo").val(dados[5][2]);
                } else {
                    preco = "";
                    $("#preco").val("")
                    precoant = "";
                    $("#precoant").val("")
                    produtol1 = "";
                    cor_produtol1 = "#000000";
                    produtol2 = "";
                    cor_produtol2 = "#000000";
                    produtol3 = "";
                    cor_produtol3 = "#000000";
                    Editor_master.setData('');
                    unidade = "";
                    $("#unidade").val("");
                    $("#acimade").val("");
                    $("#acimadevarejo").val("");
                }

                setPrimeiro(false);
            }

            var idCartaz = $("#id_cartaz").val();
        }

        if(!dados){
            dados = [[preco, precoant], [produtol1, cor_produtol1], [produtol2, cor_produtol2], [produtol3, cor_produtol3], $('#src_template').val(), [unidade, $("#acimade").val(), $("#acimadevarejo").val()]];
            dados_faixa[celula] = dados;
        }

        var id_tam = $('#tamanho').children(":selected").attr('id');
        var fator = id_tam != "A4" ? 1 : (10/7);

        //INCLUE O NOME DO PRODUTO
        ctx.textAlign = "left";
        ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#000000";
        ctx.font = ""+(70*tamanho_fonte)+"px "+$('#fonte').val(); 
        
        if($('#layout').val() == 17){
            // ctx.fillText(produtol1, 25, 90 + (h/4), (w/2) - 50);
            ctx.fillText(produtol1, 25, 70 + (h/4), 2*(w/3)-(w/15));
            ctx.font = ""+(70*tamanho_fonte)+"px "+$('#fonte').val();
            ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#000000";
            ctx.fillText(produtol2, 25, 140 + (h/4), 2*(w/3)-(w/15)-150);
            ctx.font = ""+(35*tamanho_fonte)+"px "+$('#fonte').val();
            ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#000000";
            ctx.fillText(produtol3, 25, 185 + (h/4), 2*(w/3)-(w/15)-150);
        } else {
            ctx.fillText(produtol1, 25, 75 + (h/4), (w/2) - 50);
            ctx.font = ""+(70*tamanho_fonte)+"px "+$('#fonte').val();
            ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#000000";
            ctx.fillText(produtol2, 25, 143 + (h/4), (w/2) - 170);
            ctx.font = ""+(35*tamanho_fonte)+"px "+$('#fonte').val();
            ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#000000";
            ctx.fillText(produtol3, 25, 186 + (h/4), (w/2) - 170);
        }
        
        // MENSAGEM DE RODAPÉ
        ctx.fillStyle = "#FFFFFF";
        ctx.textAlign = "left";
        
        if($('#layout').val() == 17){
            ctx.font = "bold "+(18)+"px "+$('#fonte').val();
            ctx.fillText(rodape, 25, h-(h/15), w-50);
        } else {
            ctx.font = "bold "+(18)+"px "+$('#fonte').val();
            ctx.fillText(rodape, 25, h-23, w-50);
        }

        //Preço anterior
        if($("#layout").val() == 17){
            precoant = "";
        }
        if(precoant != "" && precoant != "0,00"){
            //INCLUE O R$
            ctx.fillStyle = $("#cor_preco_anterior").val();
            ctx.textAlign = "left";
            ctx.font = "bold 25px "+$('#fonte').val();
            ctx.fillText("R$", 2*(w/4)+10, h-175, 100);

            //INCLUE O PREÇO GRANDE
            ctx.textAlign = "right";
            ctx.font = "bold 115px "+$('#fonte').val();
            ctx.fillText(precoant, w - 30 - (w/4), h-90, (w/4)-50);

            // ACIMA DE "VAREJO"
            ctx.textAlign = "left";
            ctx.font = "20px "+$('#fonte').val();
            ctx.fillText($("#acimadevarejo").val(), 2*(w/4)+10, h-50, (w/4)-100);
            
        }

        //INCLUE O R$
        ctx.fillStyle = $("#cor_preco").val();
        ctx.textAlign = "left";
        if($("#layout").val() == 17){
            ctx.font = "bold 30px "+$('#fonte').val();
            ctx.fillText("R$", 2*(w/3) + 25, (h/3) + 25, 100);
        } else {
            ctx.font = "bold 25px "+$('#fonte').val();
            ctx.fillText("R$", 3*(w/4)+5, h-175, 100);
        }

        //INCLUE O PREÇO GRANDE
        if($("#layout").val() == 17){
            ctx.textAlign = "center";
            ctx.font = "bold 150px "+$('#fonte').val();
            ctx.fillText(preco, w-(w/6), h-(h/6)-30, (w/3)-(w/25));
        } else {
            ctx.textAlign = "right";
            ctx.font = "bold 115px "+$('#fonte').val();
            ctx.fillText(preco, w-30, h-90, (w/4) - 50);
        }

        // ACIMA DE "ATACADO"
        if($("#layout").val() == 17){
            ctx.textAlign = "left";
            ctx.font = "20px "+$('#fonte').val();
            ctx.fillText($("#acimade").val(), 2*(w/3)+20, h-(h/6), (w/3)-120);
        } else {
            ctx.textAlign = "left";
            ctx.font = "20px "+$('#fonte').val();
            ctx.fillText($("#acimade").val(), 3*(w/4)+5, h-50, (w/4)-100);
        }

        // UNIDADE
        ctx.textAlign = "right";
        ctx.font = "bold 25px "+$('#fonte').val();
        if($("#layout").val() == 17){
            ctx.fillText(unidade, w-30, h-(h/6), 100);
        } else {
            ctx.fillText(unidade, w-20, h-50, 100);
        }


        //A LOGOMARCA SE INCLUI AQUI
        if(logo){
            if($("#incluilogo").prop("checked")){
                var propLogo = logo.width/logo.height;
                var altLogo = 120, contLogo = 120, largLogo = propLogo*altLogo;
                if(largLogo > 120){
                    largLogo = 120;
                    altLogo = largLogo/propLogo;
                }
                if($("#layout").val() == 17){
                    ctx.drawImage(logo, 2*(w/3) - 15 - largLogo, h-(h/7)-altLogo, largLogo, altLogo);
                } else {
                    ctx.drawImage(logo, (w/2) - 125, h-45-altLogo, largLogo, altLogo);
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
            ct.src = document.getElementById('cartaz'+$("input[name='faixa']:checked").val()).toDataURL();
            
            if(id_tam != "A5" && id_tam != "A6"){
                ct.onload = function(){
                    cartaz.drawImage(ct, 0, ($("input[name='faixa']:checked").val()-1)*h, ct.width, ct.height);
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
                    // cartaz.moveTo(0, margemSup);
                    // cartaz.lineTo(0, ct.width*2);
                    // cartaz.lineWidth = 5;
                    // cartaz.setLineDash([25]);
                    // cartaz.stroke();
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