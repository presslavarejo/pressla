<style>
    .wpp {
        position: absolute;
        right: 5px;
        top: 10%;
        cursor: pointer;
    }
</style>
<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <div id="alerta-sucesso" class="alert alert-success hide" role="alert" style='display:none;'>
        Dados atualizados com sucesso!
    </div>
    <div id="alerta-erro" class="alert alert-danger hide" role="alert" style='display:none;'>
        Ocorreu um erro! Tente novamente.
    </div>

    <h1 class="header" style='padding:10px;'>Clientes <small class="text-muted">Cadastro do cliente</small></h1>
    <hr>

    <div class="card p-4">
        <form id="frm-cliente" action="<?=base_url('index.php/clientes/update')?>" method='post' enctype="multipart/form-data" onsubmit="$('#contato').val(construirContatos())">
            <input value="<?=$cliente->id?>" id="id" name="id" type="hidden">
            <div class="form-row">
                <div class="col-sm">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nome da empresa</span>
                        </div>
                        <input type="text" class="form-control" id="nome" name="nome" type="text" class="form-control" value="<?=$cliente->nome?>" required>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Logomarca</span>
                        </div>
                        <label class='form-control' for='src' id="label-img" style="cursor:pointer;"><?php echo ($cliente->logomarca ? $cliente->logomarca : "<span class='text-muted'>Selecione uma imagem...</span>"); ?></label>
                        <input type="file" id="src" name="src" style="display:none;" oninput="$('#label-img').html($('#src').val().split('\\').pop())" accept="image/png, image/jpeg, image/jpg"/>
                    </div>
                </div>
                <input type="hidden" name="contato" id="contato" value="<?=$cliente->contato?>">
            </div>
            <div class="form-row">
                <div class="col-sm col-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">CNPJ</span>
                        </div>
                        <input name="cnpj" id="cnpj" type="text" class="form-control" value="<?=$cliente->cnpj?>"/>
                    </div>
                </div>
                <div class="col-sm col-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Cadastro</span>
                        </div>
                        <input name="data_cadastro" id="data_cadastro" type="date" class="form-control" value="<?=$cliente->data_inserido?>" required readonly/>
                    </div>
                </div>
                <div class="col-sm col-12">
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Assinatura</span>
                        </div>
                        <select name="assinatura" id="assinatura" class='form-control'>
                            <option value="1" <?php echo $cliente->assinatura == 1 ? "selected" : ""; ?>>PREMIUM</option>
                            <option value="0" <?php echo $cliente->assinatura == 0 ? "selected" : ""; ?>>Básico</option>
                            <option value="2" <?php echo $cliente->assinatura == 2 ? "selected" : ""; ?>>ILIMITADO</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm col-12">
                    <div class="input-group mb-1 pt-3">
                        <label class="ml-auto mr-auto"><input type="checkbox" name="tabloid" value="1" <?php echo $cliente->tabloid == 1 ? "checked" : ""; ?>> Acesso ao Tabloide</label>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-sm col-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Login</span>
                        </div>
                        <input name="login" id="login" type="email" class="form-control" value="<?=$cliente->login?>" placeholder="exemplo@exemplo.com" required/>
                    </div>
                </div>
                <div class="col-sm col-12">
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Senha</span>
                        </div>
                        <input name="senha" id="senha" type="password" class="form-control" placeholder="Digite uma senha para o usuário" required value="<?=$this->encryption->decrypt($cliente->senha)?>"/>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm col-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Usuário</span>
                        </div>
                        <select name="tipo" id="tipo" class="form-control">
                            <option value='2' <?php echo ($cliente->tipo == 2 ? "selected":""); ?>>Comum</option>
                            <option value='1' <?php echo ($cliente->tipo == 1 ? "selected":""); ?>>Administrador</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm col-12">
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Ativo</span>
                        </div>
                        <select name="ativo" id="ativo" class="form-control">
                            <option value="1" <?php echo ($cliente->ativo == 1 ? "selected":""); ?>>SIM</option>
                            <option value="0" <?php echo ($cliente->ativo == 0 ? "selected":""); ?>>NÃO</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm col-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Impressões</span>
                        </div>
                        <input name="impressoes" id="impressoes" type="number" class="form-control" value="<?=$cliente->impressoes?>" required/>
                    </div>
                </div>
                <div class="col-sm col-12">
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Usadas</span>
                        </div>
                        <input name="usadas" id="usadas" type="number" class="form-control" value="<?=$cliente->usadas?>" required/>
                    </div>
                </div>
                <div class="col-sm col-12">
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Fechamento</span>
                        </div>
                        <input name="fechamento" id="fechamento" type="number" class="form-control" value="<?=$cliente->fechamento?>" min="1" max="31"/>
                    </div>
                </div>
            </div>
            <fieldset>
                <legend>ENDEREÇO</legend>
                <div class="form-row">
                    <div class="col-sm-3 col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">CEP</span>
                            </div>
                            <input name="cep" id="cep" type="text" value="<?=$cliente->cep?>" class="form-control"/>
                        </div>
                    </div>
                    <div class="col-sm col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rua - Nº</span>
                            </div>
                            <input name="rua" id="rua" type="text" class="form-control" value="<?=$cliente->rua?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Bairro</span>
                            </div>
                            <input name="bairro" id="bairro" type="text" class="form-control" value="<?=$cliente->bairro?>"/>
                        </div>
                    </div>
                    <div class="col-sm col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Cidade</span>
                            </div>
                            <input name="cidade" id="cidade" type="text" class="form-control" value="<?=$cliente->cidade?>"/>
                        </div>
                    </div>
                    <div class="col-sm-2 col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">UF</span>
                            </div>
                            <input type="text" name="uf" class="form-control" id="uf" value="<?=$cliente->uf?>" >
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset id="fieldset-contatos">
                <legend>CONTATO <button id="adicionar-contato" type="button" class="btn btn-danger btn-sm"> + </button></legend>
                <?php 
                    $contato = is_array(json_decode($cliente->contato)) ? json_decode($cliente->contato) :  array(json_decode($cliente->contato));
                    
                    if (count($contato) > 0) {
                        for($i = 0; $i < count($contato[0]->nome); $i++){
                        ?>
                        <div class="contato-grupo">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contato</span>
                                </div>
                                <input name="contato[nome][]" type="text" value="<?=$contato[0]->nome[$i]?>" class="form-control nome-contato"/>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-4 col-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Telefone</span>
                                        </div>
                                        <input name="contato[telefone][]" type="text" value="<?=$contato[0]->telefone[$i]?>" class="form-control telefone-contato"/>
                                        <img src="<?=base_url("assets/images/wpp.png")?>" height="80%" class="wpp" onclick='window.open("https:\/\/api.whatsapp.com\/send?phone=55<?=str_replace(["(", ")", "-", " "], "", $contato[0]->telefone[$i])?>")'>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">E-mail</span>
                                        </div>
                                        <input name="contato[email][]" type="email" value="<?=$contato[0]->email[$i]?>" class="form-control email-contato" />
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Cargo / Função</span>
                                        </div>
                                        <input name="contato[cargo][]" type="text" value="<?=$contato[0]->cargo[$i]?>" class="form-control cargo-contato" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                <?php } else { ?>
                    <div class="contato-grupo">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Contato</span>
                            </div>
                            <input name="contato[nome][]" type="text" class="form-control nome-contato"/>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Telefone</span>
                                    </div>
                                    <input name="contato[telefone][]" type="text" class="form-control telefone-contato"/>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">E-mail</span>
                                    </div>
                                    <input name="contato[email][]" type="email" class="form-control email-contato" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Cargo / Função</span>
                                    </div>
                                    <input name="contato[cargo][]" type="text" class="form-control cargo-contato" />
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </fieldset>

            <div class="form-group">
                <label>Observação</label>
                <textarea name="obs" id="obs" class="form-control"><?=$cliente->obs?></textarea>
            </div>

            <div class="row mt-4 mb-3">
                <div class="col">
                    <strong>INTEGRAÇÃO COM WHATSAPP</strong>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="mb-2">Nome da Sessão</label>
                    <input type="text" name="sessao" class="form-control" value="<?= $cliente->sessao ?>">
                </div>
                <div class="col-md-6">
                    <label class="mb-2">Token da Sessão</label>
                    <input type="text" name="token" class="form-control" value="<?= $cliente->token ?>">
                </div>
            </div>

            <div class="row mt-4 mb-3">
                <div class="col">
                    <strong>INTEGRAÇÃO COM GOOGLE SHEETS</strong>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md">
                    <label class="mb-2">Código da Planilha</label>
                    <input type="text" name="planilha" class="form-control" value="<?= $cliente->planilha ?>">
                </div>
            </div>

            <div class="form-group">
                <button id="enviar" type="submit" class="btn btn-primary pull-right">Salvar</button>
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
    $(document).ready(function(){
        $("#cnpj").mask("00.000.000/0000-00");
        $(".telefone-contato").mask("(00) 00000-0000");
    });
</script>