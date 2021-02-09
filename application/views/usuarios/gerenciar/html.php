<div id="alerta-sucesso" class="alert alert-success hide" role="alert">
    Usuário atualizado com sucesso!
</div>
<div id="alerta-erro" class="alert alert-danger hide" role="alert">
    Ocorreu um erro! Contate o administrador.
</div>

<h1 class="header">Usuários <small class="text-muted">Gerenciamento de usuário</small></h1>
<hr>

<form id="frm-usuario">
	<input type="hidden" id="id" value="<?=$usuario->id?>" />
    <div class="form-row">
        <div class="col-sm-6 col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Nome do Usuário</span>
                </div>
                <input class="form-control" id="nome" name="nome" type="text" value="<?=$usuario->nome?>" class="form-control" required>
            </div>
        </div>
        <div class="col-sm-6 col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">E-mail do Usuário</span>
                </div>
                <input class="form-control" id="login" name="login" type="email" value="<?=$usuario->login?>" class="form-control" required>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-sm-6 col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Senha</span>
                </div>
                <input name="senha" id="senha" type="text" class="form-control" />
            </div>
        </div>
        <div class="col-sm-6 col-12">
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text">Tipo</span>
                </div>
                <select id="tipo" name="tipo" class="form-control" <?=($this->session->userdata('logado')['tipo'] != 1) ? 'disabled' : ''?>>
					<?php foreach($tipos as $tipo): ?>
						<option value="<?=$tipo->id?>" <?=($tipo->id == $usuario->tipo) ? 'selected' : '' ?> ><?=$tipo->nome?></option>
					<?php endforeach ?>
				</select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button id="enviar" type="submit" class="btn btn-primary pull-right">Enviar</button>
    </div>
</form>

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
