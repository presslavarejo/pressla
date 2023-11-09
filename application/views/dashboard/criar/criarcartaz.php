<script>
    function criaCartaz() {
        var path = "assets/images/templates/";
        $('#loader-cartaz').show();

        // NOVO MODELO PARA CARTAZES SEM TEMPLATE
        if($("#layout").val() == 26){
            var w = 0;
            var h = 0;

            //TAMANHO DO 8xA3 (4x2) - DEIXANDO PRONTO PARA QUANDO HOUVER TEMPLATES PARECIDOS
            if ($("#layout").val() == 26) {
                w = parseFloat(4*420) * 3.78;
                h = parseFloat(2*297) * 3.78;
            }

            var canvasHTML = "<canvas id='cartaz' width='" + w + "' height='" + h + "'></canvas>";
            var canvasHTMLMini = "<canvas id='cartazmini' width='" + (w/5) + "' height='" + (h/5) + "'></canvas>";
            $('#container_cartaz').html(canvasHTML);
            $('#container_cartaz').append(canvasHTMLMini);

            var ctx = carregarContextoCanvas('cartaz');
            var ctxm = carregarContextoCanvas('cartazmini');
            
            if (ctx && ctxm) {

                //PADRÃO
                liberaCampos(false);
                $(".ant").show();
                $("#label_codigo").html("Código do Produto");
                $("#codigo").attr('placeholder', "");
                $("#tamanho").attr('readonly', false);
                $("#container_preco_anterior").hide();
                $("#container_rodape").hide();
                $("#texto_rodape").html("Rodapé");
                $("#container_codigo").hide();
                $("#container_unidade").show();
                $('.container_acimade').hide();
                $("#container_texto_livre").hide();
                $("#tamanho_comum").hide();
                $("#tamanho_maior").hide();
                $("#container_tabela_18").hide();
                $("#container_tabela_19").hide();
                $("#container_tabela_20").hide();
                $("#container_tabela_23").hide();
                $("#container_linha2_cartaz").show();
                $("#container_linha3_cartaz").show();
                $(".cordesc").hide();
                $('#container_figuras').hide();
                $("#container_categoria").hide();
                $("#container_template").hide();
                $("#container_incluirlogo").hide();

                //INCLUE O FUNDO BRANCO
                ctx.beginPath();
                ctx.rect(0, 0, w, h);
                ctx.fillStyle = "#FFFFFF";
                ctx.fill();

                if ($("#layout").val() == 26) {
                    $(".preco").html("Preço");
                    continuarCartaz(ctx, w, h, false, ctxm);
                }

            }

            return;
        }

        if ($('#src_template').val() != null) {

            var quant_faixas = $('#tamanho').children(":selected").attr('id') == "A3" ? 10 : 7;
            var tam = ($("#layout").val() == 8 || $("#layout").val() == 9 ? $('#A1').val().split('<|>') : $('#A3').val().split('<|>'));
            var tamanho = tam[1].split(' x ');
            var w = parseFloat(tamanho[0]) * 3.78;
            var h = parseFloat(tamanho[1]) * 3.78;

            if ($("#layout").val() == 5 || $("#layout").val() == 6 || $("#layout").val() == 10 || $("#layout").val() == 11 || $("#layout").val() == 14 || $("#layout").val() == 25 || $("#layout").val() == 27) {
                w = parseFloat(tamanho[1]) * 3.78;
                h = $("#layout").val() != 6 ? parseFloat(tamanho[0]) * 3.78 : (parseFloat(tamanho[0]) * 3.78) / quant_faixas;
            }

            if ($("#layout").val() == "6b") {
                quant_faixas = $('#tamanho').children(":selected").attr('id') == "A3" ? 14 : 9;
                w = 169.71 * 3.78;
                h = 42.42 * 3.78;
                // w = parseFloat(tamanho[1]) * 3.78;
                // h = (parseFloat(tamanho[0]) * 3.78) / quant_faixas;
            }

            if ($("#layout").val() == 21 || $("#layout").val() == 22 || $("#layout").val() == 23) {
                w = 240.43 * 3.78;
                h = 170 * 3.78;
            }

            if ($("#layout").val() == 17 || $("#layout").val() == 16) {
                // h = (80*3.78);
                h = (parseFloat(tamanho[1]) * 3.78) / 5;
            }

            //TAMANHO DO A2
            if ($("#layout").val() == 7 || $("#layout").val() == 18) {
                w = parseFloat(420) * 3.78;
                h = parseFloat(594) * 3.78;
            }

            //TAMANHO DO A1
            if ($("#layout").val() == 14) {
                w = parseFloat(841) * 3.78;
                h = parseFloat(594) * 3.78;
            }

            var fator = quant_faixas == 10 ? 1 : (10 / 7);

            var canvasHTML = "<canvas id='cartaz" + ($("#layout").val() != 6 && $("#layout").val() != "6b" && $("#layout").val() != 16 && $("#layout").val() != 17 ? $("input[name='quadrante']:checked").val() : $("input[name='faixa']:checked").val()) + "' width='" + w + "' height='" + h + "'></canvas>"

            if ($('#container_cartaz' + ($("#layout").val() != 6 && $("#layout").val() != "6b" && $("#layout").val() != 16 && $("#layout").val() != 17 ? $("input[name='quadrante']:checked").val() : $("input[name='faixa']:checked").val())).html() != undefined) {

                $('#container_cartaz' + ($("#layout").val() != 6 && $("#layout").val() != "6b" && $("#layout").val() != 16 && $("#layout").val() != 17 ? $("input[name='quadrante']:checked").val() : $("input[name='faixa']:checked").val())).html(canvasHTML);

            } else {

                $('#container_cartaz').html(canvasHTML);

            }

            //Recebemos o elemento canvas
            var ctx = carregarContextoCanvas('cartaz' + ($("#layout").val() != 6 && $("#layout").val() != "6b" && $("#layout").val() != 16 && $("#layout").val() != 17 ? $("input[name='quadrante']:checked").val() : $("input[name='faixa']:checked").val()));
            var cartaz = carregarContextoCanvas($("#layout").val() != 7 && $("#layout").val() != 18 ? 'cartaz' : 'cartaz_a2');
            if (ctx && cartaz) {
                //Crio uma imagem com um objeto Image de Javascript
                var fundo = new Image();
                //indico a URL da imagem
                if ($("#layout").val() == 6 || $("#layout").val() == "6b" || $("#layout").val() == 16) {
                    var celula = $("input[name='faixa']:checked").val();
                    if (isPrimeiro()) {
                        if (dados_faixa[celula] && dados_faixa[celula][4]) {
                            $('#src_template').val(dados_faixa[celula][4]);
                        }
                    }
                }

                if ($("#layout").val() == 1 || $("#layout").val() == 13) {
                    var celula = $("input[name='quadrante']:checked").val();
                    if (isPrimeiro()) {
                        if (dados_quadrante[celula] && dados_quadrante[celula][4]) {
                            $('#src_template').val(dados_quadrante[celula][4]);
                        }
                    }
                }

                fundo.src = "<?php echo base_url(); ?>" + path + $('#src_template').val();

                //defino o evento onload do objeto imagen
                fundo.onload = function() {
                    //INCLUE O FUNDO BRANCO
                    ctx.beginPath();
                    ctx.rect(0, 0, w, h);
                    ctx.fillStyle = "#FFFFFF";
                    ctx.fill();

                    //PADRÃO
                    liberaCampos(false);
                    $(".ant").show();
                    $("#label_codigo").html("Código do Produto");
                    $("#codigo").attr('placeholder', "");
                    $("#tamanho").attr('readonly', false);
                    $("#container_preco_anterior").show();
                    $("#container_rodape").show();
                    $("#texto_rodape").html("Rodapé");
                    $("#container_codigo").show();
                    $("#container_unidade").show();
                    $('.container_acimade').hide();
                    $("#container_texto_livre").hide();
                    $("#tamanho_comum").show();
                    $("#tamanho_maior").hide();
                    $("#container_tabela_18").hide();
                    $("#container_tabela_19").hide();
                    $("#container_tabela_20").hide();
                    $("#container_tabela_23").hide();
                    $("#container_linha2_cartaz").show();
                    $("#container_linha3_cartaz").show();
                    $(".cordesc").hide();
                    $("#container_categoria").show();
                    $("#container_template").show();
                    $("#container_incluirlogo").show();


                    //PERSONALIZADOS
                    //CARTAZES SEM FIGURAS
                    if ($("#layout").val() == 1 || $("#layout").val() == 13) {
                        $('#container_figuras').hide();
                        $(".preco").html("Preço");
                        $(".ant").html("Anterior");
                        continuarCartaz(ctx, w, h, fundo, cartaz);
                    } else if ($("#layout").val() == 10 || $("#layout").val() == 11 || $("#layout").val() == 12 || $("#layout").val() == 21 || $("#layout").val() == 25) {
                        $('#container_figuras').hide();
                        $("#container_codigo").hide();

                        if ($("#layout").val() != 11) {
                            $("#container_unidade").hide();
                        }

                        if ($("#layout").val() != 21) {
                            $("#container_unidade").hide();
                        } else {
                            $("#tamanho").val($("#A4").val());
                            $("#tamanho").attr('readonly', true);
                            $('#quadrantes').show('fast');
                            $('#q3').prop('disabled', true);
                            $('#q4').prop('disabled', true);
                        }

                        if ($("#layout").val() == 25) {
                            $("#container_unidade").show();
                            $("#container_rodape").hide();
                            $("#tamanho").val($("#A3").val());
                            $("#tamanho").attr('readonly', true);
                            $("#produtol2").val("");
                            $("#produtol3").val("");
                            $("#container_linha2_cartaz").hide();
                            $("#container_linha3_cartaz").hide();
                        }

                        if ($("#layout").val() != 12 && $("#layout").val() != 11) {
                            $(".check_verpaisagem").attr("checked") ? $(".check_verpaisagem").click() : false;
                            $(".check_verpaisagem").hide();
                        }

                        if ($("#layout").val() == 10 || $("#layout").val() == 12) {
                            $(".preco").html("Atacado");
                            $(".ant").html("Varejo");
                            $('.container_acimade').show();
                        } else {
                            $("#container_preco_anterior").hide();
                        }
                        continuarCartaz(ctx, w, h, fundo, cartaz);
                    } else if ($("#layout").val() == 15) {
                        $(".preco").html("Valor Fidelidade");
                        $(".ant").html("Valor Normal");
                        $(".check_verpaisagem").show();
                        continuarCartaz(ctx, w, h, fundo, cartaz);
                    } else if ($("#layout").val() == 16) {
                        liberaCampos2();
                        $(".preco").html("Atacado");
                        $(".ant").html("Varejo");
                        $('.container_acimade').show();
                        continuarCartaz(ctx, w, h, fundo, cartaz);
                    } else if ($("#layout").val() == 17) {
                        liberaCampos2();
                        $(".preco").html("Preço");
                        $('.container_acimade').show();
                        $("#container_preco_anterior").hide();
                        $("#container_acimade_varejo").hide();

                        continuarCartaz(ctx, w, h, fundo, cartaz);
                    
                    } else {

                        //CARTAZES COM FIGURAS
                        $('#container_figuras').show();
                        liberaCampos(false);
                        if ($("#layout").val() == 3 || $("#layout").val() == 4) {
                            $(".preco").html("Valor Fidelidade");
                            $(".ant").html("Valor Normal");
                            $(".check_verpaisagem").show();
                        } else if ($("#layout").val() == 5 || $("#layout").val() == 10) {
                            $(".preco").html("Atacado");
                            $(".ant").html("Varejo");
                            $(".check_verpaisagem").attr("checked") ? $(".check_verpaisagem").click() : false;
                            $(".check_verpaisagem").hide();
                        } else if ($("#layout").val() == 6 || $("#layout").val() == "6b") {
                            liberaCampos(true);
                            $(".cordesc").show();
                        } else if ($("#layout").val() == 7 || $("#layout").val() == 14 || $("#layout").val() == 18) {
                            $("#tamanho_comum").hide();
                            $("#tamanho_maior").show();
                            $("#label_codigo").html("Linha 4");
                            $("#container_codigo").hide();
                            $("#container_preco_anterior").hide();
                            $("#container_rodape").hide();
                            if ($("#layout").val() == 14) {
                                $("#container_texto_livre").show();
                                $(".check_verpaisagem").hide();
                            }
                        } else if ($("#layout").val() == 8) {
                            $(".preco").html("Atacado");
                            $(".ant").html("Varejo");
                            $('.container_acimade').show();
                            $("#container_rodape").hide();
                            $("#container_codigo").hide();
                            // $("#container_unidade").hide();
                        } else if ($("#layout").val() == 9) {
                            $("#container_codigo").hide();
                        } else if ($("#layout").val() == 22) {
                            $("#container_codigo").hide();

                            $("#tamanho").val($("#A4").val());
                            $("#tamanho").attr('readonly', true);
                            $('#quadrantes').show('fast');
                            $('#q3').prop('disabled', true);
                            $('#q4').prop('disabled', true);

                            $(".check_verpaisagem").attr("checked") ? $(".check_verpaisagem").click() : false;
                            $(".check_verpaisagem").hide();
                            $("#container_preco_anterior").hide();
                        
                        } else if ($("#layout").val() == 27 || $("#layout").val() == 28) {
                            $("#container_codigo").hide();
                            $("#container_rodape").hide();
                            $("#container_codigo").hide();
                            $("#container_preco_anterior").hide();
                        } else {
                            $(".preco").html("Preço");
                            $(".ant").html("Anterior");
                            $(".check_verpaisagem").show();
                        }

                        // TABLOIDES
                        if ($("#layout").val() == 19 || $("#layout").val() == 20 || $("#layout").val() == 23) {
                            $("#container_codigo").hide();
                            $("#container_preco_anterior").hide();
                            $("#container_unidade").hide();

                            if ($("#layout").val() == 23) {
                                $("#tamanho").val($("#A4").val());
                                $("#tamanho").attr('readonly', true);
                                $('#quadrantes').show('fast');
                                $('#q3').prop('disabled', true);
                                $('#q4').prop('disabled', true);
                            }
                        }
                        
                        if ($("#layout").val() == 19) {
                            $("#container_tabela_19").show();
                        }
                        if ($("#layout").val() == 20) {
                            $("#container_tabela_20").show();
                        }
                        if ($("#layout").val() == 23) {
                            $("#container_tabela_23").show();
                        }

                        if ($("#imagematual").attr('src') != "") {
                            var figura = new Image();
                            figura.crossOrigin = "anonymous";
                            // figura.addEventListener('error', corsError, false);

                            figura.onload = function() {
                                var propfigura = figura.width / figura.height;
                                var altfigura = ($("#layout").val() != 6 ? 750 : h) + (parseInt($('#zoom').val()) * 50),
                                    contfigura = ($("#layout").val() != 6 ? 930 : 182 * fator),
                                    largfigura = propfigura * altfigura;

                                var eixoY = (w / 2) - 50 + (50 * parseInt($("#cima").val()));
                                if ($("#layout").val() == 3 || $("#layout").val() == 4) {
                                    eixoY = (w / 2) - 250 + (50 * parseInt($("#cima").val()));
                                }
                                if ($("#layout").val() == 5) {
                                    eixoY = 330 + (50 * parseInt($("#cima").val()));
                                }
                                if (largfigura > 930) {
                                    largfigura = 930;
                                    altfigura = largfigura / propfigura;
                                    eixoY += ((750 - altfigura) / 2);
                                }

                                if ($("#layout").val() == 2) {
                                    altfigura = (h / 2) + (parseInt($('#zoom').val()) * 50);
                                    contfigura = w;

                                    largfigura = propfigura * altfigura;

                                    eixoY = h / 4 + (50 * parseInt($("#cima").val()));

                                    if (largfigura > w) {
                                        largfigura = w;
                                        altfigura = largfigura / propfigura;
                                        eixoY += (altfigura / 2);
                                    }
                                }

                                if ($("#layout").val() == 6 || $("#layout").val() == "6b") {
                                    eixoY = (5 * fator) + (50 * parseInt($("#cima").val()));
                                    if (largfigura > 182 * fator) {
                                        largfigura = 182 * fator;
                                        altfigura = largfigura / propfigura;
                                        eixoY += ((h - altfigura) / 2);
                                    }
                                }

                                if ($("#layout").val() == 7) {
                                    altfigura = 2 * ((h / 2) / 3) + (parseInt($('#zoom').val()) * 50);
                                    contfigura = w / 2;

                                    largfigura = propfigura * altfigura;

                                    eixoY = 100 + (50 * parseInt($("#cima").val()));

                                    if (largfigura > (w / 2)) {
                                        largfigura = (w / 2);
                                        altfigura = largfigura / propfigura;
                                        //eixoY += (altfigura/2);
                                    }
                                }

                                if ($("#layout").val() == 18) {
                                    altfigura = 2 * ((h / 2) / 3) + (parseInt($('#zoom').val()) * 50);
                                    contfigura = w / 2;

                                    largfigura = propfigura * altfigura;

                                    if (largfigura > (w / 2)) {
                                        largfigura = (w / 2);
                                        altfigura = largfigura / propfigura;
                                    }

                                    eixoY = (h/4) - (altfigura/2) + (50 * parseInt($("#cima").val()));
                                }

                                if ($("#layout").val() == 8 || $("#layout").val() == 9) {
                                    altfigura = 2 * (h / 5) + (parseInt($('#zoom').val()) * 50);
                                    contfigura = w;

                                    largfigura = propfigura * altfigura;

                                    eixoY = (h / 5) + (50 * parseInt($("#cima").val()));

                                    if (largfigura > w - 200) {
                                        largfigura = w - 200;
                                        altfigura = largfigura / propfigura;
                                        //eixoY += (altfigura/2);
                                    }
                                }

                                if ($("#layout").val() == 6 || $("#layout").val() == "6b") {
                                    continuarCartaz(ctx, w, h, fundo, cartaz, [figura, largfigura, altfigura, eixoY]);
                                    return;

                                } else if ($("#layout").val() == 7) {
                                    ctx.drawImage(figura, (w / 2) + (contfigura - largfigura) / 2, eixoY, largfigura, altfigura);

                                } else if ($("#layout").val() == 18) {
                                    continuarCartaz(ctx, w, h, fundo, cartaz, {figura: figura, x: (contfigura - largfigura) / 2, y: eixoY, w: largfigura, h: altfigura});
                                    $("#controles").show('fast');
                                    return;

                                } else if ($("#layout").val() == 14) {
                                    altfigura = ((h / 2) - 200) + (parseInt($('#zoom').val()) * 50);
                                    contfigura = (w / 2) - 200;

                                    largfigura = propfigura * altfigura;

                                    eixoY = 100 + (50 * parseInt($("#cima").val()));

                                    ctx.drawImage(figura, (w / 4) - (largfigura / 2), eixoY, largfigura, altfigura);

                                } else if ($("#layout").val() == 22) {
                                    altfigura = 275 + (parseInt($('#zoom').val()) * 50);
                                    contfigura = (w / 2);
                                    var eixoX = (parseInt($("#direita").val()) * 50) + 30;
                                    var eixoY = h - 40 - altfigura + (parseInt($('#cima').val()) * 50);

                                    largfigura = propfigura * altfigura;

                                    if (largfigura > (w / 2)) {
                                        largfigura = (w / 2);
                                        altfigura = largfigura / propfigura;
                                    }

                                    continuarCartaz(ctx, w, h, fundo, cartaz, [figura, eixoX, eixoY, largfigura, altfigura]);
                                    $("#controles").show('fast');
                                    return;

                                } else if ($("#layout").val() == 27 || $("#layout").val() == 28) {
                                    
                                    continuarCartaz(ctx, w, h, fundo, cartaz, figura);
                                    $("#controles").show('fast');
                                    return;

                                } else {
                                    // CASO SEJA TABLOIDE OU OUTRO DESCONHECIDO
                                    if ($("#layout").val() == 19 || $("#layout").val() == 20 || $("#layout").val() == 23) {
                                        altfigura = h / ($("#height_" + $("#layout").val()).val() * 2) + 10;
                                        if ($("#layout").val() == 23) {
                                            altfigura = h / ($("#height_" + $("#layout").val()).val() * 2);
                                        }

                                        // + (parseInt($('#zoom').val())*50);
                                        contfigura = (w / 2) - 100;
                                        largfigura = propfigura * altfigura;

                                        if (largfigura > contfigura) {
                                            largfigura = contfigura;
                                            altfigura = largfigura / propfigura;
                                        }

                                        continuarCartaz(ctx, w, h, fundo, cartaz, [figura, largfigura, altfigura]);
                                        $("#controles").show('fast');
                                        return;
                                    } else {
                                        ctx.drawImage(figura, ((contfigura - largfigura) / 2) + (50 * parseInt($("#direita").val())), eixoY, largfigura, altfigura);
                                    }
                                }

                                continuarCartaz(ctx, w, h, fundo, cartaz);
                                $("#controles").show('fast');
                            }

                            if ($("#layout").val() == 6 || $("#layout").val() == "6b") {
                                var celula = $("input[name='faixa']:checked").val();
                                if (isPrimeiro()) {
                                    if (dados_faixa[celula] && dados_faixa[celula][3]) {
                                        $("#imagematual").attr('src', dados_faixa[celula][3][0].src);
                                    }
                                }
                            }

                            figura.src = $("#imagematual").attr('src');
                        } else {
                            continuarCartaz(ctx, w, h, fundo, cartaz);
                        }
                    }
                }
            } else {
                alert("canva inválido");
            }
        } else {
            $('#loader-cartaz').hide();
        }
    }

    function criaCartazFila() {

        var path = "assets/images/templates/";
        $('#loader-cartaz').show();

        if ($('#src_template').val() != null) {

            var quant_faixas = $('#tamanho').children(":selected").attr('id') == "A3" ? 10 : 7;
            var tam = $('#A3').val().split('<|>');
            var tamanho = tam[1].split(' x ');
            var w = parseFloat(tamanho[0]) * 3.78;
            var h = parseFloat(tamanho[1]) * 3.78;

            if ($("#layout").val() == 5 || $("#layout").val() == 6 || $("#layout").val() == 10 || $("#layout").val() == 11 || $("#layout").val() == 14) {
                w = parseFloat(tamanho[1]) * 3.78;
                h = $("#layout").val() != 6 ? parseFloat(tamanho[0]) * 3.78 : (parseFloat(tamanho[0]) * 3.78) / quant_faixas;
            }

            if ($("#layout").val() == 21 || $("#layout").val() == 22 || $("#layout").val() == 23) {
                w = 240.43 * 3.78;
                h = 170 * 3.78;
            }

            if ($("#layout").val() == 17 || $("#layout").val() == 16) {
                w = 200*3.78;
                h = 80*3.78;
            }

            if ($("#layout").val() == 25) {
                w = 420*3.78;
                h = 300*3.78;
            }

            //TAMANHO DO A2
            if ($("#layout").val() == 7 || $("#layout").val() == 18) {
                w = parseFloat(420) * 3.78;
                h = parseFloat(594) * 3.78;
            }

            //TAMANHO DO A1
            if ($("#layout").val() == 14) {
                w = parseFloat(841) * 3.78;
                h = parseFloat(594) * 3.78;
            }

            var ctx = []
            var cartaz = []
            
            $('#container_cartaz').html("");

            dadosdafila.forEach((produto) => {
                var numel = produto[0];

                $('#container_cartaz').append("<canvas id='cartaz" + numel + "' width='" + w + "' height='" + h + "'></canvas>");

                ctx.push(carregarContextoCanvas("cartaz"+numel));
            });
            
            if(dadosdafila[0].length > 1){
                //Recebemos o elemento canvas
                var cartaz = false;
                
                if (ctx) {
                    //Crio uma imagem com um objeto Image de Javascript
                    var fundo = new Image();
                    //indico a URL da imagem
                    fundo.src = "<?php echo base_url(); ?>" + path + $('#src_template').val();

                    //defino o evento onload do objeto imagen
                    fundo.onload = function() {
                        
                        continuarCartazFila(ctx, w, h, fundo, cartaz);
                    }
                } else {
                    alert("canva inválido");
                }
            }
        } else {
            $('#loader-cartaz').hide();
        }
    }
</script>