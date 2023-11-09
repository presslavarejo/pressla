<script>
    //LAYOUT HORIZONTAL
    function layout10(ctx,w,h,fundo,cartaz,logo){
        var tamanho_fonte = $("#tamanho_fonte").val()/100;

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
        ctx.textAlign = "left";
        ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#000000";
        ctx.font = "bold "+(225*tamanho_fonte)+"px "+$('#fonte').val(); 
        ctx.fillText(produtol1, (w/2) + 100, 275, (w/2) - 175);
        
        ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#000000";
        ctx.font = ""+(225*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol2, (w/2) + 100, 535, (w/2) - 175);

        ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#000000";
        ctx.font = ""+(225*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol3, (w/2) + 100, 795, (w/2) - 175);

        //CÓDIGO DO PRODUTO
        // ctx.textAlign = "left";
        // ctx.font = "20px "+$('#fonte').val();
        // ctx.fillText(codigo, 25, 315, 200);

        //INCLUE A MENSAGEM DE RODAPÉ
        // ctx.fillStyle = "#ffffff";
        // ctx.textAlign = "left";
        // ctx.font = "bold "+(45)+"px "+$('#fonte').val();
        // ctx.fillText(rodape, 25, h-20, w-50);

        //INCLUE O R$
        ctx.fillStyle = $("#cor_preco").val();
        ctx.textAlign = "left";
        ctx.font = "bold 150px "+$('#fonte').val();
        ctx.fillText("R$", (w/2) + 150, h-725, 300);

        //INCLUE O DETALHE
        ctx.textAlign = "right";
        ctx.font = "125px "+$('#fonte').val();
        ctx.fillText($("#detalhe").val(), w - 125, h-725, (w/4)+200);

        //INCLUE O PREÇO GRANDE
        ctx.textAlign = "right";
        ctx.font = "bold 600px "+$('#fonte').val();
        if($("#fonte").val().indexOf("MONTSERRAT") == -1){
            ctx.fillText(preco, w-110, h-250, (w/2) - 175);
        } else {
            ctx.fillText(preco, w-75, h-250, (w/2) - 175);
        }

        //INCLUE A MEDIDA
        ctx.font = "100px "+$('#fonte').val();
        ctx.fillText(unidade, w-85, h-150, (w/4)-85);

        //A LOGOMARCA SE INCLUI AQUI
        <?php if($this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca){ ?>
        if($("#incluilogo").prop("checked")){
            var propLogo = logo.width/logo.height;
            var altLogo = 250, contLogo = 250, largLogo = propLogo*altLogo;
            var eixoY = h-300;
            if(largLogo > 500){
                largLogo = 500;
                altLogo = largLogo/propLogo;
                eixoY = h-100-altLogo;
            }
            ctx.drawImage(logo, 100, eixoY, largLogo, altLogo);
        }
        <?php } ?>

        //TEXTO LATERAL
        // ctx.fillStyle = "#333333";
        // ctx.rotate(-90*Math.PI/180);
        // ctx.textAlign = "left";
        // ctx.font = "bold 20px Arial";
        // ctx.fillText("www.pressla.com.br", -h+275, 25, w-33);
        
        // ct.onload = function(){
        //     cartaz.drawImage(ct, 0, 0, ct.width, ct.height);
        //     var saida = "<img id='imgfinal' src='"+document.getElementById('cartaz').toDataURL()+"' width='80%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
        //     $('#ver_img').html(saida);
        //     //MOSTRA O RESULTADO
        //     $('#loader-cartaz').hide();
        //     //visuPaisagem();
        // }
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
</script>