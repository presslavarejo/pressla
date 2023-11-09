<script>
    //LAYOUT HORIZONTAL
    function layout25(ctx,w,h,fundo,cartaz,logo=false,i=0){
        var tamanho_fonte = $("#tamanho_fonte").val() / 100;

        if(typeof dadosdafila != "undefined" && dadosdafila.length > i){
            var context = ctx[1];
            ctx = ctx[0];
            
            var preco = dadosdafila[i][5].replace(".",",");

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
        ctx.font = "bold "+(197*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol1+(produtol2 ? " "+produtol2:"")+(produtol3 ? " "+produtol3:""), w/2, (h/4)+(h/8)-0, w-67);

        //INCLUE O PREÇO GRANDE
        ctx.textAlign = "center";
        ctx.fillStyle = $("#cor_preco").val();
        ctx.font = "bold 600px "+$('#fonte').val();
        ctx.fillText(preco, w/2-30, h-250, w);

        //INCLUE A MEDIDA
        ctx.fillStyle = "#000000";
        ctx.font = "125px "+$('#fonte').val();
        ctx.fillText(unidade, w-250, h-150, (w/4)-250);

        //A LOGOMARCA SE INCLUI AQUI
        if(logo){
            if($("#incluilogo").prop("checked")){
                var propLogo = logo.width/logo.height;
                var altLogo = 250, contLogo = 250, largLogo = propLogo*altLogo;
                var eixoY = h-300;
                if(largLogo > 500){
                    largLogo = 500;
                    altLogo = largLogo/propLogo;
                    eixoY = h-10-altLogo;
                }
                ctx.drawImage(logo, 100, eixoY, largLogo, altLogo);
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
                cartaz.drawImage(ct, 0, 0, ct.width, ct.height);
                var saida = "<img id='imgfinal' src='"+document.getElementById('cartaz1').toDataURL()+"' width='80%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                $('#ver_img').html(saida);
                //MOSTRA O RESULTADO
                $('#loader-cartaz').hide();
                visuPaisagem();
            }
        }
    }
</script>