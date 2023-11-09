<script>
    //HORIZONTAL 8x A3
    function layout26(ctx,w,h,ctxm,logo=false,i=0){
        var tamanho_fonte = $("#tamanho_fonte").val() / 100;

        if(typeof dadosdafila != "undefined" && dadosdafila.length > i){
            var context = ctx[1];
            ctx = ctx[0];
            
            var preco = dadosdafila[i][5].replace(".",",");

            var unidade = dadosdafila[i][6];
            
            var desc = separaTexto(dadosdafila[i][1]);

            var produtol1 = desc.shift();
            var produtol2 = desc.length > 0 ? desc.shift() : "";
            var produtol3 = desc.length > 0 ? desc.join(" ") : "";    
        
        } else if(typeof dadosdafila != "undefined"){
            return;
        } else {

            var preco = $("#preco").val() ? $("#preco").val() : "0,99";
            
            var unidade = $("#unidade").val() ? $("#unidade").val() : "Un";
            
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
        ctx.font = ""+(650*tamanho_fonte)+"px "+$('#fonte').val(); 
        ctx.fillText(produtol1, w/4, 150 + (h/4), (w/2)-200);
        
        ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#000000";
        ctx.font = ""+(650*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol2, w/4, 800 + (h/4), (w/2)-200);

        ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#000000";
        ctx.font = ""+(650*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol3, w/4, 1450 + (h/4), (w/2)-200);

        //INCLUE A UNIDADE
        ctx.fillStyle = "#000000";
        ctx.textAlign = "right";
        ctx.font = "bold 250px " + $('#fonte').val();
        ctx.fillText(unidade, w - 100, h - 150, (w/2) - 200);

        //INCLUE O PREÇO GRANDE
        ctx.fillStyle = $("#cor_preco").val();
        ctx.textAlign = "center";
        ctx.font = "bold 1350px "+$('#fonte').val();
        ctx.fillText(preco, 3*w/4, (h/2)+475, (w/2)-200);
        

        if(typeof dadosdafila != "undefined" && dadosdafila.length > i){
            if(i < context.length-1){
                continuarCartazFila(context, w, h, false, cartaz, null, ++i);
            } else {
                mostrarPrototipos();
            }
        } else {
            var ct = new Image();
            ct.src = document.getElementById('cartaz').toDataURL();
            
            ct.onload = function(){
                var ctxmw = ctxm.canvas.width;
                var ctxmh = ctxm.canvas.height;

                ctxm.drawImage(ct, 0, 0, ctxmw, ctxmh);
                
                ctxm.beginPath();
                ctxm.strokeStyle = "#bcbcbc";
                ctxm.moveTo(ctxmw/2, 0);
                ctxm.lineTo(ctxmw/2, ctxmh);
                ctxm.lineWidth = 1;
                ctxm.setLineDash([2]);
                ctxm.stroke();

                ctxm.beginPath();
                ctxm.strokeStyle = "#bcbcbc";
                ctxm.moveTo(0, ctxmh/2);
                ctxm.lineTo(ctxmw, ctxmh/2);
                ctxm.lineWidth = 1;
                ctxm.setLineDash([2]);
                ctxm.stroke();

                ctxm.beginPath();
                ctxm.strokeStyle = "#bcbcbc";
                ctxm.moveTo(ctxmw/4, 0);
                ctxm.lineTo(ctxmw/4, ctxmh);
                ctxm.lineWidth = 1;
                ctxm.setLineDash([2]);
                ctxm.stroke();

                ctxm.beginPath();
                ctxm.strokeStyle = "#bcbcbc";
                ctxm.moveTo(3*ctxmw/4, 0);
                ctxm.lineTo(3*ctxmw/4, ctxmh);
                ctxm.lineWidth = 1;
                ctxm.setLineDash([2]);
                ctxm.stroke();

                var saida = "<img id='imgfinal' src='"+document.getElementById('cartazmini').toDataURL()+"' width='95%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                $('#ver_img').html(saida);
                // //MOSTRA O RESULTADO
                $('#loader-cartaz').hide();
                visuPaisagem();
                
            }
        }
    }
</script>