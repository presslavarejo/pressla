<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <div id="alerta-sucesso" class="alert alert-success hide" role="alert" style='display:none;'>
        Produto cadastrado com sucesso!
    </div>
    <div id="alerta-sucesso-atualizacao" class="alert alert-success hide" role="alert" style='display:none;'>
        Produto atualizado com sucesso!
    </div>
    <div id="alerta-erro" class="alert alert-danger hide" role="alert" style='display:none;'>
        Ocorreu um erro! Tente novamente.
    </div>

    <h1 class="header" style='padding:10px;'>Produtos <small class="text-muted">Cadastro de produto</small></h1>
    <hr>
    <div class="card p-4">
        <form id="frm-produto" method="post">
            <div class="form-row">
                <div class="col-sm">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Descrição</span>
                        </div>
                        <input type="text" class="form-control" id="descricao" name="descricao" type="text" class="form-control" value="<?= isset($dados) ? $dados->descricao : "" ?>" required>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">NCM</span>
                        </div>
                        <input type="text" class="form-control" id="ncm" name="ncm" type="text" class="form-control" value="<?= isset($dados) ? $dados->ncm : "" ?>">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-sm">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Unidade</span>
                        </div>
                        <input type="text" class="form-control" id="unidade" name="unidade" type="text" class="form-control" value="<?= isset($dados) ? $dados->unidade : "Un." ?>">
                    </div>
                </div>

                <div class="col-sm">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">SKU</span>
                        </div>
                        <input type="text" class="form-control" id="sku" name="sku" type="text" class="form-control" value="<?= isset($dados) ? $dados->sku : "" ?>">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Preço</span>
                        </div>
                        <input type="text" class="form-control money" id="preco" name="preco" type="text" class="form-control" value="<?= isset($dados) ? $dados->preco : "" ?>" required>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Preço Promocional</span>
                        </div>
                        <input type="text" class="form-control money" id="preco_promocional" name="preco_promocional" type="text" class="form-control" value="<?= isset($dados) ? $dados->preco_promocional : "" ?>">
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Categoria</span>
                        </div>
                        <select name="categoria" class="form-control">
                            <?php
                            foreach($categorias as $categoria){
                            ?>
                            <option value="<?= $categoria->id ?>" <?= isset($dados) && $dados->categoria == $categoria->id ? "selected" : "" ?>><?= $categoria->tipo ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <button id="enviar" type="submit" class="btn btn-primary pull-right">Enviar</button>
            </div>
        </form>
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
</div>
<script src="<?php echo base_url('assets/js/jquery.maskMoney.js'); ?>" type="text/javascript"></script>
<script>
    $(function(){
        $(".money").maskMoney({thousands:'.', decimal:','});
        $("#ncm").mask("9999.99.99");

        <?php
        if(isset($mensagem)){
        ?>
        $("#<?=$mensagem?>").show("fast", function(){
            setTimeout(() => {
                $("#<?=$mensagem?>").hide("fast");
            }, 3000);
        });
        <?php
        }
        ?>
    });
</script>