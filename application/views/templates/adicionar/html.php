<div class='col offset-md-2'>
    <div id="alerta-sucesso" class="alert alert-success hide" role="alert" style='display:none;'>
        Dados atualizados com sucesso!
    </div>
    <div id="alerta-erro" class="alert alert-danger hide" role="alert" style='display:none;'>
        Ocorreu um erro! Tente novamente.
    </div>

    <h1 class="header" style='padding:10px;'><a  href="<?=base_url('index.php/templates/');?>">Templates </a> <small class="text-muted">Cadastro de Template</small></h1>
    <hr>
    
    <div class='row'>
        <div class='col'>
            <div class='card p-4'>
                <form id="frm-template" action="<?=base_url('index.php/templates/add')?>" method='post' enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Nome</span>
                                </div>
                                <input type="text" class="form-control" id="nome" name="nome" type="text" class="form-control" value="" placeholder="Ex.: Varejão" required>
                            </div>
                        </div>
                        <div class="col-sm col-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Imagem</span>
                                </div>
                                <label class='form-control' for='src' id="label-img" style="cursor:pointer;"><span class='text-muted'>Selecione uma imagem...</span></label>
                                <input type="file" id="src" name="src" style="display:none;" oninput="$('#label-img').html($('#src').val().split('\\').pop())" accept="image/png, image/jpeg, image/jpg"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-sm-6">
                            <span class='text-muted'>Selecione as categorias do template</span>
                            <table>
                                <?php
                                    foreach($tipos as $tipo){
                                        echo "<tr><td><input type='checkbox' value='".$tipo->id."' name='tipos' id='tipo".$tipo->id."' onchange='constuirIdsTipos()'></td><td><label class='btn p-0 m-0' for='tipo".$tipo->id."'>".$tipo->tipo."</label></td></tr>";
                                    }
                                ?>
                            </table>
                            <input type="hidden" name="ids_tipos" id="ids_tipos">
                        </div>
                        <div class="col-sm-6">
                            <span class='text-muted'>O template é exclusivo a algum dos clientes?</span>
                            <select class='form-control mt-2' name='id_exclusivo'>
                                <option value="0">Todos os Assinantes</option>
                                <option value="1">Assinantes PREMIUM</option>
                                <?php
                                    foreach($clientes as $cliente){
                                        echo "<option value='".$cliente->id."'>".$cliente->nome."</option>";
                                    }
                                ?>
                            </select>
                            <br><br>
                            <span class='text-muted'>Para qual layout será selecionado o template?</span>
                            <br>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="layout" id="layout1" value='1' class="form-check-input" checked>
                                <label for="layout1" class="form-check-label">Layout 1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="layout" id="layout2" value='2' class="form-check-input">
                                <label for="layout2" class="form-check-label">Layout 2</label>
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