<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <h1 class="header" style='padding:10px;'>Cartazes em Massa <small class="text-muted">Gerados a partir do gerenciador de produtos</small> <a href="<?php echo base_url('index.php/produtos'); ?>" class="btn btn-primary btn-sm text-white"> < </a> </h1>
    <?php $this->load->view("dashboard/criar/style"); ?>
    <hr>
    <form method="post" class="row" id="form-carregar" enctype="multipart/form-data" onsubmit="carregaprodutos(this, event, 'form-carregar')">
        <div class="col-sm text-center mt-2 mb-2">
            Para importar mais produtos. <a href="#" onclick="$('#baixamodelo').modal('show')"><strong>Clique aqui</strong></a> para baixar o arquivo modelo.
        </div>
        <div class="col-sm-4 mt-2 mb-2">
            <input type="file" name="arquivoxml" class="form-control" accept=".xml , .csv" required>
        </div>
        <div class="col-sm-1 mt-2 mb-2">
            <input type="submit" value="OK" class="btn btn-success col">
        </div>
    </form>

    <div class="row mt-2 mb-2">
        <div class="col">
            <h1 class="text-center">OU</h1>
        </div>
    </div>

    <form method="post" class="row" id="form-carregar-sheets" onsubmit="carregaprodutos(this, event, 'form-carregar-sheets')">
        <div class="col-sm-auto d-flex align-items-center">
            Importe uma planilha do Google Sheets:
        </div>
        <div class="col-sm mt-2 mb-2">
            <input type="text" name="url_planilha" class="form-control" placeholder="Cole aqui a URL da planilha" required>
        </div>
        <div class="col-sm-1 mt-2 mb-2">
            <input type="submit" value="OK" class="btn btn-success col">
        </div>
        <div class="col-12 mt-2 small text-secondary text-right">
            Obs.: Para funcionar corretamente, a planilha deve ser pública e o nome dela deve ser Produtos
        </div>
    </form>
    <hr>
    <div class="card p-2">
        <div class="row">
            <div class="col-sm-6">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Layout</span>
                    </div>
                    <select name="layout" id="layout" class='form-control' onchange="mudaCategorias(this.value)">
                        <optgroup label="Layouts Verticais">
                            <option value="1">Sem Imagem</option>
                            <option value="13">Sem Imagem 2</option>
                            <option value="3">Cartão da Loja</option>
                            <option value="4">Clube Fidelidade</option>
                            <option value="15">2 Preços - Sem Imagem</option>
                            <option value="12">2 Preços - Sem Imagem 2</option>
                        </optgroup>
                        <optgroup label="Layouts Horizontais">
                            <option value="6">Faixas para Gôndolas</option>
                            <option value="10">Atacado e Varejo - Sem imagem</option>
                            <option value="11">Varejo - Sem imagem</option>
                            <option value="16">2 preços Horizontal sem imagem 8x20</option>
                            <option value="17">1 preço Horizontal sem imagem 8x20</option>
                            <option value="25">1 Preço horizontal - Sem imagem 42x30</option>
                            <option value="21">Horizontal 17x12 sem imagem</option>
                        </optgroup>
                    </select>
                </div>
            </div>

            <div class="col-sm">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Categoria</span>
                    </div>
                    <select name="tipo_template" id="tipo_template" class='form-control' onchange="buscaIds()">
                        <?php
                        foreach ($templates as $template) {
                            echo "<option value='" . $template->id . "' id='" . $template->id . "' class='";
                            foreach ($tipos as $tipo) {
                                $arids = explode(", ", $tipo->tipos_ids);
                                if (in_array($template->id, $arids)) {
                                    echo "categoria" . $tipo->layout . " ";
                                }
                            }
                            echo "categoria'>";
                            echo $template->tipo;
                            echo "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Template</span>
                    </div>
                    <select name="template" id="template" class='form-control' onchange="buscaTemplate()">
                    </select>
                    <input type='hidden' id='src_template' />
                </div>
            </div>
            <div class="col-sm" id="tamanho_comum">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Tamanho</span>
                    </div>
                    <select name="tamanho" id="tamanho" class='form-control'>
                        <?php
                        foreach ($tamanhos as $tamanho) {
                            echo "<option value='" . $tamanho->fator . "<|>" . $tamanho->medidas . "' id='" . $tamanho->nome . "'>";
                            echo $tamanho->nome . " | " . $tamanho->medidas;
                            echo "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Fonte</span>
                    </div>
                    <select name="fonte" id="fonte" class='form-control' onchange="criaCartazFila();">
                        <?php
                        $path = 'assets/fonts/';
                        $diretorio = dir($path);

                        while ($arquivo = $diretorio->read()) {
                            if ($arquivo != "." && $arquivo != "..") {
                                echo "<option value='" . explode('.', $arquivo)[0] . "'>";
                                echo explode('.', $arquivo)[0];
                                echo "</option>";
                            }
                        }
                        $diretorio->close();
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Cor Preço</span>
                    </div>
                    <input type="color" id="cor_preco_anterior" list="arcoIris" value="#FF0000" class="form-control" style="height:38px" onchange="criaCartazFila();">
                </div>
            </div>
            <div class="col-sm">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Cor Preço</span>
                    </div>
                    <input type="color" id="cor_preco" list="arcoIris" value="#FF0000" class="form-control" style="height:38px" onchange="criaCartazFila();">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-6">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rodapé</span>
                    </div>
                    <input type="text" id="rodape_geral" value="Oferta válida enquanto durarem nossos estoques" class="form-control" onblur="mudaRodapeGeral(this.value)">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Unidade</span>
                    </div>
                    <input type="text" id="unidade_geral" value="Un." class="form-control" onblur="mudaUnidadeGeral(this.value)">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Quantidade de Cópias</span>
                    </div>
                    <input type="number" id="quantidade_geral" value="1" class="form-control" oninput="mudaQuantidadeGeral(this.value)">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col pt-2 pb-2 pr-4 text-right">
                <input type="button" value="GERAR CARTAZES" class='btn btn-primary' onclick="gerarPDFFila();" id='bt-pdf'>
            </div>
        </div>
    </div>

    <div class="card mt-3 mb-3">
        <table class="table-striped" id="tabela-produtos">
            <thead class="thead-dark">
                <tr>
                    <th></th>
                    <th>Descricao</th>
                    <th>NCM</th>
                    <th>SKU</th>
                    <th class="text-center">Preco</th>
                    <th class="text-center">Preco Promocional</th>
                    <th class="text-center">Unidade</th>
                    <th>RODAPÉ</th>
                    <th>QUANT</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="cartazes">
            </tbody>
        </table>
        <div id="carregando">
        <h1 class="text-center m-5"><?= count(json_decode($produtosselecionados)) == 1 && json_decode($produtosselecionados)[0][0] == "" ? "Importe Produtos" : "Carregando..."?></h1>
        </div>
    </div>
</div>

<div style="display:none">
    <input type="hidden" id="tamanho_fonte" value="100">
    <input type="hidden" id="unidade" value="Un">
    <input type="checkbox" name="quadrante" id="quadrante" value="1" checked>
    <input type="checkbox" name="incluirlogo" id="incluirlogo" value="1" checked>
    <input type="hidden" id="A3" value="2<|>297 x 420">
    <input type="hidden" id="id_cartaz">
    <div id="container_cartaz"></div>
    <canvas id='cartaz' width='1122.66' height='1587.6'></canvas>
    <canvas id='cartaz_a2' width='1587.6' height='2245.32'></canvas>
</div>

<div class="modal fade" id="modalAviso" tabindex="-1" role="dialog" aria-labelledby="modalAvisoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAvisoLabel">Atenção!</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="texto-aviso"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL BAIXAR MODELO -->

<div class="modal fade" id="baixamodelo" tabindex="-1" role="dialog" aria-labelledby="baixamodeloLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="baixamodeloLabel">Selecione o formato do arquivo</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <a class="btn btn-primary col m-2 text-white" href="<?= base_url('assets/produtos_xml.zip') ?>" download onclick="$('#baixamodelo').modal('hide')">Formato XML</a>
                <a class="btn btn-primary col m-2 text-white" href="<?= base_url('assets/produtos_csv.zip') ?>" download onclick="$('#baixamodelo').modal('hide')">Formato CSV</a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDITAR -->
<div class="modal fade" id="modaleditar" tabindex="-1" role="dialog" aria-labelledby="modaleditarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaleditarLabel">Editar dados do cartaz</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col mb-2">
                            <label>Descrição</label>
                            <input type="text" name="descricao" id="descricao" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label>NMC</label>
                            <input type="text" name="nmc" id="nmc" class="form-control">
                        </div>
                        <div class="col mb-2">
                            <label>SKU</label>
                            <input type="text" name="sku" id="sku" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label>Preço</label>
                            <input type="text" name="preco" id="preco" class="money_ponto form-control">
                        </div>
                        <div class="col mb-2">
                            <label>Preço Promocional</label>
                            <input type="text" name="preco_promocional" id="preco_promocional" class="money_ponto form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label>Unidade</label>
                            <input type="text" name="unidade" id="unidade_ind" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label>Rodapé</label>
                            <input type="text" name="rodape_ind" id="rodape_ind" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" type="button" onclick="editar()">Editar Cartaz</button>
                <button class="btn btn-success" type="button" onclick="editaresalvar()">Salvar em Meus Produtos</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EXCLUSÃO -->
<div class="modal fade" id="modalExcluir" tabindex="-1" role="dialog" aria-labelledby="modalExcluirLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalExcluirLabel">Atenção!</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Você realmente deseja remover o cartaz da lista atual?
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-secondary" type="button" onclick="excluir()">Sim, pode remover!</button>
            </div>
        </div>
    </div>
</div>

<script>
    var dadosdafila = <?= $produtosselecionados ?>;
    var vetor = [];
    var imgatual = 0;
    var selecionado = 0;
    var rodapeAtual = "Oferta válida enquanto durarem nossos estoques";
    var unidadeAtual = "Un.";

    function mudaRodapeGeral(valor){
        if(valor != rodapeAtual){
            rodapeAtual = valor;
            dadosdafila.forEach((item) => {
                item[7] = valor;
            });
            trataDados(2);
        }
    }

    function mudaUnidadeGeral(valor){
        if(valor != unidadeAtual){
            unidadeAtual = valor;
            dadosdafila.forEach((item) => {
                item[6] = valor;
            });
            trataDados(2);
        }
    }

    function mudaQuantidadeGeral(valor){
        $(".input-quant").each((index, item) => {
            item.value = valor;
        });
    }

    function carregaprodutos(element, e, idform){
        e.preventDefault();

        const form = document.getElementById(idform);

        $.ajax({
            url: '<?= base_url("index.php/produtos/g") ?>',
            type: 'POST',
            data: new FormData(form),
            cache: false,
            contentType: false,
            processData: false,
            success: function(html){
                html = JSON.parse(html);

                if(html.status == "ok"){
                    
                    if(dadosdafila[0].length <= 1){
                        dadosdafila = [];
                    }

                    $("#carregando").html("<h1 class='text-center m-5'>Carregando...</h1>");

                    setTimeout(() => {
                        if(dadosdafila.length == 1 && dadosdafila[0].length <= 3){
                            dadosdafila = [];
                        }

                        if(typeof html.dados === "string") {
                            html.dados = JSON.parse(html.dados);
                        }

                        console.log(html.dados);
                        
                        html.dados.forEach((item) => {
                            item[8] = item[7] ? item[7] : 1; //A QUANTIDADE VEM NO 7. PARA EVITAR MUDANÇAS NOS ARQUIVOS DE LAYOUT, ATRUBUÍMOS AQUI
                            item[7] = $("#rodape_geral").val();
                            dadosdafila.push(item);
                        });

                        trataDados(2);
                    }, 10);
                } else {
                    alert(html.msg);
                }
            }
        });
    }

    function trataDados(tipo, index=false){
        dadosdafila.forEach((item, index) => {
            if(item.length == 9 && !isNaN(item[0])){
                if(parseFloat(item[4]) == 0 || item[4] == item[5]){
                    item[4] = "";
                }
                if(parseFloat(item[5]) == 0){
                    item[5] = item[4];
                    item[4] = "";
                }
            } else if(item.length == 9){
                item.splice(5, 1);
                item.unshift(index);

                if(parseFloat(item[4]) == 0 || item[4] == item[5]){
                    item[4] = "";
                }
                if(parseFloat(item[5]) == 0){
                    item[5] = item[4];
                    item[4] = "";
                }
            }
            
            else {
                // dadosdafila.splice(index, 1);
            }
        });

        if(tipo==1){
            buscaIds();
        } else if(tipo==2){
            criaCartazFila();
        }
    }

    function mudaimg(num){
        if(imgatual + num >= 0 && imgatual + num < vetor.length){
            imgatual = imgatual + num;
            $("#img_result").attr("src", document.getElementById('cartaz'+vetor[imgatual]).toDataURL());
        }
    }

    function mostrarPrototipos(){
        $("#cartazes").html("");
        
        dadosdafila.forEach((produto) => {
            
            $("#cartazes").append(
                '<tr id="linha'+produto[0]+'"><td><img width="150px" style="margin:5px" src="'+document.getElementById('cartaz'+produto[0]).toDataURL()+'"></td>'+
                '<td>'+produto[1]+'</td>'+
                '<td>'+produto[2]+'</td>'+
                '<td>'+produto[3]+'</td>'+
                '<td class="text-center">'+produto[4]+'</td>'+
                '<td class="text-center">'+produto[5]+'</td>'+
                '<td class="text-center">'+produto[6]+'</td>'+
                '<td>'+produto[7]+'</td>'+
                '<td><input type="number" min="0" style="width:70px;padding-top:5px;padding-bottom:5px;text-align:center" class="input-quant" id="quant'+produto[0]+'" value="'+produto[8]+'"</td>'+
                '<td class="text-right text-nowrap">'+
                    '<i style="cursor:pointer" onclick="vereditar('+produto[0]+')" class="text-primary h5 fas fa-edit"></i>'+
                    '<i style="cursor:pointer" onclick="verexcluir('+produto[0]+')" class="text-danger h5 fas fa-trash"></i>'+
                '</td>'+
                '</tr>'
            );
        });
    }

    function verexcluir(num){
        selecionado = dadosdafila.findIndex(function(id){ return id[0] == num; });
        $("#modalExcluir").modal('show');
    }

    function excluir(){
        $("#linha"+dadosdafila[selecionado][0]).remove();
        dadosdafila.splice(selecionado, 1);
        $("#modalExcluir").modal('hide');
    }

    function vereditar(num){
        selecionado = dadosdafila.findIndex(function(id){ return id[0] == num; });

        $("#descricao").val(dadosdafila[selecionado][1]);
        $("#nmc").val(dadosdafila[selecionado][2]);
        $("#sku").val(dadosdafila[selecionado][3]);
        $("#preco").val(dadosdafila[selecionado][4]);
        $("#preco_promocional").val(dadosdafila[selecionado][5]);
        $("#unidade_ind").val(dadosdafila[selecionado][6]);
        $("#rodape_ind").val(dadosdafila[selecionado][7]);

        $("#modaleditar").modal('show');
    }

    function editar(){
        dadosdafila[selecionado][1] = $("#descricao").val();
        dadosdafila[selecionado][2] = $("#nmc").val();
        dadosdafila[selecionado][3] = $("#sku").val();
        dadosdafila[selecionado][4] = $("#preco").val();
        dadosdafila[selecionado][5] = $("#preco_promocional").val();
        dadosdafila[selecionado][6] = $("#unidade_ind").val();
        dadosdafila[selecionado][7] = $("#rodape_ind").val();
        criaCartazFila();
        $("#modaleditar").modal('hide');
    }

    function editaresalvar(){
        dadosdafila[selecionado][1] = $("#descricao").val();
        dadosdafila[selecionado][2] = $("#nmc").val();
        dadosdafila[selecionado][3] = $("#sku").val();
        dadosdafila[selecionado][4] = $("#preco").val();
        dadosdafila[selecionado][5] = $("#preco_promocional").val();
        dadosdafila[selecionado][6] = $("#unidade_ind").val();
        dadosdafila[selecionado][7] = $("#rodape_ind").val();
        $.post("<?= base_url("index.php/produtos/cadastro/") ?>"+dadosdafila[selecionado][0]+"/false", 
            {
                descricao : dadosdafila[selecionado][1],
                ncm : dadosdafila[selecionado][2],
				sku : dadosdafila[selecionado][3],
				preco : dadosdafila[selecionado][4],
				preco_promocional : dadosdafila[selecionado][5],
                unidade : dadosdafila[selecionado][6]
            }, 
            function(result){
                if(result.indexOf("sucesso") != -1){
                    $("#modaleditar").modal('hide');
                    criaCartazFila();
                } else {
                    alert("Algo deu errado. Tente novamente mais tarde!");
                }
            }
        );
    }

    function mudaCategorias(num) {
        // num = num == 13 ? 1 : (num == 21 || num == 22 ? 11 : num);
        num = num == 13 ? 1 : num;
        $('.categoria').hide();
        $('.categoria' + num).show();
        $(".categoria").removeAttr("selected");
        $(".categoria" + num + ":first").attr("selected", "selected");
        buscaIds();
        tamSelecionado();
        dados_faixa = {};
        dados_quadrante = {}
    }
</script>

<?php $this->load->view("dashboard/criar/script"); ?>

<script>
    function atualizaLista() {
        id_cartaz = $('.id_cartaz').length;
        for (var i = 0; i < id_cartaz+1; i++) {
            mudaAba(i);
            mudaAba(0);
        }
    }
</script>

<script>
    var objeto = {}

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

    function separaTexto(texto){
        texto = texto.split(" ");

        var linha1 = texto[0];
        var linha2 = "";
        var linha3 = "";

        var contador = 1;

        if(linha1.length <= 11){
        
            while (linha1.length <= 11 && contador < texto.length){

                if((linha1+" "+texto[contador]).length > 11){
                    break;
                } else {
                    linha1 = linha1+" "+texto[contador];
                }

                contador++;
            
            }

        }

        while (linha2.length <= 12 && contador < texto.length){

            if(linha2 == ""){
                linha2 = linha2+" "+texto[contador];
            } else {
                if((linha2+" "+texto[contador]).length > 12){
                    break;
                } else {
                    linha2 = linha2+" "+texto[contador];
                }
            }

            contador++;

        }

        while (contador < texto.length){

            linha3 = linha3+" "+texto[contador];

            contador++;

        }

        return [linha1, linha2, linha3];
    }
</script>