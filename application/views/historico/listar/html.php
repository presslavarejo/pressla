<link rel="stylesheet" href="<?= base_url("assets/js/tables/datatables.min.css") ?>">
<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <h1 class="header" style='padding:10px;'>Histórico de Fechamentos <br><small class="text-muted">Visualize o histórico de impressões mensais de cada cliente</small></h1>
    <hr>
    <div class="row mb-2">
        <div class="col text-right">
            Meses anteriores
        </div>
        <div class="col-2">
            <select name="filtro" id="filtro" class="form-control" onchange="window.location.href = '<?= base_url('index.php/historico/index/') ?>'+this.value">
                <option value="1" <?= $filtro == 1 ? "selected" : "" ?>>1</option>
                <option value="2" selected>2</option>
                <option value="3" <?= $filtro == 3 ? "selected" : "" ?>>3</option>
                <option value="4" <?= $filtro == 4 ? "selected" : "" ?>>4</option>
                <option value="5" <?= $filtro == 5 ? "selected" : "" ?>>5</option>
                <option value="6" <?= $filtro == 6 ? "selected" : "" ?>>6</option>
                <option value="7" <?= $filtro == 7 ? "selected" : "" ?>>7</option>
                <option value="8" <?= $filtro == 8 ? "selected" : "" ?>>8</option>
                <option value="9" <?= $filtro == 9 ? "selected" : "" ?>>9</option>
                <option value="10" <?= $filtro == 10 ? "selected" : "" ?>>10</option>
                <option value="11" <?= $filtro == 11 ? "selected" : "" ?>>11</option>
                <option value="12" <?= $filtro == 12 ? "selected" : "" ?>>12</option>
            </select>
        </div>
    </div>
    <div class="card p-4">
        <div class="row">
            <div class="col-12">
                <table class="table-striped" id="tabela-historico">
                    <thead class="thead-dark">
                        <tr>
                            <?php if(count($historico) > 0) {?>        
                                <th>ID Cliente</th>
                                <th>Nome Cliente</th>
                                <th>Quantidade</th>
                                <th>Aberto em</th>
                                <th>Fechado em</th>
                            <?php } else {echo "Não há histórico.";}?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        foreach($historico as $his) {?>
                        <tr>
                            <td><?= $his->id_usuario ?></td>
                            <td><?= $his->nome ?></td>
                            <td><?= $his->quantidade ?></td>
                            <td><?= $his->data_de ?></td>
                            <td><?= $his->data_ate ?></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/js/tables/datatables.min.js") ?>"></script>