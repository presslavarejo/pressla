<link rel="stylesheet" href="<?= base_url("assets/js/tables/datatables.min.css") ?>">
<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <h1 class="header" style='padding:10px;'>Histórico de Impressões por Data <br><small class="text-muted">Visualize o histórico de impressões de cada cliente. Cada registro é salvo com data e quantidade de cartazes.</small></h1>
    <hr>
    <form class="row mb-2 justify-content-end" method="post">
        <div class="col-sm-3">
            <label> <input type="checkbox" name="resumido" <?= $resumido ? "checked" : "" ?>> Mostrar em modo resumido</label>
        </div>
        <div class="col-sm-3">
            <div class="row justify-content-center">
                <div class="col-auto text-right">
                    Cliente:
                </div>
                <div class="col">
                    <select name="cliente" class="form-control">
                        <option value="0">Todos</option>
                        <?php
                        foreach($clientes as $cliente){
                        ?>
                        <option value="<?= $cliente->id ?>" <?= $cliente->id == $cli ? "selected" : "" ?>><?= $cliente->nome ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm">
            <div class="row">
                <div class="col-sm-3 text-right">
                    Período de
                </div>
                <div class="col-sm-3">
                    <input type="date" name="de" class="form-control" value="<?= $de ?>">
                </div>
                <div class="col-sm-1 text-center">
                    até
                </div>
                <div class="col-sm-3">
                    <input type="date" name="ate" class="form-control" value="<?= $ate ?>">
                </div>
                <div class="col-sm-2 text-center">
                    <input type="submit" value="APLICAR" class="btn btn-primary">
                </div>
            </div>
        </div>
    </form>
    <div class="card p-4">
        <div class="row">
            <div class="col-12">
                <table class="table-striped" id="tabela-historico">
                    <thead class="thead-dark">
                        <tr>
                            <?php if(count($historico) > 0) {?>        
                                <th style="width:10%" class="text-nowrap">ID Cliente</th>
                                <th style="width:auto">Nome Cliente</th>
                                <th style="width:12%">Quantidade</th>
                                <th style="width:18%">Período</th>
                            <?php } else {echo "Não há histórico.";}?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        foreach($historico as $his) {?>
                        <tr>
                            <td class="text-center"><?= $his->id_usuario ?></td>
                            <td><?= $his->nome ?></td>
                            <td class="text-center"><?= $his->quantidade ?></td>
                            <td class="text-nowrap"><?= $resumido ? date("d/m/Y", strtotime($de))." - ".date("d/m/Y", strtotime($ate)) : date("d/m/Y H:i:s", strtotime($his->data_hora_impressao)) ?></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/js/tables/datatables.min.js") ?>"></script>