<div class='col offset-md-2'>
    <h1 class="header" style='padding:10px;'>Clientes <small class="text-muted">Gerenciamento de clientes</small> <a href="<?php echo base_url('index.php/clientes/adicionar'); ?>" class="btn btn-success btn-sm text-white"> + </a> </h1>

    <hr>

    <div class="card p-4">
        <div class="row">
            <div class="col-12">
                <table class="table-striped" id="tabela-clientes">
                    <thead class="thead-dark">
                        <tr>
                            <th>Cliente</th>
                            <th class='text-center'>Impressões / Usadas</th>
                            <th></th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach($clientes as $cliente) {?>
                        <tr>
                            <td><?=$cliente->nome?></td>
                            <td style='text-align:center;'><?php echo $cliente->impressoes.' / '.$cliente->usadas; ?></td>
                            <td class='text-right'>
                                <a role="button" href="<?=base_url('index.php/clientes/gerenciar/'.$cliente->id)?>" class="m-1 btn btn-primary text-white">Alterar</a>
                                <a role="button" class="btn btn-danger m-1" onClick="deletarCliente('<?=$cliente->id?>')" style="color:white;">Excluir</a>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletarCliente" tabindex="-1" role="dialog" aria-labelledby="deletarClienteLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="deletarClienteLabel">Atenção!</h5>

                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">×</span>

                    </button>

                </div>

                <div class="modal-body">

                    Deseja realmente excluir este cliente?

                </div>

                <div class="modal-footer">

                    <button class="btn btn-primary" id="confirmar-exclusao" type="button">Excluir</button>

                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>

                </div>

            </div>

        </div>

    </div>
</div>