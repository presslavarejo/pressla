<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <h1 class="header" style='padding:10px;'>Produtos <small class="text-muted">Gerenciamento de produtos</small> <a href="<?php echo base_url('index.php/produtos/cadastro'); ?>" class="btn btn-success btn-sm text-white"> + </a> </h1>
    <hr>
    <form method="post" class="row" enctype="multipart/form-data">
        <div class="col-sm text-center mt-2 mb-2">
            Cadastre também produtos em massa. <a href="#" onclick="$('#baixamodelo').modal('show')">Clique aqui</a> para baixar o arquivo modelo.
        </div>
        <div class="col-sm-4 mt-2 mb-2">
            <input type="file" name="arquivoxml" class="form-control" accept=".xml , .csv" required>
        </div>
        <div class="col-sm-1 mt-2 mb-2">
            <input type="submit" value="OK" class="btn btn-success col">
        </div>
        <div class="col-sm-4 border-left mt-2 mb-2 text-center">
            <input type="button" class="btn btn-success" value="CONTINUAR COM OS SELECIONADOS" onclick="continuarSelecionados()">
        </div>
    </form>
    <hr>
    <form class="row" method="post">
        <div class="col">
            <div class="row" id="row-acao-massa" style="display:none">
                <div class="col-auto">
                    <input type="button" class="btn btn-danger" value="DELETAR SELECIONADOS" onclick="deletarprodutosmassa()">
                </div>
                <div class="col-auto">
                    Alterar selecionados para categoria:
                </div>
                <div class="col-auto">
                    <select name="muda_categoria" class="form-control" onchange="alterarcategoriaprodutosmassa(this.value)">
                        <option value="" disabled selected>Selecione...</option>
                        <?php
                        foreach($templates as $categoria){
                        ?>
                        <option value="<?= $categoria->id ?>"><?= $categoria->tipo ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-auto border-left">
            Filtro por Categoria:
        </div>
        <div class="col-auto">
            <select name="filtro_categoria" class="form-control" onchange="this.parentElement.parentElement.submit()">
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
                <table class="table-striped" id="tabela-produtos">
                    <thead class="thead-dark">
                        <tr>
                            <?php if(count($produtos) > 0) {?>        
                            <th style="padding:5px"><input type="checkbox" onclick="toggleCheck(this)"></th>
                            <th style="width:35%;">Descricao</th>
                            <th>NCM</th>
                            <th>SKU</th>
                            <th>CATEGORIA</th>
                            <th class="text-center">Preco</th>
                            <th class="text-nowrap text-center">Preco Promocional</th>
                            <th>Unidade</th>
                            <th></th>
                            <?php } else {echo "Não há produtos cadastrados.";}?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($produtos as $produto) {?>
                        <tr>
                            <td><input type="checkbox" onchange="contaSelecionados()" class="check-produto" data-id="<?=$produto->id?>" name="produtos[]" value="<?=$produto->id."<|>".$produto->descricao."<|>".$produto->ncm."<|>".$produto->sku."<|>".$produto->preco."<|>".$produto->preco_promocional."<|>".$produto->unidade?>"></td>
                            <td><?=$produto->descricao?></td>
                            <td><?=$produto->ncm?></td>
                            <td><?=$produto->sku?></td>
                            <td><?=$produto->nome_categoria?></td>
                            <td class="text-center"><?=$produto->preco?></td>
                            <td class="text-center"><?=$produto->preco_promocional?></td>
                            <td class="text-center"><?=$produto->unidade?></td>
                            <td class='text-right text-nowrap'>
                                <i style="cursor:pointer" onclick="window.location.href = '<?=base_url('index.php/produtos/cadastro/'.$produto->id)?>'" class="text-primary h5 fas fa-edit"></i>
                                <i style="cursor:pointer" onClick="deletarproduto('<?=$produto->id?>')" class="text-danger h5 fas fa-trash"></i>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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

    <div class="modal fade" id="deletarproduto" tabindex="-1" role="dialog" aria-labelledby="deletarprodutoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletarprodutoLabel">Atenção!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja realmente excluir este produto?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="confirmar-exclusao" type="button">Excluir</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletarprodutosmassa" tabindex="-1" role="dialog" aria-labelledby="deletarprodutosmassaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletarprodutosmassaLabel">Atenção!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja realmente excluir todos os produtos selecionados?
                </div>
                <div class="modal-footer">
                    <form method="post">
                        <input type="hidden" name="produtos_selecionados_modal" required>
                        <input type="hidden" name="acao" value="excluir_massa">
                        <button class="btn btn-primary" type="submit">Excluir</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="altcategoriamassa" tabindex="-1" role="dialog" aria-labelledby="altcategoriamassaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="altcategoriamassaLabel">Atenção!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja realmente alterar as categorias dos itens selecionados?
                </div>
                <div class="modal-footer">
                    <form method="post">
                        <input type="hidden" name="produtos_selecionados_modal" required>
                        <input type="hidden" name="categoria_modal" required>
                        <input type="hidden" name="acao" value="alterar_categorias_massa">
                        <button class="btn btn-primary" type="submit">SIM, alterar</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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