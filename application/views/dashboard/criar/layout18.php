<script>
    //Banner A2 Vertical
    //$("#layout").val(18);
    function layout18(ctx,w,h,fundo,cartaz,logo=false,i=0,figura=false){
        
        var produtol4 = $("#codigo").val() ? $("#codigo").val() : "";
        var tamanho_fonte = $("#tamanho_fonte").val() / 100;

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

            var idCartaz = $("#id_cartaz").val();
        }

        preco = preco.split(',');
        var precoE = preco[0];
        var precoD = preco[1] ? preco[1] : "00";

        //INCLUE O NOME DO PRODUTO
        var distancia = 50;
        var margem = 60;

        ctx.textAlign = "center";
        ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#000000";
        ctx.font = ((h/8)*tamanho_fonte)+"px "+$('#fonte').val(); 
        ctx.fillText(produtol1, 3*w/4, h/6 + distancia, (w/2)-100);

        ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#000000";
        ctx.fillText(produtol2, 3*w/4, h/3.45 + distancia, (w/2)-100);

        ctx.font = ((h/16)*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#000000";
        ctx.fillText(produtol3+" "+produtol4, 3*w/4, h/2.75 + distancia, (w/2)-100);

        ctx.textAlign = "left";
        ctx.fillStyle = "#000000";
        ctx.font = (h/15)+"px "+$('#fonte').val(); 
        
        ctx.fillText("R$", w/30, (h/2) + (h/14), (w/2)-100);
        ctx.textAlign = "right";
        ctx.fillText(unidade, w - (w/30), h - (h/24), (w/2)-100);

        //INCLUE O PREÇO ESQUERDA
        ctx.fillStyle = $("#cor_preco").val();
        ctx.textAlign = "center";
        ctx.font = "bold "+(h/2.7)+"px "+$('#fonte').val();
        ctx.fillText(precoE+","+precoD, w/2, h - (h/7), w-(3*(w/30)));

        if(figura && (typeof figura) == "object"){
            ctx.drawImage(figura.figura, figura.x, figura.y, figura.w, figura.h);
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
                cartaz.drawImage(ct, 0, 0, ct.width, ct.height);
                var saida = "<img id='imgfinal' src='"+document.getElementById('cartaz_a2').toDataURL()+"' width='60%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                $('#ver_img').html(saida);
                //MOSTRA O RESULTADO
                $('#loader-cartaz').hide();
                visuPaisagem();
            }
        }
        
    }
</script>