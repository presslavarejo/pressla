<div class='col offset-md-2'>
    <h1 class="header" style='padding:10px;'><a  href="<?=base_url('index.php/templates/');?>">Templates </a><small class="text-muted">Gerenciamento de templates</small> <a href="<?php echo base_url('index.php/templates/adicionar'); ?>" class="btn btn-success btn-sm text-white"> + </a> </h1>
    <hr>

    <div class="card p-4">
        <div class="row">
            <div class="col-12">
                <table class="table-striped" id="tabela-templates">
                    <thead class="thead-dark">
                        <tr>
                            <?php if(count($templates) > 0) {?>        
                            <th>Nome</th>
                            <th>Lista de Tipos</th>
                            <th></th>
                            <?php } else {echo "Não há templates cadastrados.";}?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        foreach($templates as $template) {?>
                        <tr>
                            <td class='esp'><a target="_blank" href="<?=base_url("assets/images/templates/".$template->src)?>"><?=$template->nome?></a></td>
                            <td class='esp'>
                            <?php
								if($template->ids_tipos){
									$tipos = explode(", ", $template->ids_tipos);
									$array_tipos = [];
									foreach($tipos as $tipo){
										array_push($array_tipos,$this->templates_model->getTiposTemplate($tipo)->tipo);
									}
									echo implode(", ",$array_tipos);
								}
                            ?>
                            </td>
                            <td class='text-right text-white'>
                                <a role="button" href="<?=base_url('index.php/templates/gerenciar/'.$template->id)?>" class="m-1 btn btn-primary">Alterar</a>
                                <a role="button" class="m-1 btn btn-danger" onClick="deletarTemplate(<?=$template->id?>)" >Excluir</a>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletarTemplate" tabindex="-1" role="dialog" aria-labelledby="deletarTemplateLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletarTemplateLabel">Atenção!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja realmente excluir este template?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="confirmar-exclusao" type="button">Excluir</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="verTemplate" tabindex="-1" role="dialog" aria-labelledby="verTemplateLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verTemplateLabel">Atenção!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id='body-verTemplate'>
                    
                </div>
            </div>
        </div>
    </div>
</div>