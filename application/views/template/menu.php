<script>
    var menuExpandido = 'true';

    if (typeof(Storage) !== "undefined") {
        if(sessionStorage.expandido){
            menuExpandido = sessionStorage.expandido == 'true' ? 'false' : 'true';
        } else {
            sessionStorage.setItem("expandido","true");
        }
    }

    $(document).ready(function(){
        recolheMenu();
    });
    function recolheMenu(status = false){
        // if($("#comptela").css('display') == 'none'){
        //     menuExpandido = 'false';
        // }

        if(status){
            menuExpandido = 'false';
            if($('#menu-componentes').css('display') == 'none'){
                $('#menu-componentes').show('fast');
            } else {
                $('#menu-componentes').hide('fast');
            }
            
        } else {
            $('#menu-componentes').hide('fast')
        }
        
        if(menuExpandido == 'true'){
            $("#comptela").hide();
            $("#tela").css('margin-left',"100px");
            $(".item-menu > span").hide("fast", function(){
                $(".item-menu > i").show('fast');
            });
            $("#logo_grande").hide("fast", function(){
                $("#logo_pequena").show('fast');
            });
            $("#menu-principal").removeClass("col-md-2 col-sm-4 col-10");
            $("#menu-principal").addClass("col-md-auto");
            $("#menu-principal").css("width","110px");
            $(".item-menu").addClass("col text-center");
            $("#btrecolhe").addClass("text-center");
            $("#principal").addClass("text-center");
            $(".exp").hide();
            $("#dir").hide();
            $("#esq").show();
            sessionStorage.expandido = 'false';
            menuExpandido = 'false';
        } else {
            $(".item-menu > i").hide("fast", function(){
                $(".item-menu > span").show('fast');
            });
            $("#logo_pequena").hide("fast", function(){
                $("#logo_grande").show('fast');
            });
            $("#menu-principal").removeClass("col-md-auto");
            $("#menu-principal").addClass("col-md-2 col-sm-4 col-10");
            $("#menu-principal").css("width","100%");
            $(".item-menu").removeClass("col text-center");
            $("#btrecolhe").removeClass("text-center");
            $("#principal").removeClass("text-center");
            $("#comptela").show('fast');
            $("#tela").css('margin-left',"0px");
            $(".exp").show();
            $("#dir").show();
            $("#esq").hide();
            sessionStorage.expandido = 'true';
            menuExpandido = 'true';
        }
    }
</script>
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

        .item-menu > i {
            display:none;
        }

        i {
            width: 40px;
            text-align: center;
            font-size:30px;
            display:none;
            margin-top: 10px;
            margin-bottom: 10px;
            color:#eeeeee;
        }
    </style>
    <div class='col-md-2 col-sm-4 col-10 d-md-block' id='menu-principal'>
        <div class="row h-100">
            <div class="col h-100">
                <div class='row'>
                    <div class="col text-center">
                        <img src="<?php echo base_url('/assets/images/logo_branco.png?v=1'); ?>" alt="Pressla" class='w-100 mt-5 mb-5' id="logo_grande">
                        <img src="<?php echo base_url('/assets/images/logo_icon.png?v=1'); ?>" alt="Pressla" class='mt-2 mb-0' id="logo_pequena" style="display:none;width:40px">
                    </div>
                </div>
                <br>
                <hr class="exp">
                <div class='row exp'>
                    <div class="col text-center">
                        <span>Olá, <?php echo $this->session->userdata('logado')['nome'].'!'; ?></span>
                    </div>
                </div>
                <hr class="exp">
                <?php
                $isADM = $this->login_model->checkAdmin(true);
                ?>
                <nav>
                    <div class='row'>
                        <div class="col">
                            <ul id='principal'>
                                <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/dashboard'); ?>'"><i class="fas fa-home ml-auto mr-0 mt-0"></i><span> Início</span></li>
                                <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/dashboard/criar') ?>'"><i class="far fa-file-image ml-auto mr-0"></i><span> Gerar Cartaz</span></li>
                                <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/produtos/cartazesmassa') ?>'"><i class="far fa-file-image ml-auto mr-0"></i><span> Gerar Cartaz em Massa</span></li>
                                <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/produtos') ?>'"><i class="fa fa-shopping-bag ml-auto mr-0"></i><span> Meus Produtos</span></li>
                                <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/meuscontatos') ?>'"><i class="fa fa-users ml-auto mr-0"></i><span> Meus Contatos</span></li>
                                <?php if($isADM){ ?>
                                <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/integracaoconf') ?>'">
                                <i class="ml-auto mr-0 mt-0 mb-0 p-0"><svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg></i><span> Integração</span>
                                </li>
                                <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/clientes/listar'); ?>'"><i class="fas fa-users ml-auto mr-0"></i><span> Clientes</span></li>
                                <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/historico/impressoes'); ?>'"><i class="fas fa-file-export ml-auto mr-0"></i><span> Histórico de Impressões</span></li>
                                <li class='item-menu' onclick="recolheMenu(true)" style="cursor:pointer"><i class="fas fa-cogs ml-auto mr-0"></i><span> Gerenciar Componentes</span></li>
                                <li>
                                    <ul id='menu-componentes' style='display:none;'>
                                        <li class='item-menu-2' onclick="window.location.href='<?php echo base_url('index.php/templates/'); ?>'"><span> Templates Cartazes</span></li>
                                        <!-- <li class='item-menu-2' onclick="window.location.href='<?php echo base_url('index.php/tabloides/'); ?>'"><span> Templates Tabloides</span></li> -->
                                        <li class='item-menu-2' onclick="window.location.href='<?php echo base_url('index.php/templates/tipos'); ?>'"><span> Categorias</span></li>
                                        <li class='item-menu-2' onclick="window.location.href='<?php echo base_url('index.php/figuras/'); ?>'"><span> Figuras</span></li>
                                    </ul>
                                </li>
                                <?php } else {?>
                                <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/figuras/'); ?>'"><i class="fas fa-file-export ml-auto mr-0"></i><span> Minhas Figuras</span></li>
                                <?php }?>
                                <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/dadoscliente'); ?>'"><i class="fas fa-user ml-auto mr-0"></i><span> Meu Perfil</span></li>
                                <li class='item-menu' onclick="window.location.href='<?php echo base_url('index.php/login/deslogar'); ?>'"><i class="fas fa-sign-out-alt ml-auto mr-0"></i><span> Sair</span></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col-auto h-100 p-0 d-none d-md-flex align-items-center justify-content-start" style="background:url('<?=base_url("assets/images/btexp.png?v=3")?>'); background-repeat:no-repeat; background-size: 100% 100%"  onclick="recolheMenu()">
                <span id="esq" class="text-white" style="font-size:1.2em;width:12px;cursor:pointer;">› </span>
                <span id="dir" class="text-white" style="font-size:1.2em;width:12px;cursor:pointer;">‹ </span>
                <!-- <img src="" height="100%" width="100%"> -->
            </div>
        </div>
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
