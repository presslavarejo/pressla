<?php $this->load->view("dashboard/criar/style"); ?>
<style>
    .card-plano {
        border-radius: 8px;
        background-color: #FFF;
        padding: 10px;
        border: 1px solid #cecece;
        box-shadow: 0px 0px 5px #cecece;
        width: 100%;
    }

    .aba-fila {
        padding: 10px;
        background-color: #cecece;
        width: 100%;
        cursor: pointer;
    }

    .aba-fila-ativa {
        background-color: white;
    }
</style>
<div class="col-2" id="comptela"></div>
<div class='col-sm pl-0 pr-md-2 pr-0 h-100' id="tela">
    <div class='card m-3'>
        <div class='row p-3'>
            <div class='col-sm-4 p-2'>
                <div class="row">
                    <div class="col">
                        Selecione uma Fila de Impressão
                        <br>
                        <select id="fila" class="form-control">
                            <option disabled selected value="">Selecione...</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <br>
                        <input type="button" value="IR" class="btn btn-primary">
                    </div>
                </div>
            </div>
            <div class='col-sm-2 p-2'>
                <br>
                <h1 class="text-center">OU</h1>
            </div>
            <div class='col-sm-6 p-2'>
                <div class="row">
                    <div class="col">
                        Adicione um arquivo .csv
                        <br>
                        <input type="file" id="arquivo" class="form-control" accept=".csv">
                    </div>
                    <div class="col-auto">
                        <br>
                        <input type="button" value="IR" class="btn btn-primary" onclick="lerArquivo()">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card m-3">
        <div class="row">
            <div class="col pt-2 pb-2 pr-4 text-right">
                <input type="button" value="GERAR PDF" class="btn btn-success">
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col-sm-6" id="dados">

            </div>
            <div class="col-sm-6" id="visual">
                <div id="ver_img" class='pt-2 text-center sticky-top w-100'>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="display:none">
    <input type="hidden" id="preco">
    <input type="hidden" id="precoant">
    <input type="hidden" id="tamanho_fonte">
    <input type="hidden" id="unidade">
    <input type="hidden" id="rodape">
    <input type="hidden" id="produtol1">
    <input type="hidden" id="produtol2">
    <input type="hidden" id="produtol3">
    <input type="hidden" id="codigo">
    <input type="hidden" id="src_template">
    <input type="checkbox" name="quadrante" id="quadrante" value="1" checked>
    <input type="checkbox" name="incluirlogo" id="incluirlogo" value="1" checked>
    <input type="hidden" id="fonte">
    <input type="hidden" id="layout">
    <input type="hidden" id="cor_preco">
    <input type="hidden" id="cor_preco_anterior">
    <select name="tamanho" id="tamanho" class='form-control'>
        <option value="" id="" selected></option>
    </select>
    <input type="hidden" id="A3" value="2<|>297 x 420">

    <div id="container_cartaz"></div>
    <canvas id='cartaz' width='1122.66' height='1587.6'></canvas>
    <canvas id='cartaz_a2' width='1587.6' height='2245.32'></canvas>
</div>

