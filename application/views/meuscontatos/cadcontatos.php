<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <div id="alerta-sucesso" class="alert alert-success hide" role="alert" style='display:none;'>
        Contato cadastrado com sucesso!
    </div>
    <div id="alerta-sucesso-atualizacao" class="alert alert-success hide" role="alert" style='display:none;'>
        Contato atualizado com sucesso!
    </div>
    <div id="alerta-erro" class="alert alert-danger hide" role="alert" style='display:none;'>
        Ocorreu um erro! Tente novamente.
    </div>

    <h1 class="header" style='padding:10px;'>Contatos <small class="text-muted">Cadastro de contato</small></h1>
    <hr>
    <div class="card p-4">
        <form id="frm-contato" method="post">
            <div class="form-row mb-2">
                <div class="col-sm">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nome</span>
                        </div>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= isset($dados) ? $dados->nome : "" ?>" required>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">E-mail</span>
                        </div>
                        <input type="email" class="form-control" id="email" name="email" value="<?= isset($dados) ? $dados->email : "" ?>">
                    </div>
                </div>
                <div class="col-sm">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Whatsapp</span>
                        </div>
                        <input type="tel" class="form-control" id="telefone" name="telefone" value="<?= isset($dados) ? $dados->telefone : "" ?>">
                    </div>
                </div>
                <div class="col-sm">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Lista</span>
                        </div>
                        <input type="tel" list="grupos" class="form-control" autocomplete="off" id="grupo" name="grupo" value="<?= isset($dados) ? $dados->grupo : "" ?>">
                        <datalist id="grupos">
                            <?php
                            foreach($grupos as $grupo){
                                echo "<option value='$grupo->grupo'/>";
                            }
                            ?>
                        </datalist>
                    </div>
                </div>
            </div>

            <div class="form-group text-right mt-3">
                <button id="enviar" type="submit" class="btn btn-success pull-right col-2">Enviar</button>
            </div>
        </form>
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
</div>

<script>
    $(function(){
        $("#telefone").mask("(00) 00000-0009");

        <?php
        if(isset($mensagem)){
        ?>
        $("#<?=$mensagem?>").show("fast", function(){
            setTimeout(() => {
                $("#<?=$mensagem?>").hide("fast");
            }, 3000);
        });
        <?php
        }
        ?>
    });
</script>