<link rel="stylesheet" href="<?= base_url("assets/js/tables/datatables.min.css") ?>">
<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <h1 class="header" style='padding:10px;'>Clientes <small class="text-muted">Gerenciamento de clientes</small> <a href="<?php echo base_url('index.php/clientes/adicionar'); ?>" class="btn btn-success btn-sm text-white"> + </a> </h1>

    <hr>

    <div class="card p-4">
        <div class="row">
            <div class="col-12">
                <table class="table-striped" id="tabela-clientes">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th class='text-center'>Impressões / Usadas</th>
                            <th>Login</th>
                            <th>Telefones</th>
                            <th>E-mails</th>
                            <th class="noExport"></th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php 
                        foreach($clientes as $cliente) {
                        $contatos = json_decode($cliente->contato);
                    ?>
                        <tr>
                            <td><?= str_pad($cliente->id, 5, "0", STR_PAD_LEFT) ?></td>
                            <td><?=$cliente->nome?></td>
                            <td style='text-align:center;'><?php echo $cliente->impressoes.' / '.$cliente->usadas; ?></td>
                            <td><?=$cliente->login?></td>
                            <td>
                                <?php
                                    foreach($contatos->telefone as $contato){
                                        echo $contato."<br>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    foreach($contatos->email as $contato){
                                        echo $contato."<br>";
                                    }
                                ?>
                            </td>
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

<script src="<?= base_url("assets/js/tables/datatables.min.js") ?>"></script>