<script>
    var objeto = {}

    function mudaAba(num, massa = false, quantidade = 0, i = 0) {
        $(".aba-fila").removeClass("aba-fila-ativa");
        $("#aba-fila-" + num).addClass("aba-fila-ativa");

        // objeto.layout[index]
        // objeto.template[index]
        // objeto.tamanho[index]
        // objeto.fonte[index]
        // objeto.fonte_tamanho[index]

        // objeto.linha1[index]
        // objeto.linha2[index]
        // objeto.linha3[index]
        // objeto.codigo[index]
        // objeto.rodape[index]

        // objeto.preco[index]
        // objeto.cor_preco[index]
        // objeto.preco_anterior[index]
        // objeto.cor_preco_anterior[index]
        // objeto.unidade[index]

        var ar_lay = $("#lay-aba-fila-" + num).val().split(" - ");
        var ar_desc = $("#desc-aba-fila-" + num).val().split(" - ");
        var ar_pre = $("#pre-aba-fila-" + num).val().split(" - ");


        $.get('<?php echo base_url('index.php/dashboard/buscaTemplate/') ?>' + ar_lay[1], function(html) {
            $('#A3').val().split('<|>');

            $("#layout").val(ar_lay[0]);
            $("#src_template").val(html);
            $('#tamanho').children(":selected").attr('id', ar_lay[2]);
            $("#fonte").val(ar_lay[3]);
            $("#tamanho_fonte").val(ar_lay[4]);

            $("#produtol1").val(ar_desc[0]);
            $("#produtol2").val(ar_desc[1]);
            $("#produtol3").val(ar_desc[2]);
            $("#codigo").val(ar_desc[3]);
            $("#rodape").val(ar_desc[4]);

            $("#preco").val(ar_pre[0]);
            $("#cor_preco").val(ar_pre[1]);
            $("#precoant").val(ar_pre[2]);
            $("#cor_preco_anterior").val(ar_pre[3]);
            $("#unidade").val(ar_pre[4]);

            // $("#preco").val(objeto.preco[num]);
            // $("#precoant").val(objeto.preco_anterior[num]);
            // $("#tamanho_fonte").val(objeto.fonte_tamanho[num]);
            // $("#unidade").val(objeto.unidade[num]);
            // $("#rodape").val(objeto.rodape[num]);
            // $("#produtol1").val(objeto.linha1[num]);
            // $("#produtol2").val(objeto.linha2[num]);
            // $("#produtol3").val(objeto.linha3[num]);
            // $("#codigo").val(objeto.codigo[num]);

            // $("#src_template").val(html);

            // $("#fonte").val(objeto.fonte[num]);
            // $("#layout").val(objeto.layout[num]);
            // $("#cor_preco").val(objeto.cor_preco[num]);
            // $("#cor_preco_anterior").val(objeto.cor_preco_anterior[num]);

            // $('#tamanho').children(":selected").attr('id', objeto.fonte_tamanho[num]);

            criaCartaz();
        });
    }

    function lerArquivo() {
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: URL.createObjectURL(document.getElementById("arquivo").files[0]),
                dataType: "text",
                success: function(data) {
                    processaArquivo(data.split("\n"));
                }
            });
        });
    }

    function processaArquivo(data) {
        var keys = data.shift().split(";");
        data.pop();
        if (keys[keys.length] == "fim_texto") {
            keys.pop();
        }

        keys.forEach((key) => {
            objeto[key] = []
        });

        data.forEach((item) => {
            item = item.split(";");

            item.forEach((coluna, index) => {
                objeto[keys[index]].push(coluna);
            });
        });
        
        objeto.layout.forEach((item, index) => {
            $("#dados").append(
                '<div class="aba-fila' + (index == 0 ? " aba-fila-ativa" : "") + '" id="aba-fila-' + (index) + '" onclick="mudaAba(' + (index) + ')">' +
                '<label class="p-2 col">LAYOUT: <br> <textarea id="lay-aba-fila-' + index + '" class="form-control col" style="background-color:transparent" onblur="mudaAba(' + (index) + ')">' + objeto.layout[index] + ' - ' + objeto.template[index] + ' - ' + objeto.tamanho[index] + ' - ' + objeto.fonte[index] + ' - ' + objeto.fonte_tamanho[index] + '</textarea></label>' +
                '<br><label class="p-2 col">TEXTO - DESCRIÇÃO: <br> <textarea id="desc-aba-fila-' + index + '" class="form-control col" style="background-color:transparent" onblur="mudaAba(' + (index) + ')">' + objeto.linha1[index] + ' - ' + objeto.linha2[index] + ' - ' + objeto.linha3[index] + ' - ' + objeto.codigo[index] + ' - ' + objeto.rodape[index] + '</textarea></label>' +
                '<br><label class="p-2 col">TEXTO - PREÇO: <br> <textarea id="pre-aba-fila-' + index + '" class="form-control col" style="background-color:transparent" onblur="mudaAba(' + (index) + ')">' + objeto.preco[index] + ' - ' + objeto.cor_preco[index] + ' - ' + objeto.preco_anterior[index] + ' - ' + objeto.cor_preco_anterior[index] + ' - ' + objeto.unidade[index] + '</textarea></label>'
            );
        });
        mudaAba(0);
    }

    // SCRIPTS FALTOSOS
    function carregarContextoCanvas(idCanvas) {
        var elemento = document.getElementById(idCanvas);
        if (elemento && elemento.getContext) {
            var contexto = elemento.getContext('2d');
            if (contexto) {
                return contexto;
            }
        }
        return false;
    }

    function isPrimeiro() {
        return false;
    }

    function liberaCampos() {
        //pass
    }

    function visuPaisagem() {
        // if($('#horizontal').prop('checked')){
        //     $('#imgfinal').css('transform','rotate(-90deg)');
        //     $('#imgfinal').css('box-shadow','-5px 5px 10px #444');
        // }
        // pass
    }

    dados_quadrante = []
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