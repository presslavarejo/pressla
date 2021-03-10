<script src="<?php echo base_url('assets/js/jquery.maskMoney.js'); ?>" type="text/javascript"></script>
<script>
    $(function(){
        $("#preco").maskMoney({thousands:'.', decimal:','});
        $("#precoant").maskMoney({thousands:'.', decimal:','});
        $('#horizontal').change(function(){
            $('#horizontal').prop('checked') ? visuPaisagem() : criaCartaz();
        });
        $('#avisohorizontal').change(function(){
            criaAviso();
        });

        document.getElementById("figura").addEventListener('keyup', function(e){
            var key = e.which || e.keyCode;
            if (key == 13) { // codigo da tecla enter
                buscaImagens(this.value);
            }
        });
    });

    function isAviso(){
        if($('#tipo_template').children(":selected").html() == "Avisos e Informações"){
            $('#avisos').show();
            $('#todos').hide();
            $('#A0').prop('disabled','true');
            $('#A1').prop('disabled','true');
            $('#A2').prop('disabled','true');
            $('#A5').prop('disabled','true');
            $("[id*='x2']").prop('disabled','true');
            criaAviso();
        } else {
            $('#avisos').hide();
            $('#todos').show();
            $('#A0').prop('disabled',false);
            $('#A1').prop('disabled',false);
            $('#A2').prop('disabled',false);
            $('#A5').prop('disabled',false);
            $("[id*='x2']").prop('disabled',false);
            criaCartaz();
        }
    }

    function tamSelecionado(){
        var id = $('#tamanho').children(":selected").attr('id');
        var tam = $('#A3').val().split('<|>');
        var tamanho = tam[1].split(' x ');
        var w = parseFloat(tamanho[0])*3.78;
        var h = parseFloat(tamanho[1])*3.78;
        var canHTML = "<canvas id='cartaz' width='"+w+"' height='"+h+"'></canvas>";
        $('#container_cartaz').html(canHTML);

        var cartaz = carregarContextoCanvas('cartaz');
        if(cartaz){
            cartaz.beginPath();
            cartaz.rect(0, 0, w, h);
            cartaz.fillStyle = "#FFFFFF";
            cartaz.fill();   
        }
        
        $('#q1').click();
        if(id == 'A5') {
            $('#q3').prop('disabled',true);
            $('#q4').prop('disabled',true);
            $('#quadrantes').show('fast');
            
            if(cartaz){
                cartaz.translate(w,h/2);
                cartaz.rotate(Math.PI/2);                    
            }
        } else if(id == 'A6') {
            $('#q3').prop('disabled',false);
            $('#q4').prop('disabled',false);
            $('#quadrantes').show('fast');
        } else {
            $('#quadrantes').hide('fast');
        }
        isAviso();
    }

    function buscaIds(){
        id = $("#tipo_template").val();
        $.get('<?php echo base_url('index.php/dashboard/buscaTemplatesPorTipo/'); ?>'+id+'/<?php echo $id; ?>/'+$("#layout").val(), function(html){
            
            var ids = html.split(',');
            var tamanho = ids.length;

            var saida = "";
            if(tamanho > 0){
                for(var i = 0; i < tamanho; i++){
                    var idss = ids[i].split('<|>');
                    saida += "<option value='"+idss[0]+"'>"+idss[1]+"</option>";
                }
            } else {
                saida += "<option disabled> - </option>";
            }
            
            
            $("#template").html(saida);
            buscaTemplate();
        });
    }

    function buscaTemplate(){
        id = $("#template").val();
        
        $.get('<?php echo base_url('index.php/dashboard/buscaTemplate/') ?>'+id, function(html){
            
            $("#src_template").val(html);
            isAviso();
        });
    }

    function carregarContextoCanvas(idCanvas){
        var elemento = document.getElementById(idCanvas);
        if(elemento && elemento.getContext){
            var contexto = elemento.getContext('2d');
            if(contexto){
                return contexto;
            }
        }
        return false;
    }

    function addLinha(){
        var tamanho = $(".textoaviso").length;

        var entrada = "<div class=\"row pl-2 pr-2\">"+
                        "<div class=\"col-sm\">"+
                            "<div class=\"input-group mb-2\">"+
                                "<div class=\"input-group-prepend\">"+
                                    "<span class=\"input-group-text\">Linha "+(++tamanho)+"</span>"+
                                "</div>"+
                                "<input type=\"text\" class=\"form-control textoaviso\" id=\"linha"+(tamanho)+"\" class=\"form-control\" onblur=\"criaAviso()\" spellcheck=\"true\">"+
                            "</div>"+
                        "</div>"+
                    "</div>";
        
        $("#linhas").append(entrada);
    }

    function criaCartaz(){
        var path = "assets/images/templates/";
        $('#loader-cartaz').show();
        if($('#src_template').val() != null){
            var tam = $('#A3').val().split('<|>');
            var tamanho = tam[1].split(' x ');
            var w = parseFloat(tamanho[0])*3.78;
            var h = parseFloat(tamanho[1])*3.78;
            var fator = tam[0];

            var canvasHTML = "<canvas id='cartaz"+$("input[name='quadrante']:checked").val()+"' width='"+w+"' height='"+h+"'></canvas>";
            $('#container_cartaz'+$("input[name='quadrante']:checked").val()).html(canvasHTML);
            
            //Recebemos o elemento canvas
            var ctx = carregarContextoCanvas('cartaz'+$("input[name='quadrante']:checked").val());
            var cartaz = carregarContextoCanvas('cartaz');
            if(ctx && cartaz){
                //Crio uma imagem com um objeto Image de Javascript
                var fundo = new Image();
                //indico a URL da imagem
                fundo.src = "<?php echo base_url(); ?>"+path+$('#src_template').val();
                //defino o evento onload do objeto imagen
                fundo.onload = function(){
                    //INCLUE O FUNDO BRANCO
                    ctx.beginPath();
                    ctx.rect(0, 0, w, h);
                    ctx.fillStyle = "#FFFFFF";
                    ctx.fill();
                    
                    if($("#layout").val() == 1){
                        $('#container_figuras').hide();
                        $(".preco").html("Preço");
                        $(".ant").html("Anterior");
                        continuarCartaz(ctx,w,h,fundo,cartaz);
                    } else {
                        $('#container_figuras').show();
                        if($("#layout").val() == 3 || $("#layout").val() == 4){
                            $(".preco").html("Valor Fidelidade");
                            $(".ant").html("Valor Normal");
                        } else {
                            $(".preco").html("Preço");
                            $(".ant").html("Anterior");
                        }
                        if($("#imagematual").attr('src') != ""){
                            var figura = new Image();
                            figura.crossOrigin="anonymous";
                            // figura.addEventListener('error', corsError, false);
                            
                            figura.onload = function(){
                                var propfigura = figura.width/figura.height;
                                var altfigura = 750 + (parseInt($('#zoom').val())*50), 
                                contfigura = 930, 
                                largfigura = propfigura*altfigura;
                                var eixoY = (w/2)-50 + (50*parseInt($("#cima").val()));
                                if($("#layout").val() == 3 || $("#layout").val() == 4){
                                    eixoY = (w/2)-250 + (50*parseInt($("#cima").val()));
                                }
                                if(largfigura > 930){
                                    largfigura = 930;
                                    altfigura = largfigura/propfigura;
                                    eixoY += ((750-altfigura)/2);
                                }

                                ctx.drawImage(figura, 100 + ((contfigura-largfigura)/2) + (50*parseInt($("#direita").val())), eixoY, largfigura, altfigura);
                                // ctx.drawImage(figura, 0+(50*$("#direita").val()), 0+(50*$("#cima").val()), w+(parseInt($('#zoom').val())*50), (w+(parseInt($('#zoom').val())*50)) * figura.height / figura.width);
                                continuarCartaz(ctx,w,h,fundo,cartaz);
                                $("#controles").show('fast');
                            }

                            figura.src = $("#imagematual").attr('src');
                        } else {
                            continuarCartaz(ctx,w,h,fundo,cartaz)
                            // $("#controles").hide('fast');
                            // $('#figura').val("")
                        }
                    }
                    
                    //alert("Você precisa de uma logomarca para continuar. Entre em contato com o administrador!");
                }
            }
        }
    }

    //Depois de adicionar figura
    function continuarCartaz(ctx,w,h,fundo,cartaz){
        if(fundo.height < fundo.width){
            ctx.drawImage(fundo, 0, 0, w, w * fundo.height / fundo.width);
        } else {
            ctx.drawImage(fundo, 0, 0, w, h);
        }
        var logo = new Image();
        logo.src = "<?php echo base_url().'assets/images/logomarcas/'.$this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca; ?>";
        
        <?php if($this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca){ ?>
        logo.onload = function(){
            if($("#layout").val() == 1){
                layout1(ctx,w,h,fundo,cartaz,logo);
            } else if($("#layout").val() == 2) {
                layout2(ctx,w,h,fundo,cartaz,logo);
            } else {
                layout3(ctx,w,h,fundo,cartaz,logo);
            }
        }
        <?php } else { ?>
            if($("#layout").val() == 1){
                layout1(ctx,w,h,fundo,cartaz,logo);
            } else if($("#layout").val() == 2) {
                layout2(ctx,w,h,fundo,cartaz,logo);
            } else {
                layout3(ctx,w,h,fundo,cartaz,logo);
            }
        <?php } ?>
    }

    //depois de adicionar(ou não) a logo
    function layout1(ctx,w,h,fundo,cartaz,logo){
        var preco = $("#preco").val() ? $("#preco").val() : "0,99";
        preco = preco.split(',');
        var precoG = preco[0];
        var precoP = preco[1] ? preco[1] : "00";
        var precoant = $("#precoant").val();
        var tamanho_fonte = $("#tamanho_fonte").val()/100;

        var unidade = $("#unidade").val() ? $("#unidade").val() : "Un";
        var rodape = $("#rodape").val() ? $("#rodape").val() : "";

        var produtol1 = $("#produtol1").val() ? $("#produtol1").val() : "Produto";
        var produtol2 = $("#produtol2").val() ? $("#produtol2").val() : "";
        var produtol3 = $("#produtol3").val() ? $("#produtol3").val() : "";

        //INCLUE O NOME DO PRODUTO
        ctx.textAlign = "center";
        ctx.font = "bold "+(197*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillStyle = "#333333";
        ctx.fillText(produtol1, w/2, (h/4)+(h/8)-125, w-67);
        
        ctx.font = "bold "+(159*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol2, w/2, (h/4)+(h/4)-125, w-133);

        ctx.font = "bold "+(66*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol3, w/2, (h/4)+(h/4)-17, w-67);

        //INCLUE A MENSAGEM DE RODAPÉ
        ctx.textAlign = "left";
        ctx.font = "bold "+(33*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(rodape, 33, h-17, w-33);

        //INCLUE A MEDIDA
        ctx.textAlign = "right";
        ctx.font = "bold "+(80*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(unidade, w-50, (h/8)*6 + (h/20), (w/4)-33);

        if(precoant != "" && precoant != "0,00"){
            //INCLUE O DE
            ctx.textAlign = "left";
            ctx.font = "bold "+(61*tamanho_fonte)+"px "+$('#fonte').val();
            ctx.fillText("DE:", 33, (h/8)*4 + 83);
            
            //Preço Anterior
            ctx.textAlign = "left";
            ctx.font = "bold "+(61*tamanho_fonte)+"px "+$('#fonte').val();
            ctx.fillText("R$ "+precoant, 150, (h/8)*4 + 83);

            ctx.beginPath();
            ctx.moveTo(200, (h/8)*4 + 108);
            ctx.lineTo(150 + precoant.length*58, (h/8)*4 + 25);
            ctx.lineWidth = 10;
            ctx.strokeStyle = '#ff0000';
            ctx.stroke();

            ctx.textAlign = "left";
            ctx.font = "bold "+(61*tamanho_fonte)+"px "+$('#fonte').val();
            ctx.fillText("POR:", 33, (h/8)*4 + 150);
        }

        //INCLUE O R$
        ctx.fillStyle = "#FF0000";
        ctx.textAlign = "right";
        ctx.font = "bold "+(99*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText("R$", w-33, (h/8)*6 - (h/8));

        //INCLUE O PREÇO GRANDE
        if(precoG.length == 1){
            ctx.textAlign = "center";
            ctx.font = "bold "+(694*tamanho_fonte)+"px "+$('#fonte').val();
            ctx.fillText(precoG, ((w/2) + 33), h-33-(h/32), w - 33);
        } else {
            ctx.textAlign = "right";
            ctx.font = "bold "+(694*tamanho_fonte)+"px "+$('#fonte').val();
            ctx.fillText(precoG, (w/4)*3 - 33, h-33-(h/32), ((w/4)*3)-67);
        }

        //INCLUE O PREÇO PEQUENO
        ctx.textAlign = "right";
        ctx.font = "bold "+(159*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(","+precoP, w-33, (h/8)*6, (w/4)-33);

        //A LOGOMARCA SE INCLUI AQUI
        <?php if($this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca){ ?>
        if($("#incluilogo").prop("checked")){
            ctx.drawImage(logo, w-33-(w/5), h-67-((w/5)*logo.height/logo.width), (w/5), (w/5) * logo.height / logo.width);
        }
        <?php } ?>

        //TEXTO LATERAL
        ctx.fillStyle = "#333333";
        ctx.rotate(-90*Math.PI/180);
        ctx.textAlign = "left";
        ctx.font = "bold 25px Arial";
        ctx.fillText("app.pressla.com.br", -h+75, 30, w-33);
        
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

    function layout2(ctx,w,h,fundo,cartaz,logo){
        var preco = $("#preco").val() ? $("#preco").val() : "0,99";
        preco = preco.split(',');
        var precoG = preco[0];
        var precoP = preco[1] ? preco[1] : "00";
        var precoant = $("#precoant").val();
        var tamanho_fonte = $("#tamanho_fonte").val()/100;

        var unidade = $("#unidade").val() ? $("#unidade").val() : "cada";
        var rodape = $("#rodape").val() ? $("#rodape").val() : "";
        var codigo = $("#codigo").val() ? "Cod.: "+$("#codigo").val() : "";

        var produtol1 = $("#produtol1").val() ? $("#produtol1").val() : "Produto";
        var produtol2 = $("#produtol2").val() ? $("#produtol2").val() : "";
        var produtol3 = $("#produtol3").val() ? $("#produtol3").val() : "";

        //INCLUE O NOME DO PRODUTO
        ctx.textAlign = "left";
        ctx.fillStyle = "#000000";
        ctx.font = "bold "+(65*tamanho_fonte)+"px "+$('#fonte').val(); 
        ctx.fillText(produtol1, 100, h-350, 900);
        
        ctx.fillStyle = "#222222";
        ctx.font = ""+(35*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol2, 100, h-280, 450);

        ctx.font = ""+(30*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol3, 100, h-235, 450);

        //CÓDIGO DO PRODUTO
        ctx.textAlign = "right";
        ctx.font = "20px "+$('#fonte').val();
        ctx.fillText(codigo, 550, h-163, 100);

        //INCLUE A MENSAGEM DE RODAPÉ
        array_rodape = rodape.split(" ");
        ctx.textAlign = "right";
        ctx.font = "25px "+$('#fonte').val();
        var saida = "";
        var contaLinha = 0;
        for(var i = 0; i < array_rodape.length; i++){
            saida += array_rodape[i]+" ";
            if(saida.length >= 10 || i == array_rodape.length-1){
                ctx.fillText(saida, 550, h-120+(26*contaLinha++), 100);
                saida = "";
            }
        }

        //Preço anterior
        if(precoant != "" && precoant != "0,00"){
            //INCLUE O DE
            ctx.textAlign = "left";
            ctx.font = "bold 25px "+$('#fonte').val();
            ctx.fillText("De R$ "+precoant, 575, h-275, 450);
            
            ctx.beginPath();
            ctx.moveTo(605, h-275);
            ctx.lineTo(605 + precoant.length*20, h-290);
            ctx.lineWidth = 5;
            ctx.strokeStyle = '#ff0000';
            ctx.stroke();

            ctx.font = "bold 25px "+$('#fonte').val();
            ctx.fillText("Por: ", 575, h-250, 450);
        }

        //INCLUE O R$
        ctx.fillStyle = "#ff0000";
        ctx.textAlign = "left";
        ctx.font = "bold 80px "+$('#fonte').val();
        ctx.fillText("R$", 580, h-140, 620);

        //INCLUE O PREÇO GRANDE
        ctx.textAlign = "right";
        ctx.font = "bold 300px "+$('#fonte').val();
        ctx.fillText(precoG, w-200, h-60, 250);

        //INCLUE O PREÇO PEQUENO
        ctx.textAlign = "left";
        ctx.font = "bold 80px "+$('#fonte').val();
        ctx.fillText(","+precoP, w-167, h-200, 130);
        
        //INCLUE A MEDIDA
        ctx.font = "50px "+$('#fonte').val();
        ctx.fillText(unidade, w-167, h-150, 125);

        //A LOGOMARCA SE INCLUI AQUI
        <?php if($this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca){ ?>
        if($("#incluilogo").prop("checked")){
            var propLogo = logo.width/logo.height;
            var altLogo = 125, contLogo = 370, largLogo = propLogo*altLogo;
            var eixoY = h-altLogo-50;
            if(largLogo > 340){
                largLogo = 340;
                altLogo = largLogo/propLogo;
                eixoY = eixoY + ((125-altLogo)/2);
            }
            ctx.drawImage(logo, (contLogo-largLogo)/2, eixoY, largLogo, altLogo);
        }
        <?php } ?>

        //TEXTO LATERAL
        ctx.fillStyle = "#333333";
        ctx.rotate(-90*Math.PI/180);
        ctx.textAlign = "left";
        ctx.font = "bold 20px Arial";
        ctx.fillText("app.pressla.com.br", -h+225, 25, w-33);
        
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

    function layout3(ctx,w,h,fundo,cartaz,logo){
        var preco = $("#preco").val() ? $("#preco").val() : "0,99";
        preco = preco.split(',');
        var precoG = preco[0];
        var precoP = preco[1] ? preco[1] : "00";
        var precoant = $("#precoant").val();
        var tamanho_fonte = $("#tamanho_fonte").val()/100;

        var unidade = $("#unidade").val() ? $("#unidade").val() : "cada";
        var rodape = $("#rodape").val() ? $("#rodape").val() : "";
        var codigo = $("#codigo").val() ? "Cod.: "+$("#codigo").val() : "";

        var produtol1 = $("#produtol1").val() ? $("#produtol1").val() : "Produto";
        var produtol2 = $("#produtol2").val() ? $("#produtol2").val() : "";
        var produtol3 = $("#produtol3").val() ? $("#produtol3").val() : "";

        //INCLUE O NOME DO PRODUTO
        ctx.textAlign = "left";
        ctx.fillStyle = "#000000";
        ctx.font = "bold "+(75*tamanho_fonte)+"px "+$('#fonte').val(); 
        ctx.fillText(produtol1, 50, h-475, 650);
        
        ctx.fillStyle = "#222222";
        ctx.font = ""+(50*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol2, 50, h-400, 650);

        ctx.font = ""+(45*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(produtol3, 50, h-350, 650);

        //CÓDIGO DO PRODUTO
        ctx.textAlign = "right";
        ctx.font = "20px "+$('#fonte').val();
        ctx.fillText(codigo, 590, h-275, 100);

        //INCLUE A MENSAGEM DE RODAPÉ
        ctx.fillStyle = "#ffffff";
        ctx.textAlign = "left";
        ctx.font = "bold "+(33*tamanho_fonte)+"px "+$('#fonte').val();
        ctx.fillText(rodape, 33, h-17, w-33);

        //Preço anterior
        if(precoant != "" && precoant != "0,00"){
            var ar_precoant = precoant.split(",");
            //INCLUE O R$
            ctx.fillStyle = "#ffffff";
            ctx.textAlign = "left";
            ctx.font = "bold 50px "+$('#fonte').val();
            ctx.fillText("R$", 750, h-500, 770);

            //INCLUE O PREÇO GRANDE
            ctx.textAlign = "right";
            ctx.font = "bold 200px "+$('#fonte').val();
            ctx.fillText(ar_precoant[0], w-192, h-380, 150);

            //INCLUE O PREÇO PEQUENO
            ctx.textAlign = "left";
            ctx.font = "bold 65px "+$('#fonte').val();
            ctx.fillText(","+ar_precoant[1], w-167, h-480, 130);
            
            //INCLUE A MEDIDA
            ctx.font = "30px "+$('#fonte').val();
            ctx.fillText(unidade, w-167, h-430, 125);
        }

        //INCLUE O R$
        ctx.fillStyle = "#ffffff";
        ctx.textAlign = "left";
        ctx.font = "bold 50px "+$('#fonte').val();
        ctx.fillText("R$", 700, h-250, 720);

        //INCLUE O PREÇO GRANDE
        ctx.textAlign = "right";
        ctx.font = "bold 250px "+$('#fonte').val();
        ctx.fillText(precoG, w-192, h-100, 200);

        //INCLUE O PREÇO PEQUENO
        ctx.textAlign = "left";
        ctx.font = "bold 75px "+$('#fonte').val();
        ctx.fillText(","+precoP, w-167, h-230, 130);
        
        //INCLUE A MEDIDA
        ctx.font = "40px "+$('#fonte').val();
        ctx.fillText(unidade, w-167, h-180, 125);

        //A LOGOMARCA SE INCLUI AQUI
        <?php if($this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca){ ?>
        if($("#incluilogo").prop("checked")){
            var propLogo = logo.width/logo.height;
            var altLogo = 125, contLogo = 370, largLogo = propLogo*altLogo;
            var eixoY = h-altLogo-85;
            if(largLogo > 340){
                largLogo = 340;
                altLogo = largLogo/propLogo;
                eixoY = eixoY + ((125-altLogo)/2);
            }
            ctx.drawImage(logo, (contLogo-largLogo)/2, eixoY, largLogo, altLogo);
        }
        <?php } ?>

        //TEXTO LATERAL
        ctx.fillStyle = "#333333";
        ctx.rotate(-90*Math.PI/180);
        ctx.textAlign = "left";
        ctx.font = "bold 20px Arial";
        ctx.fillText("app.pressla.com.br", -h+275, 25, w-33);
        
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

    // $("#tipo_template").val(20);
    // $("#tamanho").val("0.5<|>148 x 210");

    function criaAviso(){
        var path = "assets/images/templates/";
        $('#loader-cartaz').show();
        if($('#src_template').val() != null){
            var tam = $('#A3').val().split('<|>');
            var tamanho = tam[1].split(' x ');
            var w = parseFloat(tamanho[1])*3.78;
            var h = parseFloat(tamanho[0])*3.78;
            
            var fator = tam[0];
            var id_tam = $('#tamanho').children(":selected").attr('id');

            if($('#avisohorizontal').prop('checked') && id_tam != "A5"){
                w = parseFloat(tamanho[0])*3.78;
                h = parseFloat(tamanho[1])*3.78;
            }
            
            var canvasHTML = "<canvas id='aviso"+($("#avisohorizontal").prop("checked") ? "r" : "h")+$("input[name='quadrante']:checked").val()+"' width='"+w+"' height='"+h+"'></canvas>";
            $('#container_aviso'+($("#avisohorizontal").prop("checked") ? "r" : "h")+$("input[name='quadrante']:checked").val()).html(canvasHTML);
            
            //Recebemos o elemento canvas
            var ctx = carregarContextoCanvas('aviso'+($("#avisohorizontal").prop("checked") ? "r" : "h")+$("input[name='quadrante']:checked").val());
            var aviso = carregarContextoCanvas('aviso'+($("#avisohorizontal").prop("checked") ? "r" : "h"));
            if(ctx && aviso){
                //Crio uma imagem com um objeto Image de Javascript
                var fundo = new Image();
                //indico a URL da imagem
                fundo.src = "<?php echo base_url(); ?>"+path+$('#src_template').val();
                //defino o evento onload do objeto imagen
                fundo.onload = function(){
                    //INCLUE O FUNDO
                    ctx.beginPath();
                    ctx.rect(0, 0, w, h);
                    ctx.fillStyle = "#FFFFFF";
                    ctx.fill();
                    ctx.drawImage(fundo, 0, 0, w, w * fundo.height / fundo.width);

                    var logo = new Image();
                    logo.src = "<?php echo base_url().'assets/images/logomarcas/'.$this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca; ?>";
                    <?php if($this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca){ ?>
                    logo.onload = function(){
                        continuarAviso(ctx,w,h,fundo,aviso,id_tam,logo);
                    }
                    <?php } else { ?>
                        continuarAviso(ctx,w,h,fundo,aviso,id_tam,logo);
                    <?php } ?>
                }
            }
        }
    }

    function continuarAviso(ctx,w,h,fundo,aviso,id_tam,logo){
        
        var rodape = $("#rodapeaviso").val() ? $("#rodapeaviso").val() : "";
        //var linha1 = $("#linha1").val() ? $("#linha1").val() : "Primeira Linha";

        var size = $(".textoaviso").length;
        var fontsize = $("#size").val();

        for(var i = 0; i < size; i++){
            //TEXTO DO AVISO
            ctx.textAlign = "center";
            ctx.font = "bold "+(67*fontsize)+"px "+$('#fonte').val();
            ctx.fillStyle = "#333333";
            if($('#avisohorizontal').prop('checked') && id_tam != "A5"){
                ctx.fillText($(".textoaviso")[i].value, w/2, (67*(fontsize-1))+h/8+50+((83*fontsize)*i), w-67);    
            } else {
                ctx.fillText($(".textoaviso")[i].value, w/2, (67*(fontsize-1))+h/4+((83*fontsize)*i), w-67);
            }
        }
        
        //INCLUE A MENSAGEM DE RODAPÉ
        ctx.textAlign = "left";
        ctx.font = "bold "+(h/48)+"px "+$('#fonte').val();
        ctx.fillText(rodape, 33, h-17, w-33);

        <?php if($this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca){ ?>
        if($("#avisohorizontal").prop("checked")){
            if($("#incluilogo").prop("checked")){
                ctx.drawImage(logo, w-33-(w/5), h-67-((w/5)*logo.height/logo.width), (w/5), (w/5) * logo.height / logo.width);
            }
        } else {
            if($("#incluilogo").prop("checked")){
                ctx.drawImage(logo, w-33-(w/10), h-67-((w/10)*logo.height/logo.width), (w/10), (w/10) * logo.height / logo.width);
            }
        }
        <?php } ?>

        var ct = new Image();
        ct.src = document.getElementById('aviso'+($("#avisohorizontal").prop("checked") ? "r" : "h")+$("input[name='quadrante']:checked").val()).toDataURL();
        
        if(id_tam != "A5" && id_tam != "A6"){
            ct.onload = function(){
                aviso.drawImage(ct, 0, 0, ct.width, ct.height);
                var saida = "<img id='imgfinal' src='"+document.getElementById('aviso'+($("#avisohorizontal").prop("checked") ? "r" : "h")).toDataURL()+"' width='"+($("#avisohorizontal").prop("checked") ? "60%" : "80%")+"' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                $('#ver_img').html(saida);
                //MOSTRA O RESULTADO
                $('#loader-cartaz').hide();
                
                //visuPaisagem();
            }
        } else if(id_tam == 'A5'){
            ct.onload = function(){
                if($("input[name='quadrante']:checked").val() == 1){
                    aviso.rect(0, 0, w, h);
                    aviso.fillStyle = "#FFFFFF";
                    aviso.fill();
                }
                
                if($('#avisohorizontal').prop('checked')){
                    if($("input[name='quadrante']:checked").val() == 1){
                        aviso.drawImage(ct, 0, 0, ct.height, ct.width/2);
                    } else {
                        aviso.drawImage(ct, 0, ct.width/2, ct.height, ct.width/2);
                    }
                } else {
                    var margemSup = 18.0*3.78;
                    var margemDir = 10.0*3.78;
                    
                    aviso.beginPath();aviso.strokeStyle = "#cecece";
                    aviso.moveTo(-ct.height/2, margemSup);
                    aviso.lineTo(ct.height*2, margemSup);
                    aviso.lineWidth = 5;
                    aviso.setLineDash([25]);
                    aviso.stroke();

                    //linha do meio
                    aviso.beginPath();
                    aviso.moveTo(ct.width/2, margemSup);
                    aviso.lineTo(ct.width/2, ct.width*2);
                    aviso.lineWidth = 5;
                    aviso.setLineDash([25]);
                    aviso.stroke();

                    if($("input[name='quadrante']:checked").val() == 1){
                        aviso.drawImage(ct, 0, margemSup, (ct.width/2)-margemDir, (ct.height)-margemSup);
                    } else {
                        aviso.drawImage(ct, (ct.width/2)+margemDir, margemSup, (ct.width/2)-margemDir, (ct.height)-margemSup);
                    }
                    // if($("input[name='quadrante']:checked").val() == 1){
                    //     aviso.drawImage(ct, 0, 0, ct.height/2, ct.width/2);
                    // } else {
                    //     aviso.drawImage(ct, 0, ct.width/2, ct.height, ct.width/2);
                    // }
                }
                
                var saida = "<img id='imgfinal' src='"+document.getElementById('aviso'+($("#avisohorizontal").prop("checked") ? "r" : "h")).toDataURL()+"' width='"+($("#avisohorizontal").prop("checked") ? "60%" : "80%")+"' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                $('#ver_img').html(saida);
                //MOSTRA O RESULTADO
                $('#loader-cartaz').hide();
                
                //visuPaisagem();
            }
        } else if(id_tam == 'A6'){
            ct.onload = function(){
                
                if($("input[name='quadrante']:checked").val() == 1){
                    aviso.drawImage(ct, 0, 0, ct.width/2, ct.height/2);
                } else if($("input[name='quadrante']:checked").val() == 2){
                    aviso.drawImage(ct, ct.width/2, 0, ct.width/2, ct.height/2);
                } else if($("input[name='quadrante']:checked").val() == 3){
                    aviso.drawImage(ct, 0, ct.height/2, ct.width/2, ct.height/2);
                } else {
                    aviso.drawImage(ct, ct.width/2, ct.height/2, ct.width/2, ct.height/2);
                }
                
                var saida = "<img id='imgfinal' src='"+document.getElementById('aviso'+($("#avisohorizontal").prop("checked") ? "r" : "h")).toDataURL()+"' width='80%' style='box-shadow: 5px 5px 10px #444;'><div class='divblock'></div>";
                $('#ver_img').html(saida);

                //MOSTRA O RESULTADO
                $('#loader-cartaz').hide();
                
                //visuPaisagem();
            }
        }
    }

    function visuPaisagem(){
        if($('#horizontal').prop('checked')){
            $('#imgfinal').css('transform','rotate(-90deg)');
            $('#imgfinal').css('box-shadow','-5px 5px 10px #444');
        }
    }

    function baixarImagem(){
        var canvas = document.getElementById("cartaz"); // full page 
        var link = document.createElement("a");
        document.body.appendChild(link);
        link.download = "cartaz.png";
        link.href = canvas.toDataURL("image/jpeg");
        link.target = '_blank';
        link.click();
    }

    function gerarPDF(){
        $("#loader").show();
        $.get("<?php echo base_url('index.php/dashboard/checkImpressoesUsadas/'.$id); ?>", function(result){
            $("#loader").hide();
            if(result){
                var tam = $('#tamanho').val().split('<|>');
                
                var tamanho = tam[1].split(' x ');
                var w = tamanho[0];
                var h = tamanho[1];

                var id = $('#tamanho').children(":selected").attr('id');
                
                if(id == "A5" || id == "A6"){
                    id = "A4";
                    w = 210;
                    h = 297;
                }
                
                var d = new Date();
                var doc = new jsPDF({
                    orientation: id.length >= 8 ? 'l' : 'p',
                    format: id.length == 2 ? id : [w,h]
                });

                var canvas = document.getElementById("cartaz");
                
                const imagem = canvas.toDataURL("image/jpeg");

                if(id.length >= 8){
                    var paginas = parseInt(id.split(' ')[1].split('x')[1]);
                    doc.addImage(imagem, "JPEG", 0, 0, w, h*paginas);
                    doc.addPage({
                        orientation: 'l',
                        format: [w,h]
                    });
                    doc.addImage(imagem, "JPEG", 0, h*(-1), w, h*paginas);
                } else {
                    doc.addImage(imagem, "JPEG", 0, 0, w, h);
                }

                doc.save(id+'_cartaz_'+d.getTime()+'.pdf');

                $.get("<?php echo base_url('index.php/dashboard/contarImpressaoUsada/'.$id); ?>");
            } else {
                $('#texto-aviso').html("Você usou todos os créditos disponível!!<br><br>Obtenha mais créditos para continuar utilizando nossos serviços.");
                $("#modalAviso").modal('show');
            }
        });
    }

    function gerarPDFaviso(){
        $("#loader").show();
        $.get("<?php echo base_url('index.php/dashboard/checkImpressoesUsadas/'.$id); ?>", function(result){
            
            if(result){
                var tam = $('#tamanho').val().split('<|>');
                
                var id_tam = $('#tamanho').children(":selected").attr('id');
                var id = "A4"
                var tamanho = tam[1].split(' x ');
                var w = tamanho[1];
                var h = tamanho[0];

                if($('#avisohorizontal').prop('checked')){
                    w = tamanho[0];
                    h = tamanho[1];
                }

                var d = new Date();
                var doc = new jsPDF({
                    orientation: $("#avisohorizontal").prop("checked") ? "p" : "l",
                    format: [w,h]
                });

                var canvas = document.getElementById("aviso"+($("#avisohorizontal").prop("checked") ? "r" : "h"));
                
                const imagem = canvas.toDataURL("image/jpeg");

                doc.addImage(imagem, "JPEG", 0, 0, w, h);

                doc.save(id_tam+'_aviso_'+d.getTime()+'.pdf');

                $.get("<?php echo base_url('index.php/dashboard/contarImpressaoUsada/'.$id); ?>");
            } else {
                $('#texto-aviso').html("Você usou todos os créditos disponível!!<br><br>Obtenha mais créditos para continuar utilizando nossos serviços.");
                $("#modalAviso").modal('show');
            }
            $("#loader").hide();
        });
    }


    buscaIds();

    //Guarda o endereço das figuras pertencentes ao BD
    var objFiguras = {
    <?php
        foreach($figuras as $figura){
            echo '"'.$figura->nome.'" : "'.base_url("assets/images/figuras/".$figura->src).'",';
            echo '"'.$figura->ean.'" : ["'.$figura->nome.'", "'.base_url("assets/images/figuras/".$figura->src).'"],';
        }
    ?>
    }
    
    //OBTEM AS IMAGENS DO CAMPO DE PESQUISA
    function buscaImagens(value){
        if(!$("#figura").val()){
            return
        }
        $("#figura").blur();
        $("#loader").show();
        
        figuras = [];
        //Filtra as figuras do BD para retornar apenas as figuras da pesquisa
        var array_objfiguras = Object.keys(objFiguras);
        var array_filtrado = array_objfiguras.filter(function(v){
            return v.toUpperCase().indexOf(value.toUpperCase()) != -1;
        });
        array_filtrado.forEach((item)=>{
            figuras.push({"url" : (Array.isArray(objFiguras[item]) ? objFiguras[item][1] : objFiguras[item]), "title": (Array.isArray(objFiguras[item]) ? objFiguras[item][0] : $("#figura").val())});
        });
        
        //Procura 10 resultados no google
        //"https://www.googleapis.com/customsearch/v1?key=AIzaSyDn8VqTxIoktrCJsdyXzHghc6HlXG4BANA&cx=e0fab0362a537c756&q="+value+"&callback=hndlr&imgColorType=trans&searchType=image&hl=lang_pt&imgSize=large&lr=lang_pt&safe=off&filter=1"
        
        $.get("https://www.googleapis.com/customsearch/v1?key=AIzaSyDn8VqTxIoktrCJsdyXzHghc6HlXG4BANA&cx=e0fab0362a537c756&q="+value+"&callback=hndlr&searchType=image&imgSize=large", function(retorno1){
            retorno1 = retorno1.slice(22);
            retorno1 = retorno1.slice(0, -2);
            retorno1 = JSON.parse(retorno1);

            //Procura MAIS 10 resultados no google
            $.get("https://www.googleapis.com/customsearch/v1?key=AIzaSyDn8VqTxIoktrCJsdyXzHghc6HlXG4BANA&cx=e0fab0362a537c756&q="+value+"&callback=hndlr&searchType=image&start=11&imgSize=large", function(retorno2){
                retorno2 = retorno2.slice(22);
                retorno2 = retorno2.slice(0, -2);
                retorno2 = JSON.parse(retorno2);

                var response = retorno1;
                if(response.items){
					response.items = response.items.concat(retorno2.items);
				} else {
					response.items = retorno2.items;
				}
                
				if(response.items){
					for (var i = 0; i < response.items.length; i++) {
						var item = response.items[i];
						
						// testCORS(item.link, $("#cont")) ? figuras.push(item.link) : false;
						//CHAMA O MÉTODO QUE VERIFICA SE A IMAGEM NÃO TEM ERRO DE CORS
						i == (response.items.length - 1) && item.link ? testCORS(item.link, item.title, true) : testCORS(item.link, item.title, false);
					}
				} else {
					$("#loader").hide();
					alert("Não foi possível entrontrar imagens disponíveis com o parâmetro informado");
				}
            });
        });
    }

    function escondeControle(value){
        if(value == ""){
            $("#controles").hide('fast');
            $("#imagematual").attr('src',"");
            $("#produtol1").val("");
            isAviso();
        }
    }

    var figuras;

    function passaImagem(tipo){
        if($("#imagematual").attr('src') == ""){
            return;
        } else {
            var index = 0;
            for(var i=0; i<figuras.length; i++) {
                if(figuras[i].url == $("#imagematual").attr('src')) {
                    index = i;
                    break;
                }
            }
            if(tipo == 'next' && index < figuras.length - 1){
                $("#imagematual").attr('src',figuras[index+1].url);
				$("#produtol1").val(figuras[index+1].title);
                isAviso();
            } else if(tipo == 'next' && index == figuras.length - 1){
                $("#imagematual").attr('src',figuras[0].url);
				$("#produtol1").val(figuras[0].title);
                isAviso();
            } else if(tipo == 'back' && index > 0){
                $("#imagematual").attr('src',figuras[index-1].url);
				$("#produtol1").val(figuras[index-1].title);
                isAviso();
            } else {
                $("#imagematual").attr('src',figuras[figuras.length - 1].url);
				$("#produtol1").val(figuras[figuras.length - 1].title);
                isAviso();
            }
        }
    }

    //MÉTODO QUE VERIFICA SE A IMAGEM NÃO TEM ERRO DE CORS
    function testCORS(url, title, $elem) {
        $.ajax({
        url: url
        })
        .fail(function(jqXHR, textStatus) {
            if(jqXHR.status === 0) {
                // Determine if this was a CORS violation or not
                $.ajax({
                    context: url,
                    url: "<?= base_url("cors.php") ?>?url=" + escape(this.url),
                })
                .done(function(msg) {
                    if(msg.indexOf("HTTP") < 0) {
                        // $elem.append(url + " - doesn't exist or timed out<br>");
                    } else if(msg.indexOf("Access-Control-Allow-Origin") >= 0) {
                        // $elem.append(url + " - CORS violation because '" + msg + "'<br>");
                    } else {
                        // $elem.append(url + " - no Access-Control-Allow-Origin header set<br>");
                    }
                    $elem ? mostraFiguras() : false;
                })
                .fail(function(i){
                    $elem ? mostraFiguras() : false;
                });
            } else {
                // Some other failure (e.g. 404), but not CORS-related
                // $elem.append(url + " - failed because '" + responseText + "'<br>");
                $elem ? mostraFiguras() : false;
            }
        })
        .done(function(msg) {
            // Successful ajax request
            // $elem.append(this.url + " - OK<br>");
            figuras.push({"url" : url, "title" : title})
            $elem ? mostraFiguras() : false;
        })
        // .fail(function( jqXHR, settings, exception ) {
        //     console.log("Não foi possível carregar o arquivo :(");
        // });
    }

    function mostraFiguras(){
        console.clear();
        $("#imagematual").attr('src',figuras[0].url);
        $("#produtol1").val(figuras[0].title);
        isAviso();
        $("#controles").show('fast');
        $("#loader").hide();
    }
</script>