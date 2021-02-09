<nav>
    <style>
        #menu-principal::-webkit-scrollbar {
            width: 12px;
        }
        
        #menu-principal::-webkit-scrollbar {
            width: 6px;
        }
        
        #menu-principal::-webkit-scrollbar-thumb {
            /* -webkit-border-radius: 10px;
            border-radius: 10px; */
            background: #00d4ff; 
            /* -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);  */
        }
    </style>
    <div class='col-md-2 col-sm-4 col-10 d-md-block' id='menu-principal'>
        <div class='row'>
            <div class="col text-center">
                <img src="<?php echo base_url('/assets/images/logo_branco.png?v=1'); ?>" alt="Pressla" class='w-100 mt-5 mb-5'>
            </div>
        </div>
        <br>
        <hr>
        <div class='row'>
            <div class="col text-center">
                <span>Olá, <?php echo $this->session->userdata('logado')['nome'].'!'; ?></span>
            </div>
        </div>
        <hr>
        <nav>
            <div class='row'>
                <div class="col">
                    <ul id='principal'>
                        <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/dashboard'); ?>'"><span> Home</span></li>
                        <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/dashboard/criar') ?>'"><span> Criar Cartaz</span></li>
                        <?php if($this->login_model->checkAdmin(true)){ ?>
                        <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/clientes/listar'); ?>'"><span> Clientes</span></li>
                        <li class='item-menu' onclick="$('#menu-componentes').toggle('fast')"><a><span> Gerenciar Componentes</span></a></li>
                        <li>
                            <ul id='menu-componentes' style='display:none;'>
                                <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/templates/'); ?>'"><span> Templates</span></li>
                                <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/templates/tipos'); ?>'"><span> Categorias</span></li>
                                <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/figuras/'); ?>'"><span> Figuras</span></li>
                            </ul>
                        </li>
                        <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/contatos/'); ?>'"><span> Contatos</span></li>
                        <?php } else {?>
                        <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/dadoscliente'); ?>'"> Meus Dados</li>
                        <?php } ?>
                        <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/login/deslogar'); ?>'"> Sair</li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</nav>
<div class='col-sm cor-menu' id='menu-principal-mobile'>
    <div class='row'>
        <div class="col align-middle">
            <span>Olá, <?php echo $this->session->userdata('logado')['nome'].'!'; ?></span>
        </div>
        <div class="col-auto" style='text-align:center;'>
            <img width='30px' src="<?php echo base_url('assets/images/menu.png'); ?>" onclick="$('#menu-principal').toggle('fast')">
        </div>
    </div>
</div>
