<link rel="stylesheet" href="<?= base_url("assets/js/tables/datatables.min.css") ?>">
<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <h1 class="header" style='padding:10px;'>Figuras <small class="text-muted">Gerenciamento de figuras</small> <a href="<?php echo base_url('index.php/figuras/adicionar'); ?>" class="btn btn-success btn-sm text-white"> + </a> </h1>
    <hr>

    <div class="card p-4">
        <div class="row">
            <div class="col-12">
                <table class="table-striped" id="tabela-figuras">
                    <thead class="thead-dark">
                        <tr>
                            <?php if(count($figuras) > 0) {?>        
                            <th>Nome</th>
                            <th></th>
                            <?php } else {echo "Não há figuras cadastrados.";}?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        foreach($figuras as $figura) {?>
                        <tr>
                            <td class='esp'><a href="<?=base_url("assets/images/figuras/".$figura->src)?>" target="_blank"><?=$figura->nome?></a></td>
                            <td class='text-right text-white'>
                                <a role="button" href="<?=base_url('index.php/figuras/gerenciar/'.$figura->id)?>" class="m-1 btn btn-primary">Alterar</a>
                                <a role="button" class="m-1 btn btn-danger" onClick="deletarFigura(<?=$figura->id?>)" >Excluir</a>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletarFigura" tabindex="-1" role="dialog" aria-labelledby="deletarFiguraLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletarFiguraLabel">Atenção!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja realmente excluir a figura?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="confirmar-exclusao" type="button">Excluir</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="verFigura" tabindex="-1" role="dialog" aria-labelledby="verFiguraLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verFiguraLabel">Atenção!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id='body-verFigura'>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/js/tables/datatables.min.js") ?>"></script>