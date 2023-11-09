<script src="<?php echo base_url('assets/js/jquery.maskMoney.js'); ?>" type="text/javascript"></script>
<!-- COMEÇO ADD FILA -->
<script>
    function addFila(nome){
        $('#loader-cartaz').show();
        $.get("<?= base_url("dashboard/criarFila/".$this->session->userdata('logado')['id']."/") ?>"+nome, function(){
            
        });
    }
</script>
<!-- FIM ADD FILA -->
<script>
    dados_tabloid = {}
    dados_faixa = {}
    dados_quadrante = {}
    dados_tabloid_quadrante = {
        1 : {},
        2 : {},
        3 : {},
        4 : {}
    }
    var dados = []

    let primeiro = false;

    function isAvisoDois(){
        setPrimeiro(true);
        isAviso();
    }

    function setPrimeiro(primeiro){
        this.primeiro = primeiro;
    }

    function isPrimeiro(){
        return this.primeiro;
    }

    function mudaCelula(){
        setPrimeiro(true);
        isAviso();
    }

    $(function(){
        $("#preco").maskMoney({thousands:'.', decimal:','});
        $("#precoant").maskMoney({thousands:'.', decimal:','});
        $(".money").maskMoney({thousands:'.', decimal:','});
        $(".money_ponto").maskMoney({thousands:'', decimal:'.'});
        $('#horizontal').change(function(){
            $('#horizontal').prop('checked') ? visuPaisagem() : criaCartaz();
        });
        $('#avisohorizontal').change(function(){
            criaAviso();
        });
        $('#layout').change(function(){
            if($('#layout').val() == 8){
                $('#rodape').val("X unidades");
            } else {
                $('#rodape').val("Oferta válida enquanto durarem nossos estoques");
            }
        });

        $("input[name^='cel_tab']").change(function(){
            mudaCelula();
        });
        
        if(typeof dadosdafila == "undefined"){
            document.getElementById("figura").addEventListener('keyup', function(e){
                var key = e.which || e.keyCode;
                if (key == 13) { // codigo da tecla enter
                    buscaImagens(this.value);
                }
            });
        }
    });

    function isAviso(){
        if($('#tipo_template').children(":selected").html() == "Avisos e Informações"){
            $('#avisos').show();
            $('#todos').hide();
            $('.check_verpaisagem').hide();
            $('#container_tam_fonte').hide();
            $('#container_tam_fonte_aviso').show();
            $('.aba3').hide();
            $('.aba1').show();
            $('#A0').prop('disabled','true');
            $('#A1').prop('disabled','true');
            $('#A2').prop('disabled','true');
            $('#A5').prop('disabled','true');
            $("[id*='x2']").prop('disabled','true');
            criaAviso();
        } else {
            $('#avisos').hide();
            $('#todos').show();
            $('.check_verpaisagem').show();
            $('#container_tam_fonte').show();
            $('#container_tam_fonte_aviso').hide();
            $('#A0').prop('disabled',false);
            $('#A1').prop('disabled',false);
            $('#A2').prop('disabled',false);
            $('#A5').prop('disabled',false);
            $("[id*='x2']").prop('disabled',false);
            
            if(typeof dadosdafila != "undefined"){
                criaCartazFila();
            } else {
                criaCartaz();
            }
        }
    }

    function tamSelecionado(){
        var id = $('#tamanho').children(":selected").attr('id');
        var tam = ($("#layout").val() == 8 || $("#layout").val() == 9 ? $('#A1').val().split('<|>') : $('#A3').val().split('<|>'));
        var tamanho = tam[1].split(' x ');
        
        var w = parseFloat(tamanho[0])*3.78;
        var h = parseFloat(tamanho[1])*3.78;
        if($("#layout").val() == 5 || $("#layout").val() == 6 || $("#layout").val() == 10 || $("#layout").val() == 11 || $("#layout").val() == 14 || $("#layout").val() == 25|| $("#layout").val() == 27){
            w = parseFloat(tamanho[1])*3.78;
            h = parseFloat(tamanho[0])*3.78;
        }
        
        
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
        if($("#layout").val() == 8 || $("#layout").val() == 9){
            $('#A1').show();
        } else {
            $('#A1').hide();
        }
        selecionaCores();
        id = $("#tipo_template").val();
        var numLay = $("#layout").val() == 13 ? 1 : $("#layout").val();
        // if($("#layout").val() == 21 || $("#layout").val() == 22){
        //     numLay = 11;
        // }
        $.get('<?php echo base_url('index.php/dashboard/buscaTemplatesPorTipo/'); ?>'+id+'/<?php echo $id; ?>/'+numLay, function(html){
            
            var ids = html.split(',');
            var tamanho = ids.length;

            var saida = "<option value='0'>Sem fundo</option>";
            if(tamanho > 0 && ids[0] != ""){
                
                for(var i = 0; i < tamanho; i++){
                    var idss = ids[i].split('<|>');
                    saida += "<option value='"+idss[0]+"'>"+idss[1]+"</option>";
                }
            }
            
            $("#template").html(saida);
            buscaTemplate();
        });
    }

    function buscaTemplate(){
        id = $("#template").val();

        if(id == 0){
            $("#src_template").val("../semfundo.png");
            isAviso();
        } else {
            $.get('<?php echo base_url('index.php/dashboard/buscaTemplate/') ?>'+id, function(html){
            
                $("#src_template").val(html);
                isAviso();
            });
        }
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

    function liberaCampos(comando){
        $("#precoant").attr('disabled',comando);
        $("#unidade").attr('disabled',comando);
        $("#rodape").attr('disabled',comando);
        $("#codigo").attr('disabled',comando);
        $("#produtol3").attr('disabled',comando);
        $("#container_maisinfo").hide();
        if(comando){
            $("#faixas").show();
            $("#A5").hide();
            $("#A6").hide();
            var id_tam = $('#tamanho').children(":selected").attr('id');
            if($("#layout").val() == "6b"){
                $("#A3").hide();
                if(id_tam == "A4"){
                    $("#f10").attr('disabled',true);
                } else if(id_tam == "A3"){
                    $("#f8").attr('disabled',false);
                    $("#f9").attr('disabled',false);
                    $("#f10").attr('disabled',false);
                }
                $("#container_maisinfo").show();
            } else {
                if(id_tam == "A4"){
                    $("#f8").attr('disabled',true);
                    $("#f9").attr('disabled',true);
                    $("#f10").attr('disabled',true);
                } else if(id_tam == "A3"){
                    $("#f8").attr('disabled',false);
                    $("#f9").attr('disabled',false);
                    $("#f10").attr('disabled',false);
                }
            }
        } else {
            $("#faixas").hide();
            $("#A4").show();
            $("#A5").show();
            $("#A6").show();
        }
    }

    function liberaCampos2(){
        $("#container_codigo").hide();
        
        $("#faixas").show();
        $("#tamanho").attr('readonly',true);
        $("#tamanho").val("2<|>297 x 420");
        $("#A4").hide();
        $("#A5").hide();
        $("#A6").hide();
        
        // $("#f4").attr('disabled',true);
        // $("#f5").attr('disabled',true);
        $("#f6").attr('disabled',true);
        $("#f7").attr('disabled',true);
        $("#f8").attr('disabled',true);
        $("#f9").attr('disabled',true);
        $("#f10").attr('disabled',true);
    }


    </script>
    <?php $this->load->view("dashboard/criar/criarcartaz"); ?>
    <?php $this->load->view("dashboard/criar/continuarcartaz"); ?>
    <?php $this->load->view("dashboard/criar/layout1"); ?>
    <?php $this->load->view("dashboard/criar/layout2"); ?>
    <?php $this->load->view("dashboard/criar/layout3"); ?>
    <?php $this->load->view("dashboard/criar/layout4"); ?>
    <?php $this->load->view("dashboard/criar/layout5"); ?>
    <?php $this->load->view("dashboard/criar/layout6"); ?>
    <?php $this->load->view("dashboard/criar/layout7"); ?>
    <?php $this->load->view("dashboard/criar/layout8"); ?>
    <?php $this->load->view("dashboard/criar/layout9"); ?>
    <?php $this->load->view("dashboard/criar/layout10"); ?>
    <?php $this->load->view("dashboard/criar/layout11"); ?>
    <?php $this->load->view("dashboard/criar/layout12"); ?>
    <?php $this->load->view("dashboard/criar/layout13"); ?>
    <?php $this->load->view("dashboard/criar/layout14"); ?>
    <?php $this->load->view("dashboard/criar/layout18"); ?>
    <?php $this->load->view("dashboard/criar/layout25"); ?>
    <?php $this->load->view("dashboard/criar/layout26"); ?>
    <?php $this->load->view("dashboard/criar/layout27"); ?>
    <?php $this->load->view("dashboard/criar/layout28"); ?>
    
    <?php $this->load->view("dashboard/criar/criaraviso"); ?>
    <?php $this->load->view("dashboard/criar/continuaraviso"); ?>

    <?php $this->load->view("dashboard/criar/gerarpdfcartaz"); ?>
    <?php $this->load->view("dashboard/criar/gerarpdfaviso"); ?>

    <?php $this->load->view("dashboard/criar/buscafiguras"); ?>

    <script>
    // $("#tipo_template").val(20);
    // $("#tamanho").val("0.5<|>148 x 210");

    function visuPaisagem(){
        if($('#horizontal').prop('checked')){
            $('#imgfinal').css('transform','rotate(-90deg)');
            $('#imgfinal').css('box-shadow','-5px 5px 10px #444');
        }
    }

    function escondeControle(value){
        if(value == ""){
            $("#controles").hide('fast');
            $("#imagematual").attr('src',"");
            $("#produtol1").val("");
            isAviso();
        }
    }

    function selecionaCores(){
        //CORES INICIAIS
        if($("#layout").val() == 1 || $("#layout").val() == 2 || $("#layout").val() == 13 || $("#layout").val() == 25){
            $("#cor_preco").val("#FF0000");
            $("#cor_preco_anterior").val("#000000");
        } else if($("#layout").val() == 3 || $("#layout").val() == 4 || $("#layout").val() == 5 || $("#layout").val() == 6 || $("#layout").val() == 15){
            $("#cor_preco").val("#FFFFFF");
            $("#cor_preco_anterior").val("#FFFFFF");
        } else if($("#layout").val() == 7 || $("#layout").val() == 18){
            $("#cor_preco").val("#FF0000");
        } else if($("#layout").val() == 8 || $("#layout").val() == 9 || $("#layout").val() == 10 || $("#layout").val() == 11 || $("#layout").val() == 12 || $("#layout").val() == 14 || $("#layout").val() == 16 || $("#layout").val() == 17 || $("#layout").val() == 21){
            $("#cor_preco").val("#FFFFFF");
            $("#cor_preco_anterior").val("#000000");
        } else if($("#layout").val() == 18 || $("#layout").val() == 19 || $("#layout").val() == 20 || $("#layout").val() == 23){
            $("#cor_preco").val("#FFAA00");
            $("#cor_preco_anterior").val("#000000");
        }
    }

    <?php if(isset($lay)){ ?>
    $('#layout').val(<?=$lay?>);
    $('.categoria').hide();
    $('.categoria<?=$lay == 13 ? 1 : $lay?>').show();
    $(".categoria<?=$lay == 13 ? 1 : $lay?>").removeAttr("selected");
    $(".categoria<?=$lay == 13 ? 1 : $lay?>:first").attr("selected", "selected");
    
    buscaIds();
    tamSelecionado();
    <?php } else { ?>
    if(typeof dadosdafila == "undefined"){
        buscaIds();
    } else {
        trataDados(1);
    }
    <?php } ?>
</script>