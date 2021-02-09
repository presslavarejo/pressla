<div class='col offset-md-2'>
    <h1 class="header" style='padding:10px;'><a  href="<?=base_url('index.php/templates/tipos');?>">Categorias </a><small class="text-muted">Gerenciamento de Categorias</small> <a href="<?php echo base_url('index.php/templates/adicionartipo'); ?>" class="btn btn-success btn-sm text-white"> + </a> </h1>
    <hr>

    <div class="card p-4">
        <div class="row">
            <div class="col-12">
                <table class="table-striped" id="tabela-templates">
                    <thead class="thead-dark">
                        <tr>
                            <?php if(count($templates_tipo) > 0) {?>        
                            <th>Nome</th>
                            <th></th>
                            <?php } else {echo "Não há tipos de templates cadastrados.";}?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        foreach($templates_tipo as $template_tipo) {?>
                        <tr>
                            <td class='esp'><?=$template_tipo->tipo?></td>
                            <td class='text-right text-white'>
                                <a role="button" href="<?=base_url('index.php/templates/gerenciartipo/'.$template_tipo->id)?>" class="m-1 btn btn-primary">Alterar</a>
                                <a role="button" class="m-1 btn btn-danger" onClick="deletarTemplateTipo(<?=$template_tipo->id?>)" >Excluir</a>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletarTemplateTipo" tabindex="-1" role="dialog" aria-labelledby="deletarTemplateTipoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletarTemplateTipoLabel">Atenção!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja realmente excluir este tipo de template? (Verifique se existe templates cadastrados com o tipo informado para evitar futuros problemas)
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="confirmar-exclusao" type="button">Excluir</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>