<div class='col offset-md-2'>
    <div id="alerta-sucesso" class="alert alert-success hide" role="alert" style='display:none;'>
        Dados atualizados com sucesso!
    </div>
    <div id="alerta-erro" class="alert alert-danger hide" role="alert" style='display:none;'>
        Ocorreu um erro! Tente novamente.
    </div>

    <h1 class="header" style='padding:10px;'>Contatos <small class="text-muted">Cadastro do contato</small></h1>
    <hr>

    <div class="card p-4">
        <form id="frm-contato">
            <input value="<?=$contato->id?>" id="id" name="id" type="hidden">
            <div class="form-row">
                <div class="col-sm">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Tipo</span>
                        </div>
                        <input type="text" class="form-control" id="nome" name="nome" type="text" class="form-control" value="<?=$contato->nome?>" required>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Valor</span>
                        </div>
                        <input name="valor" id="valor" type="text" class="form-control" value="<?=$contato->valor?>"/>
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
