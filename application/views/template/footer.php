			</div>
		</div>
		<!-- Logout Modal-->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">deseja realmente sair?</h5>
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						Escolha a opção "Sair" para encerrar com segurança.
					</div>
					<div class="modal-footer">
						<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
						<a class="btn btn-primary" href="<?=base_url('index.php/login/deslogar')?>">Sair</a>
					</div>
				</div>
			</div>
		</div>
		
		<div id='loader' class='loader' style='display:none;'>
          <img src="<?php echo base_url('assets/images/loader.gif'); ?>">
      	</div>
		
		<script src="<?php echo base_url('./assets/js/bootstrap.min.js') ?>"></script>
		<script src="<?php echo base_url('./assets/js/jpdf.js') ?>"></script>
		<script src="<?php echo base_url('./assets/js/icones.js') ?>"></script>
		<!-- <script src="<?php echo base_url('./assets/js/html2canvas.min.js') ?>"></script> -->
	</body>
</html>
