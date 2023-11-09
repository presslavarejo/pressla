<script>
    //Banner Bolsão A2 Vertical
    //$("#layout").val(7);
    function layout6(ctx,w,h,fundo,cartaz,logo=false,i=0){
        
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
        ctx.textAlign = "center";
        ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#000000";
        var distancia = 75;
        var margem = 60;
        ctx.font = (130*tamanho_fonte)+"px "+$('#fonte').val(); 
        
        ctx.fillText(produtol1, 3*w/4, 2*(h/2)/3 + distancia, (w/2)-100);
        ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#000000";
        ctx.fillText(produtol2, 3*w/4, 2*(h/2)/3 + margem + distancia*2, (w/2)-100);
        ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#000000";
        ctx.fillText(produtol3, 3*w/4, 2*(h/2)/3 + margem*2 + distancia*3, (w/2)-100);
        ctx.fillText(produtol4, 3*w/4, 2*(h/2)/3 + margem*3 + distancia*4, (w/2)-100);

        //INCLUE O PREÇO ESQUERDA
        var tamanho_preco = 500;
        ctx.fillStyle = $("#cor_preco").val();
        ctx.textAlign = "center";
        ctx.font = "bold "+tamanho_preco+"px "+$('#fonte').val();
        ctx.fillText(precoE, w/4, h - (((h/2)-tamanho_preco)/2), w/2);

        //INCLUE O PREÇO DIREITA
        ctx.font = "bold "+tamanho_preco+"px "+$('#fonte').val();
        ctx.fillText(","+precoD, 3*w/4, h - (((h/2)-tamanho_preco)/2), (w/2)-200);
        
        //INCLUE A MEDIDA
        ctx.textAlign = "right";
        ctx.font = "100px "+$('#fonte').val();
        ctx.fillText(unidade, w-125, (h - (((h/2)-tamanho_preco)/2))+100, w/4);

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