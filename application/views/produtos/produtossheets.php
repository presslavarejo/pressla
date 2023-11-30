<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <h1 class="header" style='padding:10px;'>Produtos <small class="text-muted">no Google Sheets</small></h1>
    <hr>
    <div class="row">
        
        <div class="col-sm-12 mt-2 mb-2 text-right">
            <input type="button" class="btn btn-success" value="CONTINUAR COM OS SELECIONADOS" onclick="continuarSelecionados()">
        </div>
    </div>
    
    <hr>

    <form class="row" method="post">
        <div class="col-auto">
            Quantidade por página:    
        </div>

        <div class="col-auto">
            <select name="filtro_quantidade" id="filtro_quantidade" class="form-control" onchange="this.parentElement.parentElement.submit()">
                <option <?= $quantidade_atual == 1 ? "selected" : "" ?> value="1">1</option>
                <option <?= $quantidade_atual == 10 ? "selected" : "" ?> value="10">10</option>
                <option <?= $quantidade_atual == 100 ? "selected" : "" ?> value="100">100</option>
                <option <?= $quantidade_atual == 250 ? "selected" : "" ?> value="250">250</option>
                <option <?= $quantidade_atual == 500 ? "selected" : "" ?> value="500">500</option>
                <option <?= $quantidade_atual == 1000 ? "selected" : "" ?> value="1000">1000</option>
                <option <?= $quantidade_atual == 2500 ? "selected" : "" ?> value="2500">2500</option>
                <option <?= $quantidade_atual == 5000 ? "selected" : "" ?> value="5000">5000</option>
                <option <?= $quantidade_atual == 0 ? "selected" : "" ?> value="0">Todos</option>
            </select>
        </div>

        <div class="col border-left text-right">
            Filtro por Categoria:
        </div>
        <div class="col-auto">
            <select name="filtro_categoria" id="filtro_categoria" class="form-control" onchange="this.parentElement.parentElement.submit()">
                <option value="0">Todos</option>
                <option value="-1" <?= $categoria_atual == -1 ? "selected" : "" ?>>Sem Categoria</option>
                <?php
                foreach($templates as $categoria){
                ?>
                <option value="<?= $categoria->id ?>" <?= $categoria_atual == $categoria->id ? "selected" : "" ?>><?= $categoria->tipo ?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </form>
    <hr>
    <style>
        td {
            padding: 5px;
        }
    </style>
    <?php $this->load->view("dashboard/criar/style"); ?>
    <script>
        function contaSelecionados(){
            if($(".check-produto:checked").length > 1){
                $("#row-acao-massa").show("fast");
                let itens_selecionados = []
                $(".check-produto:checked").each((index, item) => {
                    itens_selecionados.push($(item).attr("data-id"));
                });
                $("[name=produtos_selecionados_modal]").val(itens_selecionados.join(","));
            } else {
                $("#row-acao-massa").hide("fast");
                $("[name=produtos_selecionados_modal]").val("");
            }
        }
        function toggleCheck(elemento){
            $(".check-produto").prop("checked", elemento.checked);
            contaSelecionados();
        }
    </script>
    <div class="card p-2">
        <div class="row">
            <div class="col-12">
                <?php
                $produtos = json_decode($produtos);

                if(isset($produtos->code)){
                    echo "O SISTEMA NÃO TEM PERMISSÃO PARA ACESSAR ESTA PLANILHA";
                } else if(!isset($produtos->values) || count($produtos->values) == 0){
                    echo "NÃO HÁ PRODUTOS NESTA PÁGINA";
                } else {
                ?>
                <table class="table-striped" id="tabela-produtos">
                    <thead class="thead-dark">
                        <tr>
                            <th style="padding:5px"><input type="checkbox" onclick="toggleCheck(this)"></th>
                            <th style="width:35%;">Descricao</th>
                            <th>NCM</th>
                            <th>SKU</th>
                            <th>CATEGORIA</th>
                            <th class="text-center">Preco</th>
                            <th class="text-nowrap text-center">Preco Promocional</th>
                            <th>Unidade</th>
                            <th>Quant.</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $produtos = $produtos->values;
                    
                    foreach($produtos as $produto) {
                        $produto_id = uniqid();
                        $nome_categoria = array_filter($templates, function($value) use ($produto){
                            return $value->id == $produto[5];
                        });

                        $nome_categoria = array_values($nome_categoria);

                        $nome_categoria = count($nome_categoria) > 0 ? $nome_categoria[0]->tipo : "";
                    ?>
                        <tr>
                            <td><input type="checkbox" onchange="contaSelecionados()" class="check-produto" data-id="<?=$produto_id?>" name="produtos[]" value="<?=$produto_id."<|>".$produto[0]."<|>".$produto[1]."<|>".$produto[2]."<|>".$produto[3]."<|>".$produto[4]."<|>".$produto[6]."<|> <|>".$produto[7]?>"></td>
                            <td><?=$produto[0]?></td>
                            <td><?=$produto[1]?></td>
                            <td><?=$produto[2]?></td>
                            <td><?=$nome_categoria?></td>
                            <td class="text-center"><?=$produto[3]?></td>
                            <td class="text-center"><?=$produto[4]?></td>
                            <td class="text-center"><?=$produto[6]?></td>
                            <td class="text-center"><?=$produto[7]?></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-4">
        <div class="col">
            <form class="row" method="post" onsubmit="$('#fq').val($('#filtro_quantidade').val());$('#fc').val($('#filtro_categoria').val())" id="form-paginacao">
                <input type="hidden" name="filtro_quantidade" id="fq" value="<?= $quantidade_atual ?>">
                <input type="hidden" name="filtro_categoria" id="fc" value="<?= $categoria_atual ?>">
                
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto"> <button type="button" class="btn btn-primary" onclick="mudapag('-')"> < </button> </div>
                        <select name="filtro_pagina" id="filtro_pagina" class="form-select" onchange="$('#form-paginacao').submit()">
                        <?php
                        for ($i = 1; $i <= 1000; $i++) {
                        ?>
                        <option value="<?= $i ?>" <?= $i == $pagina_atual ? "selected" : "" ?>> <?= $i ?> </option>
                        <?php
                        }
                        ?>
                        </select>
                        <div class="col-auto"> <button type="button" class="btn btn-primary" onclick="mudapag('+')"> > </button> </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function mudapag(tipo) {
            if((tipo == '-' && $('#filtro_pagina').val() == 1) || (tipo == '+' && $('#filtro_pagina').val() == 1000)) {
                return;
            } else {
                if(tipo == '+') {
                    $('#filtro_pagina').val(parseInt($('#filtro_pagina').val()) + 1);
                } else {
                    $('#filtro_pagina').val(parseInt($('#filtro_pagina').val()) - 1);
                }

                $('#form-paginacao').submit();
            }
        }
    </script>

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

<form action="<?= base_url("index.php/produtos/cartazesmassa") ?>" method="post" id="form-selecionados">
    <input type="hidden" name="produtosselecionados">
</form>

<script>
    function continuarSelecionados(){
        if($("input[name=produtos\\[\\]]:checked").length == 0){
            alert("Selecione pelo menos 1 produto");
        } else {
            var vetor = [];
            var elementos = $("input[name=produtos\\[\\]]:checked");

            $.each(elementos, function(){            
                vetor.push($(this).val());
            });

            $("input[name=produtosselecionados]").val(vetor.join(",-,"));
            $("#form-selecionados").submit();
        }
    }
</script>