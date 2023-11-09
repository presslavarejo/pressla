<script>
    //LAYOUT SEM IMAGEM
    function layout1(ctx, w, h, fundo, cartaz, logo=false, i=0) {
        var celula = $("input[name='quadrante']:checked").val();

        var dados = false;

        var tamanho_fonte = $("#tamanho_fonte").val() / 100;

        if(typeof dadosdafila != "undefined" && dadosdafila.length > i && dadosdafila[0].length > 3){
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
                if (dados_quadrante[celula]) {
                    dados = dados_quadrante[celula];

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
                    unidade = dados[5];
                    $("#unidade").val(dados[5]);
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
                }

                setPrimeiro(false);
            }

            var idCartaz = $("#id_cartaz").val();
        }

        if (!dados) {
            dados = [
                [preco, precoant], [produtol1, cor_produtol1], [produtol2, cor_produtol2], [produtol3, cor_produtol3], $('#src_template').val(), $("#unidade").val()
            ];
            dados_quadrante[celula] = dados;
        }

        //INCLUE O NOME DO PRODUTO
        ctx.textAlign = "center";
        ctx.font = "bold " + (197 * tamanho_fonte) + "px " + $('#fonte').val();
        ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#333333";
        ctx.fillText(produtol1, (w / 2), (h / 4) + (h / 8) - 125, (w - 67));

        ctx.font = "bold " + (159 * tamanho_fonte) + "px " + $('#fonte').val();
        ctx.fillStyle = cor_produtol2 ? cor_produtol2 : "#333333";
        ctx.fillText(produtol2, (w / 2), (h / 4) + (h / 4) - 125, (w - 133));

        ctx.font = "bold " + (66 * tamanho_fonte) + "px " + $('#fonte').val();
        ctx.fillStyle = cor_produtol3 ? cor_produtol3 : "#333333";
        ctx.fillText(produtol3, (w / 2), (h / 4) + (h / 4) - 17, (w - 67));

        var local = 0;
        if ($("#layout").val() != 1) {
            local = -50;
        }

        if (precoant != "" && precoant != "0,00") {
            //INCLUE O DE
            ctx.fillStyle = $("#cor_preco_anterior").val();
            ctx.textAlign = "left";
            ctx.font = "bold " + (100 * tamanho_fonte) + "px " + $('#fonte').val();
            ctx.fillText("DE: R$ " + precoant, 33, (h / 2) + 155 + local);

            ctx.textAlign = "left";
            ctx.font = "bold " + (100 * tamanho_fonte) + "px " + $('#fonte').val();
            ctx.fillText("POR:", 33, (h / 2) + 255 + local);
        }

        //INCLUE A MEDIDA
        ctx.fillStyle = $("#cor_preco").val();
        ctx.textAlign = "right";
        ctx.font = "bold 55px " + $('#fonte').val();
        
        if ($("#layout").val() != 13) {
            ctx.fillText(unidade, w - 100, h - 25, 500);
        } else {
            ctx.fillText(unidade, w - (w / 5) - 50, h - 50, (w / 2) - (w / 5) - 50);
        }

        //INCLUI O R$ GRANDE
        ctx.textAlign = "left";
        ctx.font = "bold " + (120) + "px " + $('#fonte').val();
        ctx.fillText("R$", 50, (h / 2) + 380, 100);

        ctx.textAlign = "left";
        ctx.font = "bold 550px " + $('#fonte').val();
        ctx.fillText(preco, 200, h - 125 + local, w - 300);

        //INCLUE A MENSAGEM DE RODAPÉ
        ctx.fillStyle = "#999999";
        ctx.textAlign = "center";
        ctx.font = "bold 28px " + $('#fonte').val();

        if ($("#layout").val() == 1) {
            ctx.fillText(rodape, w / 2, (h / 6) * 4 - 210, w - 66);
        } else {
            ctx.textAlign = "left";
            ctx.fillText(rodape, 33, h - 15, (w / 2) - 66);
        }

        //A LOGOMARCA SE INCLUI AQUI
        if(logo){
            if ($("#incluilogo").prop("checked")) {
                if ($("#layout").val() == 1) {
                    ctx.drawImage(logo, 33, h - 33 - ((w / 5) * logo.height / logo.width), (w / 5), (w / 5) * logo.height / logo.width);
                } else {
                    ctx.drawImage(logo, w - 33 - (w / 5), h - 33 - ((w / 5) * logo.height / logo.width), (w / 5), (w / 5) * logo.height / logo.width);
                }
            }
        }

        //TEXTO LATERAL
        ctx.fillStyle = "#333333";
        ctx.rotate(-90 * Math.PI / 180);
        ctx.textAlign = "left";
        ctx.font = "bold 25px Arial";
        ctx.fillText("www.pressla.com.br", -h + 225, 33, w - 33);

        if(typeof dadosdafila != "undefined" && dadosdafila.length > i){
            if(i < context.length-1){
                continuarCartazFila(context, w, h, fundo, cartaz, null, ++i);
            } else {
                mostrarPrototipos();
            }
        } else {

            var ct = new Image();
            ct.src = document.getElementById('cartaz' + $("input[name='quadrante']:checked").val()).toDataURL();
            var id_tam = $('#tamanho').children(":selected").attr('id');

            if (id_tam != "A5" && id_tam != "A6") {
                ct.onload = function() {
                    cartaz.drawImage(ct, 0, 0, ct.width, ct.height);
                    var saida = "<img id='imgfinal' src='" + document.getElementById('cartaz').toDataURL() + "' width='60%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                    $('#ver_img').html(saida);
                    //MOSTRA O RESULTADO
                    $('#loader-cartaz').hide();
                    visuPaisagem();
                }
            } else if (id_tam == 'A5') {
                ct.onload = function() {
                    var margemSup = 18.0 * 3.78;
                    var margemDir = 10.0 * 3.78;

                    cartaz.beginPath();
                    cartaz.strokeStyle = "#cecece";
                    cartaz.moveTo(-ct.height / 2, margemSup);
                    cartaz.lineTo(ct.height * 2, margemSup);
                    cartaz.lineWidth = 5;
                    cartaz.setLineDash([25]);
                    cartaz.stroke();

                    //linha do meio
                    cartaz.beginPath();
                    cartaz.moveTo(0, margemSup);
                    cartaz.lineTo(0, ct.width * 2);
                    cartaz.lineWidth = 5;
                    cartaz.setLineDash([25]);
                    cartaz.stroke();

                    if ($("input[name='quadrante']:checked").val() == 1) {
                        cartaz.drawImage(ct, -ct.height / 2, margemSup, (ct.height / 2) - margemDir, ct.width - margemSup);
                    } else {
                        cartaz.drawImage(ct, margemDir, margemSup, (ct.height / 2) - margemDir, ct.width - margemSup);
                    }

                    var saida = "<img id='imgfinal' src='" + document.getElementById('cartaz').toDataURL() + "' width='60%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                    $('#ver_img').html(saida);
                    //MOSTRA O RESULTADO
                    $('#loader-cartaz').hide();

                    visuPaisagem();
                }
            } else if (id_tam == 'A6') {
                ct.onload = function() {

                    if ($("input[name='quadrante']:checked").val() == 1) {
                        cartaz.drawImage(ct, 0, 0, ct.width / 2, ct.height / 2);
                    } else if ($("input[name='quadrante']:checked").val() == 2) {
                        cartaz.drawImage(ct, ct.width / 2, 0, ct.width / 2, ct.height / 2);
                    } else if ($("input[name='quadrante']:checked").val() == 3) {
                        cartaz.drawImage(ct, 0, ct.height / 2, ct.width / 2, ct.height / 2);
                    } else {
                        cartaz.drawImage(ct, ct.width / 2, ct.height / 2, ct.width / 2, ct.height / 2);
                    }

                    var saida = "<img id='imgfinal' src='" + document.getElementById('cartaz').toDataURL() + "' width='60%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                    $('#ver_img').html(saida);

                    //MOSTRA O RESULTADO
                    $('#loader-cartaz').hide();

                    visuPaisagem();
                }
            }
        }
    }
</script>