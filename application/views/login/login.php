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
  <body id="corpologin">
    <div id="interface" class='container-fluid h-100 p-0'>
        <section class='col-md h-100 flex-centro'>
            
            <form method="post" action="<?=base_url('index.php/login/logar') ?>" class='col-md-3 text-center form-login'>
                <div class="form-group mb-3">
                    <img src="<?php echo base_url('assets/images/logo_branco.png?v=1'); ?>" alt="Logomarca do site" srcset="<?php echo base_url('assets/images/logo_branco.png?v=1'); ?>" class='w-75 mt-3 mb-3'>
                </div>
                <div class="form-group mt-3 mb-3">
                    <input class="form-control" name="usuario" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Insira um e-mail" required>
                </div>
                <div class="form-group mb-3">
                    <input class="form-control" name="senha" id="exampleInputPassword1" type="password" placeholder="Insira uma senha" required autocomplete='off'>
                </div>
                <input type="submit" value="ENTRAR" class="btn btn-success btn-block mt-3">
                <br>
                <?php echo (isset($msg) ? $msg : ""); ?>
                <br>
                <a href="<?php echo base_url(); ?>">Voltar para o início</a>
            </form>
        </section>
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    </div>
  </body>
</html>