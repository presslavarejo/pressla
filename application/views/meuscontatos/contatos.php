<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <h1 class="header" style='padding:10px;'>Contatos <small class="text-muted">Gerenciamento de contatos</small> <a href="<?php echo base_url('index.php/meuscontatos/cadastro'); ?>" class="btn btn-success btn-sm text-white"> + </a> </h1>
    <hr>
    <form method="post" class="row" enctype="multipart/form-data">
        <div class="col-sm text-center mt-2 mb-2">
            Cadastre também os contatos em massa. <a href="<?= base_url('assets/contatos.csv') ?>">Clique aqui</a> para baixar o arquivo modelo.
        </div>
        <div class="col-sm-4 mt-2 mb-2">
            <input type="file" name="arquivoxml" class="form-control" accept=".csv" required>
        </div>
        <div class="col-sm-1 mt-2 mb-2">
            <input type="submit" value="OK" class="btn btn-success col">
        </div>
        <!-- <div class="col-sm-4 border-left mt-2 mb-2 text-center">
            <input type="button" class="btn btn-success" value="CONTINUAR COM OS SELECIONADOS" onclick="continuarSelecionados()">
        </div> -->
    </form>
    <hr>
    <form class="row" method="post">
        <div class="col">
            <div class="row" id="row-acao-massa" style="display:none">
                <div class="col-auto">
                    <input type="button" class="btn btn-danger" value="DELETAR SELECIONADOS" onclick="deletarcontatosmassa()">
                </div>
                <div class="col">
                    <form method="post">
                        <div class="row">
                            <input type="hidden" name="contatos_selecionados_modal" required>
                            <input type="hidden" name="acao" value="alterar_massa">
                            <div class="col text-right">
                                Alterar nome da lista dos selecionados:
                            </div>
                            <div class="col-4">
                                <input type="text" name="grupo_modal" id="grupo_modal" class="form-control" placeholder="Nome da lista">
                            </div>
                            <div class="col-auto">
                                <input type="submit" class="btn btn-primary" value="ALTERAR">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <style>
        td {
            padding: 5px;
        }
    </style>
    
    <script>
        function contaSelecionados(){
            if($(".check-contato:checked").length > 1){
                $("#row-acao-massa").show("fast");
                let itens_selecionados = []
                $(".check-contato:checked").each((index, item) => {
                    itens_selecionados.push($(item).attr("data-id"));
                });
                $("[name=contatos_selecionados_modal]").val(itens_selecionados.join(","));
            } else {
                $("#row-acao-massa").hide("fast");
                $("[name=contatos_selecionados_modal]").val("");
            }
        }
        function toggleCheck(elemento){
            $(".check-contato").prop("checked", elemento.checked);
            contaSelecionados();
        }
    </script>

    <div class="card p-2">
        <div class="row">
            <div class="col-12">
                <table class="table-striped" id="tabela-contatos">
                    <thead class="thead-dark">
                        <tr>
                            <?php if(count($contatos) > 0) {?>        
                            <th style="padding:5px"><input type="checkbox" onclick="toggleCheck(this)"></th>
                            <th style="width:35%;">NOME</th>
                            <th>EMAIL</th>
                            <th>WHATSAPP</th>
                            <th>LISTA</th>
                            <th></th>
                            <?php } else {echo "Não há contatos cadastrados.";}?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($contatos as $contato) {?>
                        <tr>
                            <td><input type="checkbox" onchange="contaSelecionados()" class="check-contato" data-id="<?=$contato->id?>" name="contatos[]" value="<?=$contato->id."<|>".$contato->nome."<|>".$contato->telefone."<|>".$contato->email?>"></td>
                            <td><?=$contato->nome?></td>
                            <td><?=$contato->email?></td>
                            <td><?=$contato->telefone?></td>
                            <td><?=$contato->grupo?></td>
                            <td class='text-right text-nowrap'>
                                <i style="cursor:pointer" onclick="window.location.href = '<?=base_url('index.php/meuscontatos/cadastro/'.$contato->id)?>'" class="text-primary h5 fas fa-edit"></i>
                                <i style="cursor:pointer" onClick="deletarcontato('<?=$contato->id?>')" class="text-danger h5 fas fa-trash"></i>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletarcontato" tabindex="-1" role="dialog" aria-labelledby="deletarcontatoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletarcontatoLabel">Atenção!</h5>
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

    <div class="modal fade" id="deletarcontatosmassa" tabindex="-1" role="dialog" aria-labelledby="deletarcontatosmassaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletarcontatosmassaLabel">Atenção!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja realmente excluir todos os contatos selecionados?
                </div>
                <div class="modal-footer">
                    <form method="post">
                        <input type="hidden" name="contatos_selecionados_modal" required>
                        <input type="hidden" name="acao" value="excluir_massa">
                        <button class="btn btn-primary" type="submit">Excluir</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
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

<form action="<?= base_url("index.php/meuscontatos/contatosmassa") ?>" method="post" id="form-selecionados">
    <input type="hidden" name="contatosselecionados">
</form>

<script>
    function continuarSelecionados(){
        if($("input[name=contatos\\[\\]]:checked").length == 0){
            alert("Selecione pelo menos 1 contato");
        } else {
            var vetor = [];
            var elementos = $("input[name=contatos\\[\\]]:checked");

            $.each(elementos, function(){            
                vetor.push($(this).val());
            });

            $("input[name=contatosselecionados]").val(vetor.join(",-,"));
            $("#form-selecionados").submit();
        }
    }
</script>