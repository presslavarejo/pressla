<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <h1 class="header" style='padding:10px;'>Contatos <small class="text-muted">Gerenciamento de contatos</small> <a href="<?php echo base_url('index.php/contatos/adicionar'); ?>" class="btn btn-success btn-sm text-white"> + </a> </h1>
    <hr>

    <div class="card p-2">
        <div class="row">
            <div class="col-12">
                <table class="table-striped" id="tabela-contatos">
                    <thead class="thead-dark">
                        <tr>
                            <?php if(count($contatos) > 0) {?>        
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th></th>
                            <?php } else {echo "Não há contatos cadastrados.";}?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($contatos as $contato) {?>
                        <tr>
                            <td class='esp' style='width:25%;'><?=$contato->nome?></td>
                            <td class='esp text-truncate' style='width:50%;'><?=$contato->valor?></td>
                            <td class='text-right text-white' style='width:25%;'>
                                <a role="button" href="<?=base_url('index.php/contatos/gerenciar/'.$contato->id)?>" class="m-1 btn btn-primary">Alterar</a>
                                <a role="button" class="m-1 btn btn-danger" onClick="deletarContato('<?=$contato->id?>')" >Excluir</a>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletarContato" tabindex="-1" role="dialog" aria-labelledby="deletarContatoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletarContatoLabel">Atenção!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja realmente excluir este contato?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="confirmar-exclusao" type="button">Excluir</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>