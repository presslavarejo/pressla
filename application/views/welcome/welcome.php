<!DOCTYPE html>
<html lang='pt-br'>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>

    <meta name="author" content="Michel Rodrigo Nunes Arruda | microDIR">
    <meta name="description" content="Crie cartazes incríveis para as suas ofertas" />
    <meta name="robots" content="index,follow"/>

    <meta property="og:title" content="Pressla"/>
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Pressla"/>
    <meta property="og:description" content="Crie cartazes incríveis para as suas ofertas"/>
    <meta property="og:image" content="<?php echo base_url('assets/images/logo.png?v=1'); ?>"/>
    <meta property="og:url" content="<?php echo base_url(''); ?>" >
    <meta property="og:image:type" content="image/jpeg" >
    <meta property="og:image:width" content="600" >
    <meta property="og:locale" content="pt_BR"></meta>
    
    <link rel="icon" href="<?php echo base_url('assets/images/logo_icon.png?v=1'); ?>" type="image/png" sizes="16x16"> 

    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/welcome.css').'?v='.time(); ?>">


  </head>
  <body id="corpowelcome">
    <div class='container-fluid h-100 p-0'>
        <div id="barra-superior">
            <header class='row w-100'>
                <div class="col-auto">
                    <img src="<?php echo base_url('assets/images/logo_branco.png?v=1'); ?>" width="150px" class="d-none d-md-block pl-2">
                    <img src="<?php echo base_url('assets/images/logo_icon.png?v=1'); ?>" width="30px" class="d-block d-md-none pl-2">
                </div>
                <div class="col">
                    <nav>
                        <ul>
                            <li><a class='home ativo' href="#home">Home</a></li>
                            <li><a class='contato' href="#cadastro">Cadastro</a></li>
                            <li><a href="<?php echo base_url('index.php/login'); ?>">Login</a></li>
                        </ul>
                    </nav>
                </div>
            </header>
        </div>
        
        <section class='col-md esq h-100 mb-5 text-center' id="home">
            <h1>Pressla</h1>
            <br><br><br><br><br>
            <img src="<?php echo base_url('assets/images/logo.png?v=1'); ?>" alt="Pressla" srcset="<?php echo base_url('assets/images/logo.png?v=1'); ?>" class="w-50 mt-5">
            <a href="#sessao2">
            <img id='img-down' src="<?php echo base_url('assets/images/down.png?v=1'); ?>" alt="down" class='pulse'>
            </a>
        </section>

        <hr>

        <div class='mb-5 mt-5' id='sessao2'></div>

        <section class='col-md-8 dir h-100 mb-5 mt-5 pt-5 deBaixo' style='margin-left:auto;margin-right:auto;'>
            
            <p class='mt-5'><h1>Utilize nossos templates e crie cartazes incríveis para as ofertas da sua loja de forma rápida e muito fácil.</h1></p>
            <p><h1>Confira!</h1></p>
            <br>
            <div id='container-img-mercado' class='w-100 text-center'>
                <img id='img-mercado' src="<?php echo base_url('assets/images/mercadinho.jpg'); ?>" alt="Imagem de um mercadinho" srcset="<?php echo base_url('assets/images/mercadinho.jpg'); ?>" class='w-75 mt-5'>
            </div>
            <a href="#contatos">
                <img id='img-down' src="<?php echo base_url('assets/images/down.png?v=1'); ?>" alt="down" class='pulse'>
            </a>
        </section>

        <hr id='cadastro'>
        
        <div class='deBaixo'></div>
        <section class='col-md mb-5 flex-centro'>
            <div class='col-md-10'>
                <div class='row'>
                    <div class='col-md mb-4 h-100 text-left p-4 flex-centro'>
                        <div class='w-100'>
                            <h2>Contatos</h2>
                            <br>
                            <?php
                                foreach($contatos as $contato){
                                    echo "<h5>".$contato->nome.": ".$contato->valor."</h5>";
                                }
                            ?>
                        </div>
                    </div>
                    <div class='col-md h-100 text-left p-4 flex-centro'>
                        <div class="row">
                            <form action="<?php echo base_url("index.php/welcome/add"); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col">
                                        <h2>Faça seu cadastro:</h2>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" name="nome" id="nome" class='form-control mb-3' placeholder='Digite o nome da sua empresa' required>        
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" name="cnpj" id="cnpj" class='form-control mb-3 cnpj' placeholder='Digite o CNPJ da sua empresa'>        
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="email" name="login" id="login" class='form-control mb-3' placeholder='Digite seu e-mail' required>        
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="password" name="senha" id="senha" class='form-control mb-3' placeholder='Digite uma senha' required>        
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="tel" name="telefone" id="telefone" class='form-control mb-5 tel'  placeholder='Deixe um telefone / whatsapp' required>        
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col mb-2">
                                        <strong>Endereço</strong>        
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" name="cep" id="cep" class='form-control mb-3 cep' placeholder='Digite seu CEP'>        
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" name="rua" id="rua" class='form-control mb-3' placeholder='Digite o nome da sua rua' required>        
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" name="bairro" id="bairro" class='form-control mb-3' placeholder='Digite o nome do bairro'>        
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" name="cidade" id="cidade" class='form-control mb-3' placeholder='Digite o nome da sua cidade' required>        
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" name="estado" id="estado" class='form-control mb-3' placeholder='Digite o nome do seu estado' required>  
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="input-group mb-3 mt-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Logomarca</span>
                                            </div>
                                            <label class='form-control' for='src' id="label-img" style="cursor:pointer;"><span class='text-muted'>Selecione uma imagem...</span></label>
                                            <input type="file" id="src" name="src" style="display:none;" oninput="$('#label-img').html($('#src').val().split('\\').pop())" accept="image/png, image/jpeg, image/jpg"/>
                                        </div>        
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="submit" value="ENVIAR" class='btn btn-success col-md-6 mt-2'>  
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php if(isset($id)){ ?>
        <div class="modal fade" id="alertarCliente" tabindex="-1" role="dialog" aria-labelledby="alertarClienteLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alertarClienteLabel">
                        <?php echo $id == 0 ? "Atenção!" : "Bem Vindo!"; ?>
                        </h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $id == 0 ? "Ocorreu algum problema durante o processamento do seu cadastro. Por favor, tente novamente mais tarde." : "Tenho certeza que vai adorar essa ferramenta incrível que preparamos pensando em você."; ?>
                    </div>
                    <div class="modal-footer">
                        <?php if ($id == 1){ ?>
                        <button class="btn btn-primary" id="confirmar-exclusao" type="button" onclick="window.location.href = '<?php echo base_url('index.php/login'); ?>'">Fazer Login</button>
                        <?php } ?>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <footer>
            Copyright&copy; 2021 | www.pressla.com.br
        </footer>
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mask.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/cep.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/general.js?v=1'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <?php if(isset($id)){ ?>
        <script>
            $("#alertarCliente").modal('show');
        </script>
        <?php } ?>
        <script src="<?php echo base_url('assets/js/animacaoaparecer.js?v='.time()); ?>"></script>
    </div>
  </body>
</html>
