<div class='col offset-md-2'>
    <div id="alerta-sucesso" class="alert alert-success hide" role="alert" style='display:none;'>
        Dados atualizados com sucesso!
    </div>
    <div id="alerta-erro" class="alert alert-danger hide" role="alert" style='display:none;'>
        Ocorreu um erro! Tente novamente.
    </div>

    <h1 class="header" style='padding:10px;'><a  href="<?=base_url('index.php/templates/');?>">Templates </a> <small class="text-muted">Gerenciamento de Template</small></h1>
    <hr>
    
    <div class='row'>
        <div class='col'>
            <div class='card p-4'>
                <form id="frm-template" action="<?=base_url('index.php/templates/update/'.$template->id)?>" method='post' enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Nome</span>
                                </div>
                                <input type="text" class="form-control" id="nome" name="nome" type="text" class="form-control" value="<?=$template->nome?>" placeholder="Ex.: Varejão" required>
                            </div>
                        </div>
                        <div class="col-sm col-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Imagem</span>
                                </div>
                                <label class='form-control' for='src' id="label-img" style="cursor:pointer;"><?=$template->src?></label>
                                <input type="file" id="src" name="src" style="display:none;" oninput="$('#label-img').html($('#src').val().split('\\').pop())" accept="image/png, image/jpeg, image/jpg"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-sm-6">
                            <span class='text-muted'>Selecione os tipos compatíveis com o template</span>
                            <table>
                                <?php
                                    $compat = explode(', ',$template->ids_tipos);
                                    
                                    foreach($tipos as $tipo){
                                        echo "<tr><td><input type='checkbox' value='".$tipo->id."' name='tipos' id='tipo".$tipo->id."' onchange='constuirIdsTipos()' ".(in_array($tipo->id, $compat)?"checked":"")."></td><td><label class='btn p-0 m-0' for='tipo".$tipo->id."'>".$tipo->tipo."</label></td></tr>";
                                    }
                                ?>
                            </table>
                            <input type="hidden" name="ids_tipos" id="ids_tipos" value="<?=$template->ids_tipos?>">
                        </div>
                        <div class="col-sm-6">
                            <span class='text-muted'>O template é exclusivo a algum dos clientes?</span>
                            <select class='form-control mt-2' name='id_exclusivo'>
                                <option value="0" <?php echo ($template->id_exclusivo == 0 ? "selected" : ""); ?>>Todos os Assinantes</option>
                                <option value="1" <?php echo ($template->id_exclusivo == 1 ? "selected" : ""); ?>>Assinantes PREMIUM</option>
                                <?php
                                    foreach($clientes as $cliente){
                                        echo "<option value='".$cliente->id."' ".($template->id_exclusivo == $cliente->id ? "selected" : "").">".$cliente->nome."</option>";
                                    }
                                ?>
                            </select>
                            <br><br>
                            <span class='text-muted'>Para qual layout será selecionado o template?</span>
                            <br>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="layout" id="layout1" value='1' class="form-check-input" <?php echo ($template->layout == 1 ? "checked" : ""); ?>>
                                <label for="layout1" class="form-check-label">Sem Imagem</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="layout" id="layout2" value='2' class="form-check-input" <?php echo ($template->layout == 2 ? "checked" : ""); ?>>
                                <label for="layout2" class="form-check-label">Com Imagem</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="layout" id="layout3" value='3' class="form-check-input" <?php echo ($template->layout == 3 ? "checked" : ""); ?>>
                                <label for="layout3" class="form-check-label">Cartão da Loja</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="layout" id="layout4" value='4' class="form-check-input" <?php echo ($template->layout == 4 ? "checked" : ""); ?>>
                                <label for="layout4" class="form-check-label">Clube Fidelidade</label>
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