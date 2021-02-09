<h1 class="header">Usuários <small class="text-muted">Gerenciamento de usuarios</small></h1>
<hr>

<div class="row">
    <div class="col-12">
        <table class="table-striped" id="tabela-usuarios">
            <thead class="thead-dark">
                <tr>
					<th>#</th>
                    <th>Nome</th>
                    <th>Login</th>
                    <th>Tipo</th>
					<th>Último acesso</th>
                    <th>Criado em</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
			<?php foreach($usuarios as $usuario) { ?>
                <tr>
					<td><?=$usuario->id?></td>
                    <td><?=$usuario->nome?></td>
                    <td><?=$usuario->login?></td>
                    <td><?=$usuario->tipo_nome?></td>
					<?php if ($usuario->ultimo_acesso != ''): ?>
						<td data-order="<?=strtotime($usuario->ultimo_acesso)?>"><?=date('d/m/Y H:i:s', strtotime($usuario->ultimo_acesso))?></td>
					<?php else: ?>
                    	<td>Nunca acessou</td>
					<?php endif ?>
                    <td data-order="<?=strtotime($usuario->data_criacao)?>"><?=date('d/m/Y H:i:s', strtotime($usuario->data_criacao))?></td>
					<?php if ($this->session->userdata('logado')['id'] != $usuario->id): ?>
						<td>
							<a role="button" href="<?=base_url('index.php/login/gerenciar/'.$usuario->id)?>" class="form-contol btn btn-info">Alterar</a>
						</td>
						<td>
							<a role="button" class="btn btn-danger" onClick="deletarUsuario('<?=$usuario->id?>')" style="color:white;">Excluir</a>
						</td>
					<?php else: ?>
						<td>
							<a role="button" href="<?=base_url('index.php/login/gerenciar/'.$usuario->id)?>" class="form-contol btn btn-info">Alterar</a>
						</td>
						<td></td>
					<?php endif ?>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="deletarUsuario" tabindex="-1" role="dialog" aria-labelledby="deletarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletarUsuarioLabel">Atenção!</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Deseja realmente excluir este usuário?
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="confirmar-exclusao" type="button">Excluir</button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
