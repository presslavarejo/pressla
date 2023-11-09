<script>
    //LAYOUT SEM IMAGEM
    function layout28(ctx, w, h, fundo, cartaz, logo=false, i=0, figura=false) {
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
        
        } else if(typeof dadosdafila != "undefined"){
            return;
        } else {

            var preco = $("#preco").val() ? $("#preco").val() : "0,99";
            
            var unidade = $("#unidade").val() ? $("#unidade").val() : "Un";

            var produtol1 = descproduto[0][0].replace("&nbsp;","");

            var cor_produtol1 = descproduto[0][1];

            if (isPrimeiro()) {
                if (dados_quadrante[celula]) {
                    dados = dados_quadrante[celula];

                    preco = dados[0][0];
                    $("#preco").val(dados[0][0])
                    
                    produtol1 = dados[1][0];
                    cor_produtol1 = dados[1][1];
                    
                    if(produtol1){
                        Editor_master.setData('<p><span style="color:'+(cor_produtol1 ? cor_produtol1 : "hsl(0, 0, 0);")+'">'+produtol1+'</span></p>');
                    } else {
                        Editor_master.setData('');
                    }
                    unidade = dados[5];
                    $("#unidade").val(dados[5]);
                } else {
                    preco = "";
                    $("#preco").val("")
                    
                    produtol1 = "";
                    cor_produtol1 = "#000000";
                    
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
                [preco, precoant], [produtol1, cor_produtol1], [false, false], [false, false], $('#src_template').val(), $("#unidade").val()
            ];
            dados_quadrante[celula] = dados;
        }

        if(figura) {
            var propfigura = figura.width / figura.height;
            
            var altfigura = (h/4) + (parseInt($('#zoom').val()) * 50);
            var largfigura = propfigura * altfigura;
            
            var eixoX = (w/2) - (largfigura/2) + (parseInt($("#direita").val()) * 50);
            var eixoY = (h / 4) + (h / 10) + (parseInt($('#cima').val()) * 50);

            ctx.drawImage(figura, eixoX, eixoY, largfigura, altfigura);
        }

        //INCLUE O NOME DO PRODUTO
        ctx.textAlign = "center";
        ctx.font = "bold " + (180 * tamanho_fonte) + "px " + $('#fonte').val();
        ctx.fillStyle = cor_produtol1 ? cor_produtol1 : "#333333";
        ctx.fillText(produtol1, (w / 2), (h / 4) + (h / 12), w - (w/6));

        // PREÇO
        ctx.fillStyle = $("#cor_preco").val();
        preco = preco.split(",");
        // INCLUI VÍRGULA E PRECO PEQUENO
        ctx.textAlign = "left";
        ctx.font = "bold 275px " + $('#fonte').val();
        
        ctx.fillText(","+preco[1], (w/2), h - (h/4.25), w/4);

        // INCLUI GRANDE
        ctx.textAlign = "right";
        ctx.font = "bold 600px " + $('#fonte').val();
        ctx.fillText(preco[0], (w/2) - 20, h - (h/10.25), w/4);

        //INCLUE A MEDIDA
        ctx.textAlign = "left";
        ctx.font = "bold 150px " + $('#fonte').val();

        ctx.fillText(" "+unidade, (w/2), h - (h/8.25), w/4);
        
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