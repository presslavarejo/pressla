<?php
$array_layouts = [
"SEM LAYOUT DEFINIDO",
"Sem Imagem",
"Com Imagem",
"Cartão da Loja",
"Clube Fidelidade",
"Layout Horizontal",
"Faixas para Gôndolas",
"Banner Bolsão A2 Vertical",
"Atacado",
"Com Imagem 2",
"Atacado e Varejo - Horizontal",
"Varejo - Horizontal",
"2 Preços - Sem Imagem 2",
"Sem Imagem 2",
"Bolsão A3x4 - Horizontal",
"2 Preços - Sem Imagem",
"2 preços Horizontal sem imagem 8x20",
"1 preço Horizontal sem imagem 8x20",
"Banner A2 Vertical",
"Tabloide 11 Produtos",
"Tabloide 12 Produtos",
"Horizontal 17x12 sem imagem",
"Horizontal 17x12 com imagem",
"Horizontal 17x12 tabloide",
"NÃO UTILIZADO",
"1 Preço horizontal - Sem imagem 42x30",
"",
"Horizontal P1",
"Vertical G1"
];
?>
<link rel="stylesheet" href="<?= base_url("assets/js/tables/datatables.min.css") ?>">
<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
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
                            <th>Categorias</th>
                            <th>Layouts</th>
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
                            <td class='esp'><?=$array_layouts[$template->layout]?></td>
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
<script src="<?= base_url("assets/js/tables/datatables.min.js") ?>"></script>