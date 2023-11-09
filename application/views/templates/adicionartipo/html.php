<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <div id="alerta-sucesso" class="alert alert-success hide" role="alert" style='display:none;'>
        Dados atualizados com sucesso!
    </div>
    <div id="alerta-erro" class="alert alert-danger hide" role="alert" style='display:none;'>
        Ocorreu um erro! Tente novamente.
    </div>

    <h1 class="header" style='padding:10px;'><a  href="<?=base_url('index.php/templates/tipos');?>">Categorias </a> <small class="text-muted">Cadastro de Categoria</small></h1>
    <hr>
    
    <div class='row'>
        <div class='col'>
            <div class='card p-4'>
                <form id="frm-template" action="<?=base_url('index.php/templates/addtipo')?>" method='post' enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Nome</span>
                                </div>
                                <input type="text" class="form-control" id="nome" name="nome" type="text" class="form-control" value="" placeholder="Ex.: Ofertas" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button id="enviar" type="submit" class="btn btn-primary pull-right mb-0 mt-2">Enviar</button>
                    </div>
                </form>
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
</div>