<script>
    //LAYOUT DAS FAIXAS DAS GÔNDOLAS 2
    function dataCliente(d){
        return d.split("-").reverse().join("/");
    }
    function layout5(ctx,w,h,fundo,cartaz,logo=false,figura,i=0){    
        if(figura){
            if($("#layout").val() != "6b"){
                ctx.drawImage(figura[0], (((w/7)-figura[1])/2) + (50*parseInt($("#direita").val())), figura[3], figura[1], figura[2]);
            } else {
                var fig = figura[0];
                var wfig = (w/3) - 10;
                var propfigh = fig.height/fig.width;
                var propfigw = fig.width/fig.height;
                var hfig = wfig*propfigh;

                if(hfig > (h/2)-10){
                    hfig = (h/2)-10;
                    wfig = hfig*propfigw;
                }

                ctx.drawImage(figura[0], (5*w/6) - wfig/2, 34, wfig, hfig);
            }
        }
                                    
        var celula = $("input[name='faixa']:checked").val();

        var dados = false;

        if(isPrimeiro()){
            if(dados_faixa[celula]){
                dados = dados_faixa[celula];

                var pl1 = dados[1][0];
                var pl2 = dados[2][0];
                var pl3 = dados[3][0];
                var cor_pl1 = dados[1][1];
                var cor_pl2 = dados[2][1];
                var cor_pl3 = dados[3][1];
                
                descproduto[0][0] = pl1;
                descproduto[1][0] = pl2;
                descproduto[2][0] = pl3;
                descproduto[0][1] = cor_pl1;
                descproduto[1][1] = cor_pl2;
                descproduto[2][1] = cor_pl3;
                
                $("#preco").val(dados[0]);
                if(pl1 && pl2 && pl3){
                    Editor_master.setData('<p><span style="color:'+(cor_pl1 ? cor_pl1 : "hsl(0, 0, 0);")+'">'+pl1+'</span></p><p><span style="color:'+(cor_pl2 ? cor_pl2 : "hsl(0, 0, 0);")+'">'+pl2+'</span></p><p><span style="color:'+(cor_pl3 ? cor_pl3 : "hsl(0, 0, 0);")+'">'+pl3+'</span></p>');
                } else if(pl1 && pl2) {
                    Editor_master.setData('<p><span style="color:'+(cor_pl1 ? cor_pl1 : "hsl(0, 0, 0);")+'">'+pl1+'</span></p><p><span style="color:'+(cor_pl2 ? cor_pl2 : "hsl(0, 0, 0);")+'">'+pl2+'</span></p>');
                } else if(pl1) {
                    Editor_master.setData('<p><span style="color:'+(cor_pl1 ? cor_pl1 : "hsl(0, 0, 0);")+'">'+pl1+'</span></p>');
                } else {
                    Editor_master.setData('');
                }
            } else {
                $("#preco").val("");
                descproduto[0][0] = "";
                descproduto[1][0] = "";
                descproduto[2][0] = "";
                descproduto[0][1] = "#000000";
                descproduto[1][1] = "#000000";
                descproduto[2][1] = "#000000";
                Editor_master.setData('');
            }
            
            setPrimeiro(false);
        }

        var tamanho_fonte = $("#tamanho_fonte").val() / 100;

        if(typeof dadosdafila != "undefined" && dadosdafila.length > i){
            var context = ctx[1];
            ctx = ctx[0];
            
            var preco = dadosdafila[i][5].replace(".",",");
            var precoant = dadosdafila[i][4].replace(".",",");
            
            var desc = separaTexto(dadosdafila[i][1]);

            var produtol1 = desc.shift();
            var produtol2 = desc.length > 0 ? desc.shift() : "";
            var produtol3 = desc.length > 0 ? desc.join(" ") : "";    
        
        } else if(typeof dadosdafila != "undefined"){
            return;
        } else {

            var preco = $("#preco").val() ? $("#preco").val() : "0,99";
            
            var produtol1 = descproduto[0][0].replace("&nbsp;","");
            var produtol2 = descproduto.length > 1 && descproduto[1][0] != "&nbsp;" ? descproduto[1][0].replace("&nbsp;","") : "";
            var produtol3 = descproduto.length > 2 && descproduto[2][0] != "&nbsp;" ? descproduto[2][0].replace("&nbsp;","") : "";

            var cor_produtol1 = descproduto[0][1];
            var cor_produtol2 = descproduto.length > 1 ? descproduto[1][1] : "";
            var cor_produtol3 = descproduto.length > 2 ? descproduto[2][1] : "";

            var idCartaz = $("#id_cartaz").val();
        }
        var id_tam = $('#tamanho').children(":selected").attr('id');
        var fator = id_tam != "A4" ? 1 : (10/7);

        if(!dados){
            dados = [preco, [produtol1, cor_produtol1], [produtol2, cor_produtol2], [produtol3, cor_produtol3], figura, $('#src_template').val()];
            dados_faixa[celula] = dados;
        }

        //INCLUE O NOME DO PRODUTO
        if($("#layout").val() == "6b"){
            ctx.textAlign = "center";
            ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#333333";
            ctx.font = (25*fator*tamanho_fonte)+"px "+$('#fonte').val(); 
            ctx.fillText(produtol1, w/2, 30, w-20);

            ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#333333";
            ctx.font = (15*fator*tamanho_fonte)+"px "+$('#fonte').val(); 
            ctx.fillText(produtol2, w/2, h-28, w-20);

            ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#333333";
            ctx.font = (15*fator*tamanho_fonte)+"px "+$('#fonte').val(); 
            ctx.fillText(produtol3, w/2, h-5, w-20);

            ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#333333";
            ctx.font = (18*fator*tamanho_fonte)+"px "+$('#fonte').val(); 
            ctx.fillText($("#informacao-adicional").val(), w/6, h-75, (w/3)-20);

            ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#333333";
            ctx.font = (20*fator*tamanho_fonte)+"px "+$('#fonte').val(); 
            ctx.fillText("ABASTECIMENTO", w/6, h-28, (w/3)-20);

            ctx.font = (15*fator*tamanho_fonte)+"px "+$('#fonte').val(); 
            ctx.fillText(dataCliente($('#abastecimento').val()), w/6, h-5, (w/3)-20);

            ctx.font = (20*fator*tamanho_fonte)+"px "+$('#fonte').val(); 
            ctx.fillText("VENCIMENTO", 5*w/6, h-28, (w/3)-20);

            ctx.font = (15*fator*tamanho_fonte)+"px "+$('#fonte').val(); 
            ctx.fillText(dataCliente($('#vencimento').val()), 5*w/6, h-5, (w/3)-20);

            //INCLUE O PREÇO
            ctx.fillStyle = $("#cor_preco").val();
            ctx.textAlign = "center";
            ctx.font = "bold "+40*fator+"px "+$('#fonte').val();
            ctx.fillText(preco, w/2, (h/2) + 14, w/3);
        } else {
            ctx.textAlign = "right";
            ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#333333";
            ctx.font = "bold "+(70*fator*tamanho_fonte)+"px "+$('#fonte').val(); 
            ctx.fillText(produtol1, w-(472*fator), 66*fator, 474*fator);
            
            ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#333333";
            ctx.font = ""+(30*fator*tamanho_fonte)+"px "+$('#fonte').val();
            ctx.fillText(produtol2 + " " + produtol3, w-(472*fator), 92*fator, 474*fator);

            //INCLUE O PREÇO GRANDE
            ctx.fillStyle = $("#cor_preco").val();
            ctx.textAlign = "right";
            ctx.font = "bold "+120*fator+"px "+$('#fonte').val();
            ctx.fillText("R$ "+preco, w-(208*fator), 92*fator, 245*fator);
        }

        //A LOGOMARCA SE INCLUI AQUI
        if(logo){
            if($("#layout").val() != "6b"){
                if($("#incluilogo").prop("checked")){
                    var propLogo = logo.width/logo.height;
                    var eixoY = 5;
                    var altLogo = h-(2*eixoY), contLogo = 180*fator, largLogo = propLogo*altLogo;
                    
                    if(largLogo > contLogo){
                        largLogo = contLogo;
                        altLogo = largLogo/propLogo;
                        eixoY = eixoY + ((h-altLogo)/2);
                    }
                    ctx.drawImage(logo, (w-contLogo) + ((contLogo-largLogo)/2), eixoY, largLogo, altLogo);
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
                    var saida = "<img id='imgfinal' src='"+document.getElementById('cartaz').toDataURL()+"' width='"+($("#layout").val() == "6b" ? 60 : 80)+"%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
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