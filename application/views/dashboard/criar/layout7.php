<script>
    //Banner Varejo
    //$("#layout").val(9);
    function layout7(ctx,w,h,fundo,cartaz,logo){
        var tamanho_fonte = $("#tamanho_fonte").val()/100;

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
        ctx.textAlign = "left";
        ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#000000";
        ctx.font = "bold "+(2*75*tamanho_fonte)+"px "+$('#fonte').val(); 
        ctx.fillText(produtol1, 2*60, 3*(h/5)+150, w-2*100);
        
        ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#000000";
        ctx.font = ""+(2*75*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol2, 2*60, 3*(h/5)+(2*150)+2*10, w-2*100);

        ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#000000";
        ctx.font = ""+(2*75*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol3, 2*60, 3*(h/5)+(3*150)+2*25, w/3);

        //INCLUE A MENSAGEM DE RODAPÉ
        if($("#layout").val() == 8){
            ctx.font = ""+(2*40)+"px "+$('#fonte').val();
            ctx.fillText($("#acimade").val(), 2*525, 3*(h/5)+(3*150)+2*25, (w/2)-2*10);
        } else {
            ctx.fillText($("#acimade").val(), 2*525, 3*(h/5)+(3*150)+2*25, (w/2)-2*10);
            ctx.fillStyle = "#333333";
            ctx.font = ""+(2*30)+"px "+$('#fonte').val();
            ctx.fillStyle = "#FFFFFF";
            ctx.textAlign = "left";
            ctx.fillText(rodape, 2*33, h-2*10, w-2*33);
        }

        //Preço anterior
        if(precoant != "" && precoant != "0,00"){
            //INCLUE O R$
            if($("#layout").val() != 9){
                ctx.fillStyle = $("#cor_preco_anterior").val();
                ctx.textAlign = "left";
                ctx.font = "bold 100px "+$('#fonte').val();
                ctx.fillText("R$", 2*75, h-2*215, 2*100);

                //INCLUE O PREÇO GRANDE
                ctx.font = "bold 300px "+$('#fonte').val();
                ctx.fillText(precoant, 2*75, h-2*90, 2*320);

                ctx.font = ""+(2*40)+"px "+$('#fonte').val();
                ctx.fillText($("#acimadevarejo").val(), 2*75, h-2*275, (w/2)-2*220);

                //INCLUE A UNIDADE VAREJO
                ctx.textAlign = "right";
                ctx.font = "bold 50px "+$('#fonte').val();
                ctx.fillText(unidade, 2*440, h-2*50, (w/3));
            } else {
                ctx.fillStyle = $("#cor_preco_anterior").val();
                ctx.textAlign = "right";
                ctx.font = "bold 80px "+$('#fonte').val();
                ctx.fillText("De: R$ "+precoant, w-2*50, 3*(h/5)+(4*150)+2*10, (w/2)-2*10);
            }
        }

        //INCLUE O R$
        ctx.fillStyle = $("#cor_preco").val();
        ctx.textAlign = "left";
        ctx.font = "bold 130px "+$('#fonte').val();
        ctx.fillText("R$", 2*525, 3*(h/5)+(4*150)+2*20, (w/2)-2*10);

        //INCLUE O PREÇO GRANDE
        ctx.font = "bold 450px "+$('#fonte').val();
        ctx.fillText(preco, 2*525, h-2*120, (w/2)-2*10);

        //INCLUE A UNIDADE ATACADO
        ctx.textAlign = "right";
        ctx.font = "bold 90px "+$('#fonte').val();
        if($("#layout").val() != 9){
            ctx.fillText(unidade, w-2*50, h-2*50, (w/2)-2*10);
        } else {
            ctx.fillText(unidade, w-2*50, h-2*65, (w/2)-2*10);
        }

        //A LOGOMARCA SE INCLUI AQUI
        <?php if($this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca){ ?>
        if($("#incluilogo").prop("checked")){
            var propLogo = logo.width/logo.height;
            var altLogo = 2*125, contLogo = 2*370, largLogo = propLogo*altLogo;
            var eixoY = h/5;
            if(largLogo > 2*340){
                largLogo = 2*340;
                altLogo = largLogo/propLogo;
                eixoY = eixoY + ((2*125-altLogo)/2);
            }
            if($("#layout").val() == 8){
                ctx.drawImage(logo, 2*50, eixoY, largLogo, altLogo);
            } else {
                propLogo = logo.width/logo.height;
                altLogo = 2*200;
                contLogo = (w/2)-2*250;
                largLogo = propLogo*altLogo;
                if(largLogo > (w/2)-2*250){
                    largLogo = (w/2)-2*250;
                    altLogo = largLogo/propLogo;
                }
                ctx.drawImage(logo, 2*50+((contLogo-largLogo)/2), h-2*50-altLogo, largLogo, altLogo);
            }
        }
        <?php } ?>

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
</script>