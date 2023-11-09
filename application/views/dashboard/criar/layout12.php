<script>
    function layout12(ctx,w,h,fundo,cartaz,logo,figura,i=0){    
        var grade = $("input[name='cel_tab_"+$("#layout").val()+"']");
        var celula = $("input[name='cel_tab_"+$("#layout").val()+"']:checked").val();

        var dados = false;

        var pl1 = false;
        var pl2 = false;
        var pl3 = false;
        var cor_pl1 = false;
        var cor_pl2 = false;
        var cor_pl3 = false;

        if(dados_tabloid[grade[i].value]){
            dados = dados_tabloid[grade[i].value];
            if(isPrimeiro() && grade[i].value == celula){
                $("#preco").val(dados[0]);

                pl1 = dados[1][0];
                pl2 = dados[2][0];
                pl3 = dados[3][0];
                cor_pl1 = dados[1][1];
                cor_pl2 = dados[2][1];
                cor_pl3 = dados[3][1];
                
                descproduto[0][0] = pl1;
                descproduto[1][0] = pl2;
                descproduto[2][0] = pl3;
                descproduto[0][1] = cor_pl1;
                descproduto[1][1] = cor_pl2;
                descproduto[2][1] = cor_pl3;
                
                if(pl1 && pl2 && pl3){
                    Editor_master.setData('<p><span style="color:'+(cor_pl1 ? cor_pl1 : "hsl(0, 0, 0);")+'">'+pl1+'</span></p><p><span style="color:'+(cor_pl2 ? cor_pl2 : "hsl(0, 0, 0);")+'">'+pl2+'</span></p><p><span style="color:'+(cor_pl3 ? cor_pl3 : "hsl(0, 0, 0);")+'">'+pl3+'</span></p>');
                } else if(pl1 && pl2) {
                    Editor_master.setData('<p><span style="color:'+(cor_pl1 ? cor_pl1 : "hsl(0, 0, 0);")+'">'+pl1+'</span></p><p><span style="color:'+(cor_pl2 ? cor_pl2 : "hsl(0, 0, 0);")+'">'+pl2+'</span></p>');
                } else if(pl1) {
                    Editor_master.setData('<p><span style="color:'+(cor_pl1 ? cor_pl1 : "hsl(0, 0, 0);")+'">'+pl1+'</span></p>');
                } else {
                    Editor_master.setData('');
                }
                
                if(dados[4]){
                    $("#imagematual").attr("src", dados[4][0].src);
                    figura = dados[4];
                    $("#controles").show("fast");
                } else {
                    $("#controles").hide("fast");
                    $("#imagematual").attr("src", "");
                    figura = false;
                }
                setPrimeiro(false);
            }
        }
        
        var tipo = grade[i].value[3];

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

            var preco = $("#preco").val() ? (grade[i].value == celula ? $("#preco").val() : (dados ? dados[0] : "")) : (dados ? dados[0] : "");
            
            var produtol1 = descproduto[0][0] ? (grade[i].value == celula ? descproduto[0][0].replace("&nbsp;","") : (dados ? dados[1][0] : "")) : (dados ? dados[1][0] : "");
            var produtol2 = descproduto.length > 1 && descproduto[1][0] != "&nbsp;" ? (grade[i].value == celula ? descproduto[1][0].replace("&nbsp;","") : (dados ? dados[2][0] : "")) : (dados ? dados[2][0] : "");
            var produtol3 = descproduto.length > 2 && descproduto[2][0] != "&nbsp;" ? (grade[i].value == celula ? descproduto[2][0].replace("&nbsp;","") : (dados ? dados[3][0] : "")) : (dados ? dados[3][0] : "");

            var cor_produtol1 = descproduto[0][1];
            var cor_produtol2 = descproduto.length > 1 ? descproduto[1][1] : "";
            var cor_produtol3 = descproduto.length > 2 ? descproduto[2][1] : "";
            
            var idCartaz = $("#id_cartaz").val();
        }

        var canvasHTML = "<canvas id='canva_temp"+i+"' width='"+((tipo == 'h' ? 2 : 1)*w/$("#width_"+$("#layout").val()).val())+"' height='"+((h-80)/$("#height_"+$("#layout").val()).val())+"'></canvas>";
        $('#container_hidden').html(canvasHTML);
        
        var ctxTemp = carregarContextoCanvas('canva_temp'+i);

        var wt = document.getElementById('canva_temp'+i).width;
        var ht = document.getElementById('canva_temp'+i).height;

        if(!dados || grade[i].value == celula){
            dados = [preco, [produtol1, cor_produtol1], [produtol2, cor_produtol2], [produtol3, cor_produtol3], false];
            dados_tabloid[grade[i].value] = dados;
        }

        if(figura && grade[i].value == celula){
            dados[4] = figura;
            dados_tabloid[grade[i].value] = dados;
            if(tipo == 'n'){
                ctxTemp.drawImage((figura[0]), (wt/2)-(figura[1]/2), ht-figura[2]-15, figura[1], figura[2]);
            } else if(tipo == 'h'){
                ctxTemp.drawImage((figura[0]), (3*wt/4)-(1.6*figura[1]/2), ht-(1.6*figura[2]), (1.6*figura[1]), (1.6*figura[2]));
            }
        } else if(dados && dados[4]){
            if(tipo == 'n'){
                ctxTemp.drawImage((dados[4][0]), (wt/2)-(dados[4][1]/2), ht-dados[4][2]-15, dados[4][1], dados[4][2]);
            } else if(tipo == 'h'){
                ctxTemp.drawImage((dados[4][0]), (3*wt/4)-(1.6*dados[4][1]/2), ht-(1.6*dados[4][2]), 1.6*dados[4][1], 1.6*dados[4][2]);
            }
        }

        //INCLUE O NOME DO PRODUTO
        ctxTemp.textAlign = "right";
        
        if(tipo == 'n'){
            ctxTemp.font = ""+(25*tamanho_fonte)+"px "+$('#fonte').val(); 
            ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#000000";
            ctxTemp.fillText(produtol1, 2*(wt/3)-30, (ht/4)-25, (wt/2));
            ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#000000";
            ctxTemp.fillText(produtol2, 2*(wt/3)-30, (ht/4), (wt/2));
            ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#000000";
            ctxTemp.fillText(produtol3, 2*(wt/3)-30, (ht/4)+25, (wt/2));
        } else {
            ctxTemp.font = ""+(50*tamanho_fonte)+"px "+$('#fonte').val(); 
            ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#000000";
            ctxTemp.fillText(produtol1, (wt/2)-30, (ht/4)-10, (wt/2)-60);
            ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#000000";
            ctxTemp.fillText(produtol2, (wt/2)-30, (ht/4)+35, (wt/2)-60);
            ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#000000";
            ctxTemp.fillText(produtol3, (wt/2)-30, (ht/4)+85, (wt/2)-60);
        }

        //INCLUE O PREÇO
        ctxTemp.fillStyle = $("#cor_preco").val();
        if(tipo == 'n'){
            ctxTemp.textAlign = "left";
            ctxTemp.font = "bold 40px "+$('#fonte').val();
            ctxTemp.fillText(preco, 2*(wt/3)-10, (ht/4)-15, (wt/3)-20);
        } else {
            ctxTemp.textAlign = "right";
            ctxTemp.font = "120px "+$('#fonte').val();
            ctxTemp.fillText(preco, (wt/2)-30, ht-30, (wt/2)-50);
        }

        var imgTemp = new Image();
        imgTemp.src = document.getElementById('canva_temp'+i).toDataURL();
        // var num = i;
        imgTemp.onload = function(){
            ctx.drawImage(imgTemp, (grade[i].value[2])*(w/$("#width_"+$("#layout").val()).val()), (grade[i].value[1])*((h)/$("#height_"+$("#layout").val()).val()));

            // RODAPÉ
            ctx.fillStyle = "#555555";
            ctx.textAlign = "center";
            ctx.font = "25px "+$('#fonte').val();
            ctx.fillText($("#rodape").val(), w/2, 10+(h/$("#height_"+$("#layout").val()).val()), w-60);
            // h/$("#height_"+$("#layout").val()).val()    
            
            if(i == grade.length-1){
                var ct = new Image();
                ct.src = document.getElementById('cartaz'+$("input[name='faixa']:checked").val()).toDataURL();
                
                ct.onload = function(){
                    cartaz.drawImage(ct, 0, ($("input[name='faixa']:checked").val()-1)*h, ct.width, ct.height);
                    var saida = "<img id='imgfinal' src='"+document.getElementById('cartaz').toDataURL()+"' width='60%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                    $('#ver_img').html(saida);
                    //MOSTRA O RESULTADO
                    $('#loader-cartaz').hide();
                    visuPaisagem();
                }
            } else {
                i++;
                layout12(ctx,w,h,fundo,cartaz,logo,figura,i);
            }
        }
    }
</script>