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
        <section class='row'>
            <div class='col-md p-4'>
                <form class="row" action="<?php echo base_url("index.php/welcome/add_iframe"); ?>" method="post" enctype="multipart/form-data">
                    <div class="col">
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
                                <input type="tel" name="telefone" id="telefone" class='form-control mb-3 tel'  placeholder='Deixe um telefone / whatsapp' required>        
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Logomarca</span>
                                    </div>
                                    <label class='form-control' for='src' id="label-img" style="cursor:pointer;"><span class='text-muted'>Selecione uma imagem...</span></label>
                                    <input type="file" id="src" name="src" style="display:none;" oninput="$('#label-img').html($('#src').val().split('\\').pop())" accept="image/png, image/jpeg, image/jpg"/>
                                </div>        
                            </div>
                        </div>
                    </div>

                    <div class="col">
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
                            <div class="col text-right">
                                <input type="submit" value="ENVIAR" class='btn btn-success col-md-6'>  
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mask.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/cep.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/general.js?v=1'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>

        <?php
            if(isset($id) && $id == 1){
        ?>
        <script>
            window.top.location.href = "https://app.pressla.com.br/index.php/login"; 
        </script>
        <?php
            }
        ?>
    </div>
  </body>
</html>